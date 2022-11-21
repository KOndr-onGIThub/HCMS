<?php

namespace App\Business;

use App\Contracts\OpenLdapClient as OpenLdapClientContract;
use App\Mail\Generator;
use App\Models\EmailTemplate;
use App\Models\Supplier;
use Exception;
use Illuminate\Support\Facades\Mail;
use stdClass;

/**
 * Class OpenLdapManager
 *
 * Business logic wrapper around OpenLdap client.
 *
 * @package App\Business
 */
class OpenLdapManager
{
    /**
     * @var OpenLdapClientContract  Needs instance of this contract implementation.
     * Can be resolved from app`s service container.
     */
    protected $client;

    public function __construct(OpenLdapClientContract $openLdapClient)
    {
        $this->client = $openLdapClient;
    }

    /**
     * Trigger necessary logic when supplier account was changed.
     * Ie account was created, renamed etc.
     *
     * @param  Supplier  $supplier
     */
    public function accountChanged(Supplier $supplier)
    {
        $newLogin = normalize($supplier->name);

        // cannot work with this name as source for login name
        if (empty($newLogin)) {
            return;
        }

        $oldLogin = $supplier->login;

        if ($oldLogin !== $newLogin) {
            // delete
            $this->deleteAccount($supplier);

            // create
            $this->createAccount($supplier);

            return;
        }

        // update
        if ($oldLogin === $newLogin) {
            $this->updateAccount($supplier);

            return;
        }
    }

    /**
     * Shortcut to client method readOne().
     *
     * @param  string  $identifier
     * @return stdClass|null
     */
    public function retrieveById(string $identifier): ?stdClass
    {
        return $this->client->readOne($identifier);
    }

    /**
     * Array of roles usually consist of role named 'supplier' and another role
     * extracted from supplier`s name, ie. 'posco'.
     * Since name role is given by login, general 'supplier' role is based on
     * roles described by OpenLdap.
     * This assures that both arrays are merged together.
     *
     * @param  stdClass  $ldapUser
     * @return array
     */
    public function accountRoles(stdClass $ldapUser): array
    {
        return array_merge(
            $ldapUser->cn ?? [],
            $this->client->findUserRoles($ldapUser->cn[0] ?? '')
        );
    }

    /**
     * We try to reset password for given supplier
     * and send notification on supplier`s contact emails.
     *
     * @param  Supplier  $supplier
     * @return bool
     */
    public function resetPassword(Supplier $supplier): bool
    {
        $resetPasswordResponse = $this->client->resetPassword($supplier->login ?? '');

        $responseStatus = $resetPasswordResponse->status ?? false;

        if (!$responseStatus) {
            return false;
        }

        // prepare mail generator
        $mailGenerator = new Generator(
            EmailTemplate::SUPPLIER_ACCOUNT_CREATED,
            [
                ':login' => $supplier->login,
                ':password' => $resetPasswordResponse->newPasw ?? '',
                ':link' => config('app.dmz_url'),
            ],
            explode(',', $supplier->safeEmails())
        );

        // mail can fail on $mailGenerator->build()
        try {
            Mail::send($mailGenerator);
        } catch (Exception $e) {
            logCriticalException($e);

            return false;
        }

        return true;
    }

    /**
     * In case of updating of supplier`s name, code etc. use this method.
     *
     * @param  Supplier  $supplier
     */
    public function updateAccount(Supplier $supplier): void
    {
        $this->client->save(
            $supplier->login ?? '',
            $supplier->name,
            $supplier->supp_code,
            'by steel app',
            true
        );
    }

    /**
     * When introducing new supplier to system,
     * we also need to create OpenLdap account for them to be able to sign into DMZ application
     * and send notification email.
     *
     * @param  Supplier  $supplier
     */
    public function createAccount(Supplier $supplier)
    {
        $login = normalize($supplier->name);

        // cannot work with this name as source for login name
        if (empty($login)) {
            return;
        }

        // fill supplier info
        $supplier->fill([
            'login' => $login,
            'ldap_role_name' => $login,
        ]);

        $newAccountResponse = $this->client->save(
            $supplier->login,
            $supplier->name,
            $supplier->supp_code,
            'by steel app',
            true
        );

        // assign app`s role to supplier
        $this->client->saveRole($supplier->login);

        // update supplier info
        $supplier->save();

        // prepare mail generator
        $mailGenerator = new Generator(
            EmailTemplate::SUPPLIER_ACCOUNT_CREATED,
            [
                ':login' => $supplier->login,
                ':password' => $newAccountResponse->pasw ?? '',
                ':link' => config('app.dmz_url'),
            ],
            explode(',', $supplier->safeEmails())
        );

        // mail can fail on $mailGenerator->build()
        try {
            Mail::send($mailGenerator);
        } catch (Exception $e) {
            logCriticalException($e);

            return;
        }
    }

    /**
     * Supplier is being deleted? Delete also OpenLdap account.
     *
     * @param  Supplier  $supplier
     */
    public function deleteAccount(Supplier $supplier)
    {
        $this->client->delete($supplier->login ?? '');

        $supplier->update([
            'login' => null,
            'ldap_role_name' => null,
        ]);
    }

    /**
     * Get currently assigned OpenLdap client implementation instance.
     *
     * @return OpenLdapClientContract
     */
    public function getClient(): OpenLdapClientContract
    {
        return $this->client;
    }
}

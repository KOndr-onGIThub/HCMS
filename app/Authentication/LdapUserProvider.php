<?php

namespace App\Authentication;

use App\Business\OpenLdapManager;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use stdClass;

/**
 * Class LdapUserProvider
 *
 * Implementation of UserProvider,
 * use in combination with implementation of OpenLdapClient Contract
 * to handle users retrieved from TPCA`s OpenLdap service.
 *
 * @package App\Authentication
 */
class LdapUserProvider implements UserProvider
{
    /**
     * The Eloquent user model.
     *
     * @var string
     */
    protected $model;

    /**
     * @var OpenLdapManager
     */
    protected $openLdapManager;

    /**
     * Create a new database user provider.
     *
     * @param  string  $model   Class name of model which will be used to map ldap user to.
     */
    public function __construct(string $model)
    {
        $this->model = $model;
        $this->openLdapManager = resolve(OpenLdapManager::class);
    }

    /**
     * @inheritDoc
     */
    public function retrieveById($identifier)
    {
        if (empty($identifier)) {
            return null;
        }

        // try to fetch ldap user
        $ldapUser = $this->openLdapManager->retrieveById($identifier);

        if (is_null($ldapUser)) {
            return null;
        }

        // map ldap user into existing Authorizable model
        return $this->createLocalUser($ldapUser);
    }

    /**
     * Not implemented. Not used in DMZ mode.
     *
     * @inheritDoc
     */
    public function retrieveByToken($identifier, $token)
    {
        return null;
    }

    /**
     * Not implemented. Not used in DMZ mode.
     *
     * @inheritDoc
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        // void
    }

    /**
     * @inheritDoc
     */
    public function retrieveByCredentials(array $credentials)
    {
        // validate credentials format
        if (empty($credentials)
            || (count($credentials) === 1
                && array_key_exists('password', $credentials)
            )
        ) {
            return null;
        }

        /* @see \App\Http\Controllers\Auth\LoginController::authenticate */
        $username = $credentials['username'] ?? '';

        if (!is_string($username) || empty($username)) {
            return null;
        }

        // try to fetch ldap user
        $ldapUser = $this->openLdapManager->retrieveById($username);

        if (is_null($ldapUser)) {
            return null;
        }

        // map ldap user into existing Authorizable model
        return $this->createLocalUser($ldapUser);
    }

    /**
     * @inheritDoc
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return $user->getAuthPassword() === $credentials['password'];
    }

    /**
     * Map ldap user stdClass into existing Authorizable model
     *
     * @param  stdClass  $ldapUser
     * @return User
     */
    public function createLocalUser(stdClass $ldapUser)
    {
        $user = $this->createModel();

        $user->setName($ldapUser->sn[0] ?? '');
        $user->setSurname($ldapUser->sn[0] ?? '');
        $user->setWholeName($ldapUser->sn[0] ?? '');
        $user->setOsc('');
        $user->setPassword($ldapUser->userpassword[0] ?? '');
        $user->setMail('');
        $user->setDn($ldapUser->dn[0] ?? '');
        $user->setARoles($this->openLdapManager->accountRoles($ldapUser));
        $user->setLoginName($ldapUser->cn[0] ?? '');
        $user->assignSupplier();

        return $user;
    }

    /**
     * Create a new instance of the model.
     *
     * @return User
     */
    public function createModel()
    {
        $class = '\\'.ltrim($this->model, '\\');

        return new $class;
    }
}

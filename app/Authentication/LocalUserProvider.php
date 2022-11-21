<?php
/**
 * Created by PhpStorm.
 * User: Denny
 * Date: 12.02.2019
 * Time: 9:22
 */

namespace App\Authentication;


use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\ServiceProvider;

class LocalUserProvider extends ServiceProvider implements UserProvider
{

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        if ($identifier == 0 || $identifier == '') {
            return $this->createLocalUser();
        }

        return null;
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed $identifier
     * @param  string $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        // TODO: Implement retrieveByToken() method.
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  string $token
     * @return void
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        // TODO: Implement updateRememberToken() method.
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        if ($credentials['username'] != env('LOCAL_USER') || $credentials['password'] != env('LOCAL_PASS')) {
            return null;
        }

        return $this->createLocalUser();
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  array $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        if ($credentials['username'] != env('LOCAL_USER') || $credentials['password'] != env('LOCAL_PASS')) {
            return false;
        }

        return true;
    }

    private function createLocalUser()
    {
        $oLarUser = new User();
        $oLarUser->setName('Local');
        $oLarUser->setSurname('Tester');
        $oLarUser->setWholeName('Local Tester');
        $oLarUser->setOsc('0000');
        $oLarUser->setPassword(env('LOCAL_PASS'));
        $oLarUser->setMail(env('LOCAL_USER') . '@tpca.cz');
        $oLarUser->setDn('n/a');
        $oLarUser->setARoles(explode(',', env('LOCAL_ROLES')));
        $oLarUser->setLoginName(env('LOCAL_USER'));

        return $oLarUser;
    }
}
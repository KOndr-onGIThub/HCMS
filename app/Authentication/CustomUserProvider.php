<?php

namespace App\Authentication;

use App\Authentication\User;
use App\Authentication\UserLaravel;
use App\Authentication\AdamLaravel;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Auth\UserProvider;

class CustomUserProvider extends ServiceProvider implements UserProvider
{
    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials['username']) || empty($credentials['password'])) {
            return null;
        }

        $oAdam = new AdamLaravel();
        $user = $oAdam->authorizeUser($credentials['username'], $credentials['password']);
        if(!is_a($user, "UserLaravel")) {
            return null;
        }

        //jinak nastav uživatele a řekni OK
        $oLarUser = $this->createFromUserLaravel($user);

        return $oLarUser;
        // Get and return a user by looking up the given credentials
    }

    /**
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        if (class_exists('UserLaravel')) {
            $oUser = new UserLaravel();
            if(!is_null($oUser))
            {
                $oLarUser = $this->createFromUserLaravel($oUser);
                return $oLarUser;
            }
        }

        return null;
    }

    /**
     * @param  mixed   $identifier
     * @param  string  $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token) {
        // Get and return a user by their unique identifier and "remember me" token
    }

    /**
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  string  $token
     * @return void
     */
    public function updateRememberToken(\Illuminate\Contracts\Auth\Authenticatable $user, $token): void
    {
        // Save the given "remember me" token for the given user
    }


    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(\Illuminate\Contracts\Auth\Authenticatable $user, array $credentials): bool
    {
        if (empty($credentials['username']) || empty($credentials['password'])) {
            return false;
        }

        $oAdam = new AdamLaravel();
        $userAt = $oAdam->authorizeUser($credentials['username'], $credentials['password']);
        if(!is_a($userAt, "UserLaravel")) {
            return false;
        }

        return true;
    }


    private function createFromUserLaravel(UserLaravel $oUser)
    {
        $oLarUser = new User();
        $oLarUser->setName($oUser->getName());
        $oLarUser->setSurname($oUser->getSurname());
        $oLarUser->setWholeName($oUser->getWholeName());
        $oLarUser->setOsc($oUser->getOsc());
        $oLarUser->setPassword("XXX");
        $oLarUser->setMail($oUser->getMail());
        $oLarUser->setDn($oUser->getDn());
        $oLarUser->setARoles($oUser->getRoles());
        $oLarUser->setLoginName($oUser->getSamaccountname());

        return $oLarUser;
    }

}

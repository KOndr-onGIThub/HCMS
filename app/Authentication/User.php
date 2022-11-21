<?php

namespace App\Authentication;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable;

class User implements Authenticatable, Authorizable
{
    private $name;
    private $surname;
    private $wholeName;
    private $osc;
    private $password;
    private $mail;
    private $dn;
    private $aRoles;
    private $loginName;
    protected $rememberTokenName = 'remember_token';
    
    
    function getName() {
        return $this->name;
    }

    function getSurname() {
        return $this->surname;
    }

    function getWholeName() {
        return $this->wholeName;
    }

    function getOsc() {
        return $this->osc;
    }

    function getPassword() {
        return $this->password;
    }

    function getMail() {
        return $this->mail;
    }

    function getDn() {
        return $this->dn;
    }

    function getARoles() {
        return $this->aRoles;
    }

    function getLoginName() {
        return $this->loginName;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setSurname($surname) {
        $this->surname = $surname;
    }

    function setWholeName($wholeName) {
        $this->wholeName = $wholeName;
    }

    function setOsc($osc) {
        $this->osc = $osc;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setMail($mail) {
        $this->mail = $mail;
    }

    function setDn($dn) {
        $this->dn = $dn;
    }

    function setARoles($aRoles) {
        $this->aRoles = $aRoles;
    }

    function setLoginName($loginName) {
        $this->loginName = $loginName;
    }

    
        
    /**     
     * Return the name of unique identifier for the user (e.g. "id")
     * @see \Illuminate\Contracts\Auth\Authenticatable::getAuthIdentifierName()
     */
    public function getAuthIdentifierName()
    {
        return "loginName";
        // Return the name of unique identifier for the user (e.g. "id")
    }
    /**
     * Return the unique identifier for the user (e.g. their ID, 123)
     * @see \Illuminate\Contracts\Auth\Authenticatable::getAuthIdentifier()     
     */
    public function getAuthIdentifier()
    {        
        return $this->{$this->getAuthIdentifierName()};        
    }
    /**
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
        // Returns the (hashed) password for the user
    }
    /**
     * @return string
     */
    public function getRememberToken()
    {
        if (! empty($this->getRememberTokenName())) {
            return $this->{$this->getRememberTokenName()};
        }
        // Return the token used for the "remember me" functionality
    }
    /**
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        // Save a new token user for the "remember me" functionality
        if (! empty($this->getRememberTokenName())) {
            $this->{$this->getRememberTokenName()} = $value;
        }
    }
    /**
     * @return string
     */
    public function getRememberTokenName()
    {
        return $this->rememberTokenName;
        // Return the name of the column / attribute used to store the "remember me" token
    }

    public function can($ability, $arguments = array()): bool {
        
    }

}

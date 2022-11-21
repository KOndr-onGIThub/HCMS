<?php

namespace App\Contracts;

use stdClass;

interface OpenLdapClient
{
    /**
     * Read supplier account.
     *
     * @param  string  $userCn
     * @return stdClass|null
     */
    public function readOne(string $userCn): ?stdClass;

    /**
     * Read all users with common DN GROUP.
     *
     * @return array|null
     */
    public function readAll(): ?array;

    /**
     * Delete user account.
     *
     * @param  string  $userCn
     * @return bool
     */
    public function delete(string $userCn): bool;

    /**
     * Create or update user.
     *
     * @param  string  $userCn  nazev dodavatele (identifikátor účtu, bez mezer a diakritiky) = login
     * @param  string  $sn  název dodavatele
     * @param  string  $title  kod dodavatele
     * @param  string  $description  ""
     * @param  bool|null  $returnPassword  vrátí/nevrátí vygenerované heslo dodavatele (jen pro nové účty)
     * @return mixed [status (bool), pasw (string): only new]
     */
    public function save(
        string $userCn,
        string $sn,
        string $title,
        string $description,
        ?bool $returnPassword = true
    );

    /**
     * Attach role to user.
     *
     * @param  string  $userCn  User identifier = email address
     * @return bool
     */
    public function saveRole(string $userCn): bool;

    /**
     * Detach role from user.
     *
     * @param  string  $userCn
     * @return bool
     */
    public function deleteRole(string $userCn): bool;

    /**
     * Reset password.
     *
     * @param  string  $userCn  email/login
     * @return stdClass [status (boolean), newPasw (string)]
     */
    public function resetPassword(string $userCn): stdClass;

    /**
     * Get user ldap roles in application.
     *
     * @param  string  $userCn
     * @return array|null
     */
    public function findUserRoles(string $userCn): ?array;
}

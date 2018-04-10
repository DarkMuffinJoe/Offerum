<?php

namespace Offerum\Command\User;

use Offerum\Entity\User;

class SaveUserCommand
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $plainPassword;

    /**
     * @var int
     */
    public $role;

    /**
     * @var string
     */
    public $fullName;

    /**
     * @var string
     */
    public $addressStreet;

    /**
     * @var string
     */
    public $addressCity;

    /**
     * @var string
     */
    public $addressPostalCode;

    /**
     * @var string
     */
    public $addressCountry;

    /**
     * @var string
     */
    public $phoneNumber;

    /**
     * @param User $user
     * @return SaveUserCommand
     */
    public static function formEntity(User $user): self
    {
        $command = new self();

        $command->id = $user->getId();
        $command->username = $user->getUsername();
        $command->email = $user->getEmail();
        $command->fullName = $user->getFullName();
        $command->addressStreet = $user->getAddress()->street;
        $command->addressCity = $user->getAddress()->city;
        $command->addressPostalCode = $user->getAddress()->postalCode;
        $command->addressCountry = $user->getAddress()->country;
        $command->phoneNumber = $user->getPhoneNumber();

        $roles = $user->getRoles();

        if (in_array('ROLE_ADMIN', $roles)) {
            $command->role = User::ROLE_ADMIN;
        } elseif (in_array('ROLE_USER', $roles)) {
            $command->role = User::ROLE_USER;
        }

        return $command;
    }
}

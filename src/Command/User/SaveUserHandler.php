<?php

namespace Offerum\Command\User;

use Offerum\Entity\Address;
use Offerum\Entity\User;
use Offerum\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SaveUserHandler
{
    private $userRepository;
    private $passwordEncoder;

    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Handles SaveUserCommand and returns ID of there saved user
     *
     * @param SaveUserCommand $command
     *
     * @return int
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function handle(SaveUserCommand $command): int
    {
        if ($command->id) {
            $user = $this->userRepository->find($command->id);
        } else {
            $user = new User();
        }

        $address = new Address();

        $address->street = $command->addressStreet;
        $address->city = $command->addressCity;
        $address->postalCode = $command->addressPostalCode;
        $address->country = $command->addressCountry;

        $user->setUsername($command->username);
        $user->setEmail($command->email);
        $user->setRole($command->role);
        $user->setFullName($command->fullName);
        $user->setAddress($address);
        $user->setPhoneNumber($command->phoneNumber);

        if ($command->plainPassword) {
            $encodedPassword = $this->passwordEncoder->encodePassword($user, $command->plainPassword);
            $user->setPassword($encodedPassword);
        }

        $this->userRepository->save($user);

        return $user->getId();
    }
}

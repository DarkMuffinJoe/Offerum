<?php

namespace Offerum\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 *
 * @package Offerum\Entity
 *
 * @ORM\Entity(repositoryClass="Offerum\Repository\UserRepository")
 *
 * @UniqueEntity(fields="username", message="Nazwa użytkownika zajęta")
 * @UniqueEntity(fields="email", message="Email już w użyciu")
 */
class User implements UserInterface
{
    const ROLE_USER = 0;
    const ROLE_ADMIN = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $role;

    /**
     * @var string|string
     *
     * @ORM\Column(type="string")
     */
    private $fullName;

    /**
     * @var Address|string
     *
     * @ORM\Column(type="string")
     */
    private $address;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $phoneNumber;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        $roles = [];

        if ($this->role == self::ROLE_USER) {
            $roles[] = "ROLE_USER";
        } elseif ($this->role == self::ROLE_ADMIN) {
            $roles[] = "ROLE_ADMIN";
        }

        return $roles;
    }

    /**
     * @param int $role
     */
    public function setRole(int $role): void
    {
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     */
    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    /**
     * @return Address|string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param Address|string $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber|null
     */
    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getSalt()
    {
    }

    public function eraseCredentials()
    {
    }
}

<?php

namespace Offerum\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 * @package Offerum\Entity
 * @ORM\Entity(repositoryClass="Offerum\Repository\UserRepository")
 * @UniqueEntity(fields="username", message="Username already taken")
 * @UniqueEntity(fields="email", message="Email already taken")
 */
class User implements UserInterface
{
    const ROLE_USER = 0;
    const ROLE_ADMIN = 0;

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $username;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $role;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): ?string
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
    public function getEmail(): ?string
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

    public function getRoles()
    {
        $roles = [];

        if ($this->role == self::ROLE_USER) {
            $roles[] = "ROLE_USER";
        }
        elseif ($this->role == self::ROLE_ADMIN) {
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

    public function getSalt()
    {

    }

    public function eraseCredentials()
    {

    }
}
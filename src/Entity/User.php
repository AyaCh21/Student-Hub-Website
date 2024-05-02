<?php

// src/Entity/User.php
namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string')]
    private string $username;

    #[ORM\Column(type: 'string', length: 400, unique: true)]
    private ?string $email;

    #[ORM\Column(type: 'string')]
    private string $password;

    #[ORM\Column(type: 'int')]
    private int $phase;

    #[ORM\Column(type: 'string')]
    private string $specialization;

    #[ORM\Column(type: 'int')]
    private int $newUser;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    /**
     * @param int|null $id
     * @param string $username
     * @param string|null $email
     * @param string $password
     */
    public function __construct(string $username, string $password,?string $email, ?int $id=null)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email??'';  //to be filled in, should get from the db
        $this->password = $password;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * The public representation of the user (e.g. a username, an email address, etc.)
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getPhase(): int
    {
        return $this->phase;
    }

    public function setPhase(int $phase): void
    {
        $this->phase = $phase;
    }

    public function getSpecialization(): string
    {
        return $this->specialization;
    }

    public function setSpecialization(string $specialization): void
    {
        $this->specialization = $specialization;
    }

    public function getNewUser(): int
    {
        return $this->newUser;
    }

    public function setNewUser(int $newUser): void
    {
        $this->newUser = $newUser;
    }



    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
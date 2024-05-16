<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
#[ORM\Table('Student')]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 120)]
    private ?string $username = null;
    #[ORM\Column(length: 60)]
    private ?string $email = null;
    #[ORM\Column(length: 20)]
    private ?string $password = null;
    #[ORM\Column]
    private ?int $phase = null;
    #[ORM\Column(length: 20)]
    private ?string $specialisation=null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getPhase(): ?int
    {
        return $this->phase;
    }

    public function setPhase(?int $phase): void
    {
        $this->phase = $phase;
    }

    public function getSpecialisation(): ?string
    {
        return $this->specialisation;
    }

    public function setSpecialisation(?string $specialisation): void
    {
        $this->specialisation = $specialisation;
    }


//    static function getAllStudent() : array {
//        $stm = $db->prepare('SELECT id, email, password, username,phase,FROM student');
//        $stm->execute();
//        $result = array();
//        while ($item = $stm->fetch()) {
//            $Student = new Student($item['email']);
//            $Student->setId($item['id']);
//
//            $result[] = $Student;
//        };
//        return $result;
//    }
}

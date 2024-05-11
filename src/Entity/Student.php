<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
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

    #[ORM\OneToMany(targetEntity: ProfessorRate::class, mappedBy: 'student')]
    private ProfessorRate $rate;

    public function __construct()
    {
        $this->rates = new ArrayCollection();
    }

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

    static function getAllStudent() : array {
        $stm = $db->prepare('SELECT id, email, password, username,phase,FROM student');
        $stm->execute();
        $result = array();
        while ($item = $stm->fetch()) {
            $Student = new Student($item['email']);
            $Student->setId($item['id']);

            $result[] = $Student;
        };
        return $result;
    }

    /**
     * @return Collection<int, ProfessorRate>
     */
    public function getRates(): Collection
    {
        return $this->rates;
    }

    public function addRate(ProfessorRate $rate): static
    {
        if (!$this->rates->contains($rate)) {
            $this->rates->add($rate);
            $rate->setStudent($this);
        }

        return $this;
    }

    public function removeRate(ProfessorRate $rate): static
    {
        if ($this->rates->removeElement($rate)) {
            // set the owning side to null (unless already changed)
            if ($rate->getStudent() === $this) {
                $rate->setStudent(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\InscriptionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionsRepository::class)]
class Inscriptions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Student::class, inversedBy: 'inscriptions')]
    private Collection $Students;

    #[ORM\ManyToMany(targetEntity: Session::class, inversedBy: 'inscriptions')]
    private Collection $sessions;

    public function __construct()
    {
        $this->Students = new ArrayCollection();
        $this->sessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudents(): Collection
    {
        return $this->Students;
    }

    public function addStudent(Student $student): static
    {
        if (!$this->Students->contains($student)) {
            $this->Students->add($student);
        }

        return $this;
    }

    public function removeStudent(Student $student): static
    {
        $this->Students->removeElement($student);

        return $this;
    }

    /**
     * @return Collection<int, Session>
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): static
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions->add($session);
        }

        return $this;
    }

    public function removeSession(Session $session): static
    {
        $this->sessions->removeElement($session);

        return $this;
    }
}

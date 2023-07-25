<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Symfony\Component\Form\FormTypeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $label = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datebegin = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateend = null;

    #[ORM\Column]
    private ?int $capacity = null;

    #[ORM\ManyToOne(inversedBy: 'sessions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Formation $formation = null;

    #[ORM\ManyToMany(targetEntity: Student::class, mappedBy: 'sessions')]
    private Collection $students;

    #[ORM\OneToMany(mappedBy: 'session', targetEntity: Program::class, orphanRemoval: true)]
    private Collection $programs;

    public function __construct()
    {
        $this->students = new ArrayCollection();
        $this->programs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getDatebegin(): ?\DateTimeInterface
    {
        return $this->datebegin;
    }

    public function setDatebegin(\DateTimeInterface $datebegin): static
    {
        $this->datebegin = $datebegin;

        return $this;
    }

    public function getDateend(): ?\DateTimeInterface
    {
        return $this->dateend;
    }

    public function setDateend(\DateTimeInterface $dateend): static
    {
        $this->dateend = $dateend;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): static
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): static
    {
        $this->formation = $formation;

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): static
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);
            $student->addSession($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): static
    {
        if ($this->students->removeElement($student)) {
            $student->removeSession($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Program>
     */
    public function getPrograms(): Collection
    {
        return $this->programs;
    }

    public function addProgram(Program $program): static
    {
        if (!$this->programs->contains($program)) {
            $this->programs->add($program);
            $program->setSession($this);
        }

        return $this;
    }

    public function removeProgram(Program $program): static
    {
        if ($this->programs->removeElement($program)) {
            // set the owning side to null (unless already changed)
            if ($program->getSession() === $this) {
                $program->setSession(null);
            }
        }

        return $this;
    }
}

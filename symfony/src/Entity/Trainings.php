<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TrainingsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrainingsRepository::class)]
#[ApiResource]
class Trainings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\OneToMany(mappedBy: 'training', targetEntity: Skills::class)]
    private $skill;

    public function __construct()
    {
        $this->skill = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, Skills>
     */
    public function getSkill(): Collection
    {
        return $this->skill;
    }

    public function addSkill(Skills $skill): self
    {
        if (!$this->skill->contains($skill)) {
            $this->skill[] = $skill;
            $skill->setTraining($this);
        }

        return $this;
    }

    public function removeSkill(Skills $skill): self
    {
        if ($this->skill->removeElement($skill)) {
            // set the owning side to null (unless already changed)
            if ($skill->getTraining() === $this) {
                $skill->setTraining(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AuthorRepository::class)
 */
class Author
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fullname;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="author", cascade={"persist"})
     */
    private $biography;

    public function __construct()
    {
        $this->biography = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getBiography(): Collection
    {
        return $this->biography;
    }

    public function addBiography(Article $biography): self
    {
        if (!$this->biography->contains($biography)) {
            $this->biography[] = $biography;
            $biography->setAuthor($this);
        }

        return $this;
    }

    public function removeBiography(Article $biography): self
    {
        if ($this->biography->removeElement($biography)) {
            // set the owning side to null (unless already changed)
            if ($biography->getAuthor() === $this) {
                $biography->setAuthor(null);
            }
        }

        return $this;
    }
}

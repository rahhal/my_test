<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CityRepository::class)
 */
class City
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Neighborhood::class, mappedBy="city")
     */
    private $neighborhoods;

    /**
     * @ORM\OneToMany(targetEntity=Person::class, mappedBy="city")
     */
    private $people;

    public function __construct()
    {
        $this->neighborhoods = new ArrayCollection();
        $this->people = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Neighborhood[]
     */
    public function getNeighborhoods(): Collection
    {
        return $this->neighborhoods;
    }

    public function addNeighborhood(Neighborhood $neighborhood): self
    {
        if (!$this->neighborhoods->contains($neighborhood)) {
            $this->neighborhoods[] = $neighborhood;
            $neighborhood->setCity($this);
        }

        return $this;
    }

    public function removeNeighborhood(Neighborhood $neighborhood): self
    {
        if ($this->neighborhoods->contains($neighborhood)) {
            $this->neighborhoods->removeElement($neighborhood);
            // set the owning side to null (unless already changed)
            if ($neighborhood->getCity() === $this) {
                $neighborhood->setCity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Person[]
     */
    public function getPeople(): Collection
    {
        return $this->people;
    }

    public function addPerson(Person $person): self
    {
        if (!$this->people->contains($person)) {
            $this->people[] = $person;
            $person->setCity($this);
        }

        return $this;
    }

    public function removePerson(Person $person): self
    {
        if ($this->people->contains($person)) {
            $this->people->removeElement($person);
            // set the owning side to null (unless already changed)
            if ($person->getCity() === $this) {
                $person->setCity(null);
            }
        }

        return $this;
    }
    public function __toString(){
        return $this->getName();
    }
}

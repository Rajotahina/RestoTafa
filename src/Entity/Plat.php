<?php

namespace App\Entity;

use App\Repository\PlatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlatRepository::class)]
class Plat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NomPlat = null;

    #[ORM\Column(length: 255)]
    private ?string $DescriptionPlat = null;

    #[ORM\Column(length: 255)]
    private ?int $prices = null;

    #[ORM\Column(length: 255)]
    private ?string $photo = null;

    #[ORM\Column(length: 255)]
    private ?string $libelleCategorie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPlat(): ?string
    {
        return $this->NomPlat;
    }

    public function setNomPlat(string $NomPlat): self
    {
        $this->NomPlat = $NomPlat;

        return $this;
    }

    public function getDescriptionPlat(): ?string
    {
        return $this->DescriptionPlat;
    }

    public function setDescriptionPlat(string $DescriptionPlat): self
    {
        $this->DescriptionPlat = $DescriptionPlat;

        return $this;
    }

    public function getPrices(): ?int
    {
        return $this->prices;
    }

    public function setPrices(int $prices): self
    {
        $this->prices = $prices;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getLibelleCategorie(): ?string
    {
        return $this->libelleCategorie;
    }

    public function setLibelleCategorie(string $libelleCategorie): self
    {
        $this->libelleCategorie = $libelleCategorie;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\ToDoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ToDoRepository::class)]
class ToDo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $Estado = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $FechaCreacion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->Nombre;
    }

    public function setNombre(string $Nombre): static
    {
        $this->Nombre = $Nombre;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->Estado;
    }

    public function setEstado(string $Estado): static
    {
        $this->Estado = $Estado;

        return $this;
    }

    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->FechaCreacion;
    }

    public function setFechaCreacion(\DateTimeInterface $FechaCreacion): static
    {
        $this->FechaCreacion = $FechaCreacion;

        return $this;
    }
}

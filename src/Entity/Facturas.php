<?php

namespace App\Entity;

use App\Repository\FacturasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FacturasRepository::class)]
class Facturas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\OneToMany(targetEntity: DetallesFactura::class, mappedBy: 'Factura')]
    private Collection $detallesFacturas;

    #[ORM\Column]
    private ?int $numero = null;

    #[ORM\Column]
    private ?int $estado = null;

    public function __construct()
    {
        $this->detallesFacturas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return Collection<int, DetallesFactura>
     */
    public function getDetallesFacturas(): Collection
    {
        return $this->detallesFacturas;
    }

    public function addDetallesFactura(DetallesFactura $detallesFactura): static
    {
        if (!$this->detallesFacturas->contains($detallesFactura)) {
            $this->detallesFacturas->add($detallesFactura);
            $detallesFactura->setFactura($this);
        }

        return $this;
    }

    public function removeDetallesFactura(DetallesFactura $detallesFactura): static
    {
        if ($this->detallesFacturas->removeElement($detallesFactura)) {
            // set the owning side to null (unless already changed)
            if ($detallesFactura->getFactura() === $this) {
                $detallesFactura->setFactura(null);
            }
        }

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getEstado(): ?int
    {
        return $this->estado;
    }

    public function setEstado(int $estado): static
    {
        $this->estado = $estado;

        return $this;
    }
}

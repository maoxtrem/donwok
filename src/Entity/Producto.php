<?php

namespace App\Entity;

use App\Repository\ProductoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductoRepository::class)]
class Producto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column]
    private ?int $precio = null;

    #[ORM\OneToMany(targetEntity: DetallesFactura::class, mappedBy: 'Producto')]
    private Collection $detallesFacturas;

    #[ORM\Column(length: 255)]
    private ?string $codigo = null;

    #[ORM\Column]
    private ?int $grupo = null;

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


    public function getPrecio(): ?int
    {
        return $this->precio;
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
            $detallesFactura->setProducto($this);
        }

        return $this;
    }

    public function removeDetallesFactura(DetallesFactura $detallesFactura): static
    {
        if ($this->detallesFacturas->removeElement($detallesFactura)) {
            // set the owning side to null (unless already changed)
            if ($detallesFactura->getProducto() === $this) {
                $detallesFactura->setProducto(null);
            }
        }

        return $this;
    }

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): static
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getGrupo(): ?int
    {
        return $this->grupo;
    }

    public function setGrupo(int $grupo): static
    {
        $this->grupo = $grupo;

        return $this;
    }

}

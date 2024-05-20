<?php

namespace App\Entity;

use App\Repository\DetallesFacturaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetallesFacturaRepository::class)]
class DetallesFactura
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'detallesFacturas')]
    private ?Producto $Producto = null;

    #[ORM\ManyToOne(inversedBy: 'detallesFacturas')]
    private ?Facturas $Factura = null;

    #[ORM\Column]
    private ?int $estado = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProducto(): ?Producto
    {
        return $this->Producto;
    }

    public function setProducto(?Producto $Producto): static
    {
        $this->Producto = $Producto;

        return $this;
    }

    public function getFactura(): ?Facturas
    {
        return $this->Factura;
    }

    public function setFactura(?Facturas $Factura): static
    {
        $this->Factura = $Factura;

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

<?php

namespace App\Repository;

use App\Entity\DetallesFactura;
use App\Entity\Facturas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DetallesFactura>
 *
 * @method DetallesFactura|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetallesFactura|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetallesFactura[]    findAll()
 * @method DetallesFactura[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetallesFacturaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, DetallesFactura::class);
        $this->entityManager = $entityManager;
    }

    public function guardar(DetallesFactura $entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
    public function borrar(DetallesFactura $entity)
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }
    public function getAllDetallesByFactura(Facturas $facturas): array
    {
        $qb = $this->createQueryBuilder('d')
            ->select('d','p','f')
            ->leftJoin('d.Factura', 'f')
            ->leftJoin('d.Producto', 'p')
            ->where('f.id = :factura')
            ->setParameter('factura', $facturas);
        return $qb->getQuery()->getArrayResult();
    }
}

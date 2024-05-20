<?php

namespace App\Repository;

use App\Entity\Facturas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Facturas>
 *
 * @method Facturas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Facturas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Facturas[]    findAll()
 * @method Facturas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FacturasRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $entityManager;


    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {

        parent::__construct($registry, Facturas::class);
        $this->entityManager = $entityManager;
    }


    public function facturaNumero(): int
    {
        return count($this->findAll()) + 1;
    }

    public function guardar(Facturas $entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }



}

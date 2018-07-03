<?php

namespace App\Repository;

use App\Entity\Allocation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Allocation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Allocation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Allocation[]    findAll()
 * @method Allocation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AllocationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Allocation::class);
    }

    public function findAllClassroomSchedule()
    {

        return $this->createQueryBuilder('a')
            ->addSelect('a')
            ->addSelect('w.abbreviation')
            ->addSelect('b.id')
            ->leftJoin('a.section', 's')
            ->leftJoin('a.classroom', 'c')
            ->leftJoin('s.schedule', 'sc')
            ->leftJoin('sc.block', 'b')
            ->leftJoin('sc.weekday', 'w')
            ->getQuery()
            ->getResult();
        // $entityManager = $this->getEntityManager();

    }
//    /**
//     * @return Allocation[] Returns an array of Allocation objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Allocation
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

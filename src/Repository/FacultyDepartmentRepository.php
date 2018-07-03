<?php

namespace App\Repository;

use App\Entity\FacultyDepartment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FacultyDepartment|null find($id, $lockMode = null, $lockVersion = null)
 * @method FacultyDepartment|null findOneBy(array $criteria, array $orderBy = null)
 * @method FacultyDepartment[]    findAll()
 * @method FacultyDepartment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FacultyDepartmentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FacultyDepartment::class);
    }

//    /**
//     * @return FacultyDepartment[] Returns an array of FacultyDepartment objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FacultyDepartment
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

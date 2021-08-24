<?php

namespace App\Repository;

use App\Entity\Jeuxvideo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Jeuxvideo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Jeuxvideo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Jeuxvideo[]    findAll()
 * @method Jeuxvideo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JeuxvideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Jeuxvideo::class);
    }

    // /**
    //  * @return Jeuxvideo[] Returns an array of Jeuxvideo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Jeuxvideo
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

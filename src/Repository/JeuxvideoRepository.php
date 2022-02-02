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
    public function findByJeuxvideoField($value)
    {
        return $this->createQueryBuilder('j')
                    ->select('j as jeuxvideo, u.slug as userSlug')
                    ->join('j.user', 'u')
                    ->groupBy('j')
                    ->orderBy('DESC')
                    ->getQuery()
                    ->getResult()
        ;
    }
    
    /**
     * @return Int Jeuxvideo
     */
    public function countAllJeuxvideo()
    {
        return $this->createQueryBuilder('j')
                    ->select('j as jeuxvideo, COUNT(j) as jeuxvideoCount')
                    ->getQuery()
                    ->getResult()
        ;
    }

    public function findByJeuxvideoCarousel($limit)
    {
        return $this->createQueryBuilder('j')
                    ->select('j.coverImage')
                    ->setMaxResults($limit)
                    ->getQuery()
                    ->getResult();
    }
    // public function findByCarousel(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    // {
    //     return $this->createQueryBuilder('j')
    //                 ->select('j as jeuxvideo')
    //                 ->setMaxResults(3)
    //                 ->getQuery()
    //                 ->getResult();
    // }

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

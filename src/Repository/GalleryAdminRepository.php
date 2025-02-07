<?php

namespace App\Repository;

use App\Entity\GalleryAdmin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method GalleryAdmin|null find($id, $lockMode = null, $lockVersion = null)
 * @method GalleryAdmin|null findOneBy(array $criteria, array $orderBy = null)
 * @method GalleryAdmin[]    findAll()
 * @method GalleryAdmin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GalleryAdminRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GalleryAdmin::class);
    }

    // /**
    //  * @return GalleryAdmin[] Returns an array of GalleryAdmin objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GalleryAdmin
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

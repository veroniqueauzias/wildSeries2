<?php

namespace App\Repository;

use App\Entity\Episode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Episode|null find($id, $lockMode = null, $lockVersion = null)
 * @method Episode|null findOneBy(array $criteria, array $orderBy = null)
 * @method Episode[]    findAll()
 * @method Episode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EpisodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Episode::class);
    }


    /**
     * Returns all Episodes per page
     * @return void 
     */
    public function getPaginatedEpisodes($limit, $page) {
        $query = $this->createQueryBuilder('e')
            ->orderBy('e.title')
            ->setFirstResult(($page * $limit) - $limit) //ex: je suis à la page 1 et j'ai 5 éléments par page le 1er élément sera 1*5 -5 soit l'élément 0. A lapage 2: 2*5 - 5: le 1er élément sera le n° 5
            ->setMaxResults($limit)
        ;
        return $query->getQuery()->getResult();
    }
     /**
     * Returns nb of sites
     */
    public function getTotalEpisodes() {
        $query = $this->createQueryBuilder('e')
            ->select('COUNT(e)');
        return $query->getQuery()->getSingleScalarResult(); // get result retourne un tableau, getSingle.... retourne juste le chiffre
    }



    // /**
    //  * @return Episode[] Returns an array of Episode objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Episode
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

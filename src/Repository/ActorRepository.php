<?php

namespace App\Repository;

use App\Entity\Actor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Actor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Actor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Actor[]    findAll()
 * @method Actor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Actor::class);
    }

     /**
     * Returns all programs per page for pagination
     * @return void 
     */
    public function getPaginatedActors($limit, $page) {
        $query = $this->createQueryBuilder('a')
            ->orderBy('a.lastName')
            ->setFirstResult(($page * $limit) - $limit) //ex: je suis à la page 1 et j'ai 5 éléments par page le 1er élément sera 1*5 -5 soit l'élément 0. A lapage 2: 2*5 - 5: le 1er élément sera le n° 5
            ->setMaxResults($limit)
        ;
        return $query->getQuery()->getResult();
    }
     /**
     * Returns nb of programs to calculaite number of pages
     */
    public function getTotalActors() {
        $query = $this->createQueryBuilder('a')
            ->select('COUNT(a)');
        return $query->getQuery()->getSingleScalarResult(); // get result retourne un tableau, getSingle.... retourne juste le chiffre
    }

    // /**
    //  * @return Actor[] Returns an array of Actor objects
    //  */
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
    public function findOneBySomeField($value): ?Actor
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

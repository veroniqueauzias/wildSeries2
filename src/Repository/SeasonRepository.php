<?php

namespace App\Repository;

use App\Entity\Season;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Season|null find($id, $lockMode = null, $lockVersion = null)
 * @method Season|null findOneBy(array $criteria, array $orderBy = null)
 * @method Season[]    findAll()
 * @method Season[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeasonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Season::class);
    }

    /**
     * Returns all episodes per page for pagination
     * @return void 
     */
    public function getPaginatedSeasons($limit, $page) {
        $query = $this->createQueryBuilder('s')
            ->join('s.program', 'p')
            ->join('p.category', 'c')
            ->orderBy('c.name')
            ->addorderBy('p.title')
            ->setFirstResult(($page * $limit) - $limit) //ex: je suis à la page 1 et j'ai 5 éléments par page le 1er élément sera 1*5 -5 soit l'élément 0. A lapage 2: 2*5 - 5: le 1er élément sera le n° 5
            ->setMaxResults($limit)
        ;
        return $query->getQuery()->getResult();
    }
     /**
     * Returns nb of episods to calculaite number of pages
     */
    public function getTotalSeasons() {
        $query = $this->createQueryBuilder('s')
            ->select('COUNT(s)');
        return $query->getQuery()->getSingleScalarResult(); // get result retourne un tableau, getSingle.... retourne juste le chiffre
    }

    // /**
    //  * @return Season[] Returns an array of Season objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Season
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

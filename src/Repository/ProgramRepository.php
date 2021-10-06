<?php

namespace App\Repository;

use App\Entity\Program;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Program|null find($id, $lockMode = null, $lockVersion = null)
 * @method Program|null findOneBy(array $criteria, array $orderBy = null)
 * @method Program[]    findAll()
 * @method Program[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgramRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Program::class);
    }

    /**
     * Returns all programs per page for pagination
     * @return void 
     */
    public function getPaginatedPrograms($limit, $page) {
        $query = $this->createQueryBuilder('p')
            ->orderBy('p.title')
            ->setFirstResult(($page * $limit) - $limit) //ex: je suis à la page 1 et j'ai 5 éléments par page le 1er élément sera 1*5 -5 soit l'élément 0. A lapage 2: 2*5 - 5: le 1er élément sera le n° 5
            ->setMaxResults($limit)
        ;
        return $query->getQuery()->getResult();
    }
     /**
     * Returns nb of programs to calculaite number of pages
     */
    public function getTotalPrograms() {
        $query = $this->createQueryBuilder('p')
            ->select('COUNT(p)');
        return $query->getQuery()->getSingleScalarResult(); // get result retourne un tableau, getSingle.... retourne juste le chiffre
    }


    // /**
    //  * @return Program[] Returns an array of Program objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Program
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

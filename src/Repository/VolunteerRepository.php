<?php

namespace App\Repository;

use App\Entity\Volunteer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Volunteer>
 */
class VolunteerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Volunteer::class);
    }

    public function listAll(): array
    {
        $qb = $this->createQueryBuilder('volunteer');

        $qb
            ->addSelect('user')
            ->addSelect('project')
            ->addSelect('event')
            ->leftJoin('volunteer.forUser', 'user')
            ->leftJoin('volunteer.project', 'project')
            ->leftJoin('volunteer.event', 'event')
        ;

        return $qb->getQuery()->getResult();
    }

    //    /**
    //     * @return Volunteer[] Returns an array of Volunteer objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('v.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Volunteer
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

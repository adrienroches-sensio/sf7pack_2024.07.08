<?php

namespace App\Repository;

use App\Entity\Event;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use InvalidArgumentException;

/**
 * @extends ServiceEntityRepository<Event>
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * @return list<Event>
     */
    public function listAll(): array
    {
        return $this->findAll();
    }

    /**
     * @return list<Event>
     *
     * @throws InvalidArgumentException If both $start & $end are null.
     */
    public function searchEventsBetweenDates(DateTimeImmutable|null $start = null, DateTimeImmutable|null $end = null): array
    {
        if (null === $start && null === $end) {
            throw new InvalidArgumentException('At least one date is required to operate this method.');
        }

        $qb = $this->createQueryBuilder('event');

        if (null !== $start) {
            $qb->andWhere($qb->expr()->gte('event.startAt', ':start'))
                ->setParameter('start', $start)
            ;
        }

        if (null !== $end) {
            $qb->andWhere($qb->expr()->lte('event.endAt', ':end'))
                ->setParameter('end', $end)
            ;
        }

        return $qb->getQuery()->getResult();
    }

    //    /**
    //     * @return Event[] Returns an array of Event objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Event
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

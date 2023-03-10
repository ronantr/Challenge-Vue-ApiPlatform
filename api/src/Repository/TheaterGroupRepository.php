<?php

namespace App\Repository;

use App\Entity\TheaterGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TheaterGroup>
 *
 * @method TheaterGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method TheaterGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method TheaterGroup[]    findAll()
 * @method TheaterGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TheaterGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TheaterGroup::class);
    }

    public function add(TheaterGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TheaterGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findNotClosedTheaterGroupsByRepresentative($representative): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.representative = :representative')
            ->andWhere('t.status != :status')
            ->setParameter('representative', $representative)
            ->setParameter('status', 'closed')
            ->getQuery()
            ->getResult();
    }

    public function findNotClosedTheaterGroupsByPhoneNumber($phoneNumber): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.phoneNumber = :phoneNumber')
            ->andWhere('t.status != :status')
            ->setParameter('phoneNumber', $phoneNumber)
            ->setParameter('status', 'closed')
            ->getQuery()
            ->getResult();   
    }

    public function findNotClosedTheaterGroupsByName($name): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.name = :name')
            ->andWhere('t.status != :status')
            ->setParameter('name', $name)
            ->setParameter('status', 'closed')
            ->getQuery()
            ->getResult();   
    }

//    /**
//     * @return TheaterGroup[] Returns an array of TheaterGroup objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TheaterGroup
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

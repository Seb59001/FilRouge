<?php

namespace App\Repository;

use App\Entity\Presence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Presence>
 *
 * @method Presence|null find($id, $lockMode = null, $lockVersion = null)
 * @method Presence|null findOneBy(array $criteria, array $orderBy = null)
 * @method Presence[]    findAll()
 * @method Presence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PresenceRepository extends ServiceEntityRepository
{
    public function recupererPresent($IdCours){
        
        $qb = $this->createQueryBuilder('a');
        $qb->select('a.present');
        $qb->where('a.presence_cours = :IdCours and a.present = 1');
        $qb->setParameter('IdCours', $IdCours);
        return $qb->getQuery()->getResult();
    }
    public function recupererAbsent($IdCours){
        $qb = $this->createQueryBuilder('a');
        $qb->select('a.present');
        $qb->where('a.presence_cours = :IdCours and a.present = 0');
        $qb->setParameter('IdCours', $IdCours);
        return $qb->getQuery()->getResult();
    }



    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Presence::class);
    }

    public function save(Presence $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Presence $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Presence[] Returns an array of Presence objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Presence
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function getPresenceyUser($user_cours_id)
    {
        return $this->createQueryBuilder('p')
            ->join('p.presence_cours', 'cr')
            ->where('cr.user_cours = :user_cours_id')
            ->setParameter('user_cours_id', $user_cours_id);
    }


}

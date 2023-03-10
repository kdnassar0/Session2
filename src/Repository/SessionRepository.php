<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Session>
 *
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);

        
    }

    public function add(Session $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Session $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Session[] Returns an array of Session objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }
public function findSessionsPassees(){
    //Récupérer la date du jour
    //class native php, on met donc un antislash
    $now = new \DateTime();
    return $this->createQueryBuilder('s')
       ->andWhere('s.dateFin < :val')
       -> setParameter('val',$now)
        ->orderBy('s.dateDebut', 'ASC')
        ->getQuery()
        ->getResult();
}
public function findSessionsEncours(){
    //Récupérer la date du jour
    //class native php, on met donc un antislash
    $now = new \DateTime();
    return $this->createQueryBuilder('s')
       ->andWhere('s.dateDebut < :val and s.dateFin > :val ' )
       -> setParameter('val',$now)
        ->orderBy('s.dateDebut', 'ASC')
        ->getQuery()
        ->getResult();
}
public function findSessionsAvenir(){
    //Récupérer la date du jour
    //class native php, on met donc un antislash
    $now = new \DateTime();
    return $this->createQueryBuilder('s')
       ->andWhere('s.dateDebut > :val')
       -> setParameter('val',$now)
        ->orderBy('s.dateDebut', 'ASC')
        ->getQuery()
        ->getResult();
}



//    public function findOneBySomeField($value): ?Session
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

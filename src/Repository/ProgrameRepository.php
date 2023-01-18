<?php

namespace App\Repository;

use App\Entity\Programe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Programe>
 *
 * @method Programe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Programe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Programe[]    findAll()
 * @method Programe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgrameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Programe::class);
    }

    public function add(Programe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Programe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }





//afficher les cours non programmeés

public function findCoursNonProgrammees($sessionId){

    $em =$this->getEntityManager();
    $sub=$em->createQueryBuilder();

    $qd = $sub ;
    $qd->select('c')

    ->from('App\Entity\Cours','c')
    ->leftJoin('c.programes','p')
    ->innerJoin('p.session','session')
    ->where('session.id = :id'); 

    $sub = $em->createQueryBuilder();
    $sub->select('st')

    ->from('App\Entity\Cours','st')
    ->where($sub->expr()->notIn('st.id',$qd->getDQL()))
    ->setParameter('id',$sessionId);
    // ->orderBy('st.nomPrograme');

    $query = $sub->getQuery();
    return $query->getResult();
}










//    /**
//     * @return Programe[] Returns an array of Programe objects
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

//    public function findOneBySomeField($value): ?Programe
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

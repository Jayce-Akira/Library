<?php

namespace App\Repository;

use App\Entity\Loan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Loan>
 *
 * @method Loan|null find($id, $lockMode = null, $lockVersion = null)
 * @method Loan|null findOneBy(array $criteria, array $orderBy = null)
 * @method Loan[]    findAll()
 * @method Loan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LoanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Loan::class);
    }

    public function add(Loan $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Loan $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // Update pour les pret en retard
    public function updateLate($date){
        return $this->createQueryBuilder('l')
        ->update()
        ->set('l.is_late', 1)
        ->where('l.date_loan =:date')
        ->andWhere('l.is_late = 0' )
        ->setParameter(':date', $date)
        ->getQuery()
        // ->getSQL();
        ->getResult();
    }

    // on supprime les livres reserve non recupere
    public function deleteLoanDateReserved($date){
        return $this->createQueryBuilder('l')
        ->delete()
        ->where('l.date_reserved = :date')
        ->andWhere('l.date_loan is Null')
        ->setParameter(':date', $date)
        ->getQuery()
        ->getResult();
    }


        // SELECT * FROM `loan` LEFT JOIN `user` ON loan.users_id = user.id LEFT JOIN `book`ON loan.book_id = book.id WHERE user.id = 10 AND loan.date_loan IS NOT NULL
        public function loanUserConfirmed($id){
            return $this->createQueryBuilder('l')
            ->leftJoin('l.book', 'b')
            ->leftJoin('l.users', 'u')
            ->Where('u.id = :iduser')
            ->andWhere('l.date_loan is not Null')
            ->setParameter('iduser', $id)
            ->getQuery()
            ->getResult();
    
        }

    // SELECT * FROM `loan` LEFT JOIN `user` ON loan.users_id = user.id LEFT JOIN `book`ON loan.book_id = book.id WHERE user.id = 10 AND loan.date_loan IS NULL
    public function loanUser($id){
        return $this->createQueryBuilder('l')
        ->leftJoin('l.book', 'b')
        ->leftJoin('l.users', 'u')
        ->Where('u.id = :iduser')
        ->andWhere('l.date_loan is Null')
        ->setParameter('iduser', $id)
        ->getQuery()
        ->getResult();

    }

    // SELECT * FROM `loan` LEFT JOIN `user` ON loan.users_id = user.id LEFT JOIN `book` ON loan.book_id = book.id WHERE user.id = ? AND book.id = ?
    public function loanReserved($idBook, $idUser)
    {
        return $this->createQueryBuilder('l')
            ->leftJoin('l.book', 'b')
            ->leftJoin('l.users', 'u')
            ->where('b.id= :idbook')
            ->andWhere('u.id = :iduser')
            ->setParameter('idbook', $idBook)
            ->setParameter('iduser', $idUser)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Loan[] Returns an array of Loan objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Loan
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

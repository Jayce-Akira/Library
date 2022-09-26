<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Loan;
use App\Repository\BookRepository;
use App\Repository\LoanRepository;
use DateInterval;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\DateTime as ConstraintsDateTime;

class LoanController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/loan', name: 'app_loan', methods:['GET', 'POST'])]
    public function index(UserInterface $user, LoanRepository $loanRepository, BookRepository $bookRepository, EntityManagerInterface $manager): Response
    {
        /*
        /1 DELETE FROM loan WHERE date_reserved < DATE_SUB( now(), INTERVAL 4 DAY )
        /1 Recuperer la date de réservation => 3 jours pour le récuperer (un décompte des jours ?)=> delete la réservation
        /2 Recupere dans les 3 jours => Employe enregistre la récupération du livre => ajoute auto le pret 7 jours ?
        /3 Si recuperer => recuperer la date de retour de pret =>  message flash "Vous devez rendre le livre au plus vite"
        /4 faute orthographe !!!!
        */
        
        $filterDateReserved = $loanRepository->loanUser($user);
        $daysSeconde3days = 60 * 60 * 24 * 4; // je rajoute + 1 afin d'avoir je jour J
        $timestampPresent = time();
        $i = 0;
        foreach($filterDateReserved as $laonDateReserved)
        {
            $value[$i]['date_reserved'] = $laonDateReserved->getDateReserved();
            $value[$i]['id'] = $laonDateReserved->getId();
            $value[$i]['book'] = $laonDateReserved->getBook();
            // dd($value[$i]);
            if( ($value[$i]['date_reserved']->getTimestamp() + $daysSeconde3days) < $timestampPresent ){
                // Suppression des date de réservation qui dépassent les 3 jours;
                $loanRepository->deleteLoanDateReserved($value[$i]['date_reserved']);
                // Incremente le nb de book + 1
                $book = $value[$i]['book'];
                $addBook = $book->setNbOfBook($book->getNbOfBook() +1 );
                $manager->persist($addBook);
                $manager->flush();

                $this->addFlash(
                    'warning',
                    'Vos réservations qui ont dépassé les 3 jours ont été supprimées !'
                );

            }
            $i++;
        }

        $filterDateConfirmed = $loanRepository->loanUserConfirmed($user);
        // dd($filterDateConfirmed);
        $daysSeconde7days = 60 * 60 * 24 * 8; // je rajoute + 1 afin d'avoir je jour J
        $timestampPresent = time();
        $i = 0;
        foreach($filterDateConfirmed as $laonDateConfirmed)
        {
            $value[$i]['id'] = $laonDateConfirmed->getId();
            $value[$i]['date_loan'] = $laonDateConfirmed->getDateLoan();
            $value[$i]['is_late'] = $laonDateConfirmed->getIsLate();
            // dd($value[$i]);
            if( (($value[$i]['date_loan']->getTimestamp() + $daysSeconde7days) < $timestampPresent) AND $value[$i]['is_late'] != 1 ){

                // dd($loanRepository->updateLate($value[$i]['date_loan']));
                $loanRepository->updateLate($value[$i]['date_loan']);

                $this->addFlash(
                    'danger',
                    'Vos prêt doit être rendu au plus vite !'
                );

            }
            $i++;
        }
        
        $loanUser = $loanRepository->loanUser($user);

        $loanUserConfirmed = $loanRepository->loanUserConfirmed($user);

        return $this->render('loan/index.html.twig', [
            'loanUser' => $loanUser,
            'loanUserConfirmed' => $loanUserConfirmed,
            'books' => $bookRepository->lastTree(),
        ]);
    }



    #[IsGranted('ROLE_USER')]
    #[Route('/loan/delete/{id}', name: 'delete_loan', methods:['GET', 'POST'])]
    public function delete(Loan $loan, EntityManagerInterface $manager): Response
    {
        if(!$loan){
            $this->addFlash(
                'danger',
                'Votre réservation n\' pas pue être supprimé !'
            );
            return $this->redirectToRoute('app_loan');
        }
        
        // Incremente le nb de book + 1
        $book = $loan->getBook();
        $addBook = $book->setNbOfBook($book->getNbOfBook() +1 );
        $manager->persist($addBook);
        $manager->flush();

        // Supprime la réservation
        $manager->remove($loan);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre réservation a été supprimé avec succés !'
        );

        return $this->redirectToRoute('app_loan');
    }
}

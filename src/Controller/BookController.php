<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Loan;
use App\Form\LoanType;
use App\Repository\BookRepository;
use App\Repository\LoanRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookController extends AbstractController
{
    #[Route('/book/{id}', name: 'book', methods:['GET', 'POST'])]
    public function index(LoanRepository $loanRepository, BookRepository $bookRepository, $id, Book $book,Request $request, UserInterface $user, EntityManagerInterface $manager): Response
    {
        // Livre choisie
        $bookRepo = $bookRepository->find($id);

        // Les 3 dernieres nouveauté de la même categorie du livre
        $idType = $book->getType()->getId();

        // On vérifie si il n'a pas deja réservé le livre
        $idBook = $bookRepo->getId();
        $idUser = $this->getUser()->getId();
        if (empty($loanRepository->loanReserved($idBook, $idUser))){
         $show_bt = true;
        } else {
         $show_bt = false;  
        }
    
        
        // création du formulaire pour enregistrer la réservation
        $loan = new Loan();
        $form = $this->createForm(LoanType::class, $loan);
        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {

            $loan->setBook($book);
            $loan->setUsers($user);
            
            $book->setNbOfBook($book->getNbOfBook() -1 );

            $manager->persist($loan);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre réservation a été éffectué avec succés !'
            );

            return $this->redirectToRoute('app_loan');
        }

        return $this->render('book/index.html.twig', [
            'book' => $bookRepo,
            'books' => $bookRepository->typeOf($idType),
            'formReserved' => $form->createView(),
            'show_bt' => $show_bt,
        ]);
    }

    #[Route('/no_book/{id}', name: 'no_book', methods:['GET', 'POST'])]
    public function userNoRegister(BookRepository $bookRepository, $id, Book $book): Response
    {
        // Livre choisie
        $book = $bookRepository->find($id);
        // Les 3 dernieres nouveauté de la même categorie du livre
        $idType = $book->getType()->getId();


        return $this->render('book/index.html.twig', [
            'book' => $book,
            'books' => $bookRepository->typeOf($idType),
        ]);
    }
}

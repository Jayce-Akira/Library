<?php

namespace App\Controller;

use App\Entity\Type;
use App\Form\NatureLivreType;
use App\Repository\BookRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods:['GET', 'POST'])]
    public function index(BookRepository $bookRepository, Request $request,  PaginatorInterface $paginator): Response
    {
        //Formulaire pour rechercher les types
        $form = $this->createForm(NatureLivreType::class);
        
        if($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
           
            $type = $form->get('name')->getData();

            $typeBook = $bookRepository->resultBook($type);

            $books = $paginator->paginate(
                $typeBook,
                $request->query->getInt('page', 1),
                6
            );

            // return $this->redirectToRoute('app_search');
            return $this->render('search/index.html.twig', [
                'searchForm' => $form->createView(),
                'categories' => $type,
                'searchResult' => $books,
                'books' => $bookRepository->lastTree(),
            ]);

        } else {
            
            $type = new Type(); 
            
        }

        return $this->render('home/index.html.twig', [
            'books' => $bookRepository->lastTree(),
            'searchForm' => $form->createView(),
        ]);
    }
}

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

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search', methods:['GET', 'POST'])]
    public function searchType(Request $request, BookRepository $bookRepository, PaginatorInterface $paginator): Response
    {

              
                
                $form = $this->createForm(NatureLivreType::class);
        
                if($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
                   
                    $type = $form->get('name')->getData();

                    $typeBook = $bookRepository->resultBook($type);

                } else {
                    
                    $type = new Type(); 
                    $typeBook = $bookRepository->findAll();
                    
                }

                $books = $paginator->paginate(
                    $typeBook,
                    $request->query->getInt('page', 1),
                    6
                );

        return $this->render('search/index.html.twig', [
            'searchForm' => $form->createView(),
            'categories' => $type,
            'searchResult' => $books,
            'books' => $bookRepository->lastTree(),
            
        ]);
    }
}

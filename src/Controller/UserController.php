<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/user/{id}', name: 'user', methods:['GET', 'POST'])]
    public function index(User $user, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
    {

        // On vérifie si il est connecté
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        // On vérifie si l'utilisateur et bien le même utilisateur
        if($this->getUser() !== $user) {
            return $this->redirectToRoute('app_home');
        }
        
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $password = $form->get('password')->getData();

            if($hasher->isPasswordValid($user, $password)) {
                
                $user = $form->getData();
                $manager->persist($user);
                $manager->flush();
                
                $this->addFlash(
                    'success',
                    'Vos modifications ont bien été prise en compte.'
                );

            } else {

                $this->addFlash(
                    'warning',
                    'Le mot de passe renseigné est incorrect.'
                );

            }
        }
        
        return $this->render('user/update.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/user/mdp/{id}', name: 'user_mdp', methods:['GET', 'POST'])]
    public function editPassword(User $user, Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $manager) : Response
    {
        // On vérifie si il est connecté
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        // On vérifie si l'utilisateur et bien le même utilisateur
        if($this->getUser() !== $user) {
            return $this->redirectToRoute('app_home');
        }

        $form = $this->createForm(UserPasswordType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            if($hasher->isPasswordValid($user, $form->get('password')->getData())) {

                $user->setPassword(
                    $hasher->hashPassword(
                        $user,
                        $form->get('newPassword')->getData()
                    )
                );

                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    'Votre mot de passe a été modifié.'
                );
                
                return $this->redirectToRoute('user', ['id' => $user->getId()]);
                
            } else {

                $this->addFlash(
                    'warning',
                    'Le mot de passe renseigné est incorrect.'
                );

            }
        }

        return $this->render('user/update_password.html.twig', [
            'mdpForm' => $form->createView(),
        ]);
    }
}

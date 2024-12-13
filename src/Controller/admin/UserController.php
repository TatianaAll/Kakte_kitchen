<?php

namespace App\Controller\admin;

use App\Entity\User;
use App\Form\AdminUserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route(path:'/admin/logout', name:'admin_logout')]
    public function logout() : void
    {
        //route utilisée par symfony pour se décnnecter, c'est magique un peu
        //en vrai ça renvoi vers le fichier security.yalm et est utilisé dans le logout
    }

    #[Route(path:'/admin/users/list', name:'admin_list_users', methods: ['GET'])]
    public function listUsers(UserRepository $userRepository) : Response
    {
        $users = $userRepository->findAll();

        return $this->render('admin/users/list.html.twig', ['users'=>$users]);
    }

    #[Route(path:'/admin/users/create', name:'admin_create_user', methods: ['GET', 'POST'])]
    public function createUser(UserRepository $userRepository,
                               Request $request,
                               EntityManagerInterface $entityManager,
                               AdminUserType $adminUserType,
                               UserPasswordHasherInterface $passwordHasher) : Response
    {
        //dd('test route');
        //j'instancie un nouvel utilisateur
        $user = new User();

        //j'appelle mon form avec les champs qui complète cette entité
        $form = $this->createForm(AdminUserType::class, $user);
        //je fais la vue que je vais renvoyer à mon twig
        $formView = $form->createView();

        //je récupère ce qu'il a été complété dans les différents inputs
        $form->handleRequest($request);

        //je vérifie la soumission et la validité du formulaire reçu
        if ($form->isSubmitted() && $form->isValid()) {
            //il faut que je récupère le mdp rentré et que je le hache
            //dd($form->get('password')->getData());
            $plaintextPassword = $form->get('password')->getData();
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);
            //dd($hashedPassword);

            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'User created!');
            return $this->redirectToRoute('admin_list_users');
        }

        return $this->render('admin/users/createUsers.html.twig', ['formView'=>$formView]);

    }


}
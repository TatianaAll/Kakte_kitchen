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
    #[Route(path: '/admin/logout', name: 'admin_logout')]
    public function logout(): void
    {
        //route utilisée par symfony pour se décnnecter, c'est magique un peu
        //en vrai ça renvoi vers le fichier security.yalm et est utilisé dans le logout
    }

    #[Route(path: '/admin/users/list', name: 'admin_list_users', methods: ['GET'])]
    public function listUsers(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render('admin/users/list.html.twig', ['users' => $users]);
    }

    #[Route(path: '/admin/users/create', name: 'admin_create_user', methods: ['GET', 'POST'])]
    public function createUser(UserRepository              $userRepository,
                               Request                     $request,
                               EntityManagerInterface      $entityManager,
                               AdminUserType               $adminUserType,
                               UserPasswordHasherInterface $passwordHasher): Response
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

            if (!$plaintextPassword) {
                $this->addFlash('error', 'Veuillez rentrer un mot de passe');
                return $this->redirectToRoute('admin_create_user');
            }
            //je hache le tout
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);
            //dd($hashedPassword);

            $roles = $form->get('roles')->getData();
            //dd($roles);
            $user->setRoles($roles);


            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'User created!');
            return $this->redirectToRoute('admin_list_users');
        }
        return $this->render('admin/users/createUsers.html.twig', ['formView' => $formView]);

    }

    #[Route(path: 'admin/users/delete/{id}', name: 'admin_delete_user', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function deleteUser(int $id, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $userToDelete = $userRepository->find($id);

        if (!$userToDelete) {
            $this->addFlash('error', 'Utilisateur introuvable');
            return $this->redirectToRoute('admin_list_users');
        }
        if ($userToDelete->getId() === $this->getUser()->getId()) {
            $this->addFlash('error', 'Cette personne est vous, vous ne pouvez pas vous supprimer');
            return $this->redirectToRoute('admin_list_users');
        }

        $entityManager->remove($userToDelete);
        $entityManager->flush();

        $this->addFlash('success', 'Utilisateur supprimé');

        return $this->redirectToRoute('admin_list_users');
    }

    #[Route(path: 'admin/users/update/{id}', name: 'admin_update_user', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function updateUser(int                    $id, UserRepository $userRepository,
                               EntityManagerInterface $entityManager,
                               Request                $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $userToUpdate = $userRepository->find($id);

        if (!$userToUpdate) {
            $this->addFlash('error', 'Utilisateur introuvable');
            return $this->redirectToRoute('admin_list_users');
        }

        $form = $this->createForm(AdminUserType::class, $userToUpdate);

        $formView = $form->createView();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //je récupère le nouveau mdp et je le hash à la hache
            $plaintextPassword = $form->get('password')->getData();
            //si rien = on garde le même
            if ($plaintextPassword) {
                //je hache le tout
                $hashedPassword = $passwordHasher->hashPassword(
                    $userToUpdate,
                    $plaintextPassword
                );
                $userToUpdate->setPassword($hashedPassword);
                //dd($hashedPassword);
            }

            $entityManager->persist($userToUpdate);
            $entityManager->flush();

            $this->addFlash('success', 'Utilisateur modifié');

            return $this->redirectToRoute('admin_list_users');
        }
        return $this->render('admin/users/updateUsers.html.twig', ['formView' => $formView,
            'userToUpdate' => $userToUpdate]);
    }


}
<?php

namespace App\Controller\admin;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
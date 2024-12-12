<?php

namespace App\Controller\admin;

use Symfony\Component\Routing\Annotation\Route;

class UserController
{
    #[Route(path:'/admin/logout', name:'admin_logout')]
    public function logout() : void
    {
        //route utilisée par symfony pour se décnnecter, c'est magique un peu
        //en vrai ça renvoi vers le fichier security.yalm et est utilisé dans le logout
    }
}
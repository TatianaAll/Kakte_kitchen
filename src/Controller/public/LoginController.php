<?php

namespace App\Controller\public;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    //je fais ma route avec le/login dans ma partie ublic par ce que sinon je ne peux jamais ya voir accès
    #[Route(path:'/login', name:'login')]
    public function login(AuthenticationUtils $authenticationUtils) : Response
    {
        //dd('test route');

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('public/login.html.twig', [
            'error' => $error,
            'lastUsername' => $lastUsername
        ]);

    }
}
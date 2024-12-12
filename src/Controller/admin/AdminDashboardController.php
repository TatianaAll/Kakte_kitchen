<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
    #[Route(path:'/admin', name:'admin_dashboard', methods: ['GET'])]
    public function adminDashboard(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }
}
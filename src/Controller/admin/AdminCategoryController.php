<?php

namespace App\Controller\admin;

use App\Entity\Category;
use App\Form\AdminCreateCategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{
    #[Route(path: '/admin/create/category', name: 'admin_create_category', methods: ['POST', 'GET'])]
    public function adminCreateCategory(Request $request, EntityManagerInterface $entityManager)
    {
        //dd('test route');
        $category = new Category();

        $formAdminCategory = $this->createForm(AdminCreateCategoryType::class, $category);
        $formAdminCategory->handleRequest($request);

        $formView = $formAdminCategory->createView();

        if($formAdminCategory->isSubmitted()) {
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success', 'Catégorie créée');

            return $this->redirectToRoute('admin_create_category');
        }
        return $this->render('admin/createCategory.html.twig', ['formView' => $formView]);
    }
}
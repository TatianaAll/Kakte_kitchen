<?php
namespace App\Controller\admin;

use App\Entity\Recipe;
use App\Form\AdminRecipeCreateFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminRecipeController extends AbstractController
{
    #[Route(path: '/admin/create/recipe', name: 'admin_create_recipe', methods: ['POST', 'GET'])]
    public function adminCreateRecipe() : Response
    {
        //dd('test route');
        $recipe = new Recipe();

        $adminRecipeCreateForm = $this->createForm(AdminRecipeCreateFormType::class, $recipe);

        $adminFormView = $adminRecipeCreateForm->createView();

        return $this->render('admin/createRecipe.html.twig', ['formView' => $adminFormView]);
    }
}
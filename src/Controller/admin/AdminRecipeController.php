<?php
namespace App\Controller\admin;

use App\Entity\Recipe;
use App\Form\AdminRecipeCreateFormType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminRecipeController extends AbstractController
{
    #[Route(path: '/admin/create/recipe', name: 'admin_create_recipe', methods: ['POST', 'GET'])]
    public function adminCreateRecipe(Request $request, EntityManagerInterface $entityManager) : Response
    {
        //dd('test route');
        //1- je crée une nouvelle entité que je vais venir complétée
        $recipe = new Recipe();
        //j'appelle le form qui correspond à l'entité Recette et qui a les champs necessaires
        $adminRecipeCreateForm = $this->createForm(AdminRecipeCreateFormType::class, $recipe);
        //je fais la vue que je vais envoyé à twig pour l'affichage
        $adminFormView = $adminRecipeCreateForm->createView();
        //je récupère les données entrées dans les inputs coté client
        $adminRecipeCreateForm->handleRequest($request);
        //si c'est bien soumis alors je complète et j'envoie en DataBase
        if($adminRecipeCreateForm->isSubmitted())
        {
            $entityManager->persist($recipe);
            $entityManager->flush();
            //message de succès
            $this->addFlash('success', 'Recette créée');

            return $this->redirectToRoute('admin_list_recipes');
        }

        return $this->render('admin/createRecipe.html.twig', ['formView' => $adminFormView]);
    }

    #[Route(path: '/admin/list/recipes', name: 'admin_list_recipes', methods: ['GET'])]
    public function listRecipes(RecipeRepository $recipeRepository) : Response
    {
        $recipes = $recipeRepository->findAll();

        return $this->render('admin/listRecipes.html.twig', ['recipes' => $recipes]);
    }


}
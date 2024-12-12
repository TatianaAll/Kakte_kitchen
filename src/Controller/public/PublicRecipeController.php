<?php

namespace App\Controller\public;

use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PublicRecipeController extends AbstractController
{
    #[Route('/recipes', name: 'public_recipes_list', methods: ['GET'])]
    public function listRecipes(RecipeRepository $recipeRepository) : Response
    {
        $recipesPublished = $recipeRepository->findBy(['isPublished' => true]);

        return $this->render('public/recipes/list.html.twig', ['recipes'=>$recipesPublished]);
    }

    #[Route(path:'recipe/{id}', name: 'public_recipe_show', methods: ['GET'])]
    public function showRecipe (int $id, RecipeRepository $recipeRepository) : Response
    {
        $recipe = $recipeRepository->find($id);

        if(!$recipe || !$recipe->isPublished()) {
            $this->addFlash('warning', 'Recette inexistante');
            return $this->redirectToRoute('public_recipes_list');
        }
        return $this->render('public/recipes/show.html.twig', ['recipe'=>$recipe]);
    }

}
<?php

namespace App\Controller\public;

use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route(path:'recipe/{id}', name: 'public_recipe_show', requirements: ['id'=>'\d+'], methods: ['GET'] )]
    public function showRecipe (int $id, RecipeRepository $recipeRepository) : Response
    {
        $recipe = $recipeRepository->find($id);

        if(!$recipe || !$recipe->isPublished()) {
            $this->addFlash('warning', 'Recette inexistante');
            return $this->redirectToRoute('public_recipes_list');
        }
        return $this->render('public/recipes/show.html.twig', ['recipe'=>$recipe]);
    }

    #[Route(path:'/recipes/search', name: 'public_recipes_search', methods: ['GET'] )]
    public function searchRecipes(Request $request, RecipeRepository $recipeRepository)
    {
        //dd('test');
        $search = $request->query->get('search');
        //dd($search);

        $recipes = $recipeRepository->findBySearchInTitle($search);

        //dd($recipes);
        return $this->render('public/recipes/search.html.twig', ['recipes'=>$recipes, 'search'=>$search]);
    }

}
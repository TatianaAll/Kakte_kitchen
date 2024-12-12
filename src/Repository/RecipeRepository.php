<?php

namespace App\Repository;

use App\Entity\Recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recipe>
 */
class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    public function findBySearchInTitle(string $search) : array
    {
        //dd('test repository');

        // je créé mon query builder
        $queryBuilder = $this->createQueryBuilder('recipes');
        //je sélection tous ce qu'il y a dans recipes
        $query = $queryBuilder->select('recipes')
            //je donne mes conditions, ici c'est le titre de ma recette est A PEU PRES comme search
            ->where('recipes.title LIKE :search')
            //et search vaut : 'nb caractère indéfinis' + contenu du get + 'nb caractère indéfinis'
            ->setParameter('search', '%'.$search.'%')
            //j'envoi ma requete à mon ORM qui va la traduire en SQL (du vrai)
            ->getQuery();

        //dd($query);
        return $query->getArrayResult();
    }


}

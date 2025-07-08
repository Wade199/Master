<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\RecipeRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\RecipeType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Recipe;

class RecipeController extends AbstractController
{
    #[Route('/Recipe', name: 'app_Recipe', methods: ['GET'])]
    public function Recipe(RecipeRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $recipes = $paginator->paginate(
            $recipes = $repository->findAll(),
            $request->query->getInt('page', 1), 
            10 
        );
        return $this->render('recipes/Recipe.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    #[Route('/creation', name: 'recipes.creation', methods: ['GET', 'Post'] )]
    public function creation(): Response
    {
        $recipe= new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);

        return $this->render('recipes/creation.html.twig', [

            'form' => $form->createView()
           
        ]);
    } 
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Ingredient;
use App\Repository\IngredientRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\IngredientType;
use Doctrine\ORM\EntityManagerInterface;

class IngredientController extends AbstractController
{
   /**
     * cette fonction permet d'afficher la lite des ingreingrédients 
     */

    #[Route('/Ingredient', name: 'app_Ingredient', methods: ['GET', 'POST'])]
    public function ingredient(IngredientRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $ingredients = $paginator->paginate(
            $ingredients = $repository->findAll(),
            $request->query->getInt('page', 1), 
            10 
        );

        return $this->render('base/Ingredient.html.twig', [

            'ingredients' => $ingredients
            
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $manager ): Response
    {

       $ingredient = new ingredient();
       $form = $this->createForm(IngredientType::class, $ingredient);

       $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
           $ingredient = $form->getData();
           
           $manager->persist($ingredient);
           $manager->flush();

           $this->addFlash(
               'success',
               'Votre ingrédient a été créé avec succés ! '
           );

           return $this->redirectToRoute('app_Ingredient');
          
    }
        return $this->render('base/new.html.twig', [
            'form' => $form->createView()
        ]);
    } 

    #[Route('/edition/{id}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Ingredient $ingredient, Request $request, EntityManagerInterface $manager): Response
    {
        
        $form = $this->createForm(IngredientType::class, $ingredient);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
           $ingredient = $form->getData();
           
           $manager->persist($ingredient);
           $manager->flush();

           $this->addFlash(
               'success',
               'Votre ingrédient a été modifié avec succés ! '
           );

           return $this->redirectToRoute('app_Ingredient');
        }
 
        return $this->render('base/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    #[Route('/suppression/{id}', name: 'app_delete', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, Ingredient $ingredient): Response
    {
        if(!$ingredient){
            $this->addFlash(
                'success',
                'L\'ingredient n\'a pas été trouvé!'
            );
    
            return $this->redirectToRoute('app_Ingredient');
        }
        $manager->remove($ingredient);
        $manager->flush();
        $this->addFlash(
            'success',
            'Votre ingrédient a été supprimé avec succés ! '
        );

        return $this->redirectToRoute('app_Ingredient');
    }
}
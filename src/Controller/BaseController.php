<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Ingredient;
use App\Repository\IngredientRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\IngredientType;
use Doctrine\ORM\EntityManagerInterface;


class BaseController extends AbstractController
{
    #[Route('/', name: 'base')]
    public function index(): Response
    {
        return $this->render('base/index.html.twig', [
        ]);
    }

    /**
     * cette fonction permet d'afficher la lite des ingreingrédients 
     */

    #[Route('/Ingredient', name: 'app_Ingredient', methods: ['GET'])]
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
          
    }
        return $this->render('base/new.html.twig', [
            'form' => $form->createView()
        ]);
    } 
 

}
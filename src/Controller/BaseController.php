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

    
}
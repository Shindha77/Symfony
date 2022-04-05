<?php
// src/Controller/CategoryController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;

/**
 * @Route("/category", name="category_")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @return Response A response instance
     */
    public function index(CategoryRepository $doctrine): Response
    {
        $categories = $doctrine->findAll();
        return $this->render(
            'category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/{categoryName}", methods="GET", name="show")
     */
    public function show(CategoryRepository $c, ProgramRepository $p, string $categoryName): Response
    {
        $category = $c->findOneBy(['name' => $categoryName]);
        
        if (!$category) {
            throw $this->createNotFoundException(
                'Aucune catégorie nommée : '.$categoryName.'.'
            );
        }

        $id = $category->getId();
        
        $programs = $p->findBy(['category' => $id], ['id' => 'DESC'], 3);
        
        return $this->render('category/show.html.twig', [
            'programs' => $programs
        ]);
    }
}

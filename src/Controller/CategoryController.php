<?php
// src/Controller/CategoryController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use App\Form\CategoryType;
use App\Entity\Category;

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
            'category/index.html.twig',
            [
                'categories' => $categories
            ]
        );
    }

    /**
     * The controller for the category add form
     *
     * @Route("/new", name="new")
     */
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        // Create a new Category Object
        $category = new Category();
        // Create the associated Form
        $form = $this->createForm(CategoryType::class, $category);
        // Get data from HTTP request
        $form->handleRequest($request);

        // Was the form submitted ?
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            // Deal with the submitted data
            // Get the Entity Manager
            $entityManager = $doctrine->getManager();
            // Persist Category Object
            $entityManager->persist($category);
            // Flush the persisted object
            $entityManager->flush();
            // Finally redirect to categories list
            return $this->redirectToRoute('category_index');
        }
        // Render the form
        return $this->render('category/new.html.twig', ["form" => $form->createView()]);
    }

    /**
     * @Route("/{categoryName}", methods="GET", name="show")
     */
    public function show(CategoryRepository $cr, ProgramRepository $pr, string $categoryName): Response
    {
        $category = $cr->findOneBy(['name' => $categoryName]);

        if (!$category) {
            throw $this->createNotFoundException(
                'Aucune catégorie nommée : ' . $categoryName . '.'
            );
        }

        $id = $category->getId();

        $programs = $pr->findBy(['category' => $id], ['id' => 'DESC'], 3);

        return $this->render('category/show.html.twig', [
            'programs' => $programs,
            'category' => $category
        ]);
    }
}

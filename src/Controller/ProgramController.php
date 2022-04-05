<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;

/**
 * @Route("/program", name="program_")
 */
class ProgramController extends AbstractController
{
    /**
     * Show all rows from Program’s entity
     *
     * @Route("/", name="index")
     * @return Response A response instance
     */
    public function index(ProgramRepository $doctrine): Response
    {
        $programs = $doctrine->findAll();
        return $this->render(
            'program/index.html.twig', [
                'programs' => $programs
            ]);
    }

    /**
     * @Route("/{id<\d+>}", methods="GET", name="show")
     */
    public function show(ProgramRepository $doctrine, int $id): Response
    {
        $program = $doctrine->findOneBy(['id' => $id]);
        
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program
        ]);
    }
}

<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;

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
    public function show(Program $program): Response
    {
        
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with this id found in program\'s table.'
            );
        }
        
        return $this->render('program/show.html.twig', [
            'program' => $program
        ]);
    }
    
    /**
     * @Route("/{program<\d+>}/seasons/{season<\d+>}", methods="GET", name="season_show")
     */
    public function showSeason(Program $program, Season $season)
    {
        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season
        ]);
    }

    /**
     * @Route("/{program<\d+>}/seasons/{season<\d+>}/episode/{episode<\d+>}", methods="GET", name="episode_show")
     */
    public function showEpisode(Program $program, Season $season, Episode $episode)
    {
        return $this->render('program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode
        ]);
    }
}

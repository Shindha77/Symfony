<?php
// src/Controller/ActorController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ActorRepository;
use App\Repository\ProgramRepository;

/**
 * @Route("/actor", name="actor_")
 */
class ActorController extends AbstractController
{
    /**
     * @Route("/{id<\d+>}", methods="GET", name="show")
     */

    public function show(ActorRepository $ar, int $id): Response
    {
        $actor = $ar->findOneBy(['id' => $id]);

        if (!$actor) {
            throw $this->createNotFoundException(
                'Aucun acteur trouvé avec cet identifiant'
            );
        }

        return $this->render('actor/actor_show.html.twig', [
            'actor' => $actor
        ]);
    }
}

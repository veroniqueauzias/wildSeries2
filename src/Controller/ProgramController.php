<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;
use App\Entity\Season;

/**
* @Route("/program", name="program_")
*/

class ProgramController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
             ->getRepository(Program::class)
             ->findAll();

         return $this->render(
             'program/index.html.twig',
             ['programs' => $programs]
         );
    }


    /**
     * @Route("/{id}", methods={"GET"}, requirements={"id"="\d+"}, name="show")
     * @return Response
     */
    public function show(Program $program) : Response
    {
       
    if (!$program) {
        throw $this->createNotFoundException(
            'Aucune série avec l\'identifiant '.$id.' n\'a été trouvé.'
        );
    }
        //get seasons for the selected program
        $seasons = $program->getSeasons();
    

    return $this->render('program/show.html.twig', [
        'program' => $program,
        'seasons' => $seasons,
    ]);
    }

    /**
     * @Route("/{program}/seasons/{season}", methods={"GET"}, requirements={"programId"="\d+", "seasonId"="\d+"}, name="season_show")
     * @return Response
     */
    public function showSeason(Program $program, Season $season) : Response
    {
        
    if (!$program) {
        throw $this->createNotFoundException(
            'Aucune série avec l\'identifiant '.$programId.' n\'a été trouvée.'
        );
    }
    
    if (!$season) {
        throw $this->createNotFoundException(
            'Aucune saison avec l\'identifiant '.$seasonId.' n\'a été trouvée.'
        );

    }
    //get episodes for the season
        $episodes = $season->getEpisodes();
    

    return $this->render('program/season_show.html.twig', [
        'program' => $program,
        'season' => $season,
        'episodes' => $episodes,
    ]);

    }
}
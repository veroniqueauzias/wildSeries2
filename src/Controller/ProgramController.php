<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use App\Repository\ProgramRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProgramType;

/**
* @Route("/program", name="program_")
*/

class ProgramController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(ProgramRepository $programRepository, Request $request): Response
    { 
        //define pagination elements
        //number of element par page
        $limit = 4;
        //get page from url
        $page = (int)$request->query->get('page',1); //$request->query->get retrive page number in GET, returns a string, we force it into int
        // get list of episodes for each page.
        $programs = $programRepository->getPaginatedPrograms($limit, $page);
        //get total episode to calculate number of pages
        $total = $programRepository->getTotalPrograms();
        
         return $this->render('program/index.html.twig',[
                'programs' => $programs,
                'total' => $total,
                'limit' => $limit,
                'page' => $page,
             ]);
    }

    /**
     * The controller for the program add form
     *
     * @Route("/ajouter", name="new")
     */
    public function new(Request $request): Response
    {
        // Create a new Program Object
        $program = new Program();
        // Create the associated Form
        $form = $this->createForm(ProgramType::class, $program);
        // Get data from HTTP request
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // Deal with the submitted data
            // Get the Entity Manager
            $entityManager = $this->getDoctrine()->getManager();
            // Persist Category Object
            $entityManager->persist($program);
            // Flush the persisted object
            $entityManager->flush();
            // Finally redirect to categories list
            return $this->redirectToRoute('program_index');
        }
        // Render the form
        return $this->render('program/new.html.twig', [
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", methods={"GET"}, requirements={"id"="\d+"}, name="show")
     * @return Response
     */
    public function show(Program $program) : Response
    {
       
    if (!$program) {
        throw $this->createNotFoundException(
            'Aucune série n\'a été trouvée.'
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
     * @Route("/{program}/seasons/{season}", methods={"GET"}, name="season_show")
     * @return Response
     */
    public function showSeason(Program $program, Season $season) : Response
    {
        
    if (!$program) {
        throw $this->createNotFoundException(
            'Aucune série  n\'a été trouvée.'
        );
    }
    
    if (!$season) {
        throw $this->createNotFoundException(
            'Aucune saison n\'a été trouvée.'
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

     /**
     * @Route("/program/{programId}/season/{seasonId}/episode/{episodeId}", methods={"GET"}, name="episode_show")
     * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"programId": "id"}})
     * @ParamConverter("season", class="App\Entity\Season", options={"mapping": {"seasonId": "id"}})
     * @ParamConverter("episode", class="App\Entity\Episode", options={"mapping": {"episodeId": "id"}})
     * @return Response
     */
    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {
        return $this->render('program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode,
        ]);
    
    }
}
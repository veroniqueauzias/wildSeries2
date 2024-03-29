<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\Program;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
/**
* @Route("/categories", name="category_")
*/

class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request, CategoryRepository $categoryRepository): Response
    {
        //define pagination elements
        //number of element par page
        $limit = 10;
        //get page from url
        $page = (int)$request->query->get('page',1); //$request->query->get retrive page number in GET, returns a string, we force it into int
        // get list of episodes for each page.
        $categories = $categoryRepository->getPaginatedCategories($limit, $page);
        //get total episode to calculate number of pages
        $total = $categoryRepository->getTotalCategories();
        
         return $this->render('category/index.html.twig',[
                'categories' => $categories,
                'total' => $total,
                'limit' => $limit,
                'page' => $page,
             ]);
    }

    /**
     * The controller for the category add form
     *
     * @Route("/ajouter", name="new")
     */
    public function new(Request $request): Response
    {
        // Create a new Category Object
        $category = new Category();
        // Create the associated Form
        $form = $this->createForm(CategoryType::class, $category);
        // Get data from HTTP request
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Deal with the submitted data
            // Get the Entity Manager
            $entityManager = $this->getDoctrine()->getManager();
            // Persist Category Object
            $entityManager->persist($category);
            // Flush the persisted object
            $entityManager->flush();
            // Finally redirect to categories list
            return $this->redirectToRoute('category_index');
        }
        // Render the form
        return $this->render('category/new.html.twig', [
            "form" => $form->createView(),
        ]);
    }


    /**
     * @Route("/{categoryName}", methods={"GET"}, requirements={"categoryName"="\w+"}, name="show")
     * @ParamConverter("category", class="App\Entity\Category", options={"mapping": {"categoryName": "name"}})
     * @return Response
     */
   public function show(Request $request, Category $category, ProgramRepository $programRepository) : Response
    {
     //define pagination elements
        //number of element par page
        $limit = 5;
        //get page from url
        $page = (int)$request->query->get('page',1); //$request->query->get retrive page number in GET, returns a string, we force it into int
        // get list of episodes for each page.
        $programs = $programRepository->getCategPaginatedProgram($limit, $page, $category);
        //get total episode to calculate number of pages
        $total = $programRepository->getTotalCategPrograms($category);
    
    
    return $this->render('category/show.html.twig', [
        'category' => $category,
        'programs' => $programs,
        'limit' => $limit,
        'page' => $page,
        'total' => $total,
    ]);
    }

    /**
     * @Route("/{categoryName}/modifier", name="edit", methods={"GET","POST"})
     * @ParamConverter("category", class="App\Entity\Category", options={"mapping": {"categoryName": "name"}})
     */
    public function edit(Request $request, Category $category): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_show',['categoryName' => $category->getName()]);
        }

        return $this->renderForm('category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Category $category): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('category_index');
    }

}

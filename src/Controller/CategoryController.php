<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\Program;

/**
* @Route("/Categories", name="category_")
*/

class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $categories = $this->getDoctrine()
             ->getRepository(Category::class)
             ->findAll();

         return $this->render(
             'category/index.html.twig',
             ['categories' => $categories]
         );
    }


    /**
     * @Route("/{categoryName}", methods={"GET"}, requirements={"categoryName"="\w+"}, name="show")
     * @return Response
     */
   public function show(string $categoryName) : Response
    {
        $category = $this->getDoctrine()
        ->getRepository(Category::class)
        ->findOneBy(['name' => $categoryName]);
    if (!$category) {
        throw $this->createNotFoundException(
            'Aucune catégorie avec le nom : '.$categoryName.' n\'a été trouvée.'
        );
    }else{
        $programs = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findBy(['category' => $category],
        ['id' => 'DESC'],
        3);
    }
    return $this->render('category/show.html.twig', [
        'category' => $category,
        'programs' => $programs,
    ]);
    }

}

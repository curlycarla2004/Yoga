<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ArticlesRepository;
use App\Repository\ContentRepository;

class YomController extends AbstractController
{
    // #[Route('/', name: 'accueil', methods: ['GET'])] //
    /**
     * @Route("/", name="accueil")
     */
    public function accueil(ArticlesRepository $articlesRepo,  ContentRepository $contentRepo): Response
    {
        $articles = $articlesRepo->findBy(array('active'=> 1));
        $content = $contentRepo->findContent();
        return $this->render('yom/accueil.html.twig', [
            'articles' => $articles,
            'content'=> $content
        ]);
    }

    #[Route('/', name: 'test')]
    public function test(): Response
    {
        // Controller logic here
        return $this->render('yom/accueil.html.twig');
    }

    public function header($currentPage){
        return $this->render('yom/header.html.twig' , [
            'currentPage' => $currentPage,
            'linkScroll' => $currentPage == 'accueil' ? 'scroll' : '',
        ]);
    }
}

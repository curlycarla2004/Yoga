<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticlesRepository;
use App\Repository\ContentRepository;


class YomController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function accueil(ArticlesRepository $articlesRepo,  ContentRepository $contentRepo)
    {
        $articles = $articlesRepo->findAll();
        $content = $contentRepo->findContent();
        return $this->render('yom/accueil.html.twig', [
            'articles' => $articles,
            'content'=> $content
        ]);
    }

        

    public function header($currentPage){
        return $this->render('yom/header.html.twig' , [
            'currentPage' => $currentPage,
            'linkScroll' => $currentPage == 'accueil' ? 'scroll' : '',
        ]);
    }


}

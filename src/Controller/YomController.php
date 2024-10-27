<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ArticlesRepository;
use App\Repository\ContentRepository;

class YomController extends AbstractController
{
    #[Route('/', name: 'accueil', methods: ['GET'])]
    public function accueil(ArticlesRepository $articlesRepo,  ContentRepository $contentRepo): Response
    {
        $articles = $articlesRepo->findBy(array('active'=> 1));
        $content = $contentRepo->findContent();
        return $this->render('yom/accueil.html.twig', [
            'articles' => $articles,
            'content'=> $content
        ]);
    }

    #[Route('/test', name: 'test')]
    public function test(ArticlesRepository $articlesRepo,  ContentRepository $contentRepo): Response
    {
        $articles = $articlesRepo->findBy(array('active' => 1));

        $content = $contentRepo->findContent();
        // Controller logic here
        $html = '<html><body>';
        $html .= '<h1>Welcome to Accueil</h1>';

        // Display articles
        $html .= '<h2>Articles</h2>';
        foreach ($articles as $article) {
            $html .= '<div><strong>' . htmlspecialchars($article->getTitle()) . '</strong></div>';
        }

        // Display content
        $html .= '<h2>Content</h2>';
        $html .= '<p>' . htmlspecialchars($content->getText()) . '</p>';

        $html .= '</body></html>';

        // Return the response with the HTML content
        return new Response($html);
    }

    public function header($currentPage){
        return $this->render('yom/header.html.twig' , [
            'currentPage' => $currentPage,
            'linkScroll' => $currentPage == 'accueil' ? 'scroll' : '',
        ]);
    }
}

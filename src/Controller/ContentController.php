<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticlesRepository;
use App\Repository\ContentRepository;

class ContentController extends AbstractController
{
    /**
     * @Route("/content", name="content")
     */
    public function index(ArticlesRepository $articlesRepo, ContentRepository $contentRepo)
    {
        $articles = $articlesRepo->findAll();
        $content = $contentRepo->findContent();
        return $this->render('content/index.html.twig', [
            'articles' => $articles,
            'content'=> $content
        ]);
    }
}

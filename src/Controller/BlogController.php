<?php

namespace App\Controller;
use App\Entity\Articles;
use App\Entity\Comments;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticlesRepository;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

use App\Form\ArticlesType;


class BlogController extends AbstractController
{    
    /**
     *      
     * @Route("/admin/create_article/{slug}", name="create_article")
     */
    public function create_article($slug = null, ArticlesRepository $articlesRepo, Request $request)
    {
        // $hasAccess = $this->isGranted('ROLE_ADMIN');
        // $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        // if(!$hasAccess) {
        //     throw new \Exception("vous n'avez pas acces.");
        // }

        $em = $this->getDoctrine()->getManager();
        if(!$slug) {
            $article = new Articles();

            // $article->setTitle('title');
            // $em->persist($article);
            // $em->flush();

            // echo $article->getSlug();

            $nouveau = true;
        } else{
            $article = $articlesRepo->find($slug);
            if(!$article) {
                $this->addFlash('danger', "Cet article n'a pas été trouvé");
                return $this->redirectToRoute('blog');
            }
            $nouveau = false;
            $article->setUpdatedAt(new \DateTime());
        }
        
        //SUPPRIMER UN ARTICLE
        $action = $request->query->get('action');
        if ($action && $action == 'delete') {
            $em->remove($article);
            $em->flush();

            $this->addFlash('warning', "L'article a bien été supprimé.");
            return $this->redirectToRoute('blog');
        }

        $form = $this->createForm(ArticlesType::class, $article);
        
        $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){

                
                // upload image sans Vich
                // $image = $form->get('featured_image')->getData();
                // if($image){
                //     $fileName = 'normal'.md5(uniqid()).'.'.$image->guessExtension();
                //     $image->move(
                //         $this->getParameter('_images_directory'),
                //         $fileName
                //     );
                //     $article->setFeaturedImage($fileName);
                // }


                // if($nouveau) {
                //     $article
                //     ->setFeaturedImage($fichier)
                //     ->setDateCreation( new \DateTime() )
                //     ->setActive(1)
                //     ;
                // } 
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                $this->addFlash('success', "L'article ete bien". ($nouveau ? ' créé' : 'modifié') .".");
                return $this->redirectToRoute('create_article', [
                    'id' => $article->getId(),
                    'slug' => $article->getSlug(),
                ] );
            }

        return $this->render('admin/create_article.html.twig', [
            'form' =>$form->createView(),
            'nouveau'=>$nouveau,
            'article'=>$article
        ]);
    }

     /**
     * @Route("/article/{slug}", name="article")
     */
    public function article($slug, Request $request, ArticlesRepository $articlesRepo){
        $em = $this->getDoctrine()->getManager(); //em entity manager
        $articlesRepo = $em->getRepository(Articles::class);

        // $active == 1
        $article = $articlesRepo->findOneBySlug($slug);
        // dd($article);
        if (!$article) {
            $this->addFlash('danger', "L'article demandé n'a pas été trouvé");
            return $this->redirectToRoute('articles');    
        }

        //supprimer un commentaire
        $action = $request->query->get('action');
        if ($action && $action == 'delete') { 

            $id_comment = $request->query->get('id_comment');
            if($id_comment){
                $commentsRepo = $em->getRepository(Comments::class);
                $comment = $commentsRepo->find($id_comment);

                $em->remove($comment);
                $em->flush();
            
                return $this->redirectToRoute('article' , ['id' => $article->getId() ]);
            }
        }

        if($request->isMethod('POST')) {
            $data = $request->request->all();
            $comment = (new Comments())
                ->setArticle( $article )
                ->setAuthor( $data['author'])
                ->setEmail( $data['email'])
                ->setComment( $data['comment'])
                ->setDateCreation( new \DateTime() )
                ;

            $em->persist($comment);
            $em->flush();

            //$this->addFlash('success', "Your comment has been published!");
            //_fragment helps to get me back to the newly created comment once posted
            return $this->redirectToRoute('article', ['slug' => $article->getSlug(), '_fragment' => 'comment-'.$comment->getId() ]);
        }

        $postId = $request->get('slug');
        $post = $em->getRepository(Articles::class)->findOneBySlug($postId);
        $recentArticles = $em->getRepository(Articles::class)->getRecentArticles($post->getSlug());

        return $this->render('blog/article.html.twig', [
            'article' => $article,
            'post'=>$post,
            'recentArticles'=> $recentArticles,
            'slug'=>$slug
        ]);
            
     }

     /**
     * @Route("/articles", name="articles")
     */
    public function articles( Request $request, ArticlesRepository $articlesRepo, PaginatorInterface $paginator)
    {
        $donnees = $this->getDoctrine()->getRepository(Articles::class)->findBy(array('active'=> 1));
        $articles = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            4 // Nombre de résultats par page
        );
        return $this->render('blog/articles.html.twig', [
            'articles' => $articles,
        ]);
    }



}
    

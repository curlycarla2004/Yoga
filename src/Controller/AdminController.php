<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
   
    /**
     * @Route("/upload-image", name="admin_upload_image")
     */
    public function admin_upload_image(Request $request, SluggerInterface $slugger)
    {
        // récupérer l'image 
        $file = $request->files->get('upload');
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = $slugger->slug($originalName).'-'.uniqid().'.'.$file->guessExtension();
        $path = $this->getParameter('public_path') . $this->getParameter('app.path.gallery_images');

         // enregistrer l'image
        try {
            $file->move($path, $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }
       
        // Retourner l'URL de l'image enregistrée
        $url = $this->getParameter('app.path.gallery_images') . '/' . $fileName;
        $response = [
            'uploaded' => 1,
            'fileName' => $fileName,
            'url' => $url,
        ];
        return new JsonResponse($response);
    }

    /**
     * @Route("/browse-image", name="admin_browse_image")
     */
    public function admin_browse_image()
    {
        $files = [];

        $files[] = [
            '5ea95a14041a3548876085.JPG'
        ];
        $files[] = [
            '5ea95aa9eb23a692984987.PNG'
        ];
        $files[] = [
            '5ea98e6e84243491060455.jpg'
        ];

        $response = [
            'resourceType' => 'Images',
            'currentFolder' => [
                'path'=> '/',
                'acl' => 0,
                'url' => $this->getParameter('app.path.gallery_images').'/'
            ],
            'files' => $files

        ];
        return new JsonResponse($response);
    }

    
}

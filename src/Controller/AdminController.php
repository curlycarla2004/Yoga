<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin')]
class AdminController extends AbstractController
{

    #[Route('/upload-image', name: 'admin_upload_image', methods: ['POST'])]
    public function admin_upload_image(Request $request, SluggerInterface $slugger): JsonResponse
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
            return new JsonResponse([
                'uploaded' => 0,
                'error' => ['message' => 'File upload failed.'],
            ], 500);
        }
       
        // Retourner l'URL de l'image enregistrée
        $url = $this->getParameter('app.path.gallery_images') . '/' . $fileName;
        return new JsonResponse([
            'uploaded' => 1,
            'fileName' => $fileName,
            'url' => $url,
        ]);

//        $response = [
//            'uploaded' => 1,
//            'fileName' => $fileName,
//            'url' => $url,
//        ];
//        return new JsonResponse($response);
    }

    #[Route('/browse-image', name: 'admin_browse_image', methods: ['GET'])]
    public function admin_browse_image(): JsonResponse
    {
        // Predefined list of image files
        $files = [
            ['name' => '5ea95a14041a3548876085.JPG'],
            ['name' => '5ea95aa9eb23a692984987.PNG'],
            ['name' => '5ea98e6e84243491060455.jpg'],
        ];

        // Base URL for the images
        $baseUrl = $this->getParameter('app.path.gallery_images') . '/';

        // Prepare response with resource information
        $response = [
            'resourceType' => 'Images',
            'currentFolder' => [
                'path' => '/',
                'acl' => 0, // Access Control List, modify as needed
                'url' => $baseUrl,
            ],
            'files' => array_map(function($file) use ($baseUrl) {
                return [
                    'name' => $file['name'],
                    'url' => $baseUrl . $file['name'],
                ];
            }, $files)
        ];

        return new JsonResponse($response);
    }
}

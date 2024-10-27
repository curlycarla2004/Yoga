<?php

namespace App\Controller;

use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\EmailService;


class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact', methods: ['GET', 'POST'])]
    public function contact(Request $request, EmailService $emailService, EntityManagerInterface $em): JsonResponse
    {
        if ($request->isMethod('POST')) {
            $data = $request->request->all();

            // Create and populate Contact entity
            $contact = (new Contact())
                ->setNom($data['lastname'])
                ->setPrenom($data['firstname'])
                ->setEmail($data['email'])
                ->setSujet($data['subject'])
                ->setMessage($data['message']);

            // Persist Contact entity
            $em->persist($contact);
            $em->flush();

            // Use the EmailService to send the contact email
            $emailService->contact($contact);

            // Create response
            $response = [
                'status' => 1,
                'msg' => 'Your message has been successfully sent.'
            ];

            return new JsonResponse($response);
        }

        return new JsonResponse(['status' => 0, 'msg' => 'Invalid request.'], JsonResponse::HTTP_BAD_REQUEST);
    }
}

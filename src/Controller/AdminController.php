<?php

namespace App\Controller;
use App\Entity\Articles;
use App\Entity\Contact;
use App\Form\ArticlesType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticlesRepository;
use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{
   

    /**
     * @Route("/admin/home", name="home")
     */
    public function home()
    {
       
        return $this->render('admin/home.html.twig', [
            
        ]);
    }

    /**
     * @Route("/admin/contact-list", name="contact_list")
     */
    public function contact_list(ContactRepository $contactsRepo)
    {

        $em = $this->getDoctrine()->getManager(); //em entity manager
        $contactsRepo = $em->getRepository(Contact::class);

        // $active == 1
        $contacts = $contactsRepo->findAll();
       
        return $this->render('admin/contact_list.html.twig', [
            'contacts' => $contacts
        ]);
    }

    
}

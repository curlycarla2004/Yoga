<?php

namespace App\Service;

use App\Entity\Contact;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;


class EmailService{

    private $mailer;

    public function __construct(
        MailerInterface $mailer
    ) {
        $this->mailer = $mailer;
        $this->mon_email = 'gergelovakarla@gmail.com';
        $this->data = array (
            'from' => false,
            'to' =>false,
            'replyTo'=>false,
            'subject' =>false,
            'template' =>false,
            'context' =>false,
        );
    }


    public function send($data){

        $data = array_merge($this->data, $data);
        // dd($data);
        if(!$data['from']) {$data ['from'] = $_ENV['MY_EMAIL'] ; }
        if(!$data['to']) {$data ['to'] = $_ENV['MY_EMAIL'] ; }
        if(!$data['replyTo']) {$data ['replyTo'] = $data['from'] ; }

        if($_ENV['APP_ENV'] == 'dev') { $data['to'] = $_ENV['MY_EMAIL'] ; }
        // dd($data);
        $email = (new templatedEmail())
        ->from($data['from'])
        ->to($data['to'])
        ->replyTo($data['replyTo'])
        ->subject($data['subject'])
        ->htmlTemplate($data['template'])
        ->context($data['context']);

        //if ($_ENV['APP_ENV'] == 'prod') {
            $this->mailer->send($email);
        //}
    }


    

    public function contact(Contact $contact){
        $data = array(
            // 'to' =>$contact->getEmail(),
            'from'=>'gergelovakarla@aol.com',
            'subject' =>"Contact Yom Yoga",
            'template' =>'emails/contact.email.twig',
            'context' => ['contact' => $contact]
        );
        
        $this->send($data);
    }

  
}
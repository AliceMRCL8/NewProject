<?php

namespace App\Controller;

use App\Form\ContxtFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(Request $request): Response
    {
        $form=$this->createForm(ContxtFormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            dump($form->getData());
        }

        return $this->render('contact/index.html.twig', [
            'form'=>$form->createView(),
        ]);
    }
}

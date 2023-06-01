<?php

namespace App\Controller;

use App\Form\ContxtFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(): Response
    {
        $form=$this->createForm(ContxtFormType::class);
        return $this->render('contact/index.html.twig', [
            'form'=>$form->createView(),
            'controller_name' => 'ContactController',
        ]);
    }
}

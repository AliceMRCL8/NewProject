<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoFilterTypeController extends AbstractController
{
    /**
     * @Route("/todo/filter/type", name="app_todo_filter_type")
     */
    public function index(): Response
    {
        return $this->render('todo_filter_type/index.html.twig', [
            'controller_name' => 'TodoFilterTypeController',
        ]);
    }
}

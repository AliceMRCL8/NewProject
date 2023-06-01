<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Form\ContxtFormType;
use App\Form\TodoFilterType;
use App\Form\TodoSearchType;
use App\Form\TodoType;
use App\Repository\TodoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/todo")
 */
class TodoController extends AbstractController
{
    /**
     * @Route("/", name="app_todo_index", methods={"GET", "POST"})
     */
    public function index(TodoRepository $todoRepository, Request $request)
    {
        $checked=null;
        //Formulaire pour filtrer le tableau
        $form=$this->createForm(TodoFilterType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $checked=($form->get("stiltodo")->getData());
        }

        //Formulaire pour la barre de recherche
        $search=$this->createForm(TodoSearchType::class);
        $search->handleRequest($request);
        if($search->isSubmitted()&&$search->isValid()){
            dump($search->get("recherche")->getData());
        }

        //organiser son tableau au clique sur le lien 
       $order=$request->query->get('order',"asc");
       $orderby=$request->query->get('orderby', "id");

       //Tableau vide
       $vide= [];
       //condition qui verrifie si le formulaire filtre est cocher
       if($checked==1){
        $vide = ["done"=>$checked];
       }


       //affiche le resultat de toute les ligne d'avant (formulairechecher, formulaireDeRecherche,) et affiche le tableau Todo/index.html.twig
       return $this->render('todo/index.html.twig', [
           'todos' => $todoRepository->findBy($vide,[$orderby=>$order]),
           'order'=>($order == "asc") ? "desc" : "asc",
           'form'=>$form->createView(),
           'search'=>$search->createView()
        ]);
    
    }

    /**
     * @Route("/new", name="app_todo_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TodoRepository $todoRepository): Response
    {
        $todo = new Todo();
        $form = $this->createForm(TodoType::class, $todo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $todoRepository->add($todo, true);

            return $this->redirectToRoute('app_todo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('todo/new.html.twig', [
            'todo' => $todo,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_todo_show", methods={"GET"})
     */
    public function show(Todo $todo): Response
    {
        return $this->render('todo/show.html.twig', [
            'todo' => $todo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_todo_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Todo $todo, TodoRepository $todoRepository): Response
    {
        $form = $this->createForm(TodoType::class, $todo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $todoRepository->add($todo, true);

            return $this->redirectToRoute('app_todo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('todo/edit.html.twig', [
            'todo' => $todo,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_todo_delete", methods={"POST"})
     */
    public function delete(Request $request, Todo $todo, TodoRepository $todoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$todo->getId(), $request->request->get('_token'))) {
            $todoRepository->remove($todo, true);
        }

        return $this->redirectToRoute('app_todo_index', [], Response::HTTP_SEE_OTHER);
    }
}

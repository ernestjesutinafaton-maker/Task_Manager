<?php

namespace App\Controller;

use App\Entity\ToDo;
use App\Form\ToDoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ToDoController extends AbstractController
{
    #[Route('/todo/', name: 'app_to_do_list')]
    public function listToDos(EntityManagerInterface $entityManager): Response
    {
        $toDos = $entityManager->getRepository(ToDo::class)->findAll();

        return $this->render('to_do/list.html.twig', [
            'toDos' => $toDos,
        ]);
    }

    #[Route('/todo/new', name: 'app_to_do_new')]
    public function newTask(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $toDo = new ToDo();

        $form = $this->createForm(ToDoType::class, $toDo);

        // Récupère les données envoyées par le formulaire
        $form->handleRequest($request);

        // Vérifie si le formulaire a été envoyé et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Prépare l'objet pour l'enregistrement
            $entityManager->persist($toDo);

            // Enregistre réellement dans la base de données
            $entityManager->flush();

            // Redirection vers la liste des todos
            return $this->redirectToRoute('app_to_do_list');
        }

        return $this->render('to_do/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/todo/task{id}', name: 'app_to_do_show')]
public function show(int $id, EntityManagerInterface $entityManager): Response
{
    $toDo = $entityManager->getRepository(ToDo::class)->find($id);

    if (!$toDo) {
        throw $this->createNotFoundException('Todo non trouvé');
    }

    return $this->render('to_do/show.html.twig', [
        'toDo' => $toDo,
    ]);
}

#[Route('/todo/assigned/{AssignedTo}', name: 'app_to_do_assigned')]
public function assignedTo(
    string $AssignedTo,
    EntityManagerInterface $entityManager
): Response {
    $toDos = $entityManager
        ->getRepository(ToDo::class)
        ->findBy(['AssignedTo' => $AssignedTo]);

    return $this->render('to_do/assigned.html.twig', [
        'toDos' => $toDos,
        'AssignedTo' => $AssignedTo,
    ]);
}
#[Route('/todo/{id}/status', name: 'app_to_do_status', methods: ['POST'])]
public function changeStatus(
    int $id,
    Request $request,
    EntityManagerInterface $entityManager
): Response {
    $toDo = $entityManager->getRepository(ToDo::class)->find($id);

    if (!$toDo) {
        throw $this->createNotFoundException('Todo non trouvé');
    }

    if ($toDo->getStatus() < 2) {
        $toDo->setStatus($toDo->getStatus() + 1);
    }

    $entityManager->flush();

    return $this->redirectToRoute('app_to_do_list');
}
#[Route('/todo/{id}/edit', name: 'app_to_do_edit')]
public function edit(
    int $id,
    Request $request,
    EntityManagerInterface $entityManager
): Response {
    $toDo = $entityManager->getRepository(ToDo::class)->find($id);

    if (!$toDo) {
        throw $this->createNotFoundException('Todo non trouvé');
    }

    $form = $this->createForm(ToDoType::class, $toDo);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        return $this->redirectToRoute('app_to_do_show', [
            'id' => $toDo->getId(),
        ]);
    }

    return $this->render('to_do/edit.html.twig', [
        'form' => $form,
        'toDo' => $toDo,
    ]);
}

}
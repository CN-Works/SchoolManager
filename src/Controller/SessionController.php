<?php

namespace App\Controller;

use App\Entity\Program;
use App\Entity\Session;
use App\Entity\Student;
use App\Form\SessionType;
use App\Repository\ProgramRepository;
use App\Repository\SessionRepository;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(SessionRepository $sessionRepository): Response
    {
        $sessions = $sessionRepository->findBy([],["label" => "ASC"]);
        return $this->render('session/index.html.twig', [
            'allsessions' => $sessions,
        ]);
    }

    #[Route('/session/new', name: 'new_session')]
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/session/{id}/edit', name: 'edit_session')]
    #[IsGranted('ROLE_ADMIN')]
    public function new_edit(Session $session = null,Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$session) {
            $session = new Session;
        }

        $form = $this->createForm(SessionType::class, $session);

        $form->handleRequest($request);

        // Checks if form inputs are in a valid type
        if ($form->isSubmitted() && $form->isValid()) {

            // Affecting the form data into the object
            $session = $form->getData();

            $entityManager->persist($session);
            // Saving in db
            $entityManager->flush();

            // Redirection to all societies
            return $this->redirectToRoute("show_session", ["id" => $session->getId()]);
        }

        return $this->render('session/new_edit.html.twig', [
            'formAddEditSession' => $form,
            "edit" => $session->getId(),
        ]);
    }

    #[Route('/session/{id}/delete', name: 'delete_session')]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(SessionRepository $sessionRepository, EntityManagerInterface $entityManager, $id)
    {   
        $session = $sessionRepository->find(($id));
        $entityManager->remove($session);
        $entityManager->flush();

        return $this->redirectToRoute('app_session');
    }

    #[Route('/session/{id}', name: 'show_session')]
    public function show(Session $session): Response {
        
        return $this->render('session/show_session.html.twig', [
            "session" => $session,
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormationController extends AbstractController
{
    #[Route('/formation', name: 'app_formation')]
    public function index(FormationRepository $formationRepository): Response
    {
        // Getting all formations
        $formations = $formationRepository->findBy([],["label" => "ASC"]);
        return $this->render('formation/index.html.twig', [
            'allformations' => $formations,
        ]);
    }

    #[Route('/formation/new', name: 'new_formation')]
    #[Route('/formation/{id}/edit', name: 'edit_formation')]
    #[IsGranted('ROLE_TEACHER')]
    public function new_edit(Formation $formation = null,Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$formation) {
            $formation = new Formation;
        }

        $form = $this->createForm(FormationType::class, $formation);

        $form->handleRequest($request);

        // Checks if form inputs are in a valid type
        if ($form->isSubmitted() && $form->isValid()) {

            // Affecting the form data into the object
            $formation = $form->getData();

            $entityManager->persist($formation);
            // Saving in db
            $entityManager->flush();

            // Redirection to all societies
            return $this->redirectToRoute("show_formation", ["id" => $formation->getId()]);
        }

        return $this->render('formation/new_edit.html.twig', [
            'formAddEditFormation' => $form,
            "edit" => $formation->getId(),
        ]);
    }

    #[Route('/formation/{id}/delete', name: 'delete_formation')]
    #[IsGranted('ROLE_TEACHER')]
    public function delete(FormationRepository $formationRepository, EntityManagerInterface $entityManager, $id)
    {   
        $formation = $formationRepository->find(($id));
        $entityManager->remove($formation);
        $entityManager->flush();

        return $this->redirectToRoute('app_formation');
    }

    #[Route('/formation/{id}', name: 'show_formation')]
    public function show(Formation $formation): Response {
        
        return $this->render('formation/show_formation.html.twig', [
            "formation" => $formation,
        ]);
    }
}

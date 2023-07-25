<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Repository\FormationRepository;
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

    

    #[Route('/formation/{id}', name: 'formation_show')]
    public function show(Formation $formation): Response {
        
        return $this->render('formation/show_formation.html.twig', [
            "formation" => $formation,
        ]);
    }
}

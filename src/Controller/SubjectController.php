<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Form\SubjectType;
use App\Repository\SubjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SubjectController extends AbstractController
{
    #[Route('/subject', name: 'app_subject')]
    public function index(SubjectRepository $subjectRepository): Response
    {
        $subjects = $subjectRepository->findBy([],["label" => "ASC"]);
        return $this->render('subject/index.html.twig', [
            'allsubjects' => $subjects,
        ]);
    }
}

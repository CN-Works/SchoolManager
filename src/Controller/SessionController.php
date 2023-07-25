<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Program;
use App\Entity\Student;
use App\Repository\SessionRepository;
use App\Repository\ProgramRepository;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}

<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(StudentRepository $studentRepository): Response
    {
        $students = $studentRepository->findBy([],["firstname" => "ASC"]);
        return $this->render('student/index.html.twig', [
            'allstudents' => $students,
        ]);
    }

    #[Route('/student/{id}', name: 'show_student')]
    public function show(Student $student): Response {
        
        return $this->render('student/show_student.html.twig', [
            "student" => $student,
        ]);
    }
}

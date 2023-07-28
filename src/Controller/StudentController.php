<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\SessionRepository;
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

    #[Route('/student/new', name: 'new_student')]
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/student/{id}/edit', name: 'edit_student')]
    #[IsGranted('ROLE_ADMIN')]
    public function new_edit(Student $student = null,Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$student) {
            $student = new Student;
        }

        $form = $this->createForm(StudentType::class, $student);

        $form->handleRequest($request);

        // Checks if form inputs are in a valid type
        if ($form->isSubmitted() && $form->isValid()) {

            // Affecting the form data into the object
            $student = $form->getData();

            $entityManager->persist($student);
            // Saving in db
            $entityManager->flush();

            // Redirection to all societies
            return $this->redirectToRoute("show_student", ["id" => $student->getId()]);
        }

        return $this->render('student/new_edit.html.twig', [
            'formAddEditStudent' => $form,
            "edit" => $student->getId(),
        ]);
    }

    #[Route('/student/{id}/delete', name: 'delete_student')]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(StudentRepository $studentRepository, EntityManagerInterface $entityManager, $id)
    {   
        $student = $studentRepository->find(($id));
        
        $entityManager->remove($student);
        $entityManager->flush();

        return $this->redirectToRoute('app_student');
    }

    #[Route('/student/{id}/interrupt/{sessionid}', name: 'interrupt_student')]
    #[IsGranted('ROLE_ADMIN')]
    public function interrupt(StudentRepository $studentRepository, SessionRepository $sessionRepository, EntityManagerInterface $entityManager, $id, $sessionid)
    {   
        // Getting the student entity by id
        $student = $studentRepository->find(($id));

        // Getting the session by it's id
        $session = $sessionRepository->find(($sessionid));

        // Removing Session onject from Student's collection list
        $student = $student->removeSession($session);

        // Sync new data
        $entityManager->flush();

        // Redirecting to student's page
        return $this->redirectToRoute('show_student', ["id" => $student->getId()]);
    }

    #[Route('/student/{id}', name: 'show_student')]
    public function show(Student $student): Response {
        
        return $this->render('student/show_student.html.twig', [
            "student" => $student,
        ]);
    }
}

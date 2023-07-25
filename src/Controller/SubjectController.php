<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Entity\Category;
use App\Form\SubjectType;
use App\Repository\SubjectRepository;
use App\Repository\CategoryRepository;
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

    #[Route('/subjectcategory', name: 'app_subjectcategory')]
    public function index_cateogry(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findBy([],["label" => "ASC"]);
        return $this->render('subject/category/index.html.twig', [
            'allcategories' => $categories,
        ]);
    }

    #[Route('/subject/new', name: 'new_subject')]
    #[Route('/subject/{id}/edit', name: 'edit_subject')]
    public function new_edit(Subject $subject = null,Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$subject) {
            $subject = new Subject;
        }

        $form = $this->createForm(SubjectType::class, $subject);

        $form->handleRequest($request);

        // Checks if form inputs are in a valid type
        if ($form->isSubmitted() && $form->isValid()) {

            // Affecting the form data into the object
            $subject = $form->getData();

            $entityManager->persist($subject);
            // Saving in db
            $entityManager->flush();

            // Redirection to all societies
            return $this->redirectToRoute("app_subject");
        }

        return $this->render('subject/new_edit.html.twig', [
            'formAddEditSubject' => $form,
            "edit" => $subject->getId(),
        ]);
    }

    #[Route('/subject/{id}/delete', name: 'delete_subject')]
    public function delete(SubjectRepository $subjectRepository, EntityManagerInterface $entityManager, $id)
    {   
        $subject = $subjectRepository->find(($id));
        $entityManager->remove($subject);
        $entityManager->flush();

        return $this->redirectToRoute('app_subject');
    }

    #[Route('/subjectcategory/{id}', name: 'show_subjectcategory')]
    public function show_category(Category $category): Response {
        
        return $this->render('subject/category/show_category.html.twig', [
            "category" => $category,
        ]);
    }

    #[Route('/subject/{id}', name: 'show_subject')]
    public function show(Subject $subject): Response {
        
        return $this->render('subject/show_subject.html.twig', [
            "subject" => $subject,
        ]);
    }
}

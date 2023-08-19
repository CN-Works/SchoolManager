<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessageController extends AbstractController
{
    #[Route('/message', name: 'app_message')]
    public function index(MessageRepository $messageRepository): Response
    {   
        if ($this->getUser() === null) {
            
        }

        return $this->render('message/index.html.twig', [
            'controller_name' => 'MessageController',
        ]);
    }

    #[Route('/message/new', name: 'new_message')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $message = new Message;

        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);

        // Checks if form inputs are in a valid type
        if ($form->isSubmitted() && $form->isValid()) {

            // This set the sender as the current user
            $message->setSender($this->getUser());
            // Sets the actual date time
            $message->setCreationdate(new \DateTime());

            // Affecting the form data into the object
            $message = $form->getData();

            $entityManager->persist($message);
            // Saving in db
            $entityManager->flush();

            // Redirection to all societies
            return $this->redirectToRoute("app_message");
        }

        return $this->render('message/new.html.twig', [
            'formAddMessage' => $form,
        ]);
    }

    #[Route('/message/{id}/delete', name: 'delete_message')]
    public function delete(MessageRepository $messageRepository, EntityManagerInterface $entityManager, $id)
    {   
        $message = $messageRepository->find(($id));

        // Only removes the message if user is the receiver
        if ($this->getUser() === $message->getRecipient()) {
            $entityManager->remove($message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_message');
    }

    #[Route('/message/{id}', name: 'show_message'), IsGranted('ROLE_USER')]
    public function show(Message $message, EntityManagerInterface $entityManager): Response {
        $message->setReaded(true);
        $entityManager->persist($message);
        // Saving in db
        $entityManager->flush();
        return $this->render('message/show_message.html.twig', [
            "message" => $message,
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Message;
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
        return $this->render('message/index.html.twig', [
            'controller_name' => 'MessageController',
        ]);
    }
}

<?php
// src/Controller/ChatController.php
namespace App\Controller;

use App\Entity\ChatMessageEntity;
use App\Message\ChatMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class ChatController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/send', name: 'send_message')]
    public function send(Request $request, MessageBusInterface $bus): Response
    {
        if ($request->isMethod('POST')) {
            // Получаем статус из запроса
            $status = $request->request->get('status') === 'true';
            // Отправляем сообщение в шину сообщений
            $bus->dispatch(new ChatMessage($status));
            // Перенаправляем на ту же страницу
            return $this->redirectToRoute('send_message');
        }

        // Получаем все сообщения из базы данных
        $messages = $this->entityManager->getRepository(ChatMessageEntity::class)->findAll();

        // Рендерим шаблон и передаем сообщения в шаблон
        return $this->render('chat/send.html.twig', [
            'messages' => $messages,
        ]);
    }
}


<?php

namespace App\Controller;

use App\Entity\ChatMessageEntity;
use App\Message\ChatMessage;
use App\Repository\ChatMessageRepository;
use App\Service\SendNotificationsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\DateTime;

class ChatController extends AbstractController
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ChatMessageRepository $chatMessageRepository,
        private readonly SendNotificationsService $sendNotificationsService,
    )
    {

    }

    #[Route('/send', name: 'send_message')]
    public function send(Request $request): Response
    {
        $isPublish = $request->get('publish') !== null;

        $chatMessage = $this->chatMessageRepository->find(1);

        // Если запись найдена, обновляем поле active
        if ($chatMessage) {
            $chatMessage->setActive($isPublish);
            $this->entityManager->flush();
        }

        if ($chatMessage->isActive() === true){
            $this->sendNotificationsService->sendNotifications($chatMessage);
        }

        return $this->render('chat/send.html.twig', [
            'publish' => $request->get('publish'),
            'chatMessage' => $chatMessage // Передача найденной записи в шаблон, если нужно
        ]);
    }
}


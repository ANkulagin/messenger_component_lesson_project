<?php

namespace App\MessageHandler;

use App\Entity\ChatMessageEntity;
use App\Message\ChatMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Service\Command\SendNotificationsService;

#[AsMessageHandler]
class ChatMessageHandler
{
    private HttpClientInterface $httpClient;
    private EntityManagerInterface $entityManager;
    private SendNotificationsService $sendNotificationsService;

    public function __construct(HttpClientInterface $httpClient, EntityManagerInterface $entityManager, SendNotificationsService $sendNotificationsService)
    {
        $this->httpClient = $httpClient;
        $this->entityManager = $entityManager;
        $this->sendNotificationsService = $sendNotificationsService;
    }

    public function __invoke(ChatMessage $message)
    {
        $chatMessage = new ChatMessageEntity($message->getStatus());

        try {
            if ($message->getStatus()) {
                $newsItem = [
                    'id' => 'example-id',
                    'title' => 'Test Message',
                ];
                $this->sendNotificationsService->sendNotifications($newsItem, $this->httpClient);

                // Отметка сообщения как отправленного
                $chatMessage->markAsSent();
            }
        } catch (\Exception $e) {
            // Сохранение сообщения в базе данных в случае неудачи
            $this->entityManager->persist($chatMessage);
            $this->entityManager->flush();
            throw $e; // Бросаем исключение, чтобы сообщение оставалось в очереди
        }

        // Сохранение сообщения в базе данных в случае успеха
        $this->entityManager->persist($chatMessage);
        $this->entityManager->flush();
    }
}

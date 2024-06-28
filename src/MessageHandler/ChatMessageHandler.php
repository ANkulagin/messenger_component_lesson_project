<?php
// src/MessageHandler/ChatMessageHandler.php
namespace App\MessageHandler;

use App\Entity\ChatMessageEntity as ChatMessageEntity;
use App\Message\ChatMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsMessageHandler]
class ChatMessageHandler
{
    private HttpClientInterface $httpClient;
    private EntityManagerInterface $entityManager;

    public function __construct(HttpClientInterface $httpClient, EntityManagerInterface $entityManager)
    {
        $this->httpClient = $httpClient;
        $this->entityManager = $entityManager;
    }

    public function __invoke(ChatMessage $message)
    {
        $chatMessage = new ChatMessageEntity($message->getStatus());

        try {
            if ($message->getStatus()) {
                // Симулируем неудачу
                 throw new \Exception('Simulated failure');

                // Симулируем успешную отправку
                $response = $this->httpClient->request('POST', 'https://httpbin.org/post', [
                    'json' => ['message' => 'Hello, World!']
                ]);

                if ($response->getStatusCode() !== 200) {
                    throw new \Exception('Failed to send message');
                }

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

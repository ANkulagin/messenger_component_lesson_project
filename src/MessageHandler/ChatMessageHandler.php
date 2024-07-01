<?php

namespace App\MessageHandler;

use App\Message\ChatMessage;
use Exception;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsMessageHandler]
class ChatMessageHandler
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function __invoke(ChatMessage $message)
    {
        try {
            // GET запрос
            //Расскоментировать для симуляции ошибки
            //throw new \Exception('Simulated failure');
            $response = $this->httpClient->request('GET', 'https://Текст скрыт так как предоставляет конфиденциальную информацию/api/v4/users/email/' . $message->getAuthor(), [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer Текст скрыт так как предоставляет конфиденциальную информацию',
                ],
            ]);
            $userData = $response->toArray();
            $userId = $userData['id'];
            // POST запрос
            $response = $this->httpClient->request('POST', 'https://Текст скрыт так как предоставляет конфиденциальную информацию/api/v4/channels/direct', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer Текст скрыт так как предоставляет конфиденциальную информацию',
                ],
                'json' => [
                    $userId,
                    'Текст скрыт так как предоставляет конфиденциальную информацию',
                ],
            ]);
            $userData = $response->toArray();
            $channelId = $userData['id'];
            // POST запрос
            $this->httpClient->request('POST', 'https://Текст скрыт так как предоставляет конфиденциальную информацию/api/v4/posts', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer Текст скрыт так как предоставляет конфиденциальную информацию',
                ],
                'json' => [
                    'channel_id' => $channelId,
                    'message' => $message->getMessage(),
                ],
            ]);
        } catch (Exception $e) {
            throw $e; // Чтобы сообщение осталось в базе данных
        }
    }
}

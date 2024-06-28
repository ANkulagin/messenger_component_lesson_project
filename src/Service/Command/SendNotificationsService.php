<?php

namespace App\Service\Command;

use Exception;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SendNotificationsService
{
    public function sendNotifications(array $newsItem, HttpClientInterface $httpClient): void
    {
        $message = sprintf(
            'Заголовок: %s. Ссылка на статью: https://www.banki.ru/news/daytheme/?id=%s',
            (string) $newsItem['title'],
            (string) $newsItem['id']
        );

        try {
            // GET запрос
            $httpClient->request('GET', 'https://bankiru.loop.ru/api/v4/users/email/XXXXXXXXXXXXXXXXXXX', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer XXXXXXXXXXXXXXXXXXX',
                ],
            ]);
            // POST запрос
            $httpClient->request('POST', 'https://bankiru.loop.ru/XXXXXXXXXXXXXXXXXXX', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer XXXXXXXXXXXXXXXXXXX',
                ],
                'json' => [
                    'XXXXXXXXXXXXXXXXXXX',
                    'XXXXXXXXXXXXXXXXXXX',
                ],
            ]);
            // POST запрос
            $httpClient->request('POST', 'https://bankiru.loop.ru/XXXXXXXXXXXXXXXXXXX', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer XXXXXXXXXXXXXXXXXXX',
                ],
                'json' => [
                    'channel_id' => 'XXXXXXXXXXXXXXXXXXX',
                    'message' => $message,
                ],
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

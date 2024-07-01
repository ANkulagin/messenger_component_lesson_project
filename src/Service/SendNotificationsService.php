<?php

namespace App\Service;

use App\Entity\ChatMessageEntity;
use App\Message\ChatMessage;
use Exception;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SendNotificationsService
{
    private array $categoryMapping = [
        'Настоящие данные не будут' => 'В открытом доступе((((((',
    ];

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly MessageBusInterface $messageBus,
    ) {
    }
    public function sendNotifications(ChatMessageEntity $article): void
    {
        $products = $article->getProducts();
        $authorsReceivedNotification = [];
        foreach ($products as $product) {
            if (array_key_exists($product, $this->categoryMapping)) {
                $authorsReceivedNotification[$product] = $this->categoryMapping[$product];
            }
        }
        $authorsReceivedNotification = array_unique($authorsReceivedNotification);
        if ($authorsReceivedNotification !== []) {
            foreach ($authorsReceivedNotification as $author) {
                $message = $this->createMessageForNotification($article, $author);
                $this->messageBus->dispatch(new ChatMessage($message , $author));
            }
        }
    }

    private function createMessageForNotification(ChatMessageEntity $article, string $authorStatistic): string
    {
        $title = $article->getTitle();
        $url = 'https://www.banki.ru/news/daytheme/?id=' . $article->getId();
        $publicationDate = $article->getDateStart();//->format('Y-m-d H:i:s');
        $authorName = $authorStatistic;

        return sprintf(
            "Опубликован новый текст.\n\n%s\nПодробнее на сайте Banki.ru %s\n\nДата публикации - %s \nАвтор для статистики - %s",
            $title,
            $url,
            $publicationDate,
            $authorName
        );
    }
}

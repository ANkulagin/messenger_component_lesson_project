<?php
// src/Message/ChatMessage.php

namespace App\Message;

/**
 * Класс сообщения, которое отправляется в шину сообщений.
 * Содержит статус, который определяет, нужно ли отправить сообщение чат-боту.
 */
class ChatMessage
{

    public function __construct(
        private readonly string $message,
        private readonly string $author,
    )
    {
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

}



<?php
// src/Message/ChatMessage.php

namespace App\Message;

/**
 * Класс сообщения, которое отправляется в шину сообщений.
 * Содержит статус, который определяет, нужно ли отправить сообщение чат-боту.
 */
class ChatMessage
{
    private bool $status;

    /**
     * Конструктор сообщения.
     *
     * @param bool $status
     */
    public function __construct(bool $status)
    {
        $this->status = $status;
    }

    /**
     * Получить статус сообщения.
     *
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->status;
    }
}



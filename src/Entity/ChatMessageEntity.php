<?php
// src/Entity/ChatMessageEntity.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Сущность для хранения сообщений в базе данных.
 *
 * @ORM\Entity
 */
#[ORM\Entity]
class ChatMessageEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'boolean')]
    private bool $status;

    #[ORM\Column(type: 'boolean')]
    private bool $sent = false;

    /**
     * Конструктор сущности сообщения.
     *
     * @param bool $status
     */
    public function __construct(bool $status)
    {
        $this->status = $status;
    }

    /**
     * Получить ID сообщения.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * Проверить, отправлено ли сообщение.
     *
     * @return bool
     */
    public function isSent(): bool
    {
        return $this->sent;
    }

    /**
     * Отметить сообщение как отправленное.
     */
    public function markAsSent(): void
    {
        $this->sent = true;
    }
}


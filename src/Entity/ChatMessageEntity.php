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

    #[ORM\Column(type: 'boolean', nullable: true, options: ['default' => false])]
    private ?bool $active = false;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $products;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $title;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $dateStart;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getProducts(): ?array
    {
        return $this->products;
    }

    public function setProducts(?array $products): static
    {
        $this->products = $products;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDateStart(): ?string
    {
        return $this->dateStart;
    }

    public function setDateStart( $dateStart): void
    {
        $this->dateStart = $dateStart;
    }
}


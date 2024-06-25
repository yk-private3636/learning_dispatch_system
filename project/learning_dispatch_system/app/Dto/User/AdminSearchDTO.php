<?php

namespace App\Dto\User;

class AdminSearchDTO
{
    public function __construct(
        private ?string $email,
        private ?string $name,
        private ?int $usageStatus,
    ){}

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getUsageStatus(): ?int
    {
        return $this->usageStatus;
    }
}
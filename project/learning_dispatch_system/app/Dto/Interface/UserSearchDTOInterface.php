<?php

namespace App\Dto\Interface;

interface UserSearchDTOInterface
{
    public function getEmail(): ?string;
    public function getName(): ?string;
    public function getUsageStatus(): ?int;
}
<?php

namespace App\Dtos;

final readonly class StoreOrUpdateUserDto
{
    public function __construct(
        public string $name,
        public string $lastName,
        public string $phone,
        public array $emails,
    ) {}
}

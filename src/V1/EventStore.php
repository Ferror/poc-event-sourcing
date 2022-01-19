<?php
declare(strict_types=1);

namespace App\V1;

interface EventStore
{
    public function save(Event $event): void;
    public function all(string $id): array;
}

<?php
declare(strict_types=1);

namespace App\V2;

interface EventStore
{
    public function save(Event $event): void;

    /**
     * @return \App\V2\Event[]
     */
    public function all(string $id): array;
}

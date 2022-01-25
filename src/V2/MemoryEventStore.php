<?php
declare(strict_types=1);

namespace App\V2;

class MemoryEventStore implements EventStore
{
    public function __construct(
        private array $memory = [],
    )
    {
    }

    public function save(Event $event): void
    {
        $this->memory[$event->getAggregateId()][] = $event;
    }

    public function all(string $id = ''): array
    {
        if (empty($id)) {
            return $this->memory;
        }

        return $this->memory[$id] ?? [];
    }
}

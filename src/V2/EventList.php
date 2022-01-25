<?php
declare(strict_types=1);

namespace App\V2;

class EventList
{
    public function __construct(
        private array $items = [],
    )
    {
    }

    public function add(Event $event): void
    {
        $this->items[] = $event;
    }

    public function getAll(): array
    {
        return $this->items;
    }

    public function each(callable $action): void
    {
        foreach ($this->items as $item) {
            $action($item);
        }
    }
}

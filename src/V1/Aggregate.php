<?php
declare(strict_types=1);

namespace App\V1;

use App\V1\Event\AggregateChangedNameEvent;
use App\V1\Event\AggregateCreatedEvent;

class Aggregate
{
    public static function create(): self
    {
        return new self('', '');
    }

    public function __construct(
        private string $id,
        private string $name,
    )
    {
    }

    public function changeName(string $name): EventList
    {
        $this->name = $name;

        return new EventList([new AggregateChangedNameEvent('id', [])]);
    }

    public function apply(Event $event): self
    {
        if ($event instanceof AggregateCreatedEvent) {
            $this->id = $event->get('id')->toString();
            $this->name = $event->get('name')->toString();

            return $this;
        }

        if ($event instanceof AggregateChangedNameEvent) {
            $this->name = $event->get('name')->toString();

            return $this;
        }

        throw new \Exception();
    }

    public function getId(): string
    {
        return $this->id;
    }
}

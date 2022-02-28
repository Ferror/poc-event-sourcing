<?php
declare(strict_types=1);

namespace App\V2;

class AggregateRepository
{
    public function __construct(
        private EventStore $eventStore,
    )
    {
    }

    public function load(string $aggregateId): Aggregate
    {
        $events = $this->eventStore->all($aggregateId);
        $aggregate = new Aggregate();

        foreach ($events as $event) {
            $aggregate->apply($event);
        }

        return $aggregate;
    }

    public function persist()
    {
    }
}

<?php
declare(strict_types=1);

namespace App\V1;

class AggregateRepository
{
    public function __construct(
        private EventStore $eventStore,
    )
    {
    }

    public function load(string $id): Aggregate
    {
        $events = $this->eventStore->all($id);
        $aggregate = Aggregate::create();

        foreach ($events as $event) {
            $aggregate = $aggregate->apply($event);
        }

        return $aggregate;
    }
}

<?php
declare(strict_types=1);

namespace App\V2\Event;

use App\V2\Event;

class AggregateCreatedEvent extends Event
{
    public function __construct(string $aggregateId, array $data)
    {
        parent::__construct('aggregate::events::created', $aggregateId, 1, $data);
    }
}

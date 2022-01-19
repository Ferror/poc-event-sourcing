<?php
declare(strict_types=1);

namespace App\V1;

abstract class Event
{
    public function __construct(
        private string $name,
        private string $aggregateId,
        private int $version,
        private array $data,
    )
    {
    }

    public function get(string $name): Parameter
    {
        return $this->data[$name];
    }

    public function getAggregateId(): string
    {
        return $this->aggregateId;
    }
}

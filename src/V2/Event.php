<?php
declare(strict_types=1);

namespace App\V2;

use JsonSerializable;

abstract class Event implements JsonSerializable
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

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'version' => $this->version,
            'aggregate_id' => $this->aggregateId,
            'data' => json_encode($this->data, JSON_THROW_ON_ERROR),
        ];
    }
}

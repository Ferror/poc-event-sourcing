<?php
declare(strict_types=1);

namespace App\V1;

class Parameter
{
    public function __construct(
        private mixed $value,
    ) {
    }

    public function get(string $name): self
    {
        return $this->value[$name];
    }

    public function toString(): string
    {
        return (string) $this->value;
    }

    public function toInteger(): int
    {
        return (int) $this->value;
    }

    public function toFloat(): float
    {
        return (float) $this->value;
    }

    public function toBoolean(): bool
    {
        return (bool) $this->value;
    }
}

<?php
declare(strict_types=1);

namespace App\V2\Command;

class CreateAggregateCommand
{
    public function __construct(
        public string $id,
        public string $name,
    )
    {
    }
}

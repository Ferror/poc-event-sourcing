<?php
declare(strict_types=1);

namespace App\V2\Command;

class ChangeNameAggregateCommand
{
    public function __construct(
        public string $name,
    )
    {
    }
}

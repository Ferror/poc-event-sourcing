<?php
declare(strict_types=1);

namespace App\V2;

use App\V2\Event\AggregateChangedNameEvent;
use App\V2\Event\AggregateCreatedEvent;
use App\V2\Command\ChangeNameAggregateCommand;
use App\V2\Command\CreateAggregateCommand;
use JsonSerializable;

class Aggregate implements JsonSerializable
{
    private string $id;
    private string $name;

    public static function create(CreateAggregateCommand $command): EventList
    {
        $o = new self();
        $o->id = $command->id;
        $o->name = $command->name;

        return new EventList([
            new AggregateCreatedEvent($o->id, ['name' => new Parameter($o->name)])
        ]);
    }

    public function changeName(ChangeNameAggregateCommand $command): EventList
    {
        $this->name = $command->name;

        return new EventList([
            new AggregateChangedNameEvent($this->id, ['name' => new Parameter($this->name)])
        ]);
    }

    public function apply(Event $event): void
    {
        if ($event instanceof AggregateCreatedEvent) {
            $this->id = $event->getAggregateId();
            $this->name = $event->get('name')->toString();
        }

        if ($event instanceof AggregateChangedNameEvent) {
            $this->name = $event->get('name')->toString();
        }
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}

<?php
declare(strict_types=1);

namespace App\V1;

use App\V1\Event\AggregateCreatedEvent;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Action extends Command
{
    public function __construct(
        private AggregateRepository $aggregateRepository,
        private EventStore $eventStore,
    )
    {
        parent::__construct('business:v1');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        // 1.1 Create Aggregate
        // 1.2 Save Events (EventStore)
        // 1.3 Save Aggregate (Repository)
        $this->createAggregateHandler('Name 1');


        // 2.1 Find Aggregate (Repository)
        // 2.2 Change Aggregate Name "Name 2"
        // 2.3 Save Events (EventStore)
        // 2.4 Save Aggregate (Repository)
        // 2.5 Remove Aggregate (Repository)
        $this->changeAggregateNameHandler('Name 2');

        // 3.1 Load Aggregate (Repository)
        // 3.2 Aggregate Name is "Name 2"
        // 3.3 Save Aggregate (Repository)
        $this->changeAggregateNameHandler('Name 3');

        return Command::SUCCESS;
    }

    private function createAggregateHandler(string $name): void
    {
        $aggregate = new Aggregate('id', $name);
        $events = new EventList([new AggregateCreatedEvent('id', ['name' => $name])]);

        $events->each(function (Event $event) {
            $this->eventStore->save($event);
        });
    }

    private function changeAggregateNameHandler(string $name): void
    {
        $aggregate = $this->aggregateRepository->load('id');
        $events = $aggregate->changeName($name);

        $events->each(function (Event $event) {
            $this->eventStore->save($event);
        });
    }
}

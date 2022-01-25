<?php
declare(strict_types=1);

namespace App\V2;

use App\V2\Command\ChangeNameAggregateCommand;
use App\V2\Command\CreateAggregateCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Uid\Uuid;

class Action extends Command
{
    private AggregateRepository $aggregateRepository;
    private EventStore $eventStore;

    public function __construct()
    {
        $this->eventStore = new MemoryEventStore();
        $this->aggregateRepository = new AggregateRepository($this->eventStore);
        parent::__construct('business:v2');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $id = Uuid::v4()->jsonSerialize();

        $events = Aggregate::create(new CreateAggregateCommand($id, 'Name 1'));
        $events->each(function (Event $event) {
            $this->eventStore->save($event);
        });
        $aggregate = $this->aggregateRepository->load($id);
        $events = $aggregate->changeName(new ChangeNameAggregateCommand('Name 2'));
        $events->each(function (Event $event) {
            $this->eventStore->save($event);
        });

        $aggregate = $this->aggregateRepository->load($id);
        $events = $aggregate->changeName(new ChangeNameAggregateCommand('Name 3'));
        $events->each(function (Event $event) {
            $this->eventStore->save($event);
        });

        $table = new Table($output);
        $table->setHeaders(['event', 'version', 'aggregate', 'data']);

        foreach ($this->eventStore->all($id) as $event) {
            $table->addRow($event->jsonSerialize());
        }

        $table->render();

        return Command::SUCCESS;
    }
}

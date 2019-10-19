<?php
declare(strict_types=1);


namespace App\Module\Shared\Infrastructure\Repository;


use App\Module\Shared\Domain\Event;
use App\Module\Shared\Infrastructure\EventStore\EventStore;

class InMemoryRepository
{
    /** @var EventStore */
    private $eventsStore;

    /** @var Event[] */
    protected $unCommittedEvents;

    public function __construct(EventStore $eventsStore)
    {
        $this->eventsStore = $eventsStore;
    }

    public function save(): void
    {
        array_map(function (Event $event) {
            $this->eventsStore->addEvent($event);
        }, $this->unCommittedEvents);
    }
}
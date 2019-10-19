<?php
declare(strict_types=1);


namespace App\Module\Shared\Domain;


abstract class AggregateRoot
{
    /**
     * @var AggregateRootId
     */
    protected $id;
    /**
     * @var array<Event>
     */
    private $unCommittedEvent = [];

    /**
     * @return AggregateRootId
     */
    public function getId(): AggregateRootId
    {
        return $this->id;
    }

    protected function record(Event $event): void
    {
        $this->unCommittedEvent[] = $event;
        $this->apply($event);
    }

    public function commitEvent(): void
    {
        $this->unCommittedEvent = [];
    }

    abstract public function apply(Event $event): void;

    /**
     * @return array
     */
    public function getUnCommittedEvent(): array
    {
        return $this->unCommittedEvent;
    }
}
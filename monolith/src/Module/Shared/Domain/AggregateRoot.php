<?php
declare(strict_types=1);


namespace App\Module\Shared\Domain;


use App\Module\Account\Main\Domain\Account;

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

    public static function restore(array $events): Account
    {
        $account = new Account();
        /** @var Event $event */
        foreach ($events as $event)
        {
            $account->apply($event);
        }

        return $account;
    }
}
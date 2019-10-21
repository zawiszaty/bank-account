<?php
declare(strict_types=1);


namespace App\Module\Account\Main\Infrastructure\Repository;


use App\Module\Account\Main\Domain\Account;
use App\Module\Shared\Domain\AggregateRootId;
use App\Module\Shared\Infrastructure\EventStore\EventStoreInterface;
use App\Module\Shared\Infrastructure\Repository\InMemoryRepository;

final class AccountRepository extends InMemoryRepository implements AccountRepositoryInterface
{
    public function __construct(EventStoreInterface $eventsStore)
    {
        parent::__construct($eventsStore);
        $this->aggregate = Account::class;
    }

    public function apply(Account $account): void
    {
        $this->unCommittedEvents = array_merge($this->unCommittedEvents, $account->getUnCommittedEvent());
    }

    public function find(AggregateRootId $id): Account
    {
        return $this->getAggregate($id);
    }

    public function getAll(): array
    {
        return $this->getAllAggregatesByType();
    }
}
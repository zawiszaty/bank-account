<?php
declare(strict_types=1);


namespace App\Module\Account\Main\Infrastructure\Repository;


use App\Module\Account\Main\Domain\Account;
use App\Module\Shared\Infrastructure\Repository\InMemoryRepository;

final class AccountRepository extends InMemoryRepository
{
    public function apply(Account $account): void
    {
        $this->unCommittedEvents = array_merge($this->unCommittedEvents, $account->getUnCommittedEvent());
    }
}
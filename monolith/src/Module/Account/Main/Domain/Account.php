<?php

declare(strict_types=1);

namespace App\Module\Account\Main\Domain;

use App\Module\Account\Main\Domain\Entity\Balance;
use App\Module\Account\Main\Domain\Event\AccountBalanceWasAdded;
use App\Module\Account\Main\Domain\Event\AccountBalanceWasWithdraw;
use App\Module\Account\Main\Domain\Event\AccountWasCreated;
use App\Module\Shared\Domain\AggregateRoot;
use App\Module\Shared\Domain\AggregateRootId;
use App\Module\Shared\Domain\Event;
use Assert\Assertion;

final class Account extends AggregateRoot
{
    /** @var Balance */
    private $balance;

    public static function create(): self
    {
        $account = new static();
        $account->record(new AccountWasCreated(AggregateRootId::generate()));

        return $account;
    }

    public function getBalance(): Balance
    {
        return $this->balance;
    }

    public function addBalance(float $addBalance): void
    {
        Assertion::notSame(0, $addBalance, 'Balance cannot be equal to 0');
        $this->record(new AccountBalanceWasAdded($this->id, $this->balance->addBalance($addBalance)));
    }

    public function withdraw(float $amount): void
    {
        Assertion::notSame(0, $amount, 'Amount cannot be equal to 0');
        $this->record(new AccountBalanceWasWithdraw($this->id, $this->balance->withdraw($amount)));
    }

    public function apply(Event $event): void
    {
        if ($event instanceof AccountWasCreated) {
            $this->id = $event->getId();
            $this->balance = Balance::create();
        } elseif ($event instanceof AccountBalanceWasAdded) {
            $this->balance = $event->getBalance();
        } elseif ($event instanceof AccountBalanceWasWithdraw) {
            $this->balance = $event->getBalance();
        }
    }
}

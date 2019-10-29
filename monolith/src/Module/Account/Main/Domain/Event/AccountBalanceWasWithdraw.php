<?php

declare(strict_types=1);

namespace App\Module\Account\Main\Domain\Event;

use App\Module\Account\Main\Domain\Entity\Balance;
use App\Module\Shared\Domain\AggregateRootId;
use App\Module\Shared\Domain\Event;

final class AccountBalanceWasWithdraw implements Event
{
    /** @var AggregateRootId */
    private $id;

    /** @var Balance */
    private $balance;

    public function __construct(AggregateRootId $id, Balance $balance)
    {
        $this->id = $id;
        $this->balance = $balance;
    }

    public function getId(): AggregateRootId
    {
        return $this->id;
    }

    public function getBalance(): Balance
    {
        return $this->balance;
    }
}

<?php
declare(strict_types=1);


namespace App\Module\Account\Main\Domain\Event;


use App\Module\Account\Main\Domain\ValueObject\Balance;
use App\Module\Shared\Domain\AggregateRootId;

final class AccountBalanceWasWithdraw
{
    /** @var AggregateRootId */
    private $id;

    /** @var Balance */
    private $balance;

    public function __construct(AggregateRootId $id, Balance $balance)
    {
        $this->id      = $id;
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
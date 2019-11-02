<?php

declare(strict_types=1);

namespace App\Module\Account\Main\Domain;

use App\Module\Account\Main\Domain\Account;
use App\Module\Shared\Domain\AggregateRoot;
use App\Module\Shared\Domain\AggregateRootId;

interface AccountRepositoryInterface
{
    public function apply(Account $account): void;

    public function find(AggregateRootId $id): Account;

    public function getAll(): array;

    public function save(): void;

    public function getAggregate(AggregateRootId $id): AggregateRoot;

    /**
     * @return AggregateRoot[]
     */
    public function getAllAggregatesByType(): array;

    public function getSingle(string $id): Account;
}

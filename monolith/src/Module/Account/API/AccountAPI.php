<?php

declare(strict_types=1);

namespace App\Module\Account\API;

use App\Module\Account\IO\Account as AccountOutput;
use App\Module\Account\IO\AccountCollection;

interface AccountAPI
{
    public function create(): void;

    public function addToBalance(string $id, float $amount): void;

    public function getAccounts(): AccountCollection;

    public function withdraw(string $id, float $amount): void;

    public function getAccount(string $id): AccountOutput;
}

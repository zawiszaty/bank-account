<?php
declare(strict_types=1);


namespace App\Module\Account\API;


use App\Module\Account\IO\Balance;

interface AccountAPI
{
    public function addToBalance(float $amount): void;

    public function getBalance(): Balance;

    public function withdraw(): void;
}
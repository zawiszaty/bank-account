<?php
declare(strict_types=1);


namespace App\Module\Account\API;


use App\Module\Account\IO\Balance;
use App\Module\Account\Main\Application\AccountService;

final class ImplAccountAPI implements AccountAPI
{
    /**
     * @var AccountService
     */
    private $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function addToBalance(float $amount): void
    {
        $this->accountService->addBalance();
    }

    public function getBalance(): Balance
    {
        // TODO: Implement getBalance() method.
    }

    public function withdraw(): void
    {
        // TODO: Implement withdraw() method.
    }
}
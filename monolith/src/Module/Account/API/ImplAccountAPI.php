<?php
declare(strict_types=1);


namespace App\Module\Account\API;


use App\Module\Account\IO\AccountCollection;
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

    public function addToBalance(string $id, float $amount): void
    {
        // TODO: Implement addToBalance() method.
    }

    public function getAccount(): AccountCollection
    {
        return new AccountCollection($this->accountService->getAll());
    }

    public function withdraw(string $id, float $amount): void
    {
        // TODO: Implement withdraw() method.
    }

    public function create(): void
    {
        $this->accountService->create();
    }
}
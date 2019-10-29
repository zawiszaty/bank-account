<?php

declare(strict_types=1);

namespace App\Module\Account\API;

use App\Module\Account\IO\Account as AccountOutput;
use App\Module\Account\IO\AccountCollection;
use App\Module\Account\Main\Application\AccountService;
use App\Module\Account\Main\Domain\Account;

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
        $this->accountService->addBalance($id, $amount);
    }

    public function getAccounts(): AccountCollection
    {
        $accounts = $this->accountService->getAll();
        $output = [];

        /** @var Account $account */
        foreach ($accounts as $account) {
            $output[] = new AccountOutput($account->getId()->toString(), $account->getBalance()->toFloat());
        }
        $accountCollection = new AccountCollection($output);

        return $accountCollection;
    }

    public function getAccount(string $id): AccountOutput
    {
        $output = $this->accountService->getSingle($id);

        $account = new AccountOutput($output->getId()->toString(), $output->getBalance()->toFloat());

        return $account;
    }

    public function withdraw(string $id, float $amount): void
    {
        $this->accountService->withdraw($id, $amount);
    }

    public function create(): void
    {
        $this->accountService->create();
    }
}

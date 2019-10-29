<?php

declare(strict_types=1);

namespace App\Module\Account\Main\Application;

use App\Module\Account\Main\Domain\Account;
use App\Module\Account\Main\Infrastructure\Repository\AccountRepositoryInterface;
use App\Module\Shared\Domain\AggregateRootId;

final class AccountService
{
    /**
     * @var AccountRepositoryInterface
     */
    private $accountRepository;

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function create(): void
    {
        $account = Account::create();
        $this->accountRepository->apply($account);
        $this->accountRepository->save();
    }

    public function addBalance(string $id, float $balance): void
    {
        $account = $this->accountRepository->find(AggregateRootId::withId($id));
        $account->addBalance($balance);
        $this->accountRepository->apply($account);
        $this->accountRepository->save();
    }

    public function withdraw(string $id, float $amount): void
    {
        $account = $this->accountRepository->find(AggregateRootId::withId($id));
        $account->withdraw($amount);
        $this->accountRepository->apply($account);
        $this->accountRepository->save();
    }

    public function getAll(): array
    {
        return $this->accountRepository->getAll();
    }

    public function getSingle(string $id): Account
    {
        return $this->accountRepository->getSingle($id);
    }
}

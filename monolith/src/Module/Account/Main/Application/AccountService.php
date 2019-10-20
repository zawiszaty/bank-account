<?php
declare(strict_types=1);


namespace App\Module\Account\Main\Application;

use App\Module\Account\Main\Domain\Account;
use App\Module\Account\Main\Infrastructure\Repository\AccountRepository;
use App\Module\Shared\Domain\AggregateRootId;

final class AccountService
{
    /**
     * @var AccountRepository
     */
    private $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function create(): void
    {
        $account = Account::create();
        $this->accountRepository->apply($account);
        $this->accountRepository->save();
    }

    public function addBalance(AggregateRootId $id, float $balance): void
    {
        $account = $this->accountRepository->find($id);
        $account->addBalance($balance);
        $this->accountRepository->apply($account);
        $this->accountRepository->save();
    }

    public function withdraw(AggregateRootId $id, float $amount): void
    {
        $account = $this->accountRepository->find($id);
        $account->withdraw($amount);
        $this->accountRepository->apply($account);
        $this->accountRepository->save();
    }

    public function getAll(): array
    {
        return $this->accountRepository->getAll();
    }
}
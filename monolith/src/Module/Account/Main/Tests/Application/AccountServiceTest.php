<?php
declare(strict_types=1);


namespace App\Module\Account\Main\Application;

use App\Module\Account\Main\Infrastructure\Repository\AccountRepository;
use App\Module\Shared\Infrastructure\EventStore\EventStore;
use PHPUnit\Framework\TestCase;

class AccountServiceTest extends TestCase
{
    /**
     * @var EventStore
     */
    private $eventStore;
    /**
     * @var AccountRepository
     */
    private $accountRepository;

    protected function setUp(): void
    {
        $this->eventStore        = new EventStore();
        $this->accountRepository = new AccountRepository($this->eventStore);

    }

    public function test_it_create()
    {
        $service = new AccountService($this->accountRepository);
        $service->create();
        $this->assertCount(1, $this->eventStore->getEvents());
    }

    public function test_it_add_balance()
    {
        $service = new AccountService($this->accountRepository);
        $service->create();
        $event       = $this->eventStore->getEvents()[0];
        $aggregateId = $event->getId();
        $account     = $this->accountRepository->find($aggregateId);
        $service->addBalance($account->getId(), 100);
        $account = $this->accountRepository->find($aggregateId);
        $this->assertSame((float) 300, $account->getBalance()->toFloat());
    }

    public function test_it_withdraw()
    {
        $service = new AccountService($this->accountRepository);
        $service->create();
        $event       = $this->eventStore->getEvents()[0];
        $aggregateId = $event->getId();
        $account     = $this->accountRepository->find($aggregateId);
        $service->withdraw($account->getId(), 100);
        $account = $this->accountRepository->find($aggregateId);
        $this->assertSame((float) 100, $account->getBalance()->toFloat());
    }
}

<?php
declare(strict_types=1);


namespace App\Module\Account\Main\Application;

use App\Module\Account\Main\Domain\Account;
use App\Module\Account\Main\Domain\Event\AccountBalanceWasAdded;
use App\Module\Account\Main\Domain\Event\AccountBalanceWasWithdraw;
use App\Module\Account\Main\Domain\Event\AccountWasCreated;
use App\Module\Account\Main\Domain\Entity\Balance;
use App\Module\Account\Main\Infrastructure\Repository\AccountRepository;
use App\Module\Shared\Domain\AggregateRootId;
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

    public function test_it_get_all_aggregates()
    {
        $this->mockEvents();
        $service = new AccountService($this->accountRepository);
        $all     = $service->getAll();
        /** @var Account $account */
        $account = $all[0];
        $this->assertInstanceOf(Account::class, $account);
        $this->assertSame((float) 100, $account->getBalance()->toFloat());
    }

    private function mockEvents(): void
    {
        $id = AggregateRootId::generate();
        $this->eventStore->addEvent(new AccountWasCreated($id), Account::class);
        $this->eventStore->addEvent(new AccountBalanceWasAdded($id, Balance::create(300)), Account::class);
        $this->eventStore->addEvent(new AccountBalanceWasWithdraw($id, Balance::create(100)), Account::class);
    }
}

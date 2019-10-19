<?php
declare(strict_types=1);


namespace App\UI\CLI;


use App\Module\Account\API\AccountAPI;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class AccountCommand extends Command
{
    protected static $defaultName = 'app:account';
    /**
     * @var AccountAPI
     */
    private $accountAPI;

    public function __construct(AccountAPI $accountAPI)
    {
        parent::__construct();
        $this->accountAPI = $accountAPI;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->accountAPI->addToBalance(1.0);
    }
}
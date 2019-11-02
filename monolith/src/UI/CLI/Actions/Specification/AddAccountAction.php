<?php
declare(strict_types=1);


namespace App\UI\CLI\Actions\Specification;


use App\Module\Account\API\AccountAPI;
use App\UI\CLI\AccountCommand;
use App\UI\CLI\Actions\ActionInterface;
use App\UI\CLI\Actions\Actions;
use Symfony\Component\Console\Style\SymfonyStyle;

final class AddAccountAction implements ActionInterface
{
    private $accountAPI;

    public function __construct(AccountAPI $accountAPI)
    {
        $this->accountAPI = $accountAPI;
    }

    public function supports(Actions $action): bool
    {
        return Actions::ADD_ACCOUNT()->equals($action);
    }

    public function execute(SymfonyStyle $io): void
    {
        $this->accountAPI->create();
        $io->write(AccountCommand::CLEAR_TERMINAL);
        $io->success('Account Created');
    }
}
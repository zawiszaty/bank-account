<?php

declare(strict_types=1);


namespace App\UI\CLI\Actions\Specification;


use App\Module\Account\API\AccountAPI;
use App\Module\Account\IO\Account;
use App\UI\CLI\AccountCommand;
use App\UI\CLI\Actions\ActionInterface;
use App\UI\CLI\Actions\ActionType;
use App\UI\CLI\CLICodeHelper;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

final class GetSingleAction implements ActionInterface
{
    private $accountAPI;

    public function __construct(AccountAPI $accountAPI)
    {
        $this->accountAPI = $accountAPI;
    }

    public function supports(ActionType $action): bool
    {
        return ActionType::GET_SINGLE()->equals($action);
    }

    public function execute(SymfonyStyle $io): void
    {
        $accounts      = $this->accountAPI->getAccounts()->getAccounts();
        $selectAccount = new ChoiceQuestion('Please select Account', $accounts, 0);
        $selectAccount->setErrorMessage('Account %s is invalid.');
        $accountId = $io->askQuestion($selectAccount);
        $account   = $this->accountAPI->getAccount($accountId);
        $io->write(CLICodeHelper::CLEAR_TERMINAL);

        if ($account instanceof Account)
        {
            $io->section(sprintf('<info>id: %s, balance: %s</info>', $account->getId(), $account->getBalance()));

            return;
        }
        $io->writeln('<error>Account not found</error>');
    }
}
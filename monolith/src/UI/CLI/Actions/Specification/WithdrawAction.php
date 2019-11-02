<?php

declare(strict_types=1);


namespace App\UI\CLI\Actions\Specification;


use App\Module\Account\API\AccountAPI;
use App\UI\CLI\AccountCommand;
use App\UI\CLI\Actions\ActionInterface;
use App\UI\CLI\Actions\Actions;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

final class WithdrawAction implements ActionInterface
{
    private $accountAPI;

    public function __construct(AccountAPI $accountAPI)
    {
        $this->accountAPI = $accountAPI;
    }

    public function supports(Actions $action): bool
    {
        return Actions::WITHDRAW()->equals($action);
    }

    public function execute(SymfonyStyle $io): void
    {
        $accounts      = $this->accountAPI->getAccounts()->getAccounts();
        $selectAccount = new ChoiceQuestion('Please select Account', $accounts, 0);
        $selectAccount->setErrorMessage('Account %s is invalid.');
        $accountId     = $io->askQuestion($selectAccount);
        $selectAccount = new Question('Input withdraw: ');
        $action        = intval($io->askQuestion($selectAccount));

        if (0 !== $action)
        {
            $this->accountAPI->withdraw($accountId, $action);
            $io->write(AccountCommand::CLEAR_TERMINAL);
            $io->success(sprintf('Withdraw %s from balance', $action));

            return;
        }
        $io->writeln('Withdraw cannot be 0');

    }
}
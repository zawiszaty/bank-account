<?php

declare(strict_types=1);

namespace App\UI\CLI;

use App\Module\Account\API\AccountAPI;
use App\Module\Account\IO\Account;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

final class AccountCommand extends Command
{
    const ADD_ACCOUNT = 'Add Account';
    const ADD_BALANCE = 'Add Balance';
    const WITHDRAW    = 'Withdraw';
    const GET_SINGLE  = 'Get Single';

    const OPTIONS = [self::ADD_ACCOUNT, self::ADD_BALANCE, self::WITHDRAW, self::GET_SINGLE];

    protected static $defaultName = 'app:account';

    private $accountAPI;

    public function __construct(AccountAPI $accountAPI)
    {
        parent::__construct();
        $this->accountAPI = $accountAPI;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->write("\033c");
        $question = new ChoiceQuestion('Please select Action', self::OPTIONS, 0);
        $question->setErrorMessage('Action %s is invalid.');

        while (true)
        {
            $accountCount = count($this->accountAPI->getAccounts()->getAccounts());
            $io->writeln(sprintf('<info>You have %s account in Database</info>', $accountCount));
            $action = $io->askQuestion($question);

            switch ($action)
            {
                case self::ADD_ACCOUNT:
                    $this->accountAPI->create();
                    $io->write("\033c");
                    $io->success('Account Created');
                    break;
                case self::ADD_BALANCE:
                    $accounts      = $this->accountAPI->getAccounts()->getAccounts();
                    $selectAccount = new ChoiceQuestion('Please select Account', $accounts, 0);
                    $selectAccount->setErrorMessage('Account %s is invalid.');
                    $accountId     = $io->askQuestion($selectAccount);
                    $selectAccount = new Question('Input amount: ');
                    $action        = intval($io->askQuestion($selectAccount));

                    if (0 !== $action)
                    {
                        $this->accountAPI->addToBalance($accountId, $action);
                        $io->write("\033c");
                        $io->success(sprintf('Added %s to balance', $action));
                        break;
                    }
                    $io->writeln('Amount cannot be 0');
                    break;
                case self::GET_SINGLE:
                    $accounts      = $this->accountAPI->getAccounts()->getAccounts();
                    $selectAccount = new ChoiceQuestion('Please select Account', $accounts, 0);
                    $selectAccount->setErrorMessage('Account %s is invalid.');
                    $accountId = $io->askQuestion($selectAccount);
                    $account   = $this->accountAPI->getAccount($accountId);
                    $io->write("\033c");

                    if ($account instanceof Account)
                    {
                        $io->section(sprintf('<info>id: %s, balance: %s</info>', $account->getId(), $account->getBalance()));
                        break;
                    }
                    $io->writeln('<error>Account not found</error>');
                    break;
                case self::WITHDRAW:
                    $accounts      = $this->accountAPI->getAccounts()->getAccounts();
                    $selectAccount = new ChoiceQuestion('Please select Account', $accounts, 0);
                    $selectAccount->setErrorMessage('Account %s is invalid.');
                    $accountId     = $io->askQuestion($selectAccount);
                    $selectAccount = new Question('Input withdraw: ');
                    $action        = intval($io->askQuestion($selectAccount));

                    if (0 !== $action)
                    {
                        $this->accountAPI->withdraw($accountId, $action);
                        $io->write("\033c");
                        $io->success(sprintf('Withdraw %s from balance', $action));
                        break;
                    }
                    $io->writeln('Withdraw cannot be 0');
                    break;
            }
        }
    }
}

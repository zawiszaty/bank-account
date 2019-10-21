<?php
declare(strict_types=1);


namespace App\UI\CLI;


use App\Module\Account\API\AccountAPI;
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

    const OPTIONS = [self::ADD_ACCOUNT, self::ADD_BALANCE, self::WITHDRAW];
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
            $accountCount = count($this->accountAPI->getAccount()->getAccounts());
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
                    $accounts      = $this->accountAPI->getAccount()->getAccounts();
                    $selectAccount = new ChoiceQuestion('Please select Account', $accounts, 0);
                    $selectAccount->setErrorMessage('Account %s is invalid.');
                    $accountId = $io->askQuestion($selectAccount);

                    $selectAccount = new Question('Input amount: ');
                    $action        = intval($io->askQuestion($selectAccount));
                    if ($action !== 0)
                    {
                        $this->accountAPI->addToBalance($accountId, $action);
                        $io->write("\033c");
                        $io->success(sprintf('Added %s to balance', $action));
                        break;
                    }
                    $io->writeln('Amount must not be a 0');
                    break;
            }
        }
    }
}
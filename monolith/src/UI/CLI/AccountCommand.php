<?php

declare(strict_types=1);

namespace App\UI\CLI;

use App\Module\Account\API\AccountAPI;
use App\UI\CLI\Actions\ActionType;
use App\UI\CLI\Actions\ActionsManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

final class AccountCommand extends Command
{
    protected static $defaultName = 'app:account';

    private $actionsManager;

    private $accountAPI;

    public function __construct(ActionsManager $actionsManager, AccountAPI $accountAPI)
    {
        parent::__construct();
        $this->actionsManager = $actionsManager;
        $this->accountAPI     = $accountAPI;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->write(CLICodeHelper::CLEAR_TERMINAL);
        $question = new ChoiceQuestion('Please select Action', array_values(ActionType::values()), 0);
        $question->setErrorMessage('Action %s is invalid.');

        while (true)
        {
            $accountCount = count($this->accountAPI->getAccounts()->getAccounts());
            $io->writeln(sprintf('<info>You have %s account in Database</info>', $accountCount));
            $action = new ActionType($io->askQuestion($question));
            $this->actionsManager->executeAction($action, $io);
        }
    }
}

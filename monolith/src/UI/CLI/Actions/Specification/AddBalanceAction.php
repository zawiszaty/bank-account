<?php
declare(strict_types=1);


namespace App\UI\CLI\Actions\Specification;


use App\Module\Account\API\AccountAPI;
use App\UI\CLI\AccountCommand;
use App\UI\CLI\Actions\ActionInterface;
use App\UI\CLI\Actions\ActionType;
use App\UI\CLI\CLICodeHelper;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

final class AddBalanceAction implements ActionInterface
{
    private $accountAPI;

    public function __construct(AccountAPI $accountAPI)
    {
        $this->accountAPI = $accountAPI;
    }

    public function supports(ActionType $action): bool
    {
        return ActionType::ADD_BALANCE()->equals($action);
    }

    public function execute(SymfonyStyle $io): void
    {
        $accounts      = $this->accountAPI->getAccounts()->getAccounts();
        $selectAccount = new ChoiceQuestion('Please select Account', $accounts, 0);
        $selectAccount->setErrorMessage('Account %s is invalid.');
        $accountId     = $io->askQuestion($selectAccount);
        $selectAccount = new Question('Input amount: ');
        $action        = intval($io->askQuestion($selectAccount));

        if (0 !== $action)
        {
            $this->accountAPI->addToBalance($accountId, $action);
            $io->write(CLICodeHelper::CLEAR_TERMINAL);
            $io->success(sprintf('Added %s to balance', $action));

            return;
        }
        $io->writeln('Amount cannot be 0');
    }
}
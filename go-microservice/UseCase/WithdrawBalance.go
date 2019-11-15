package UseCase

import (
	"errors"
	"zawiszaty/microservice/Repository"
)

type WithdrawBalanceCommand struct {
	Id      string
	Balance float64
}

func WithdrawBalanceHandler(command WithdrawBalanceCommand, repository Repository.AccountRepositoryInterface) error {
	account, err := repository.Find(command.Id)

	if err != nil {
		return errors.New("123")
	}
	account.Balance.WithdrawBalance(command.Balance)
	repository.Apply(*account)

	return nil
}

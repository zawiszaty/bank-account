package UseCase

import (
	"errors"
	"zawiszaty/microservice/Repository"
)

type AddBalanceCommand struct {
	Id      string
	Balance float64
}

func AddBalanceHandler(command AddBalanceCommand, repository Repository.AccountRepositoryInterface) error {
	account, err := repository.Find(command.Id)
	if err != nil {
		return errors.New("123")
	}
	account.Balance.AddBalance(command.Balance)
	repository.Apply(*account)
	return nil
}

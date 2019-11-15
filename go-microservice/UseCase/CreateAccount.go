package UseCase

import (
	"zawiszaty/microservice/Domain"
	"zawiszaty/microservice/Repository"
)

type CreateAccountCommand struct {
}

func CreateAccountHandler(command CreateAccountCommand, repository Repository.AccountRepositoryInterface) error {
	balance, err := Domain.NewBalance(200.0)

	if err != nil {
		return err
	}
	account := Domain.NewAccount(balance)
	repository.Apply(*account)

	return nil
}

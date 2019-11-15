package UseCase

import (
	"testing"
	"zawiszaty/microservice/Repository"
)

func TestCreateAccountHandler(t *testing.T) {
	repository := Repository.InMemoryAccountRepository{}
	err := CreateAccountHandler(CreateAccountCommand{}, &repository)

	if err != nil {
		t.Fail()
	}

	accounts := repository.GetAll()
	account := accounts[0]

	if account.Balance.GetAmount() != 200.0 {
		t.Fail()
	}
}

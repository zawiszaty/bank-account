package UseCase

import (
	"testing"
	"zawiszaty/microservice/Repository"
)

func TestAddBalanceHandler(t *testing.T) {
	repository := Repository.InMemoryAccountRepository{}
	account := CreateAccountMother()
	repository.Apply(account)
	err := AddBalanceHandler(AddBalanceCommand{Id: account.Id, Balance: 200.0}, &repository)

	if err != nil {
		t.Fail()
	}
	accounts := repository.GetAll()
	account = accounts[0]

	if account.Balance.GetAmount() != 400.0 {
		t.Fail()
	}
}

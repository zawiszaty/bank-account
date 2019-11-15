package UseCase

import (
	"testing"
	"zawiszaty/microservice/Repository"
)

func TestWithdrawBalanceHandler(t *testing.T) {
	repository := Repository.InMemoryAccountRepository{}
	account := CreateAccountMother()
	repository.Apply(account)

	accounts := repository.GetAll()
	account = accounts[0]

	err := WithdrawBalanceHandler(WithdrawBalanceCommand{Id: account.Id, Balance: 200.0}, &repository)

	if err != nil {
		t.Fail()
	}
	accounts = repository.GetAll()
	account = accounts[0]

	if account.Balance.GetAmount() != 0.0 {
		t.Fail()
	}
}

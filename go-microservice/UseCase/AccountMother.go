package UseCase

import "zawiszaty/microservice/Domain"

func CreateAccountMother() Domain.Account {
	balance, _ := Domain.NewBalance(200.0)

	return Domain.Account{Id: "test", Balance: *balance}
}

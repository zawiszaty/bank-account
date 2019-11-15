package Repository

import (
	"database/sql"
	"fmt"
	"zawiszaty/microservice/Domain"
)

type MysqlAccountRepository struct {
	db sql.DB
}

func NewMysqlAccountRepository(db sql.DB) *MysqlAccountRepository {
	return &MysqlAccountRepository{db: db}
}

func (repository *MysqlAccountRepository) Apply(account Domain.Account) {
	results, _ := repository.Find(account.Id)
	balance := fmt.Sprintf("%f", account.Balance.GetAmount())

	if results == nil {
		query := repository.db.Query("INSERT INTO `go_microservice`.`accounts` (`id`, `balance`) VALUES ('" + account.Id + "', " + balance + ")")
	} else {
		repository.db.Query("UPDATE `go_microservice`.`accounts` t SET  t.`balance` = " + balance + " WHERE t.`id` = '" + account.Id + "'")
	}
}

func (repository MysqlAccountRepository) GetAll() []Domain.Account {
	results, _ := repository.db.Query("SELECT * from accounts")
	var accounts []Domain.Account

	for results.Next() {
		var id string
		var balance float64

		_ = results.Scan(&id, &balance)
		balanceVo, _ := Domain.NewBalance(balance)
		account := Domain.Account{Id: id, Balance: *balanceVo}
		accounts = append(accounts, account)
	}

	return accounts
}

func (repository MysqlAccountRepository) Find(id string) (*Domain.Account, error) {
	var Id string
	var Balance float64

	results := repository.db.QueryRow("SELECT * from accounts where accounts.id='" + id + "'")
	err := results.Scan(&Id, &Balance)

	if err != nil {
		return nil, err
	}
	balanceVo, _ := Domain.NewBalance(Balance)
	account := Domain.Account{Id: id, Balance: *balanceVo}

	return &account, nil
}

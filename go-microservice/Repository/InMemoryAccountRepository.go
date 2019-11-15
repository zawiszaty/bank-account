package Repository

import (
	"errors"
	"zawiszaty/microservice/Domain"
)

type InMemoryAccountRepository struct {
	accounts []Domain.Account
}

func (repository *InMemoryAccountRepository) Apply(account Domain.Account) {
	for index, item := range repository.accounts {
		if item.Id == account.Id {
			repository.accounts[index] = account
			return
		}
	}
	repository.accounts = append(repository.accounts, account)
}

func (repository InMemoryAccountRepository) GetAll() []Domain.Account {
	return repository.accounts
}

func (repository InMemoryAccountRepository) Find(id string) (*Domain.Account, error) {
	for _, item := range repository.accounts {
		if item.Id == id {
			return &item, nil
		}
	}

	return nil, errors.New("Account not found")
}

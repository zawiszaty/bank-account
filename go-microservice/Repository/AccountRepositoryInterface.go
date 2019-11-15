package Repository

import "zawiszaty/microservice/Domain"

type AccountRepositoryInterface interface {
	Apply(account Domain.Account)
	GetAll() []Domain.Account
	Find(id string) (*Domain.Account, error)
}

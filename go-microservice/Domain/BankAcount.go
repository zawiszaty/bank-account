package Domain

import (
	"errors"
	"github.com/satori/go.uuid"
)

type balance struct {
	Amount float64
}

func (b balance) GetAmount() float64 {
	return b.Amount
}

func (b *balance) AddBalance(balance float64) {
	b.Amount += balance
}

func (b *balance) WithdrawBalance(balance float64) {
	b.Amount -= balance
}

func NewBalance(amount float64) (*balance, error) {
	if amount < 0 {
		return nil, errors.New("nie działa")
	}
	return &balance{Amount: amount}, nil
}

type Account struct {
	Id      string
	Balance balance
}

func NewAccount(balance *balance) *Account {
	id := uuid.Must(uuid.NewV4(), nil)
	return &Account{Id: id.String(), Balance: *balance}
}

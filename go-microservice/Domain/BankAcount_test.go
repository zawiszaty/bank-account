package Domain

import (
	"testing"
)

func TestNewBalance(t *testing.T) {
	balance, err := NewBalance(200.0)

	if err != nil && balance.GetAmount() != 200.0 {
		t.Fail()
	}
}

func TestNewBalanceWhenAddWrongAmount(t *testing.T) {
	_, err := NewBalance(-200.0)

	if err == nil {
		t.Fail()
	}
}

func TestBalance_AddBalance(t *testing.T) {
	balance, err := NewBalance(200.0)

	if err != nil {
		t.Fail()
	}

	balance.AddBalance(200.0)

	if balance.GetAmount() != 400.0 {
		t.Fail()
	}
}

func TestBalance_WithdrawBalance(t *testing.T) {
	balance, err := NewBalance(200.0)

	if err != nil {
		t.Fail()
	}

	balance.WithdrawBalance(200.0)

	if balance.GetAmount() != 0.0 {
		t.Fail()
	}
}
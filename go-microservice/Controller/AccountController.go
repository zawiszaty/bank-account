package Controller

import (
	"encoding/json"
	"fmt"
	"github.com/gorilla/mux"
	"net/http"
	"zawiszaty/microservice/Repository"
	"zawiszaty/microservice/UseCase"
	"zawiszaty/microservice/Utlis"
)

func AddAccount(w http.ResponseWriter, r *http.Request) {
	repository := Repository.NewMysqlAccountRepository(Utlis.GetDb())
	err := UseCase.CreateAccountHandler(UseCase.CreateAccountCommand{}, repository)

	if err != nil {
		fmt.Fprintf(w, "%s", err.Error())
	}
	w.WriteHeader(http.StatusNoContent)
}

func GetALL(w http.ResponseWriter, r *http.Request) {
	repository := Repository.NewMysqlAccountRepository(Utlis.GetDb())
	t := repository.GetAll()

	if len(t) == 0 {
		w.WriteHeader(http.StatusNotFound)
		return
	}
	jsons, _ := json.Marshal(t)
	_, _ = fmt.Fprintf(w, "%s", jsons)
}

func GetSingle(w http.ResponseWriter, r *http.Request) {
	vars := mux.Vars(r)
	repository := Repository.NewMysqlAccountRepository(Utlis.GetDb())
	account, _ := vars["id"]
	t, err := repository.Find(account)

	if err != nil {
		w.WriteHeader(http.StatusNotFound)
		return
	}
	jsons, _ := json.Marshal(t)
	_, _ = fmt.Fprintf(w, "%s", jsons)
}

type accountForm struct {
	Amount float64
}

func AddBalance(w http.ResponseWriter, r *http.Request) {
	vars := mux.Vars(r)
	repository := Repository.InMemoryAccountRepository{}
	id, _ := vars["id"]
	account, err := repository.Find(id)

	if err != nil {
		w.WriteHeader(http.StatusNotFound)
		return
	}
	decoder := json.NewDecoder(r.Body)
	var data accountForm
	err = decoder.Decode(&data)

	if err != nil {
		panic(err)
	}
	account.Balance.AddBalance(data.Amount)
	repository.Apply(*account)
	w.WriteHeader(http.StatusOK)
}

func Withdraw(w http.ResponseWriter, r *http.Request) {
	vars := mux.Vars(r)
	repository := Repository.InMemoryAccountRepository{}
	id, _ := vars["id"]
	account, err := repository.Find(id)

	if err != nil {
		w.WriteHeader(http.StatusNotFound)
		return
	}
	decoder := json.NewDecoder(r.Body)
	var data accountForm
	err = decoder.Decode(&data)

	if err != nil {
		panic(err)
	}
	account.Balance.WithdrawBalance(data.Amount)
	repository.Apply(*account)
	w.WriteHeader(http.StatusOK)
}

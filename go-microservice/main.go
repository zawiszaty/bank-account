package main

import (
	"fmt"
	_ "github.com/go-sql-driver/mysql"
	"github.com/gorilla/mux"
	"net/http"
	"zawiszaty/microservice/Controller"
	"zawiszaty/microservice/Utlis"
)

func main() {
	Utlis.Migrate()
	r := mux.NewRouter()

	r.HandleFunc("/api/account", Controller.AddAccount).Methods("PUT")
	r.HandleFunc("/api/accounts", Controller.GetALL).Methods("GET")
	r.HandleFunc("/api/account/{id}", Controller.GetSingle).Methods("GET")
	r.HandleFunc("/api/account/{id}/add/balance", Controller.AddBalance).Methods("POST")
	r.HandleFunc("/api/account/{id}/withdraw/balance", Controller.Withdraw).Methods("POST")

	println("Servers run on port 80 in container and 8989 on your localhost")
	err := http.ListenAndServe(":80", r)

	if err != nil {
		fmt.Println(err.Error())
	}
}

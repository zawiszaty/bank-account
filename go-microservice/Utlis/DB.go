package Utlis

import "database/sql"

func GetDb() sql.DB {
	db, err := sql.Open("mysql", "root:admin@tcp(db:3306)/go_microservice")

	if err != nil {
		panic(err.Error())
	}
	return *db
}

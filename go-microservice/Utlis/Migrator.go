package Utlis

import "fmt"

func Migrate() {
	db := GetDb()
	db.Begin()
	db.QueryRow("create DATABASE go_microservice if not exists;")
	db.QueryRow("create table if not exists accounts ( id         varchar(36) primary key, balance    double(8, 2) not null) collate = utf8mb4_unicode_ci;")
	db.Close()
	fmt.Println("Success")
}

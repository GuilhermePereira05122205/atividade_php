CREATE DATABASE IF NOT EXISTS Atividade;

CREATE TABLE Cliente(
	id int primary key auto_increment,
	nome varchar(100),
    email varchar(100),
    cidade varchar(80),
    estado varchar(2)
);
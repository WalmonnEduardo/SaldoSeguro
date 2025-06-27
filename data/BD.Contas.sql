CREATE DATABASE dbContas;
USE dbContas;
CREATE TABLE Cliente (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    email VARCHAR(50) NOT NULL
);
CREATE TABLE Conta (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL,
    data_vencimento DATE NOT NULL,
    valor DECIMAL(17,2) NOT NULL,
    tipo CHAR(1) NOT NULL,
    importancia CHAR(1) NOT NULL,
    id_cliente INT NOT NULL,
    FOREIGN KEY (id_cliente) REFERENCES Cliente(id)
);

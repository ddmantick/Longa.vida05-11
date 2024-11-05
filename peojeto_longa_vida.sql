CREATE DATABASE longa_vida
USE longa_vida

CREATE TABLE Plano (
    Numero CHAR(2) PRIMARY KEY NOT NULL,
    Descricao CHAR(30),
    Valor DECIMAL(10,2)
);

CREATE TABLE Associado (
    Plano CHAR(2) NOT NULL,
    Nome CHAR(40) PRIMARY KEY NOT NULL,
    Endereco CHAR(35),
    Cidade CHAR(20),
    Estado CHAR(2),
    CEP CHAR(9),
    FOREIGN KEY (Plano) REFERENCES Plano(Numero)
);

INSERT INTO Plano (Numero, Descricao, Valor) VALUES
('B1', 'Plano Basico 1', 300.00),
('B2', 'Plano Basico 2', 350.00),
('B3', 'Plano Basico 3', 400.00),
('E1', 'Plano Executivo 1', 500.00),
('E2', 'Plano Executivo 2', 550.00),
('E3', 'Plano Executivo 3', 600.00),
('M1', 'Plano Master 1', 700.00),
('M2', 'Plano Master 2', 750.00),
('M3', 'Plano Master 3', 800.00);

INSERT INTO Associado (Plano, Nome, Endereco, Cidade, Estado, CEP) VALUES
('B1', 'JOAO SILVA', 'RUA A', 'SAO PAULO', 'SP', '01234-567'),
('B2', 'MARIA OLIVEIRA', 'RUA B', 'COTIA', 'SP', '06541-098'),
('E1', 'CARLOS SOUZA', 'RUA C', 'DIADEMA', 'SP', '09987-654'); 

SELECT Associado.Nome, Plano.Descricao, Plano.Valor
FROM Associado
JOIN Plano ON Associado.Plano = Plano.Numero;

SELECT COUNT(*) AS TotalAssociadosB1
FROM Associado
WHERE Plano = 'B1';


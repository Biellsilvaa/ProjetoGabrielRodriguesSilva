create database projetodb;
use projetodb;

-- Tabela para armazenar informações de produtos
CREATE TABLE produtos (
    idProduto INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    preco DOUBLE(10, 2) NOT NULL,
    quantidade INT NOT NULL,
    image VARCHAR(255) 
);

-- Tabela para armazenar informações de vendas
CREATE TABLE vendas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT,
    quantidade_vendida INT NOT NULL,
    desconto DOUBLE(10, 2) NOT NULL,
    data_venda TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (produto_id) REFERENCES produtos(idProduto)
);



DELIMITER //
CREATE PROCEDURE ObterProdutoPorID(IN produtoID INT)
BEGIN
    SELECT *
    FROM produtos
    WHERE id = produtoID;
END //
DELIMITER ;


select * from produtos;
select * from vendas;

drop database projetodb;
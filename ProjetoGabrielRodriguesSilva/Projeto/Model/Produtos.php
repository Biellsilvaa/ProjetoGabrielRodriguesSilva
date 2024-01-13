<?php

class Produto {
    // Propriedades (atributos) privados da classe
    private $idProduto;   // Identificador único do produto
    private $nome;        // Nome do produto
    private $preco;       // Preço do produto
    private $quantidade;  // Quantidade disponível em estoque

    // Método para obter o ID do produto
    public function getIdProduto() {
        return $this->idProduto;
    }

    // Método para definir o ID do produto
    public function setIdProduto($idProduto) {
        $this->idProduto = $idProduto;
    }

    // Método para definir o nome do produto
    public function setNome($nome) {
        $this->nome = $nome;
    }

    // Método para obter o nome do produto
    public function getNome() {
        return $this->nome;
    }

    // Método para definir o preço do produto
    public function setPreco($preco) {
        $this->preco = $preco;
    }

    // Método para obter o preço do produto
    public function getPreco() {
        return $this->preco;
    }

    // Método para definir a quantidade disponível em estoque
    public function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
    }

    // Método para obter a quantidade disponível em estoque
    public function getQuantidade() {
        return $this->quantidade;
    }
}
?>

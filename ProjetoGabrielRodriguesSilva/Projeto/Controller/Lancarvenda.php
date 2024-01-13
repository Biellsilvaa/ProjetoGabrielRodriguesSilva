<?php
session_start();

// Informações de conexão com o banco de dados

include('../dados/conexao.php');


if (isset($_GET['idProduto'])) {
    $idProduto = $_GET['idProduto'];

    try {
   
        $stmt = $pdo->prepare("SELECT * FROM produtos WHERE idProduto = :idProduto");
        $stmt->bindParam(':idProduto', $idProduto);
        $stmt->execute();

        if ($produto = $stmt->fetch(PDO::FETCH_ASSOC)) {
            
            $quantidadeVendida = isset($_GET['quantidade_vendida']) ? intval($_GET['quantidade_vendida']) : 0;
            $desconto = isset($_GET['desconto']) ? floatval($_GET['desconto']) : 0.0;

            // Verificar se há estoque suficiente

            if ($produto['quantidade'] >= $quantidadeVendida) {

                // Calcular o novo estoque
                $novoEstoque = $produto['quantidade'] - $quantidadeVendida;

                try {
                
                    $pdo->beginTransaction();

                    // Atualizar o estoque no banco 
                    $stmtUpdate = $pdo->prepare("UPDATE produtos SET quantidade = :novoEstoque WHERE idProduto = :idProduto");
                    $stmtUpdate->bindParam(':novoEstoque', $novoEstoque);
                    $stmtUpdate->bindParam(':idProduto', $idProduto);
                    $stmtUpdate->execute();

                    // Registrar a venda em vendas
                    $stmtVenda = $pdo->prepare("INSERT INTO vendas (produto_id, quantidade_vendida, desconto, data_venda) VALUES (:produto_id, :quantidade_vendida, :desconto, CURRENT_TIMESTAMP)");
                    $stmtVenda->bindParam(':produto_id', $idProduto);
                    $stmtVenda->bindParam(':quantidade_vendida', $quantidadeVendida);
                    $stmtVenda->bindParam(':desconto', $desconto);
                    $stmtVenda->execute();

                 
                    $pdo->commit();
                } catch (PDOException $e) {

                    
                    $pdo->rollBack();
                    echo "Erro ao processar a venda: " . $e->getMessage();
                    exit;
                }

                // Mostra a última venda registrada e o estoque atual

                $_SESSION['message'] = "Venda realizada com sucesso!";

                $_SESSION['lastSale'] = [
                    'produto' => $produto['nome'],
                    'quantidadeVendida' => $quantidadeVendida,
                    'desconto' => $desconto,
                    'estoqueAtual' => $novoEstoque,
                ];

                header('Location:../View/index.php');
                exit;
            } else {
                $_SESSION['message'] = "Estoque insuficiente para realizar a venda.";
                header('Location:../View/index.php');
                exit;
            }
        } else {
            $_SESSION['message'] = "Produto não encontrado com o ID: $idProduto";
            header('Location:../View/index.php');
            exit;
        }
    } catch (PDOException $e) {
        echo "Erro ao buscar o produto no banco de dados: " . $e->getMessage();
        exit;
    }
} else {
    $_SESSION['message'] = "ID do produto não fornecido para a venda.";
    header('Location:../View/index.php');
    exit;
}
?>

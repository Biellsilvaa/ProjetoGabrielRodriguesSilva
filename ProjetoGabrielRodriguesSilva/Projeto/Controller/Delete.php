<?php
session_start();

// Informações de conexão com o banco de dados
include('../dados/conexao.php');

if (isset($_GET['idProduto'])) {
    $idProduto = $_GET['idProduto'];

    // Lógica para excluir o produto e vendas relacionadas do banco
    try {
        $pdo->beginTransaction();

        // Excluir vendas relacionadas ao produto
        $stmtDeleteVendas = $pdo->prepare("DELETE FROM vendas WHERE produto_id = :idProduto");
        $stmtDeleteVendas->bindParam(':idProduto', $idProduto);
        $stmtDeleteVendas->execute();

        // Excluir o produto
        $stmtDeleteProduto = $pdo->prepare("DELETE FROM produtos WHERE idProduto = :idProduto");
        $stmtDeleteProduto->bindParam(':idProduto', $idProduto);
        $stmtDeleteProduto->execute();

        $pdo->commit();

        $_SESSION['message'] = "Produto removido com sucesso.";
        header('Location:../View/index.php');
        exit;
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Erro ao excluir o produto do banco de dados: " . $e->getMessage();
        exit;
    }
} else {
    $_SESSION['message'] = "ID do produto não fornecido para exclusão.";
    header('Location:../View/index.php');
    exit;
}
?>

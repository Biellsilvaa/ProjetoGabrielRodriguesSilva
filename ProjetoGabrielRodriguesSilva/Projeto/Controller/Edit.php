<?php
session_start();

// Informações de conexão com o banco de dados
include('../dados/conexao.php');

if (!isset($_SESSION['produtos'])) {
    $_SESSION['produtos'] = array();
}

// Verifica se o ID do produto foi passado na URL
if (isset($_GET['idProduto'])) {
    $idProduto = $_GET['idProduto'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM produtos WHERE idProduto = :idProduto");
        $stmt->bindParam(':idProduto', $idProduto);
        $stmt->execute();

        // Verifica se o produto com o ID fornecido existe no banco de dados
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($produto) {
            // Processar o formulário de edição se o método for POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $novoNome = $_POST['nome'];
                $novaQuantidade = $_POST['quantidade'];
                $novoPreco = $_POST['preco'];

                // Verificar se um novo arquivo de imagem foi enviado
                if ($_FILES['image']['size'] > 0) {
                    $uploadDir = '../uploads/';
                    $uploadFile = $uploadDir . basename($_FILES['image']['name']);

                    // Mover o arquivo enviado para o diretório de upload
                    move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile);

                    // Atualizar o caminho da imagem no banco de dados
                    $novoCaminhoImagem = 'uploads/' . $_FILES['image']['name'];
                    $stmtUpdate = $pdo->prepare("UPDATE produtos SET nome = :nome, quantidade = :quantidade, preco = :preco, image = :image WHERE idProduto = :idProduto");
                    $stmtUpdate->bindParam(':image', $novoCaminhoImagem);

                    // Adicione esta linha para atualizar o caminho da imagem na sessão produtos
                    $_SESSION['produtos']['image'] = $novoCaminhoImagem;
                } else {
                    // Caso nenhum novo arquivo de imagem tenha sido enviado, manter o caminho existente
                    $stmtUpdate = $pdo->prepare("UPDATE produtos SET nome = :nome, quantidade = :quantidade, preco = :preco WHERE idProduto = :idProduto");
                }

                $stmtUpdate->bindParam(':nome', $novoNome);
                $stmtUpdate->bindParam(':quantidade', $novaQuantidade);
                $stmtUpdate->bindParam(':preco', $novoPreco);
                $stmtUpdate->bindParam(':idProduto', $idProduto);
                $stmtUpdate->execute();

                $_SESSION['message'] = "Produto atualizado com sucesso!";
                header('Location: ../View/index.php');
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
    $_SESSION['message'] = "ID do produto não fornecido para edição.";
    header('Location:../View/index.php');
    exit;
}
?>

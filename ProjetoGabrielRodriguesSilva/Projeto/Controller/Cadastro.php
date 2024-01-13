<?php
session_start();

// Informações de conexão com o banco de dados
include('../dados/conexao.php');

if (isset($_POST['nome'])) {
    if ($_POST['nome'] != "") {
        if (isset($_FILES['image'])) {
            $ext = strtolower(substr($_FILES['image']['name'], -4));
            $file_name = md5(date('Y.m.d.H.i.s')) . $ext;
            $dir = '../uploads/';

            move_uploaded_file($_FILES['image']['tmp_name'], $dir . $file_name);
        }

        $nome = $_POST['nome'];
        $preco = $_POST['preco'];
        $quantidade = $_POST['quantidade'];

        try {
           
            $stmt = $pdo->prepare("INSERT INTO produtos (nome, preco, quantidade, image) VALUES (:nome, :preco, :quantidade, :image)");

            
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':preco', $preco);
            $stmt->bindParam(':quantidade', $quantidade);
            $stmt->bindParam(':image', $file_name);

            $stmt->execute();
            
            $idProduto = $pdo->lastInsertId();

            // Cria um array com os dados do produto
            $produto = array(
                'idProduto' => $idProduto,
                'nome' => $nome,
                'preco' => $preco,
                'quantidade' => $quantidade,
                'image' => $file_name
            );

            $_SESSION['produtos'] = $produto;
            $_SESSION['lastImagePath'] = $file_name; // Armazena o nome do arquivo da imagem na sessão

            echo "Produto cadastrado com sucesso no banco de dados.";
        } catch (PDOException $e) {
            echo "Erro ao cadastrar o produto: " . $e->getMessage();
        }

        unset($_POST['nome']);
        unset($_POST['preco']);
        unset($_POST['quantidade']);
        header('Location:../View/index.php');
    } else {
        $_SESSION['message'] = "O campo nome do produto não pode ser vazio!";
        header('Location:../View/index.php');
    }
}
?>

<?php
session_start();

include('../dados/conexao.php');

if (!isset($_SESSION['produtos'])) {
    $_SESSION['produtos'] = array();
}

// Verifica se o ID do produto foi passado na URL
if (isset($_GET['idProduto'])) {
    $idProduto = $_GET['idProduto'];

    try {
        // Prepara a consulta SQL para obter os detalhes do produto
        $stmt = $pdo->prepare("SELECT * FROM produtos WHERE idProduto = :idProduto");
        $stmt->bindParam(':idProduto', $idProduto);
        $stmt->execute();

        // Verifica se o produto com o ID fornecido existe no banco de dados
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($produto) {
            // Passa o caminho da imagem do produto para a sessão
            $_SESSION['lastImagePath'] = $produto['image'];

            // Agora, você pode acessar o caminho da imagem em $_SESSION['lastImagePath']
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
    <title>Editar produtos</title>
</head>
<body>

<div class="container">

<div class="header">
    <h2>Editar de Produtos</h2>
</div>

<div class="form">
<form action="../Controller/edit.php?idProduto=<?php echo $produto['idProduto']; ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="edit_key" value="<?php echo $produto['idProduto']; ?>">
    <label for="nome">*Produto:</label>
    <input type="text" name="nome" placeholder="Nome do produto" value="<?php echo $produto['nome']; ?>">
    <label for="quantidade">Quantidade:</label>
    <input type="int" name="quantidade" placeholder="Quantidade do produto" value="<?php echo $produto['quantidade']; ?>">
    <label for="preco">Preço:</label>
    <input type="int" name="preco" value="<?php echo $produto['preco']; ?>">

    
    <button type="submit">Editar Produto</button>
</form>

    <?php 
    if (isset($_SESSION['message'])) {
        echo "<p style='color:#D3252D';>" . $_SESSION['message'] . "</p>";
        unset($_SESSION['message']);
    }
    ?>

</div>

<div class="footer">
    <p>Desenvolvido por @DeeBieel</p>
</div>
</div>

</body>
</html>



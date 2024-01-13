<?php
session_start();

// Informações de conexão com o banco de dados
include('../dados/conexao.php');

if (!isset($_SESSION['produtos'])) {
    $_SESSION['produtos'] = array();
}


if (isset($_GET['idProduto'])) {
    $idProduto = $_GET['idProduto'];

    try {
        
        $stmt = $pdo->prepare("SELECT * FROM produtos WHERE idProduto = :idProduto");
        $stmt->bindParam(':idProduto', $idProduto);
        $stmt->execute();

        if ($produto = $stmt->fetch(PDO::FETCH_ASSOC)) {
         
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
    <title>Vender produto</title>
</head>
<body>

<div class="container">

<div class="header">
    <h2>Lançar venda de produto</h2>
</div>

<div class="form">
    <form action="../Controller/Lancarvenda.php" method="get">
        <input type="hidden" name="idProduto" value="<?php echo $idProduto; ?>">

        <dl>
            <dt><strong>Produto</strong></dt>
            <dd><?php echo (empty($produto['nome']) ? 'Produto não encontrado' : $produto['nome']); ?></dd>
            <dt><strong>Quantidade disponível</strong></dt>
            <dd><?php echo (empty($produto['quantidade']) ? 0 : $produto['quantidade']) ?></dd>
            <dt><strong>Preço do produto</strong></dt>
            <dd>R$ <?php echo number_format(empty($produto['preco']) ? 0 : $produto['preco'], 2, ',', '.'); ?></dd>
        </dl>

        <label for="quantidade_vendida">Quantidade:</label>
        <input type="number" name="quantidade_vendida" placeholder="Quantidade do produto" required>

        <label for="desconto">Desconto (%):</label>
        <input type="number" name="desconto" placeholder="Desconto em %" required>

        <button type="submit" class="btn-lancar-venda">Vender Produto</button>
    </form>
</div>

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

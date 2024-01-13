
<?php
session_start();

// Informações de conexão com o banco de dados
include('../dados/conexao.php');

// Consulta SQL para obter todos os produtos
$stmt = $pdo->prepare("SELECT * FROM produtos");
$stmt->execute();
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Cadastrar produtos</title>
</head>
<body>

<div class="container">

<div class="header">
<h2>Cadastro de Produtos</h2>
</div>

<div class="form">

   <form action="../Controller/Cadastro.php" method="post" enctype="multipart/form-data">

    <input type="hidden" name="insert" value="insert">
            <label for="nome">*Produto:</label>
            <input type="text" name="nome" placeholder="Nome do produto">
            <label for="quantidade">Quantidade:</label>
            <input type="int" name="quantidade" placeholder="Qantidade do produto">
            <label for="preco">Preço:</label>
            <input type="int" name="preco">
            <label for="image">Imagem:</label>
            <input type="file" name="image">

    <button type="submit">Cadastrar Produto</button>

    </form>

    <?php 
        
        if (isset ($_SESSION['message'])){
            echo "<p style='color:#D3252D';>". $_SESSION['message'] . "</p>";
            unset ($_SESSION['message']);
        }
        
        
        ?>
</div>

<div class="list-tasks">

<?php

if ($resultado) {
    echo "<ul>";

    foreach ($resultado as $produto) {
        $idProduto = $produto['idProduto'];

        echo "<li>
                  <a href='details.php?idProduto=$idProduto'>";
        echo  $produto['nome'];
        echo "</a>
                  <button type='button' class='btn-clear' onclick='deletar($idProduto)'> Remover </button>
              </li>";
    }

    echo "</ul>";
}

?>

<script>
    function deletar(idProduto) {
        if (confirm('Deseja remover o produto?')) {
            window.location = 'http://localhost/ProjetoGabrielRodriguesSilva/projeto/controller/delete.php?idProduto=' + idProduto;
        }
    }
</script>





<div class="footer">
        <p>Desenvolvido por @DeeBieel</p>
</div>
</div>


</body>
</html>
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
    <title>Gerenciador de tarefas</title>
</head>
<body>
    <div class="details_container">
        <div class="header">
            <h1><?php echo isset($produto['nome']) ? $produto['nome'] : "Nome não definido"; ?></h1>
        </div>
        <div class="row">
            <div class="details">
                <dl>
                    <dt>Quantidade do produto</dt>
                    <dd><?php echo (empty($produto['quantidade']) ? 0 : $produto['quantidade']) ?></dd>
                    <dt>Preço do produto</dt>
                    <dd>R$ <?php echo number_format(empty($produto['preco']) ? 0 : $produto['preco'], 2, ',', '.'); ?></dd>
                </dl>

                <dt><strong>Última Venda</strong></dt>
                    <dd>
                        <?php
                        try {
                            $stmtUltimaVenda = $pdo->prepare("SELECT * FROM vendas WHERE produto_id = :idProduto ORDER BY data_venda DESC LIMIT 1");
                            $stmtUltimaVenda->bindParam(':idProduto', $idProduto);
                            $stmtUltimaVenda->execute();

                            if ($ultimaVenda = $stmtUltimaVenda->fetch(PDO::FETCH_ASSOC)) {
                                echo "Quantidade Vendida: " . $ultimaVenda['quantidade_vendida'] . "<br>";
                                
                                // Formatar a data para o formato dd/mm/aa
                                $dataFormatada = date('d/m/y', strtotime($ultimaVenda['data_venda']));
                                echo "Data da Venda: " . $dataFormatada . "<br>";
                                
                                echo "Desconto: " . $ultimaVenda['desconto'] . "<br>";
                            } else {
                                echo "Nenhuma venda registrada.";
                            }
                        } catch (PDOException $e) {
                            echo "Erro ao obter informações da última venda: " . $e->getMessage();
                        }
                        ?>
                    </dd>

                <?php
             
                ?>
                <form action='http://localhost/ProjetoGabrielRodriguesSilva/projeto/View/edit.php' method='get'>
                    <input type='hidden' name='idProduto' value='<?php echo $idProduto; ?>'>
                    <button type='submit' class='btn-edit'>Editar produto</button>
                </form>
                
                <form action='http://localhost/ProjetoGabrielRodriguesSilva/projeto/View/Venda.php' method='get'>
                <input type='hidden' name='idProduto' value='<?php echo $idProduto; ?>'>
                <button type='submit' class='btn-lancar-venda'>Lançar Venda</button>
                </form>


            </div>
            <div class="image"> 

            <?php
                // Verifica se há uma imagem definida para o produto
                if (!empty($produto['image'])) {
                    // Se houver, constrói o caminho completo da imagem
                    $caminhoImagem = "../uploads/" . $produto['image'];
                    // Exibe a imagem usando a tag <img>
                    echo "<img src=\"$caminhoImagem\" alt=\"Imagem do produto\">";
                } else {
                    // Se não houver imagem, exibe uma mensagem indicando que não está disponível
                    echo "Imagem não disponível";
                }
                ?>



            
</div>

        </div>
        <div class="footer">
            <p>Desenvolvido por @DeeBieel</p>
        </div>
    </div>
</body>
</html>

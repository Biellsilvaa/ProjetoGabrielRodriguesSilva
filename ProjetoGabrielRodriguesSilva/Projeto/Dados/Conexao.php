<?php
// Tenta criar uma conexão PDO com o banco de dados MySQL
try {
    //  Host, o nome do banco de dados, o nome de usuário e a senha
    $pdo = new PDO('mysql:host=localhost;dbname=projetodb', 'root', '');

    // Tratamento de erros
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Se ocorrer algum erro exibe uma mensagem de erro
    
    echo 'Erro: ' . $e->getMessage();

    // Encerra a execução do script
    exit;
}
?>

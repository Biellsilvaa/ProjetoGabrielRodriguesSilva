# ProjetoGabrielRodriguesSilva
Visão Geral
Este projeto consiste em um sistema de gerenciamento de produtos e vendas, desenvolvido em PHP e utilizando um banco de dados MySQL para armazenar as informações. O sistema permite a adição, edição e visualização de produtos, além de possibilitar o lançamento de vendas associadas a esses produtos.

Estrutura do Projeto
O projeto está estruturado em duas principais pastas:
Controller: Contém os scripts PHP responsáveis por manipular as requisições do usuário e interagir com o banco de dados.
View: Contém os arquivos HTML que definem a interface do usuário, bem como os estilos CSS associados.
Além disso, há uma pasta de dados que contém o script SQL para criar a tabela no banco de dados e uma pasta uploads para armazenar as imagens dos produtos.

Funcionalidades
Cadastro de Produtos:
Adição de novos produtos com informações como nome, quantidade, preço e imagem.
Visualização de Produtos:
Listagem de todos os produtos cadastrados.
Edição de Produtos:
Possibilidade de editar informações de produtos existentes, incluindo a troca de imagens.
Lançamento de Vendas:
Registro de vendas associadas a produtos, incluindo quantidade vendida, data da venda e desconto.
Visualização Detalhada de Produtos:
Exibição detalhada de informações de um produto, incluindo dados de vendas associadas e última venda realizada.

Como Iniciar o Projeto
Configuração do Banco de Dados:
Importe o script SQL localizado em dados/script.sql para criar a tabela no banco de dados.
Configuração da Conexão com o Banco de Dados:
Edite o arquivo dados/conexao.php para fornecer as informações corretas de conexão com o banco de dados.
Execução:
Certifique-se de que o servidor web (como Apache) e o PHP estão instalados.
Coloque o projeto na pasta do servidor web.
Acesse a aplicação através do navegador.

Tecnologias Utilizadas
PHP: Linguagem de programação utilizada para a lógica do servidor.
MySQL: Banco de dados utilizado para armazenar informações sobre produtos e vendas.
HTML/CSS: Linguagens de marcação e estilo para a criação da interface do usuário.



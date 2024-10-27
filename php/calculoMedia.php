<?php
require_once 'conexão.php'; // Certifique-se de que o caminho está correto

// Verifica se a requisição é do tipo GET e se os parâmetros necessários foram passados
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['nome'], $_GET['nota1'], $_GET['nota2'])) {
    $nome = $_GET['nome'];
    $nota1 = $_GET['nota1'];
    $nota2 = $_GET['nota2'];

    // Calculando a média
    $media = ($nota1 + $nota2) / 2;

    // Definindo a situação com base na média
    if ($media >= 6) {
        $situacao = 'Aprovado';
    } elseif ($media == 5) {
        $situacao = 'Recuperação';
    } else {
        $situacao = 'Reprovado';
    }

    // Inserindo os dados no banco de dados
    $query = "INSERT INTO cadastro (nome, nota1, nota2, media, situacao) VALUES (?, ?, ?, ?, ?)";

    // Prepara e executa a consulta
    $stmt = $conexao->prepare($query);
    $stmt->bind_param("ssdds", $nome, $nota1, $nota2, $media, $situacao);

    // HTML básico para Bootstrap
    ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    /* Estilo personalizado */
    body {
        background-color: #f8f9fa;
        /* Cor de fundo suave */
    }

    .container {
        margin-top: 50px;
        max-width: 600px;
        /* Largura máxima do container */
    }

    h2 {
        color: #28a745;
        /* Cor verde para a mensagem de sucesso */
    }
    </style>
</head>

<body>
    <div class="container bg-white shadow rounded p-4">
        <?php
            if ($stmt->execute()) {
                // Exibir mensagem de sucesso e perguntar se deseja adicionar mais um aluno
                echo '<h2>Notas inseridas com sucesso!</h2>';
                echo '<p>Deseja adicionar mais um aluno?</p>';
                echo '<div class="d-flex justify-content-between">';
                echo '<form action="../pages/cadastrar_notas.html" method="GET" class="me-2">';
                echo '<button type="submit" class="btn btn-primary">Sim</button>';
                echo '</form>';
                echo '<form action="../pages/consulta.html" method="GET">';
                echo '<button type="submit" class="btn btn-secondary">Não</button>';
                echo '</form>';
                echo '</div>'; // Fecha o div da d-flex
            } else {
                echo '<div class="alert alert-danger" role="alert">';
                echo "Erro ao inserir os dados: " . $stmt->error;
                echo '</div>';
            }

            $stmt->close();
            $conexao->close();
            ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
} else {
    echo '<div class="alert alert-warning" role="alert">Método de requisição inválido.</div>';
}
?>
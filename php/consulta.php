<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Consultar Médias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
    /* Remove margin do body para que a barra de navegação fique no topo da tela */
    body {
        margin: 0;
    }

    /* Ajusta a largura do formulário */
    .form-container {
        max-width: 400px;
        /* Largura máxima */
    }

    .aprovado {
        color: green;
    }

    .reprovado {
        color: red;
    }
    </style>
</head>

<body>
    <!-- Barra de Navegação -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="../pages/SobreEscola.html">Escola Exemplo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Alternar navegação">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/consulta.html">Consultar Médias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/cadastrar_notas.html">Cadastrar Notas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/SobreEscola.html">Sobre a Escola</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <h1 class="text-center mb-4">Consultar Médias dos Alunos</h1>

        <form action="" method="GET">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Aluno:</label>
                <input type="text" class="form-control" id="nome" name="nome" required />
            </div>
            <button type="submit" class="btn btn-primary">Consultar</button>
        </form>

        <div class="mt-4" id="resultado">
            <?php 
        if (isset($_GET['nome'])) {
            require_once '../php/conexão.php';
            
            $nome_aluno = $_GET['nome'];
            $query = "SELECT * FROM cadastro WHERE nome LIKE ?";
            $stmt = $conexao->prepare($query);
            $nome_aluno_param = $nome_aluno . '%';
            $stmt->bind_param("s", $nome_aluno_param);
            $stmt->execute();
            $resultado = $stmt->get_result();
            
            if ($resultado->num_rows > 0) {
                echo '<table class="table table-striped">';
                echo '<thead><tr><th>Nome</th><th>Nota 1</th><th>Nota 2</th><th>Média</th><th>Situação</th></tr></thead>';
                echo '<tbody>';
                
                while ($aluno = $resultado->fetch_assoc()) {
                    $situacao = $aluno['situacao'];
                    $classe_situacao = ($situacao === 'Aprovado') ? 'aprovado' : 'reprovado';
                    
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($aluno['nome']) . '</td>';
                    echo '<td>' . htmlspecialchars($aluno['nota1']) . '</td>';
                    echo '<td>' . htmlspecialchars($aluno['nota2']) . '</td>';
                    echo '<td>' . htmlspecialchars($aluno['media']) . '</td>';
                    echo '<td class="' . $classe_situacao . '">' . htmlspecialchars($situacao) . '</td>';
                    echo '</tr>';
                }
                
                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<div class="alert alert-warning">Nenhum aluno encontrado com esse nome.</div>';
            }

            $stmt->close();
            $conexao->close();
        }
        ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
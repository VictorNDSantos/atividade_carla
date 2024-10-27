<?php
$localhost = "localhost";
$usuario = "root";
$senha = "";
$db = "controle_notas";
$conexao = new mysqli($localhost, $usuario, $senha, $db);
if ($conexao->connect_error) {
    die("Erro de conexão : " . $conexao->connect_error);
} else {
    //echo "conectado";
}
?>
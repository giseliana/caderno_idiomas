<?php
session_start();

$servidor = "localhost";
$usuario_db = "root";
$senha_db = "";
$banco = "caderno_idiomas";

$conexao = new mysqli($servidor, $usuario_db, $senha_db, $banco);

if ($conexao->connect_error) {
    die("Falha na conexão com o banco: " . $conexao->connect_error);
}
?>
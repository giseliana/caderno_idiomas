<?php
require 'conexao.php';

if (!isset($_SESSION['usuario_id']) || !isset($_GET['acao']) || !isset($_GET['id'])) {
    header("Location: painel_idiomas.php");
    exit();
}

$id_usuario = $_SESSION['usuario_id'];
$id_palavra = (int)$_GET['id'];
$acao = $_GET['acao'];

if ($acao == 'aprender') {
    $conexao->query("UPDATE palavras SET status = 'aprendido' WHERE id = $id_palavra AND usuario_id = $id_usuario");
} elseif ($acao == 'excluir') {
    $conexao->query("DELETE FROM palavras WHERE id = $id_palavra AND usuario_id = $id_usuario");
}

header("Location: painel_idiomas.php");
exit();
?>
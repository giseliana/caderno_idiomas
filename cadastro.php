<?php
require 'conexao.php';

$mensagem_erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_usuario = $_POST['nome'];
    $email_usuario = $_POST['email'];
    $senha_usuario = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
    $comando = $conexao->prepare($sql);
    $comando->bind_param("sss", $nome_usuario, $email_usuario, $senha_usuario);

    if ($comando->execute()) {
        header("Location: index.php");
        exit();
    } else {
        $mensagem_erro = "Erro ao cadastrar. Este e-mail já pode estar em uso.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - Caderno de Idiomas</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container-autenticacao">
        <div class="caixa-autenticacao">
            <div class="caixa-logo">CONTA</div>

            <?php if ($mensagem_erro != ""): ?>
                <div class="alerta-erro"><?= $mensagem_erro ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="grupo-formulario">
                    <label>Seu Nome</label>
                    <input type="text" name="nome" required placeholder="Ex: Maria Silva">
                </div>
                <div class="grupo-formulario">
                    <label>E-mail</label>
                    <input type="email" name="email" required placeholder="seu@email.com">
                </div>
                <div class="grupo-formulario">
                    <label>Senha</label>
                    <input type="password" name="senha" required placeholder="Crie uma senha">
                </div>
                <button type="submit" class="botao-roxo">Criar Conta</button>
            </form>

            <a href="index.php" class="link-texto">Já tem conta? Voltar para o Login</a>
        </div>
    </div>
</body>
</html>
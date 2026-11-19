<?php
require 'conexao.php';

$mensagem_erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email_usuario = $_POST['email'];
    $senha_usuario = $_POST['senha'];

    $sql = "SELECT id, nome, senha FROM usuarios WHERE email = ?";
    $comando = $conexao->prepare($sql);
    $comando->bind_param("s", $email_usuario);
    $comando->execute();
    $resultado = $comando->get_result();

    if ($usuario = $resultado->fetch_assoc()) {
        if (password_verify($senha_usuario, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            header("Location: painel_idiomas.php");
            exit();
        } else {
            $mensagem_erro = "Senha incorreta!";
        }
    } else {
        $mensagem_erro = "E-mail não encontrado!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR" translate="no">
<head>
    <meta charset="UTF-8">
    <title>Login - Caderno de Idiomas</title>
    <link rel="stylesheet" href="estilo.css">]
    <meta name="google" content="notranslate">
</head>
<body class="notranslate">
    <div class="container-autenticacao">
        <div class="caixa-autenticacao">
            <div class="caixa-logo">IDIOMAS</div>
            
            <?php if ($mensagem_erro != ""): ?>
                <div class="alerta-erro"><?= $mensagem_erro ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="grupo-formulario">
                    <label>E-mail</label>
                    <input type="email" name="email" required placeholder="seu@email.com">
                </div>
                <div class="grupo-formulario">
                    <label>Senha</label>
                    <input type="password" name="senha" required placeholder="••••••••">
                </div>
                <button type="submit" class="botao-roxo">Entrar</button>
            </form>

            <a href="cadastro.php" class="link-texto">Não tem conta? Cadastre-se aqui</a>
        </div>
    </div>
</body>
</html>
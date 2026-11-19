<?php
require 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_SESSION['usuario_id'];
    $termo = $_POST['termo'];
    $traducao = $_POST['traducao'];
    $exemplo = $_POST['exemplo'];
    $idioma = $_POST['idioma'];

    $sql = "INSERT INTO palavras (usuario_id, termo, traducao, exemplo, idioma) VALUES (?, ?, ?, ?, ?)";
    $comando = $conexao->prepare($sql);
    $comando->bind_param("issss", $id_usuario, $termo, $traducao, $exemplo, $idioma);

    if ($comando->execute()) {
        header("Location: painel_idiomas.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Nova Palavra</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="formulario-card">
        <h2 style="text-align: center; color: #581c87; margin-bottom: 20px;">Cadastrar Nova Palavra</h2>
        
        <form method="POST" action="">
            <div class="grupo-formulario">
                <label>Termo no Idioma</label>
                <input type="text" name="termo" required placeholder="Ex: Breakthrough">
            </div>

            <div class="grupo-formulario">
                <label>Tradução / Significado</label>
                <input type="text" name="traducao" required placeholder="Ex: Avanço / Revelação">
            </div>

            <div class="grupo-formulario">
                <label>Frase de Exemplo</label>
                <textarea name="exemplo" rows="3" placeholder="Ex: This discovery was a major scientific breakthrough."></textarea>
            </div>

            <div class="grupo-formulario">
                <label>Idioma</label>
                <select name="idioma">
                    <option value="Inglês">Inglês</option>
                    <option value="Espanhol">Espanhol</option>
                    <option value="Francês">Francês</option>
                    <option value="Outro">Outro</option>
                </select>
            </div>

            <div class="botoes-duplos">
                <a href="painel_idiomas.php" class="botao-branco" style="width: 50%; text-align: center;">Cancelar</a>
                <button type="submit" class="botao-roxo" style="width: 50%;">Salvar Palavra</button>
            </div>
        </form>
    </div>
</body>
</html>
<?php
require 'conexao.php';

if (!isset($_SESSION['usuario_id']) || !isset($_GET['id'])) {
    header("Location: painel_idiomas.php");
    exit();
}

$id_usuario = $_SESSION['usuario_id'];
$id_palavra = (int)$_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $termo = $_POST['termo'];
    $traducao = $_POST['traducao'];
    $exemplo = $_POST['exemplo'];
    $idioma = $_POST['idioma'];
    $status = $_POST['status'];

    $sql = "UPDATE palavras SET termo=?, traducao=?, exemplo=?, idioma=?, status=? WHERE id=? AND usuario_id=?";
    $comando = $conexao->prepare($sql);
    $comando->bind_param("sssssii", $termo, $traducao, $exemplo, $idioma, $status, $id_palavra, $id_usuario);
    $comando->execute();

    header("Location: painel_idiomas.php");
    exit();
}

$sql_busca = "SELECT * FROM palavras WHERE id = $id_palavra AND usuario_id = $id_usuario";
$palavra = $conexao->query($sql_busca)->fetch_assoc();

if (!$palavra) {
    header("Location: painel_idiomas.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes da Palavra</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="formulario-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <a href="painel_idiomas.php" style="text-decoration: none; color: #7c3aed; font-weight: bold;">← Voltar</a>
            <h2 style="color: #581c87;">Detalhes da Palavra</h2>
            <a href="acoes.php?acao=excluir&id=<?= $palavra['id'] ?>" class="botao-perigo" style="padding: 6px 12px; font-size: 0.85rem;" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
        </div>

        <form method="POST" action="">
            <div class="grupo-formulario">
                <label>Termo</label>
                <input type="text" name="termo" value="<?= htmlspecialchars($palavra['termo']) ?>" required>
            </div>

            <div class="grupo-formulario">
                <label>Tradução</label>
                <input type="text" name="traducao" value="<?= htmlspecialchars($palavra['traducao']) ?>" required>
            </div>

            <div class="grupo-formulario">
                <label>Frase de Exemplo</label>
                <textarea name="exemplo" rows="3"><?= htmlspecialchars($palavra['exemplo']) ?></textarea>
            </div>

            <div class="grupo-formulario">
                <label>Idioma</label>
                <input type="text" name="idioma" value="<?= htmlspecialchars($palavra['idioma']) ?>">
            </div>

            <div class="grupo-formulario">
                <label>Status de Aprendizado</label>
                <select name="status">
                    <option value="preciso_revisar" <?= $palavra['status'] == 'preciso_revisar' ? 'selected' : '' ?>>Preciso Revisar</option>
                    <option value="aprendido" <?= $palavra['status'] == 'aprendido' ? 'selected' : '' ?>>Aprendido</option>
                </select>
            </div>

            <button type="submit" class="botao-roxo" style="margin-top: 10px;">Salvar Alterações</button>
        </form>
    </div>
</body>
</html>
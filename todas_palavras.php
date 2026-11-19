<?php
require 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

$id_usuario = $_SESSION['usuario_id'];
$filtro_escolhido = isset($_GET['filtro']) ? $_GET['filtro'] : 'todas';

if ($filtro_escolhido == 'preciso_revisar') {
    $sql = "SELECT * FROM palavras WHERE usuario_id = $id_usuario AND status = 'preciso_revisar' ORDER BY id DESC";
} elseif ($filtro_escolhido == 'aprendido') {
    $sql = "SELECT * FROM palavras WHERE usuario_id = $id_usuario AND status = 'aprendido' ORDER BY id DESC";
} else {
    $sql = "SELECT * FROM palavras WHERE usuario_id = $id_usuario ORDER BY id DESC";
}

$resultado_palavras = $conexao->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Todas as Palavras</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="layout-aplicacao">
        <aside class="barra-lateral">
            <div>
                <h2>Indiomando</h2>
                <nav class="menu-links">
                    <a href="painel_idiomas.php">📖 Para Revisar</a>
                    <a href="todas_palavras.php" class="ativo">📚 Todas as Palavras</a>
                    <a href="nova_palavra.php">➕ Nova Palavra</a>
                </nav>
            </div>
            <div class="menu-links">
                <a href="sair.php" style="color: #ef4444;">🚪 Sair</a>
            </div>
        </aside>

        <main class="conteudo-principal">
            <div class="barra-topo">
                <h1>Todas as Palavras Cadastradas</h1>
                <div style="display: flex; gap: 10px;">
                    <form method="GET" action="">
                        <select name="filtro" onchange="this.form.submit()" style="width: auto;">
                            <option value="todas" <?= $filtro_escolhido == 'todas' ? 'selected' : '' ?>>Mostrar: Todas</option>
                            <option value="preciso_revisar" <?= $filtro_escolhido == 'preciso_revisar' ? 'selected' : '' ?>>Apenas Para Revisar</option>
                            <option value="aprendido" <?= $filtro_escolhido == 'aprendido' ? 'selected' : '' ?>>Apenas Aprendidas</option>
                        </select>
                    </form>
                    <a href="nova_palavra.php" class="botao-roxo" style="width: auto;">+ Nova</a>
                </div>
            </div>

            <div class="painel-branco">
                <?php if ($resultado_palavras->num_rows > 0): ?>
                    <?php while ($palavra = $resultado_palavras->fetch_assoc()): ?>
                        <div class="tarefa-item">
                            <div>
                                <strong><?= htmlspecialchars($palavra['termo']) ?></strong> 
                                <span style="color: #7c3aed; font-weight: bold;">(<?= htmlspecialchars($palavra['traducao']) ?>)</span>
                                <span class="etiqueta <?= $palavra['status'] == 'preciso_revisar' ? 'etiqueta-pendente' : 'etiqueta-concluida' ?>" style="margin-left: 10px;">
                                    <?= $palavra['status'] == 'preciso_revisar' ? 'Preciso Revisar' : 'Aprendido' ?>
                                </span>
                                <p style="font-size: 0.85rem; color: #666; margin-top: 4px;">
                                    Idioma: <?= htmlspecialchars($palavra['idioma']) ?> | Exemplo: "<?= htmlspecialchars($palavra['exemplo']) ?>"
                                </p>
                            </div>
                            <a href="detalhes_palavra.php?id=<?= $palavra['id'] ?>" class="botao-branco" style="padding: 6px 14px; font-size: 0.85rem;">Abrir / Editar</a>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Nenhuma palavra encontrada com esse filtro.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
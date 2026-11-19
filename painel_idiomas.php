<?php
require 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

$id_usuario = $_SESSION['usuario_id'];

$total_palavras = $conexao->query("SELECT COUNT(*) as quantidade FROM palavras WHERE usuario_id = $id_usuario")->fetch_assoc()['quantidade'];
$preciso_revisar = $conexao->query("SELECT COUNT(*) as quantidade FROM palavras WHERE usuario_id = $id_usuario AND status = 'preciso_revisar'")->fetch_assoc()['quantidade'];
$aprendido = $conexao->query("SELECT COUNT(*) as quantidade FROM palavras WHERE usuario_id = $id_usuario AND status = 'aprendido'")->fetch_assoc()['quantidade'];

$sql_revisar = "SELECT * FROM palavras WHERE usuario_id = $id_usuario AND status = 'preciso_revisar' ORDER BY termo ASC";
$resultado_revisar = $conexao->query($sql_revisar);
?>
<!DOCTYPE html>
<html lang="pt-BR" translate="no">
<head>
    <meta charset="UTF-8">
    <title>Painel - Palavras para Revisar</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body class="notranslate">
    <div class="layout-aplicacao">
        <aside class="barra-lateral">
            <div>
                <h2>indiomando
                </h2>
                <nav class="menu-links">
                    <a href="painel_idiomas.php" class="ativo">📖 Para Revisar</a>
                    <a href="todas_palavras.php">📚 Todas as Palavras</a>
                    <a href="nova_palavra.php">➕ Nova Palavra</a>
                </nav>
            </div>
            <div class="menu-links">
                <p style="font-size: 0.85rem; margin-bottom: 10px; color: #666;">Olá, <strong><?= htmlspecialchars($_SESSION['usuario_nome']) ?></strong></p>
                <a href="sair.php" style="color: #ef4444;">🚪 Sair</a>
            </div>
        </aside>

        <main class="conteudo-principal">
            <div class="barra-topo">
                <h1>Painel de Vocabulário</h1>
                <a href="nova_palavra.php" class="botao-roxo" style="width: auto;">+ Nova Palavra</a>
            </div>

            <div class="cards-resumo">
                <div class="card">
                    <h3>Total de Palavras</h3>
                    <p><?= $total_palavras ?></p>
                </div>
                <div class="card" style="border-left-color: #f59e0b;">
                    <h3>Preciso Revisar</h3>
                    <p><?= $preciso_revisar ?></p>
                </div>
                <div class="card" style="border-left-color: #10b981;">
                    <h3>Já Aprendido</h3>
                    <p><?= $aprendido ?></p>
                </div>
            </div>

            <div class="painel-branco">
                <h2 style="margin-bottom: 15px; color: #581c87;">Palavras que Preciso Revisar</h2>
                
                <?php if ($resultado_revisar->num_rows > 0): ?>
                    <?php while ($palavra = $resultado_revisar->fetch_assoc()): ?>
                        <div class="tarefa-item">
                            <div>
                                <strong><?= htmlspecialchars($palavra['termo']) ?></strong> 
                                <span style="color: #7c3aed; font-weight: bold;">(<?= htmlspecialchars($palavra['traducao']) ?>)</span>
                                <p style="font-size: 0.85rem; color: #666; margin-top: 4px;">
                                    Idioma: <?= htmlspecialchars($palavra['idioma']) ?> | 
                                    Exemplo: "<?= htmlspecialchars($palavra['exemplo']) ?>"
                                </p>
                            </div>
                            <div style="display: flex; gap: 10px;">
                                <a href="acoes.php?acao=aprender&id=<?= $palavra['id'] ?>" class="botao-roxo" style="padding: 6px 12px; font-size: 0.85rem;">✓ Já sei</a>
                                <a href="detalhes_palavra.php?id=<?= $palavra['id'] ?>" class="botao-branco" style="padding: 6px 12px; font-size: 0.85rem;">Detalhes</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p style="color: #666;">Parabéns! Nenhuma palavra pendente para revisão.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
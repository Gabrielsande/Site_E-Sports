<?php
// index.php — FragZone
session_start();
require_once 'conexao.php';
require_once 'funcoes.php';

$stmt = $pdo->query("
    SELECT n.*, u.nome AS autor_nome
    FROM noticias n
    JOIN usuarios u ON n.autor = u.id
    ORDER BY n.data DESC
");
$noticias = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FragZone — Portal de Games e E-Sports</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="hero">
    <div class="hero-badge">// NOTÍCIAS DO DIA //</div>
    <h1 class="hero-title">🎮 Frag<span>Zone</span></h1>
    <p class="hero-sub">games &amp; e-sports // br</p>
    <p class="hero-deco">━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━</p>
</div>

<div class="container">
    <div class="section-title">Últimas Notícias</div>

    <?php if (empty($noticias)): ?>
        <div class="empty-state">
            <span class="icon">📭</span>
            <p>Nenhuma notícia publicada ainda.<br>Seja o primeiro a publicar!</p>
            <?php if (!usuario_logado()): ?>
                <a href="cadastro.php" class="btn btn-primary mt-3">Criar Conta</a>
            <?php else: ?>
                <a href="nova_noticia.php" class="btn btn-primary mt-3">Nova Notícia</a>
            <?php endif; ?>
        </div>
    <?php else: ?>
    <div class="news-grid">
        <?php foreach ($noticias as $n): ?>
        <div class="card">
            <div class="card-img">
                <?php if ($n['imagem']): ?>
                    <img src="imagens/<?= sanitizar($n['imagem']) ?>" alt="<?= sanitizar($n['titulo']) ?>">
                <?php else: ?>
                    <span class="placeholder">🕹️</span>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <span class="card-tag">E-Sports</span>
                <h2><?= sanitizar($n['titulo']) ?></h2>
                <p><?= sanitizar(resumo($n['noticia'])) ?></p>
                <div class="card-meta">
                    <span>✍ <?= sanitizar($n['autor_nome']) ?></span>
                    <span>📅 <?= formatar_data($n['data']) ?></span>
                </div>
                <a href="noticia.php?id=<?= $n['id'] ?>" class="btn btn-primary btn-sm">▶ LER MAIS</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
</body>
</html>

<?php
// noticia.php — FragZone
session_start();
require_once __DIR__ . '/../include/conexao.php';
require_once __DIR__ . '/../include/funcoes.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("
    SELECT n.*, u.nome AS autor_nome
    FROM noticias n JOIN usuarios u ON n.autor = u.id
    WHERE n.id = ?
");
$stmt->execute([$id]);
$n = $stmt->fetch();
if (!$n) redirecionar('../public/index.php');

$page_title = $n['titulo'];
include '../include/header.php';
?>

<div class="container" style="padding-top:2.5rem; padding-bottom:4rem">
    <div class="article-wrap">

        <div class="article-tag">
            <span class="card-tag">E-Sports</span>
        </div>

        <h1 class="article-title"><?= sanitizar($n['titulo']) ?></h1>

        <div class="article-meta">
            <span>✍ <span class="meta-author"><?= sanitizar($n['autor_nome']) ?></span></span>
            <span>📅 <?= formatar_data($n['data']) ?></span>
            <?php if (usuario_logado() && $_SESSION['usuario_id'] == $n['autor']): ?>
                <span style="margin-left:auto; display:flex; gap:.5rem; flex-wrap:wrap">
                    <a href="editar_noticia.php?id=<?= $n['id'] ?>" class="btn btn-ghost btn-sm">✏️ Editar</a>
                    <a href="excluir_noticia.php?id=<?= $n['id'] ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('Excluir esta notícia permanentemente?')">🗑️ Excluir</a>
                </span>
            <?php endif; ?>
        </div>

        <?php if ($n['imagem']): ?>
            <img src="imagens/<?= sanitizar($n['imagem']) ?>" alt="<?= sanitizar($n['titulo']) ?>" class="article-img">
        <?php endif; ?>

        <div class="article-body">
            <?php foreach (explode("\n", sanitizar($n['noticia'])) as $p): ?>
                <?php if (trim($p) !== ''): ?>
                    <p><?= nl2br($p) ?></p>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <div class="article-actions">
            <a href="../public/index.php" class="btn btn-ghost">← Voltar ao Portal</a>
        </div>

    </div>
</div>

<?php include '../include/footer.php'; ?>

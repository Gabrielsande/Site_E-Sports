<?php
// noticia.php — FragZone
session_start();
require_once '../includes/conexao.php';
require_once '../includes/funcoes.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT n.*, u.nome AS autor_nome FROM noticias n JOIN usuarios u ON n.autor = u.id WHERE n.id = ?");
$stmt->execute([$id]);
$n = $stmt->fetch();
if (!$n) redirecionar('../public/index.php');
?>
<!DOCTYPE html>
<html lang="pt-br" data-theme="dark">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= sanitizar($n['titulo']) ?> — FragZone</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include '../public/header.php'; ?>
<div class="container">
    <div class="noticia-full">
        <span class="card-tag" style="margin-bottom:0.8rem">E-Sports</span>
        <h1 class="noticia-titulo"><?= sanitizar($n['titulo']) ?></h1>
        <div class="noticia-meta">
            <span>✍ <?= sanitizar($n['autor_nome']) ?></span>
            <span>📅 <?= formatar_data($n['data']) ?></span>
        </div>
        <?php if ($n['imagem']): ?>
            <img src="imagens/<?= sanitizar($n['imagem']) ?>" alt="<?= sanitizar($n['titulo']) ?>" class="noticia-img">
        <?php endif; ?>
        <div class="noticia-conteudo">
            <?= nl2br(sanitizar($n['noticia'])) ?>
        </div>
        <div class="noticia-actions">
            <a href="../public/index.php" class="btn btn-ghost">← Voltar</a>
            <?php if (usuario_logado() && $_SESSION['usuario_id'] == $n['autor']): ?>
                <a href="../admin/editar_noticia.php?id=<?= $n['id'] ?>" class="btn btn-orange">✏️ Editar</a>
                <a href="../admin/excluir_noticia.php?id=<?= $n['id'] ?>" class="btn btn-danger"
                   onclick="return confirm('Excluir esta notícia?')">🗑️ Excluir</a>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php include '../public/footer.php'; ?>
</body></html>

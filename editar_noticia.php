<?php
// editar_noticia.php — FragZone
require_once 'verifica_login.php';
require_once 'conexao.php';
require_once 'funcoes.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM noticias WHERE id = ? AND autor = ?");
$stmt->execute([$id, $_SESSION['usuario_id']]);
$n = $stmt->fetch();
if (!$n) redirecionar('dashboard.php');

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo   = sanitizar($_POST['titulo'] ?? '');
    $conteudo = trim($_POST['noticia'] ?? '');
    $imagem   = $n['imagem'];

    if (!$titulo || !$conteudo) {
        $erro = 'Título e conteúdo são obrigatórios.';
    } else {
        if (!empty($_FILES['imagem']['name'])) {
            $ext = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                $erro = 'Formato inválido.';
            } elseif ($_FILES['imagem']['size'] > 5*1024*1024) {
                $erro = 'Imagem muito grande.';
            } else {
                $nome = uniqid('img_') . '.' . $ext;
                if (!is_dir('imagens')) mkdir('imagens', 0755, true);
                move_uploaded_file($_FILES['imagem']['tmp_name'], 'imagens/' . $nome);
                $imagem = $nome;
            }
        }
        if (!$erro) {
            $upd = $pdo->prepare("UPDATE noticias SET titulo=?, noticia=?, imagem=? WHERE id=? AND autor=?");
            $upd->execute([$titulo, $conteudo, $imagem, $id, $_SESSION['usuario_id']]);
            redirecionar('dashboard.php');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br" data-theme="dark">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Notícia — FragZone</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="container">
    <div class="form-wrap wide">
        <h2>✏️ Editar Notícia</h2>
        <?php if ($erro): ?><div class="alert alert-error">⚠ <?= $erro ?></div><?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Título *</label>
                <input type="text" name="titulo" required value="<?= sanitizar($n['titulo']) ?>">
            </div>
            <div class="form-group">
                <label>Conteúdo *</label>
                <textarea name="noticia" required style="min-height:250px"><?= sanitizar($n['noticia']) ?></textarea>
            </div>
            <?php if ($n['imagem']): ?>
            <div class="form-group">
                <label>Imagem atual</label>
                <img src="imagens/<?= sanitizar($n['imagem']) ?>" style="max-height:140px;border:2px solid var(--border);display:block;margin-bottom:.5rem">
            </div>
            <?php endif; ?>
            <div class="form-group">
                <label>Nova imagem (opcional)</label>
                <input type="file" name="imagem" accept="image/*">
            </div>
            <div class="flex gap-2 flex-wrap">
                <button type="submit" class="btn btn-primary">💾 SALVAR</button>
                <a href="dashboard.php" class="btn btn-ghost">Cancelar</a>
            </div>
        </form>
    </div>
</div>
<?php include 'footer.php'; ?>
</body></html>

<?php
// nova_noticia.php — FragZone
require_once 'verifica_login.php';
require_once 'conexao.php';
require_once 'funcoes.php';

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo   = sanitizar($_POST['titulo'] ?? '');
    $conteudo = trim($_POST['noticia'] ?? '');
    $imagem   = null;

    if (!$titulo || !$conteudo) {
        $erro = 'Título e conteúdo são obrigatórios.';
    } else {
        if (!empty($_FILES['imagem']['name'])) {
            $ext = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                $erro = 'Formato de imagem inválido.';
            } elseif ($_FILES['imagem']['size'] > 5*1024*1024) {
                $erro = 'Imagem muito grande (máx 5MB).';
            } else {
                $nome = uniqid('img_') . '.' . $ext;
                if (!is_dir('imagens')) mkdir('imagens', 0755, true);
                move_uploaded_file($_FILES['imagem']['tmp_name'], 'imagens/' . $nome);
                $imagem = $nome;
            }
        }
        if (!$erro) {
            $stmt = $pdo->prepare("INSERT INTO noticias (titulo, noticia, autor, imagem) VALUES (?,?,?,?)");
            $stmt->execute([$titulo, $conteudo, $_SESSION['usuario_id'], $imagem]);
            redirecionar('dashboard.php');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br" data-theme="dark">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Notícia — FragZone</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="container">
    <div class="form-wrap wide">
        <h2>📝 Nova Notícia</h2>
        <?php if ($erro): ?><div class="alert alert-error">⚠ <?= $erro ?></div><?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Título *</label>
                <input type="text" name="titulo" placeholder="Título da notícia" required value="<?= isset($_POST['titulo']) ? sanitizar($_POST['titulo']) : '' ?>">
            </div>
            <div class="form-group">
                <label>Conteúdo *</label>
                <textarea name="noticia" placeholder="Escreva o conteúdo completo da notícia..." required style="min-height:250px"><?= isset($_POST['noticia']) ? sanitizar($_POST['noticia']) : '' ?></textarea>
            </div>
            <div class="form-group">
                <label>Imagem (opcional)</label>
                <input type="file" name="imagem" accept="image/*">
            </div>
            <div class="flex gap-2 flex-wrap">
                <button type="submit" class="btn btn-primary">▶ PUBLICAR</button>
                <a href="dashboard.php" class="btn btn-ghost">Cancelar</a>
            </div>
        </form>
    </div>
</div>
<?php include 'footer.php'; ?>
</body></html>

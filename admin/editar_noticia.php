<?php
// editar_noticia.php — FragZone
require_once __DIR__ . '/../include/verifica_login.php';
require_once __DIR__ . '/../include/conexao.php';
require_once  __DIR__. '/../include/funcoes.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM noticias WHERE id = ? AND autor = ?");
$stmt->execute([$id, $_SESSION['usuario_id']]);
$n = $stmt->fetch();
if (!$n) redirecionar('dashboard.php');

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo   = sanitizar($_POST['titulo']  ?? '');
    $conteudo = trim($_POST['noticia']       ?? '');
    $imagem   = $n['imagem'];

    if (!$titulo || !$conteudo) {
        $erro = 'Título e conteúdo são obrigatórios.';
    } else {
        if (!empty($_FILES['imagem']['name'])) {
            $ext = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                $erro = 'Formato inválido.';
            } elseif ($_FILES['imagem']['size'] > 5 * 1024 * 1024) {
                $erro = 'Imagem muito grande (máx 5 MB).';
            } else {
                if (!is_dir('imagens')) mkdir('imagens', 0755, true);
                $nome_arq = uniqid('img_') . '.' . $ext;
                move_uploaded_file($_FILES['imagem']['tmp_name'], 'imagens/' . $nome_arq);
                $imagem = $nome_arq;
            }
        }
        if (!$erro) {
            $upd = $pdo->prepare("UPDATE noticias SET titulo=?, noticia=?, imagem=? WHERE id=? AND autor=?");
            $upd->execute([$titulo, $conteudo, $imagem, $id, $_SESSION['usuario_id']]);
            redirecionar('dashboard.php');
        }
    }
}

$page_title = 'Editar Notícia';
include 'header.php';
?>

<div class="form-page" style="padding-top:2rem">
    <div class="form-card wide">
        <div class="form-card-header">
            <h2>Editar Notícia</h2>
            <p>Altere os campos e salve as mudanças</p>
        </div>

        <?php if ($erro): ?>
            <div class="alert alert-error">⚠ <?= $erro ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label class="form-label">Título *</label>
                <input class="form-control" type="text" name="titulo" required
                       value="<?= sanitizar($n['titulo']) ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Conteúdo *</label>
                <textarea class="form-control" name="noticia" required
                          style="min-height:260px"><?= sanitizar($n['noticia']) ?></textarea>
            </div>

            <?php if ($n['imagem']): ?>
            <div class="form-group">
                <label class="form-label">Imagem atual</label>
                <img src="imagens/<?= sanitizar($n['imagem']) ?>"
                     style="max-height:160px; border-radius:var(--radius); border:1px solid var(--border); display:block; margin-bottom:.5rem">
            </div>
            <?php endif; ?>

            <div class="form-group">
                <label class="form-label">Nova imagem (deixe vazio para manter a atual)</label>
                <input class="form-control" type="file" name="imagem" accept="image/*">
                <p class="form-hint">JPG, PNG, GIF ou WEBP · Máximo 5 MB</p>
            </div>

            <div class="flex gap-2 flex-wrap mt-2">
                <button type="submit" class="btn btn-primary">Salvar alterações</button>
                <a href="dashboard.php" class="btn btn-ghost">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>

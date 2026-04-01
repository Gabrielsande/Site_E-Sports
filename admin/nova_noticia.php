<?php
session_start();
require_once __DIR__ . '/../include/conexao.php';
require_once __DIR__ . '/../include/funcoes.php';
require_once __DIR__ . '/../include/verifica_login.php';

// Variável de feedback
$mensagem = "";

// Verifica se enviou o formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titulo = trim($_POST['titulo']);
    $noticia = trim($_POST['noticia']);
    $categoria = $_POST['categoria'] ?? '';
    $autor = $_SESSION['usuario_id'];

    $imagemNome = null;

    // Upload de imagem
    if (!empty($_FILES['imagem']['name'])) {

        $pasta = __DIR__ . '/../assets/img/';
        $nomeArquivo = time() . "_" . basename($_FILES['imagem']['name']);
        $caminho = $pasta . $nomeArquivo;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho)) {
            $imagemNome = $nomeArquivo;
        } else {
            $mensagem = "Erro ao enviar imagem!";
        }
    }

    // Validação básica
    if ($titulo && $noticia && $categoria) {

        $stmt = $pdo->prepare("
            INSERT INTO noticias (titulo, noticia, autor, data, imagem, categoria)
            VALUES (?, ?, ?, NOW(), ?, ?)
        ");

        if ($stmt->execute([$titulo, $noticia, $autor, $imagemNome, $categoria])) {
            $mensagem = "Notícia publicada com sucesso!";
        } else {
            $mensagem = "Erro ao salvar notícia.";
        }

    } else {
        $mensagem = "Preencha todos os campos obrigatórios!";
    }
}
?>

<?php include __DIR__ . '/../include/header.php'; ?>

<div class="container container-pad">

    <h2>📰 Nova Notícia</h2>

    <?php if ($mensagem): ?>
        <div class="alert">
            <?= sanitizar($mensagem) ?>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="form">

        <label>Título:</label>
        <input type="text" name="titulo" required>

        <label>Conteúdo:</label>
        <textarea name="noticia" rows="6" required></textarea>

        <label>Imagem:</label>
        <input type="file" name="imagem">

        <!-- ✅ CATEGORIA -->
        <label>Categoria:</label>
        <select name="categoria" required>
            <option value="">Selecione uma categoria</option>
            <option value="e-sports">E-Sports</option>
            <option value="games">Games</option>
            <option value="campeonatos">Campeonatos</option>
            <option value="lancamentos">Lançamentos</option>
            <option value="analises">Análises</option>
        </select>

        <button type="submit" class="btn btn-primary">Publicar Notícia</button>

    </form>

</div>

<?php include __DIR__ . '/../include/footer.php'; ?>
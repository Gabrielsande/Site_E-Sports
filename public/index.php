<?php
// index.php — FragZone
session_start();
require_once __DIR__ . '/../include/conexao.php';
require_once __DIR__ . '/../include/funcoes.php';

// Busca
$busca = trim($_GET['q'] ?? '');
$cat   = trim($_GET['cat'] ?? '');

if ($busca !== '') {
    $stmt = $pdo->prepare("
        SELECT n.*, u.nome AS autor_nome
        FROM noticias n
        JOIN usuarios u ON n.autor = u.id
        WHERE n.titulo LIKE ? OR n.noticia LIKE ?
        ORDER BY n.data DESC
    ");
    $like = '%' . $busca . '%';
    $stmt->execute([$like, $like]);
} else {
    $stmt = $pdo->query("
        SELECT n.*, u.nome AS autor_nome
        FROM noticias n
        JOIN usuarios u ON n.autor = u.id
        ORDER BY n.data DESC
    ");
}
$noticias = $stmt->fetchAll();

$page_title = $busca ? 'Busca: ' . $busca : 'Início';
include '../include/header.php';
?>

<!-- Hero band (esconde na busca) -->
<?php if (!$busca && !$cat): ?>
<section class="hero-band">
    <div class="container">
        <div class="hero-eyebrow">Portal Oficial · Games &amp; E-Sports</div>
        <h1 class="hero-title">FRAG<em>ZONE</em></h1>
        <p class="hero-sub">As melhores notícias do universo gamer em um só lugar</p>
    </div>
</section>
<?php endif; ?>

<div class="container container-pad">

    <!-- Título da seção / resultado de busca -->
    <div class="section-head">
        <div class="section-head-left">
            <div class="section-head-bar"></div>
            <h2>
                <?php if ($busca): ?>
                    Resultados para "<?= sanitizar($busca) ?>"
                <?php elseif ($cat): ?>
                    <?= sanitizar(ucfirst($cat)) ?>
                <?php else: ?>
                    Últimas Notícias
                <?php endif; ?>
            </h2>
        </div>
        <?php if (usuario_logado()): ?>
            <a href="../admin/nova_noticia.php">+ Publicar</a>
        <?php endif; ?>
    </div>

    <!-- Resultado vazio -->
    <?php if (empty($noticias)): ?>
        <div class="empty-state">
            <span class="ei"><?= $busca ? '🔍' : '📭' ?></span>
            <h3><?= $busca ? 'Nenhum resultado encontrado' : 'Nenhuma notícia ainda' ?></h3>
            <p><?= $busca ? 'Tente outros termos de busca.' : 'Seja o primeiro a publicar uma notícia!' ?></p>
            <?php if ($busca): ?>
                <a href="../public/index.php" class="btn btn-ghost mt-2">← Voltar ao início</a>
            <?php elseif (usuario_logado()): ?>
                <a href="../admin/nova_noticia.php" class="btn btn-primary mt-2">+ Nova Notícia</a>
            <?php else: ?>
                <a href="..public/cadastro.php" class="btn btn-primary mt-2">Criar Conta</a>
            <?php endif; ?>
        </div>

    <!-- Grid de notícias -->
    <?php else: ?>
        <div class="news-grid">
            <?php foreach ($noticias as $i => $n): ?>
            <article class="card<?= $i === 0 && !$busca ? ' card-featured' : '' ?>">
                <div class="card-img">
                    <?php if ($n['imagem']): ?>
                        <img src="imagens/<?= sanitizar($n['imagem']) ?>"
                             alt="<?= sanitizar($n['titulo']) ?>"
                             loading="<?= $i < 3 ? 'eager' : 'lazy' ?>">
                    <?php else: ?>
                        <div class="card-img-placeholder">🎮</div>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <span class="card-tag">E-Sports</span>
                    <h2><a href="../public/noticia.php?id=<?= $n['id'] ?>"><?= sanitizar($n['titulo']) ?></a></h2>
                    <p class="card-excerpt"><?= sanitizar(resumo($n['noticia'], $i === 0 && !$busca ? 260 : 180)) ?></p>
                    <div class="card-meta">
                        <span class="card-meta-author">✍ <?= sanitizar($n['autor_nome']) ?></span>
                        <span><?= formatar_data_curta($n['data']) ?></span>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<?php include '../include/footer.php'; ?>

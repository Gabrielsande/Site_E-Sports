<?php
// header.php — FragZone · Estilo ESPN/GE.com
// Requer: session_start() + require_once 'funcoes.php' antes de incluir
?>
<!DOCTYPE html>
<html lang="pt-br" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? sanitizar($page_title) . ' — ' : '' ?>FragZone</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script>
        // Aplica tema salvo ANTES de renderizar (evita flash)
        (function(){
            var t = localStorage.getItem('fz-theme') || 'light';
            document.documentElement.setAttribute('data-theme', t);
        })();
    </script>
</head>
<body>

<?php
// Define aba ativa da navbar
$atual = basename($_SERVER['PHP_SELF'], '.php');
function nav_active(string $page): string {
    global $atual;
    return $atual === $page ? ' active' : '';
}
?>

<header>

    <!-- ── Camada 1: Topbar vermelha ── -->
    <div class="topbar">
        <span>🎮 Portal de Games &amp; E-Sports do Brasil</span>
        <div class="topbar-right">
            <span><?= date('d/m/Y') ?></span>
            <?php if (usuario_logado()): ?>
                <span>Olá, <strong><?= sanitizar($_SESSION['usuario_nome']) ?></strong></span>
            <?php endif; ?>
        </div>
    </div>

    <!-- ── Camada 2: Logo + Search + Actions ── -->
    <div class="header-brand">
        <div class="header-brand-inner">

            <a href="index.php" class="logo">
                <span class="logo-name">FRAG<em>ZONE</em></span>
                <span class="logo-sub">Games &amp; E-Sports News</span>
            </a>

            <!-- Barra de pesquisa -->
            <form class="search-form" action="index.php" method="GET" role="search">
                <input
                    class="search-input"
                    type="search"
                    name="q"
                    placeholder="Buscar notícias, jogos, campeonatos..."
                    value="<?= isset($_GET['q']) ? sanitizar($_GET['q']) : '' ?>"
                    autocomplete="off"
                    aria-label="Buscar"
                >
                <button class="search-btn" type="submit" aria-label="Pesquisar">🔍</button>
            </form>

            <!-- Ações da direita -->
            <div class="header-actions">
                <button class="btn-theme" id="theme-btn" onclick="toggleTheme()" title="Alternar tema">🌙</button>
                <?php if (!usuario_logado()): ?>
                    <a href="../public/cadastro.php" class="btn btn-primary btn-sm">Cadastrar</a>
                <?php endif; ?>
            </div>

        </div>
    </div>

    <!-- ── Camada 3: Navbar preta ── -->
    <nav class="navbar" aria-label="Navegação principal">
        <div class="navbar-inner">

            <!-- Links de categorias -->
            <ul class="navbar-links">
                <li>
                    <a href="../public/index.php" class="<?= nav_active('index') ?>">
                        Início
                    </a>
                </li>
                <li>
                    <a href="../public/index.php?cat=esports" class="<?= nav_active('esports') ?>">
                        E-Sports
                        <span class="live-badge">Ao vivo</span>
                    </a>
                </li>
                <li>
                    <a href="../public/index.php?cat=games" class="<?= nav_active('games') ?>">
                        Games
                    </a>
                </li>
                <li>
                    <a href="../public/index.php?cat=campeonatos" class="<?= nav_active('campeonatos') ?>">
                        Campeonatos
                    </a>
                </li>
                <li>
                    <a href="../public/index.php?cat=lancamentos" class="<?= nav_active('lancamentos') ?>">
                        Lançamentos
                    </a>
                </li>
                <li>
                    <a href="../public/index.php?cat=analises" class="<?= nav_active('analises') ?>">
                        Análises
                    </a>
                </li>
            </ul>

            <!-- Auth à direita -->
            <div class="navbar-auth">
                <?php if (usuario_logado()): ?>
                    <a href="../admin/dashboard.php">Painel</a>
                    <a href="../admin/nova_noticia.php" style="color:var(--red); font-weight:900">+ Notícia</a>
                    <a href="../admin/logout.php">Sair</a>
                <?php else: ?>
                    <a href="../public/login.php">Login</a>
                <?php endif; ?>
            </div>

        </div>
    </nav>

    <!-- ── Ticker de notícias ── -->
    <div class="ticker">
        <span class="ticker-label">Destaques</span>
        <div class="ticker-track">
            <span class="ticker-scroll">
                CBLOL 2026: LOUD encerra fase de grupos invicta com 9 vitórias
                <span class="ticker-sep">|</span>
                CS2 Major de Paris: premiação recorde de US$ 2 milhões confirmada
                <span class="ticker-sep">|</span>
                Free Fire World Series: Brasil é tricampeão mundial em Bangkok
                <span class="ticker-sep">|</span>
                GTA VI chega em setembro de 2026 para PS5 e Xbox Series
                <span class="ticker-sep">|</span>
                Valorant Champions Tour: Brasil garante 3 vagas internacionais
                <span class="ticker-sep">|</span>
                Nintendo anuncia novo Direct com novidades para o Switch 2
                <span class="ticker-sep">|</span>
                League of Legends: nova temporada traz mudanças radicais no mapa
            </span>
        </div>
    </div>

</header>

<script>
function toggleTheme() {
    var html = document.documentElement;
    var cur  = html.getAttribute('data-theme');
    var next = cur === 'light' ? 'dark' : 'light';
    html.setAttribute('data-theme', next);
    localStorage.setItem('fz-theme', next);
    document.getElementById('theme-btn').textContent = next === 'light' ? '🌙' : '☀️';
}
// Ícone correto ao carregar
(function(){
    var t   = localStorage.getItem('fz-theme') || 'light';
    var btn = document.getElementById('theme-btn');
    if (btn) btn.textContent = t === 'light' ? '🌙' : '☀️';
})();
</script>

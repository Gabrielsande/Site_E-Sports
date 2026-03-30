<?php
// header.php — FragZone
// Requer: session_start() e require_once 'funcoes.php' antes de incluir
?>
<header>
    <div class="header-inner">
        <a href="index.php" class="logo">
            <span class="logo-icon">🎮</span>
            <span class="logo-info">
                <span class="logo-name">Frag<span>Zone</span></span>
                <span class="logo-tagline">// games &amp; e-sports news</span>
            </span>
        </a>

        <nav class="header-nav">
            <a href="index.php" class="nav-link">Início</a>

            <?php if (usuario_logado()): ?>
                <a href="dashboard.php" class="nav-link">Painel</a>
                <a href="nova_noticia.php" class="btn btn-primary btn-sm">+ Notícia</a>
                <a href="logout.php" class="nav-link">Sair [<?= sanitizar($_SESSION['usuario_nome']) ?>]</a>
            <?php else: ?>
                <a href="login.php" class="nav-link">Login</a>
                <a href="cadastro.php" class="btn btn-primary btn-sm">Cadastrar</a>
            <?php endif; ?>

            <button class="btn-theme" onclick="toggleTheme()" title="Alternar tema" id="theme-btn">☀️</button>
        </nav>
    </div>

    <div class="header-ticker">
        <span class="ticker-label">► LIVE</span>
        <span class="ticker-scroll">
            💥 CBLOL 2026: LOUD vence e avança para semifinal &nbsp;|&nbsp;
            🔥 CS2: Major de Paris confirmado para julho &nbsp;|&nbsp;
            🕹️ GTA VI: Rockstar anuncia data de lançamento &nbsp;|&nbsp;
            🏆 Free Fire World Series 2026 com novo recorde de audiência &nbsp;|&nbsp;
            🎮 Nintendo anuncia novo Direct com surpresas para Switch 2 &nbsp;|&nbsp;
            ⚡ Valorant Champions Tour: Brasil garante 3 vagas &nbsp;|&nbsp;
            🚀 FragZone: O seu portal de games &amp; e-sports
        </span>
    </div>
</header>

<script>
// Tema
(function() {
    const saved = localStorage.getItem('fragzone-theme') || 'dark';
    document.documentElement.setAttribute('data-theme', saved);
    document.getElementById('theme-btn').textContent = saved === 'dark' ? '☀️' : '🌙';
})();

function toggleTheme() {
    const html = document.documentElement;
    const current = html.getAttribute('data-theme');
    const next = current === 'dark' ? 'light' : 'dark';
    html.setAttribute('data-theme', next);
    localStorage.setItem('fragzone-theme', next);
    document.getElementById('theme-btn').textContent = next === 'dark' ? '☀️' : '🌙';
}
</script>

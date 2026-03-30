<?php
// footer.php — FragZone
?>
<footer>
    <div class="footer-grid">
        <div class="footer-brand">
            <a href="../public/index.php" class="logo" style="justify-content:flex-start; margin-bottom:0.5rem;">
                <span style="font-size:1.5rem; filter:drop-shadow(0 0 6px var(--accent))">🎮</span>
                <span class="logo-name">Frag<span>Zone</span></span>
            </a>
            <p>O portal número 1 de notícias sobre games e e-sports do Brasil. Cobertura completa de torneios, lançamentos e tudo que rola no universo gamer.</p>
            <span class="footer-powered">POWERED BY PHP + MYSQL</span>
        </div>

        <div class="footer-col">
            <h4>▶ Navegação</h4>
            <ul>
                <li><a href="../public/index.php">🏠 Início</a></li>
                <?php if (usuario_logado()): ?>
                    <li><a href="../admin/dashboard.php">📊 Painel</a></li>
                    <li><a href="../admin/nova_noticia.php">📝 Nova Notícia</a></li>
                    <li><a href="../admin/editar_usuario.php">👤 Minha Conta</a></li>
                    <li><a href="../public/logout.php">🚪 Sair</a></li>
                <?php else: ?>
                    <li><a href="../public/login.php">🔑 Login</a></li>
                    <li><a href="../public/cadastro.php">📋 Cadastro</a></li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="footer-col">
            <h4>▶ Categorias</h4>
            <ul>
                <li><a href="#">🏆 E-Sports</a></li>
                <li><a href="#">🎯 FPS</a></li>
                <li><a href="#">⚔️ MOBA</a></li>
                <li><a href="#">📱 Mobile Gaming</a></li>
                <li><a href="#">🕹️ Retrô</a></li>
                <li><a href="#">🚀 Lançamentos</a></li>
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
        <p class="footer-copy">
            © <?= date('Y') ?> <span>FragZone</span> — TODOS OS DIREITOS RESERVADOS
        </p>
        <pre class="footer-ascii">
 _____                 ______
|  ___|               |___  /
| |_ _ __ __ _  __ _     / /  ___  _ __   ___
|  _| '__/ _` |/ _` |   / /  / _ \| '_ \ / _ \
| | | | | (_| | (_| | ./ /__| (_) | | | |  __/
\_| |_|  \__,_|\__, | \_____/\___/|_| |_|\___|
                __/ |
               |___/</pre>
    </div>
</footer>

<?php // footer.php — FragZone ?>

<footer>
    <div class="footer-inner">

        <div class="footer-brand">
            <a href="../public/index.php" class="logo" style="text-decoration:none">
                <span class="logo-name">FRAG<em>ZONE</em></span>
            </a>
            <p>O portal de referência em notícias de Games e E-Sports do Brasil. Cobertura completa de campeonatos, lançamentos e tudo que acontece no universo gamer.</p>
            <span class="footer-badge">🎮 PHP · MySQL · NoticiasGE</span>
        </div>

        <div class="footer-col">
            <h4>Navegação</h4>
            <ul>
                <li><a href="../public/index.php">Início</a></li>
                <li><a href="../public/index.php?cat=esports">E-Sports</a></li>
                <li><a href="../public/index.php?cat=games">Games</a></li>
                <li><a href="../public/index.php?cat=campeonatos">Campeonatos</a></li>
                <li><a href="../public/index.php?cat=lancamentos">Lançamentos</a></li>
                <li><a href="../public/index.php?cat=analises">Análises</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Portal</h4>
            <ul>
                <?php if (usuario_logado()): ?>
                    <li><a href="../admin/dashboard.php">Painel do Jornalista</a></li>
                    <li><a href="../admin/nova_noticia.php">Publicar Notícia</a></li>
                    <li><a href="../admin/dashboard.php?aba=perfil">Minha Conta</a></li>
                    <li><a href="../admin/logout.php">Sair</a></li>
                <?php else: ?>
                    <li><a href="../public/login.php">Login</a></li>
                    <li><a href="../public/cadastro.php">Criar Conta</a></li>
                <?php endif; ?>
            </ul>
        </div>

    </div>

    <div class="footer-bottom">
        <p class="footer-copy">&copy; <?= date('Y') ?> <strong>FragZone</strong> — Todos os direitos reservados.</p>
        <span class="footer-tech">Banco: NoticiasGE · PHP 8 · MySQL 8</span>
    </div>
</footer>

</body>
</html>

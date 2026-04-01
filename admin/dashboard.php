<?php
// dashboard.php — FragZone
require_once __DIR__ . '/../include/verifica_login.php';
require_once __DIR__ . '/../include/conexao.php';
require_once __DIR__ . '/../include/funcoes.php';

// Dados do usuário
$stmtU = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmtU->execute([$_SESSION['usuario_id']]);
$usuario = $stmtU->fetch();

// Total de notícias
$stmtT = $pdo->prepare("SELECT COUNT(*) AS total FROM noticias WHERE autor = ?");
$stmtT->execute([$_SESSION['usuario_id']]);
$total = (int)$stmtT->fetch()['total'];

// Última publicação
$stmtL = $pdo->prepare("SELECT data FROM noticias WHERE autor = ? ORDER BY data DESC LIMIT 1");
$stmtL->execute([$_SESSION['usuario_id']]);
$ultima = $stmtL->fetch();

// Notícias do usuário
$stmtN = $pdo->prepare("SELECT * FROM noticias WHERE autor = ? ORDER BY data DESC");
$stmtN->execute([$_SESSION['usuario_id']]);
$noticias = $stmtN->fetchAll();

// Aba ativa
$aba = in_array($_GET['aba'] ?? '', ['noticias','perfil']) ? $_GET['aba'] : 'noticias';

// ── Processar edição de perfil ──────────────────────────
$erro = ''; $sucesso = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'editar_perfil') {
    $nome  = sanitizar($_POST['nome']  ?? '');
    $email = sanitizar($_POST['email'] ?? '');
    $senha = $_POST['senha']           ?? '';
    $conf  = $_POST['conf_senha']      ?? '';

    if (!$nome || !$email) {
        $erro = 'Nome e e-mail são obrigatórios.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'E-mail inválido.';
    } elseif ($senha && strlen($senha) < 6) {
        $erro = 'Nova senha deve ter no mínimo 6 caracteres.';
    } elseif ($senha && $senha !== $conf) {
        $erro = 'As senhas não coincidem.';
    } else {
        $chk = $pdo->prepare("SELECT id FROM usuarios WHERE email = ? AND id != ?");
        $chk->execute([$email, $_SESSION['usuario_id']]);
        if ($chk->fetch()) {
            $erro = 'Este e-mail já pertence a outra conta.';
        } else {
            if ($senha) {
                $hash = password_hash($senha, PASSWORD_DEFAULT);
                $pdo->prepare("UPDATE usuarios SET nome=?, email=?, senha=? WHERE id=?")
                    ->execute([$nome, $email, $hash, $_SESSION['usuario_id']]);
            } else {
                $pdo->prepare("UPDATE usuarios SET nome=?, email=? WHERE id=?")
                    ->execute([$nome, $email, $_SESSION['usuario_id']]);
            }
            $_SESSION['usuario_nome'] = $nome;
            $sucesso = 'Dados atualizados com sucesso!';
            $stmtU->execute([$_SESSION['usuario_id']]);
            $usuario = $stmtU->fetch();
        }
    }
    $aba = 'perfil';
}

// Inicial do nome para o avatar
$inicial = mb_strtoupper(mb_substr($usuario['nome'], 0, 1));

$page_title = 'Painel';
include '../include/header.php';
?>

<div class="dash-page">
<div class="container">

    <!-- Stats -->
    <div class="dash-stats">
        <div class="stat-card">
            <span class="stat-number"><?= $total ?></span>
            <span class="stat-label">Publicações</span>
        </div>
        <div class="stat-card">
            <span class="stat-number"><?= $ultima ? formatar_data_curta($ultima['data']) : '—' ?></span>
            <span class="stat-label">Última publicação</span>
        </div>
        <div class="stat-card">
            <span class="stat-number" style="font-size:1.6rem">🟢</span>
            <span class="stat-label">Status</span>
        </div>
    </div>

    <div class="dash-layout">

        <!-- ── Sidebar ── -->
        <aside class="dash-sidebar">
            <div class="dash-profile-box">
                <div class="dash-avatar"><?= $inicial ?></div>
                <div class="dash-profile-name"><?= sanitizar($usuario['nome']) ?></div>
                <div class="dash-profile-role">Jornalista</div>
            </div>

            <nav class="dash-nav">
                <a href="../admin/dashboard.php?aba=noticias"
                   class="dash-nav-item <?= $aba === 'noticias' ? 'active' : '' ?>">
                    📰 Minhas Notícias
                </a>
                <a href="../admin/dashboard.php?aba=perfil"
                   class="dash-nav-item <?= $aba === 'perfil' ? 'active' : '' ?>">
                    👤 Editar Perfil
                </a>
                <div class="dash-nav-sep"></div>
                <a href="../admin/nova_noticia.php" class="dash-nav-item">✏️ Nova Notícia</a>
                <a href="../public/index.php"        class="dash-nav-item">🏠 Ver Portal</a>
                <div class="dash-nav-sep"></div>
                <a href="../admin/excluir_usuario.php" class="dash-nav-item danger"
                   onclick="return confirm('Excluir sua conta permanentemente?')">
                   🗑️ Excluir Conta
                </a>
                <a href="../admin/logout.php" class="dash-nav-item danger">🚪 Sair</a>
            </nav>
        </aside>

        <!-- ── Main ── -->
        <main>

            <?php if ($aba === 'noticias'): ?>
            <!-- Painel de notícias -->
            <div class="dash-main-card">
                <div class="dash-main-header">
                    <h2>Minhas Notícias</h2>
                    <a href="../admin/nova_noticia.php" class="btn btn-primary btn-sm">+ Nova Notícia</a>
                </div>
                <div class="dash-main-body">
                    <?php if (empty($noticias)): ?>
                        <div class="empty-state">
                            <span class="empty-icon">📭</span>
                            <h3>Nenhuma notícia publicada</h3>
                            <p>Clique em "Nova Notícia" para começar a publicar.</p>
                            <a href="../admin/nova_noticia.php" class="btn btn-primary">Publicar primeira notícia</a>
                        </div>
                    <?php else: ?>
                        <div class="table-wrap">
                            <table>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Título</th>
                                        <th>Data</th>
                                        <th>Imagem</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($noticias as $n): ?>
                                    <tr>
                                        <td style="color:var(--text-3); font-size:.75rem"><?= $n['id'] ?></td>
                                        <td>
                                            <a href="../public/noticia.php?id=<?= $n['id'] ?>" style="color:var(--text); font-weight:500">
                                                <?= sanitizar(mb_strimwidth($n['titulo'], 0, 55, '…')) ?>
                                            </a>
                                        </td>
                                        <td style="white-space:nowrap; color:var(--text-3)">
                                            <?= formatar_data_curta($n['data']) ?>
                                        </td>
                                        <td><?= $n['imagem'] ? '<span style="color:#27ae60">✔ Sim</span>' : '<span style="color:var(--text-3)">—</span>' ?></td>
                                        <td>
                                            <div class="td-actions">
                                                <a href="../admin/editar_noticia.php?id=<?= $n['id'] ?>" class="btn btn-ghost btn-sm">Editar</a>
                                                <a href="../admin/excluir_noticia.php?id=<?= $n['id'] ?>"
                                                   class="btn btn-danger btn-sm"
                                                   onclick="return confirm('Excluir esta notícia?')">Excluir</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php elseif ($aba === 'perfil'): ?>
            <!-- Painel de perfil -->
            <div class="dash-main-card">
                <div class="dash-main-header">
                    <h2>Editar Perfil</h2>
                </div>
                <div class="dash-main-body">

                    <?php if ($erro): ?>
                        <div class="alert alert-error">⚠ <?= $erro ?></div>
                    <?php endif; ?>
                    <?php if ($sucesso): ?>
                        <div class="alert alert-success">✔ <?= $sucesso ?></div>
                    <?php endif; ?>

                    <form method="POST" action="dashboard.php?aba=perfil">
                        <input type="hidden" name="acao" value="editar_perfil">

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Nome completo</label>
                                <input class="form-control" type="text" name="nome" required
                                       value="<?= sanitizar($usuario['nome']) ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">E-mail</label>
                                <input class="form-control" type="email" name="email" required
                                       value="<?= sanitizar($usuario['email']) ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Nova senha</label>
                                <input class="form-control" type="password" name="senha"
                                       placeholder="Deixe vazio para não alterar">
                                <p class="form-hint">Mínimo 6 caracteres</p>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Confirmar nova senha</label>
                                <input class="form-control" type="password" name="conf_senha"
                                       placeholder="Repita a nova senha">
                            </div>
                        </div>

                        <div style="background:var(--bg-subtle); border:1px solid var(--border); border-radius:var(--radius); padding:.75rem 1rem; margin-bottom:1.25rem; font-size:.82rem; color:var(--text-3)">
                            📅 Conta criada em: <strong style="color:var(--text-2)"><?= formatar_data($usuario['criado_em']) ?></strong>
                        </div>

                        <div class="flex gap-2 flex-wrap">
                            <button type="submit" class="btn btn-primary">Salvar alterações</button>
                            <a href="../admin/dashboard.php?aba=noticias" class="btn btn-ghost">Cancelar</a>
                        </div>
                    </form>

                </div>
            </div>

            <?php endif; ?>

        </main>
    </div>

</div>
</div>

<?php include '../include/footer.php'; ?>

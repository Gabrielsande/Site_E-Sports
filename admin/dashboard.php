<?php
// dashboard.php — FragZone
require_once 'verifica_login.php';
require_once 'conexao.php';
require_once 'funcoes.php';

// Stats do usuário
$stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM noticias WHERE autor = ?");
$stmt->execute([$_SESSION['usuario_id']]);
$total = $stmt->fetch()['total'];

// Notícia mais recente
$stmt2 = $pdo->prepare("SELECT data FROM noticias WHERE autor = ? ORDER BY data DESC LIMIT 1");
$stmt2->execute([$_SESSION['usuario_id']]);
$ultima = $stmt2->fetch();

// Notícias do usuário
$stmt3 = $pdo->prepare("SELECT * FROM noticias WHERE autor = ? ORDER BY data DESC");
$stmt3->execute([$_SESSION['usuario_id']]);
$noticias = $stmt3->fetchAll();

// Dados do usuário para o form
$stmt4 = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt4->execute([$_SESSION['usuario_id']]);
$usuario = $stmt4->fetch();

// Aba ativa
$aba = $_GET['aba'] ?? 'noticias';

// Processar edição de dados
$erro = ''; $sucesso = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao'])) {

    if ($_POST['acao'] === 'editar_perfil') {
        $nome  = sanitizar($_POST['nome'] ?? '');
        $email = sanitizar($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';
        $conf  = $_POST['confirmar_senha'] ?? '';

        if (!$nome || !$email) {
            $erro = 'Nome e e-mail são obrigatórios.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erro = 'E-mail inválido.';
        } else {
            $check = $pdo->prepare("SELECT id FROM usuarios WHERE email = ? AND id != ?");
            $check->execute([$email, $_SESSION['usuario_id']]);
            if ($check->fetch()) {
                $erro = 'Este e-mail já está em uso.';
            } elseif ($senha && strlen($senha) < 6) {
                $erro = 'Senha deve ter no mínimo 6 caracteres.';
            } elseif ($senha && $senha !== $conf) {
                $erro = 'Senhas não coincidem.';
            } else {
                if ($senha) {
                    $hash = password_hash($senha, PASSWORD_DEFAULT);
                    $upd = $pdo->prepare("UPDATE usuarios SET nome=?, email=?, senha=? WHERE id=?");
                    $upd->execute([$nome, $email, $hash, $_SESSION['usuario_id']]);
                } else {
                    $upd = $pdo->prepare("UPDATE usuarios SET nome=?, email=? WHERE id=?");
                    $upd->execute([$nome, $email, $_SESSION['usuario_id']]);
                }
                $_SESSION['usuario_nome'] = $nome;
                $sucesso = 'Perfil atualizado com sucesso!';
                $stmt4->execute([$_SESSION['usuario_id']]);
                $usuario = $stmt4->fetch();
            }
        }
        $aba = 'perfil';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel — FragZone</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container">

    <!-- Stats -->
    <div class="dash-stats">
        <div class="stat-box">
            <span class="stat-number"><?= $total ?></span>
            <span class="stat-label">Notícias</span>
        </div>
        <div class="stat-box">
            <span class="stat-number"><?= $ultima ? date('d', strtotime($ultima['data'])) : '—' ?></span>
            <span class="stat-label">Último post</span>
        </div>
        <div class="stat-box">
            <span class="stat-number">🟢</span>
            <span class="stat-label">Online</span>
        </div>
    </div>

    <div class="dash-layout">

        <!-- Sidebar -->
        <aside class="dash-sidebar">
            <div class="dash-profile">
                <span class="dash-avatar">👾</span>
                <div class="dash-name"><?= sanitizar($_SESSION['usuario_nome']) ?></div>
                <div class="dash-role">// Jornalista</div>
            </div>
            <ul class="dash-menu">
                <li>
                    <a href="dashboard.php?aba=noticias" class="<?= $aba === 'noticias' ? 'active' : '' ?>">
                        📰 Minhas Notícias
                    </a>
                </li>
                <li>
                    <a href="dashboard.php?aba=perfil" class="<?= $aba === 'perfil' ? 'active' : '' ?>">
                        👤 Editar Perfil
                    </a>
                </li>
                <li>
                    <a href="nova_noticia.php">✏️ Nova Notícia</a>
                </li>
                <li>
                    <a href="index.php">🏠 Ver Portal</a>
                </li>
                <li>
                    <a href="logout.php" style="color: var(--accent3)">🚪 Sair</a>
                </li>
            </ul>
        </aside>

        <!-- Main -->
        <main>

            <?php if ($aba === 'noticias'): ?>
            <!-- ABA: Notícias -->
            <div class="dash-header-row">
                <div class="section-title" style="margin-bottom:0">Minhas Notícias</div>
                <a href="nova_noticia.php" class="btn btn-primary">+ Nova Notícia</a>
            </div>

            <?php if (empty($noticias)): ?>
                <div class="empty-state">
                    <span class="icon">📭</span>
                    <p>Você ainda não publicou nenhuma notícia.<br>Clique em "Nova Notícia" para começar!</p>
                </div>
            <?php else: ?>
            <div class="table-box">
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
                            <td style="color:var(--muted)"><?= $n['id'] ?></td>
                            <td>
                                <a href="noticia.php?id=<?= $n['id'] ?>" style="color:var(--text)">
                                    <?= sanitizar(mb_strimwidth($n['titulo'], 0, 50, '...')) ?>
                                </a>
                            </td>
                            <td style="font-family:'VT323',monospace; font-size:1rem;">
                                <?= formatar_data($n['data']) ?>
                            </td>
                            <td><?= $n['imagem'] ? '✅' : '—' ?></td>
                            <td>
                                <div class="td-actions">
                                    <a href="editar_noticia.php?id=<?= $n['id'] ?>" class="btn btn-ghost btn-sm">✏️</a>
                                    <a href="excluir_noticia.php?id=<?= $n['id'] ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Excluir esta notícia?')">🗑️</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>

            <?php elseif ($aba === 'perfil'): ?>
            <!-- ABA: Editar Perfil -->
            <div class="section-title">Editar Perfil</div>

            <div class="form-wrap wide" style="margin: 0;">
                <h2>👤 Dados do Jornalista</h2>

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
                            <label>Nome</label>
                            <input type="text" name="nome" required value="<?= sanitizar($usuario['nome']) ?>">
                        </div>
                        <div class="form-group">
                            <label>E-mail</label>
                            <input type="email" name="email" required value="<?= sanitizar($usuario['email']) ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Nova Senha</label>
                            <input type="password" name="senha" placeholder="Deixe vazio para não alterar">
                        </div>
                        <div class="form-group">
                            <label>Confirmar Senha</label>
                            <input type="password" name="confirmar_senha" placeholder="Repita a nova senha">
                        </div>
                    </div>

                    <div style="font-family:'VT323',monospace; font-size:1rem; color:var(--muted); margin-bottom:1.2rem;">
                        📅 Conta criada em: <?= formatar_data($usuario['criado_em']) ?>
                    </div>

                    <div class="flex gap-2 flex-wrap">
                        <button type="submit" class="btn btn-primary">💾 Salvar</button>
                        <a href="excluir_usuario.php"
                           class="btn btn-danger"
                           onclick="return confirm('Tem certeza? Esta ação é permanente e excluirá todas as suas notícias.')">
                           💣 Excluir Conta
                        </a>
                    </div>
                </form>
            </div>

            <?php endif; ?>

        </main>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>

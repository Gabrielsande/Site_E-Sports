<?php
// login.php — FragZone
session_start();
require_once '../includes/conexao.php';
require_once '../includes/funcoes.php';

if (usuario_logado()) redirecionar('../admin/dashboard.php');

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitizar($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    if (!$email || !$senha) {
        $erro = 'Preencha e-mail e senha.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $u = $stmt->fetch();
        if ($u && password_verify($senha, $u['senha'])) {
            $_SESSION['usuario_id']   = $u['id'];
            $_SESSION['usuario_nome'] = $u['nome'];
            redirecionar('../admin/dashboard.php');
        } else {
            $erro = 'E-mail ou senha incorretos.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br" data-theme="dark">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — FragZone</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include '../public/header.php'; ?>
<div class="container">
    <div class="form-wrap">
        <h2>🔑 Player Login</h2>
        <?php if ($erro): ?><div class="alert alert-error">⚠ <?= $erro ?></div><?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>E-mail</label>
                <input type="email" name="email" placeholder="seu@email.com" required value="<?= isset($_POST['email']) ? sanitizar($_POST['email']) : '' ?>">
            </div>
            <div class="form-group">
                <label>Senha</label>
                <input type="password" name="senha" placeholder="********" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%">▶ ENTRAR</button>
        </form>
        <p style="text-align:center;margin-top:1.2rem;font-family:'VT323',monospace;font-size:1.1rem;color:var(--muted)">
            Novo por aqui? <a href="../public/cadastro.php">Criar conta</a>
        </p>
    </div>
</div>
<?php include '../public/footer.php'; ?>
</body></html>

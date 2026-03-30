<?php
// cadastro.php — FragZone
session_start();
require_once '../includes/conexao.php';
require_once '../includes/funcoes.php';

if (usuario_logado()) redirecionar('dashboard.php');

$erro = ''; $sucesso = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome  = sanitizar($_POST['nome'] ?? '');
    $email = sanitizar($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $conf  = $_POST['confirmar_senha'] ?? '';

    if (!$nome || !$email || !$senha || !$conf) {
        $erro = 'Preencha todos os campos.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'E-mail inválido.';
    } elseif (strlen($senha) < 6) {
        $erro = 'Senha deve ter no mínimo 6 caracteres.';
    } elseif ($senha !== $conf) {
        $erro = 'As senhas não coincidem.';
    } else {
        $check = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $check->execute([$email]);
        if ($check->fetch()) {
            $erro = 'Este e-mail já está cadastrado.';
        } else {
            $hash = password_hash($senha, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?,?,?)");
            $stmt->execute([$nome, $email, $hash]);
            $sucesso = 'Conta criada! <a href="../public/login.php">Faça login</a>.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br" data-theme="dark">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro — FragZone</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include '../public/header.php'; ?>
<div class="container">
    <div class="form-wrap">
        <h2>📋 Criar Conta</h2>
        <?php if ($erro): ?><div class="alert alert-error">⚠ <?= $erro ?></div><?php endif; ?>
        <?php if ($sucesso): ?><div class="alert alert-success">✔ <?= $sucesso ?></div><?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Nome</label>
                <input type="text" name="nome" placeholder="Seu nome de jornalista" required value="<?= isset($_POST['nome']) ? sanitizar($_POST['nome']) : '' ?>">
            </div>
            <div class="form-group">
                <label>E-mail</label>
                <input type="email" name="email" placeholder="seu@email.com" required value="<?= isset($_POST['email']) ? sanitizar($_POST['email']) : '' ?>">
            </div>
            <div class="form-group">
                <label>Senha</label>
                <input type="password" name="senha" placeholder="Mínimo 6 caracteres" required>
            </div>
            <div class="form-group">
                <label>Confirmar Senha</label>
                <input type="password" name="confirmar_senha" placeholder="Repita a senha" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%">▶ CADASTRAR</button>
        </form>
        <p style="text-align:center;margin-top:1.2rem;font-family:'VT323',monospace;font-size:1.1rem;color:var(--muted)">
            Já tem conta? <a href="..public/login.php">Login</a>
        </p>
    </div>
</div>
<?php include '../public/footer.php'; ?>
</body></html>

<?php
// excluir_usuario.php — FragZone
require_once __DIR__ . '/../include/verifica_login.php';
require_once __DIR__ . '/../include/conexao.php';
require_once __DIR__ . '/../include/funcoes.php';

// Remove imagens das notícias do usuário
$imgs = $pdo->prepare("SELECT imagem FROM noticias WHERE autor = ? AND imagem IS NOT NULL");
$imgs->execute([$_SESSION['usuario_id']]);
foreach ($imgs->fetchAll() as $row) {
    if (file_exists('imagens/' . $row['imagem'])) {
        unlink('imagens/' . $row['imagem']);
    }
}

// Exclui o usuário (CASCADE remove as notícias)
$pdo->prepare("DELETE FROM usuarios WHERE id = ?")
    ->execute([$_SESSION['usuario_id']]);

session_destroy();
redirecionar('index.php');

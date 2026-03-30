<?php
// excluir_usuario.php
require_once 'verifica_login.php';
require_once 'conexao.php';
require_once 'funcoes.php';

// Remove as imagens das notícias do usuário
$stmt = $pdo->prepare("SELECT imagem FROM noticias WHERE autor = ? AND imagem IS NOT NULL");
$stmt->execute([$_SESSION['usuario_id']]);
$imagens = $stmt->fetchAll();
foreach ($imagens as $img) {
    if (file_exists('imagens/' . $img['imagem'])) {
        unlink('imagens/' . $img['imagem']);
    }
}

// Exclui o usuário (cascade exclui as notícias)
$del = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
$del->execute([$_SESSION['usuario_id']]);

session_destroy();
redirecionar('index.php');

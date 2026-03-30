<?php
// excluir_noticia.php
require_once 'verifica_login.php';
require_once 'conexao.php';
require_once 'funcoes.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT * FROM noticias WHERE id = ? AND autor = ?");
$stmt->execute([$id, $_SESSION['usuario_id']]);
$noticia = $stmt->fetch();

if ($noticia) {
    // Remove imagem se existir
    if ($noticia['imagem'] && file_exists('imagens/' . $noticia['imagem'])) {
        unlink('imagens/' . $noticia['imagem']);
    }
    $del = $pdo->prepare("DELETE FROM noticias WHERE id = ? AND autor = ?");
    $del->execute([$id, $_SESSION['usuario_id']]);
}

redirecionar('dashboard.php');

<?php
// excluir_noticia.php — FragZone
require_once __DIR__ . '/../include/verifica_login.php';
require_once __DIR__ . '/../include/conexao.php';
require_once __DIR__ . '/../include/funcoes.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT * FROM noticias WHERE id = ? AND autor = ?");
$stmt->execute([$id, $_SESSION['usuario_id']]);
$n = $stmt->fetch();

if ($n) {
    if ($n['imagem'] && file_exists('imagens/' . $n['imagem'])) {
        unlink('imagens/' . $n['imagem']);
    }
    $pdo->prepare("DELETE FROM noticias WHERE id = ? AND autor = ?")
        ->execute([$id, $_SESSION['usuario_id']]);
}

redirecionar('dashboard.php');

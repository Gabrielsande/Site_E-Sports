<?php
// funcoes.php

function usuario_logado() {
    return isset($_SESSION['usuario_id']);
}

function redirecionar($url) {
    header("Location: $url");
    exit;
}

function sanitizar($texto) {
    return htmlspecialchars(strip_tags(trim($texto)));
}

function resumo($texto, $limite = 200) {
    $texto = strip_tags($texto);
    if (strlen($texto) <= $limite) return $texto;
    return substr($texto, 0, $limite) . '...';
}

function formatar_data($data) {
    $dt = new DateTime($data);
    return $dt->format('d/m/Y \à\s H:i');
}

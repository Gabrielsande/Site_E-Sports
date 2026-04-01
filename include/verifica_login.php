<?php
// verifica_login.php — FragZone
session_start();
require_once __DIR__. '/../include/funcoes.php';
if (!usuario_logado()) redirecionar('../public/login.php');

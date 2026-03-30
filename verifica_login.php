<?php
// verifica_login.php
session_start();
require_once 'funcoes.php';

if (!usuario_logado()) {
    redirecionar('login.php');
}

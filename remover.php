<?php

require_once 'sessions.php';
require_once 'login/verifica_login.php';

//  Recebe o GET
$id = $_GET['id'] ?? null;

//  Testa se o GET ID está na URL
if (!isset($_GET['id'])) {
    //Não há id para trabalhar
    header('Location: index.php?del=empty');
    exit;
} 

require __DIR__.'/src/db.php';

if ($db_delete($id)) {
    //  Redirecionamento
    pg_close($conn);
    header('location: index.php?delete=success');
    exit;
}

//  Erro ao deletar
header('location: index.php?delete=error');
exit;

?>
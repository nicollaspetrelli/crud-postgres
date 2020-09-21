<?php

require_once '../sessions.php'; // Session Start
$conn = require '../connection.php'; // Inicia conexão com a database

pg_close($conn); // Encerra a conexão com a database!

// Destroi a sessão
session_destroy(); // ou unset($_SESSION['usuario'])

header('location: login.php?out=success');
exit();
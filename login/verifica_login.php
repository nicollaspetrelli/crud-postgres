<?php
require_once 'sessions.php'; // Session Start

if (!$_SESSION['usuario']) {
    header('location: login/login.php?not=auth');
    exit();
}

?>
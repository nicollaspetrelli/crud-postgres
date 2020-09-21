<?php
    // Connection com o PostgresSQL
    $host = "localhost";
    $port = "5432"; // null
    $dbname = "redstone";
    $user = "postgres";
    $password = "123456"; 
    $con_string = "host={$host} dbname={$dbname} user={$user} password={$password} ";
    //host=127.0.0.1 dbname=redstone user=postgres password=sonic9595

    $conn = pg_connect($con_string);
    
    if(!$conn = pg_connect($con_string)) die ("Erro ao conectar ao banco<br/>".pg_last_error($conn));

    return $conn;
?>
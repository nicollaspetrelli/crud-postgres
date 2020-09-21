<?php
/*  
    ===============================================
    Funções Relacionadas ao Banco de Dados Postgres
    ===============================================
*/

$conn = require 'connection.php'; 

/*  
    =========================================
    Função Anonima - Insere dados na Database
    =========================================
*/

$db_create = function ($dados) use ($conn) {

    //Recupera os dados e joga no array $dados[]
    //$dados = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

    // echo '<pre>';
    // var_dump($dados);
    // echo '</pre>';

    // Insert
    $sql = "INSERT INTO clientes (nome, sobrenome, email, endereco, bairro, numero, cidade, estado, cep) VALUES ('{$dados["nome"]}', '{$dados["sobrenome"]}', '{$dados["email"]}', '{$dados["endereco"]}', '{$dados["bairro"]}', '{$dados["numero"]}', '{$dados["cidade"]}', '{$dados["estado"]}', '{$dados["cep"]}')";
    $result = pg_query($conn, $sql);
    //print_r($result);
    
    // Verifica se deu erro
    if (!$result) {
        //  Erro na inserção de dados
        pg_close($conn);
        return false;
        exit;
    }

    //Se chegou até aqui deu certo =)
    return true;
};

/*  
    =================================================
    Função Anonima - Porcura apenas um ID na database   
    =================================================
*/

$db_one = function ($id) use ($conn) {

    // Faz a conexão com o Banco de Dados
    $conn = require 'connection.php'; 

    // Realizando uma query no banco de dados
    $sql = pg_query($conn, "SELECT * from clientes WHERE id='$id'"); // Mostra os dados da tabela cliente

    // Puxando o registro do ID especifico
    $result = pg_fetch_all($sql);

    if (!$result) {
        // Não foi encontrado ID para remover
        pg_close($conn);
        return false;
        exit();
    }

    return $result;
};


/*  
    =========================================
    Função Anonima - Remove dados na Database    
    =========================================
*/

$db_delete = function ($id) use ($conn) {

    // Faz a conexão com o Banco de Dados
    $conn = require 'connection.php'; 

    // Remove o User da Database
    $result = pg_query($conn, "DELETE from clientes WHERE id=$id"); 

    //  Verifica Erros
    if (!$result) {
        // Não foi possivel remover
        pg_close($conn);
        return false;
        exit();
    }

    return true;
};

/*  
    ====================================================
    Função Anonima - Edita com base em um ID na database   
    ====================================================
*/

$db_edit = function ($id, $dados) use ($conn) {

    $nome = $dados['nome'] ;
    $sobrenome = $dados['sobrenome'] ;
    $email = $dados['email'] ;
    $endereco = $dados['endereco'] ;
    $bairro = $dados['bairro'] ;
    $numero = $dados['numero'] ;
    $cidade = $dados['cidade'] ;
    $estado = $dados['estado'] ;
    $cep = $dados['cep'] ;

    // Faz a conexão com o Banco de Dados
    $conn = require 'connection.php'; 

    $result = pg_query($conn, "UPDATE clientes SET (nome, sobrenome, email, endereco, bairro, numero, cidade, estado, cep) = ('$nome','$sobrenome', '$email', '$endereco', '$bairro', '$numero', '$cidade', '$estado', '$cep') WHERE id = '$id'");

    if  (!$result) {
        //Query não foi executada!
        pg_close($conn);
        return false;
    } 

    return true;
};

/*
    ===================
    Funções Útilitárias  
    ===================
*/

$verificaCampo = function ($dados) {
    //dados via array
    $dados = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

    echo '<pre>';
    var_dump($dados);
    echo '</pre>';

    $vazio = 0;
    
    foreach ($dados as $input) {
        if ($input === '') {
            $vazio++; 
        }
    }

    if ($vazio > 0) {
        // Se 1 campo ou mais estiver vázio!
        return false;
        exit;
    }
    
    return true;
};
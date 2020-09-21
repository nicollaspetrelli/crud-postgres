<?php

require_once 'sessions.php';
require_once 'login/verifica_login.php';

// Faz a conexão com o Banco de Dados
$conn = require 'connection.php';

// Realizando uma query no banco de dados
$sql = pg_query($conn, "select * from clientes"); // Mostra os dados da tabela cliente

// Puxando todas linhas da tabela inteira
$users = pg_fetch_all($sql);

if (empty($users)) {
    header('location: cadastro.php?db=null');
    exit();
}

// Alertas
$alert = false;

// Alert sucesso ao CADASTRAR novo user
if (isset($_GET['cad']) && $_GET['cad'] == 'success') {
    $alert = true;
    $tipo = 'success';
    $title = 'Sucesso!';
    $desc = ' O novo usuário foi cadastrado no banco de dados!';
}

// Alert sucesso ao DELETAR um user
if (isset($_GET['delete']) && $_GET['delete'] == 'success') {
    $alert = true;
    $tipo = 'success';
    $title = 'Sucesso!';
    $desc = ' O usuário foi removido do banco de dados!';
}

// Alert ao acessar o VER.PHP sem ID no GET
if (isset($_GET['ver']) && $_GET['ver'] == 'empty') {
    $alert = true;
    $tipo = 'danger';
    $title = 'Acesso Negado!';
    $desc = ' Você não pode entrar na visualização detalhada sem especificar o usuario!';
}

// Alert ao acessar o REMOVER.PHP sem ID no GET
if (isset($_GET['del']) && $_GET['del'] == 'empty') {
    $alert = true;
    $tipo = 'danger';
    $title = 'Acesso Negado!';
    $desc = ' Você não pode remover um cadastro sem especificar o usuario!';
}

// Alert ao acessar o REMOVER.PHP e não achar o ID
if (isset($_GET['del']) && $_GET['del'] == '404') {
    $alert = true;
    $tipo = 'danger';
    $title = 'ERRO 404!';
    $desc = ' Não achamos o ID especificado para ser removido!';
}

// Alert ao acessar o VER.PHP e não achar o ID
if (isset($_GET['ver']) && $_GET['ver'] == '404') {
    $alert = true;
    $tipo = 'danger';
    $title = 'ERRO 404!';
    $desc = ' Não achamos o ID especificado para ser acessado!';
}

?>

<!doctype html>
<html lang="pt-br">
  <head>
    <title>CRUD em Postgres</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/css.style.css">
  </head>
  <body>

    <!-- Navbar -->
    <?php require_once 'navbar.php'?>

    <div class="container text-center mt-5">
        
        <?php if ($alert) { // Alerta dinamico ?>

        <div class="alert alert-<?= $tipo ?> alert-dismissible fade show mb-4" role="alert">
            <span><strong><?= $title ?></strong> <?= $desc ?></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <?php } // Fim do bloco ?>

        <h1 >Listagem dos Cadastros</h1>
        <p class="mb-4">Carregado com sucesso um total de <strong><?=count($users)?> registos!</strong></p>
        <a class="btn btn-success mb-5" href="cadastro.php">Cadastrar</a>
        
        <div class="row-fluid">
            <?php foreach ($users as $user): ?>
                <div class="col-md mb-5 card-custom">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $user['nome'] . ' ' . $user['sobrenome']; ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?php echo $user['email']; ?></h6>
                            <p class="card-text"><?php echo $user['endereco'] .', '. $user['numero']. '<br/>'. $user['bairro']. '<br/> CEP: '. $user['cep']; ?></p>
                        <!-- <p class="card-text">Avenida Maestro Rubens Parada, 676 <br/> Jardim Boa Esperança <br/> CEP: 13604-131</p> -->
                            <a href="ver.php?id=<?php echo $user['id'];?>" class="btn btn-primary">Visualizar</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
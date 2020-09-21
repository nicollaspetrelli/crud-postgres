<?php

require_once 'sessions.php';
require_once 'login/verifica_login.php';

// Configurando Alerts Dinamicos de Possiveis Erros recebidos via GET
$alert = false;

// Vertifica se o cadastro é vazio!
if (isset($_GET['cad']) && $_GET['cad'] == 'empty'){
    $alert = true;
    $tipo = 'danger';
    $title = 'ERRO!';
    $desc = ' Algum campo do formulário está vázio!';
}

if (isset($_GET['db']) && $_GET['db'] == 'null') {
    $alert = true;
    $tipo = 'warning';
    $title = 'Ops!';
    $desc = ' Não há nenhum registro ainda! Cadastre o primeiro!';
}

// ===========================================

// Verifica se a requisição é POST! Ou seja enviou o Formulario!
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    require __DIR__.'/src/db.php';

    $dados = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

    if (!$verificaCampo($dados)) {
        // Um ou mais campo vázio!
        pg_close($conn);
        header('location: ./cadastro.php?cad=empty');
        exit;
    } 

    if ($db_create($dados)) {
        pg_close($conn);
        header('location: ./index.php?cad=success');
        exit;
    }

    header('location: ./cadastro.php?db=error');
    exit;

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
    <style>
        .card-custom{
            min-width: 20rem;
            max-width: 50rem;
            margin: 0 auto;
        }

        .form{
            min-width: 15rem;
            max-width: 40rem;
            margin: 0 auto;
        }
    </style>
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


        <h1 class="mb-4">Cadastro Novo Usuário</h1>
        
        <div class="form mb-5">
            <form action="cadastro.php" method="post">
                <div class="form-row">
                    <div class="form-grup col-md-6">
                        <label for="nome">Nome</label>
                        <input name="nome" id="nome" type="text" class="form-control" placeholder="Nome">
                    </div>
                    <div class="form-grup col-md-6">
                        <label for="sobrenome">Sobrenome</label>
                        <input name="sobrenome" id="sobrenome" type="text" class="form-control" placeholder="Sobrenome">
                    </div>
                </div>

                <div class="form-row mt-3">
                    <div class="form-group col-md-12">
                        <label for="Email">Contato</label>
                        <input name="email" id="email" type="email" class="form-control" placeholder="Email">
                    </div>
                </div>

                <div class="form-group">
                        <label for="endereco">Endereço</label>
                        <input name="endereco" id="endereco" type="text" class="form-control" placeholder="Rua dos Bobos, nº 0" readonly>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input name="bairro" id="bairro" type="text" class="form-control" placeholder="Bairro Jardim Nova Vida" readonly>
                    </div>

                    <div class="form-group col-md-6">
                        <input name="numero" type="text" class="form-control" placeholder="Numero, Apartamento, hotel, casa, etc.">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="cidade">Cidade</label>
                        <input name="cidade" id="cidade" type="text" class="form-control" placeholder="Cidade" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="estado">Estado</label>
                        <input name="estado" id="estado" type="text" class="form-control" placeholder="UF" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="cep">CEP</label>
                        <input name="cep" id="CEP" type="text" class="form-control" placeholder="13028-000" onblur="validaDados(this.value)">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-12">
                        <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="edit" id="edit" value="checkedValue" >
                            <span>Editar Campos de Endereço</span>
                        </label>
                        </div>
                    </div>
			    </div>
                <button type="submit" class="btn btn-success mt-1">Cadastrar</button>
                <a class="btn btn-primary ml-2 mt-1" href="index.php">Voltar</a>
            </form>
        </div>

    </div>

      
    <!-- JavaScript -->
    <script src="assets/js/consultaCep.js"></script>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
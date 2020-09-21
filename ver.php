<?php

require_once 'sessions.php';
require_once 'login/verifica_login.php';

//  Recebe o GET
$id = $_GET['id'] ?? null;

if (!isset($_GET['id'])) {
    // GET ID não existe
    header('Location: index.php?ver=empty');
    exit();

} else {

    require __DIR__.'/src/db.php';

    $result = $db_one($id);

    if (!$result) {
        // Se users retornar false pois não achaou o ID no registro
        header('Location: index.php?ver=404');
        exit();
    } else {
        $users = $result;
    }
}

?>

<!doctype html>
<html lang="pt-br">
  <head>
    <title>CRUD em Postgres - Visualização</title>
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
    </style>
  </head>
  <body>

    <!-- Navbar -->
    <?php require_once 'navbar.php'?>

    <div class="container text-center mt-5">

        <?php if (isset($_GET['update']) && $_GET['update'] == 'success'){ ?>

        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <span><strong>Sucesso!</strong> Foi atualizado as informações no Banco de Dados!</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>    

        <?php } ?>

        <h1 class="mb-5">Visualização Detalhada</h1>

        <div class="row-fluid">
            <?php foreach ($users as $user): ?>
                <div class="col-md mb-5 card-custom">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $user['nome'] . ' ' . $user['sobrenome']; ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?php echo $user['email']; ?></h6>
                            <h6 class="card-text mb-2 mt-2 "><?php echo 'ID: ' . $user['id']; ?></h6>
                            <p class="card-text"><?php echo $user['endereco'] .', '. $user['numero']. '<br/>'. $user['bairro']. '<br/> CEP: '. $user['cep']; ?></p>
                        <!-- <p class="card-text">Avenida Maestro Rubens Parada, 676 <br/> Jardim Boa Esperança <br/> CEP: 13604-131</p> -->
                            <a href="editar.php?id=<?php echo $user['id'];?>" class="btn btn-primary">Editar</a>
                            <a href="remover.php?id=<?php echo $user['id'];?>" class="btn btn-danger">Remover</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <a class="btn btn-primary mb-5" href="index.php">Voltar</a>

    </div>

      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
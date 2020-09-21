<?php

require_once '../sessions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Faz a conexão com o Banco de Dados
    $conn = require '../connection.php';

    //Validação simples
    if (empty($_POST['email']) || empty($_POST['password'])) {
        header('location: login.php?erro=empty');
        exit();
    }

    // Proteção contra SQL INJECTION
    $usuario = pg_escape_string($conn, $_POST['email']);
    $senha = pg_escape_string($conn, $_POST['password']);

    //Query verifica login
    $query = "SELECT user_id, email from users where email = '{$usuario}' and password = md5('{$senha}')";
    $result = pg_query($conn, $query);
    $row = pg_num_rows($result);

    pg_close($conn);

    if ($row == 1) {
        $_SESSION['usuario'] = $usuario;
        header('location: ../index.php');
        exit();
    } else {
        header('location: login.php?pass=wrong');
        $_SESSION['nao_autenticado'] = true;
        exit();
    }
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
    <link rel="stylesheet" href="../assets/css/style.css">
  </head>
  <body>

    <!-- Navbar -->
    <nav class="navbar navbar-light bg-light justify-content-center">
    <span class="navbar-brand mb-0 h1">CRUD com PostgresSQL</span>
    </nav>

    <div class="container text-center mt-5">

        <h1>Faça sua Autenticação</h1>
        
        <section class="form-login">

            <div class="alert alert-info mt-4" role="alert">
                <span>Sua sessão é valida até você sair do navegador ou fazer logoff!</span>
            </div>

            <?php if (isset($_SESSION['nao_autenticado'])):?>
            
            <div class="alert alert-danger mt-4" role="alert">
                <span><strong>ERRO!</strong> O usuario ou senha não foi encontrado!</span>
            </div>

            <?php endif; ?>

            <?php if (isset($_GET['out']) && $_GET['out'] == 'success'){ ?>
                <div class="alert alert-success mt-4" role="alert">
                <span><strong>Desconectado!</strong> Você fez logout com sucesso!</span>
                </div>
            <?php } ?>


            <?php if (isset($_GET['not']) && $_GET['not'] == 'auth'){ ?>
                <div class="alert alert-danger mt-4" role="alert">
                <span><strong>Acesso Negado!</strong> Você precisa logar para ver essa pagina!</span>
                </div>
            <?php } ?>

            <?php if (isset($_GET['erro']) && $_GET['erro'] == 'empty'){ ?>
                <div class="alert alert-warning mt-4" role="alert">
                <span><strong>Aviso!</strong> Você precisa preencher todos os campos!</span>
                </div>
            <?php } ?>
            

            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="email">Endereço de email</label>
                    <input name='email' type="text" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Usuário">
                    <small id="email" class="form-text text-muted">Nunca vamos compartilhar seu email, com ninguém.</small>
                </div>

                <div class="form-group">
                    <label for="password">Senha</label>
                    <input name='password' type="password" class="form-control" id="password" placeholder="Senha">
                </div>

                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </section>


    </div>

      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
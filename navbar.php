<!-- Navbar -->
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
      <h5 class="my-0 mr-md-auto font-weight-bold">CRUD com PostgreSQL</h5>
        <span class="navbar-text my-0 mr-md-auto">
            <strong>Bem-vindo(a)</strong> user: <?= $_SESSION['usuario'] ?? 'Redstone'?>
        </span>
      <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-dark" href="http://localhost/Workstation/index.php">Consultar</a>
        <a class="p-2 text-dark" href="http://localhost/Workstation/cadastro.php">Cadastrar</a>
      </nav>
      <a class="btn btn-outline-primary" href="login/logout.php">Logout</a>
</div>
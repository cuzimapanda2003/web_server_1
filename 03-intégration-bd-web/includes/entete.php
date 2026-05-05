<header>
  <h1>Mon premier site web en php</h1>

  <nav id="menu" class="navbar navbar-expand-lg">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Accueil</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              GET/POST
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="exemple-post.php">Exemple POST</a></li>
              <li><a class="dropdown-item" href="exemple-get.php">Exemple GET</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Validation
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="validation-client.php">Validation client</a></li>
              <li><a class="dropdown-item" href="validation-serveur.php">Validation serveur</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Blogue
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="gestion-tags.php">Gestion des tags</a></li>
              <li><a class="dropdown-item" href="gestion-tags-js.php">Gestion des tags (js)</a></li>
              <li><a class="dropdown-item" href="liste-blogues.php">Les blogues</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="a-propos.php">À propos</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>
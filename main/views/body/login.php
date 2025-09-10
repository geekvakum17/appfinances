<style>
  .error-message {
    color: #d8000c;
    background-color: #ffd2d2;
    border: 1px solid #d8000c;
    padding: 12px;
    margin: 15px 0;
    border-radius: 5px;
    font-weight: bold;
  }
</style>
<main class="main-content  mt-0">
  <div class="page-header align-items-start min-vh-100" style="background-image: url('public/assets/img/img.jpg');">
    <span class="mask bg-gradient-dark opacity-6"></span>
    <div class="container my-auto">
      <div class="row">
        <div class="col-lg-4 col-md-8 col-12 mx-auto">
          <div class="card z-index-0 fadeIn3 fadeInBottom">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-success shadow-dark border-radius-lg py-3 pe-1">
                <center><img class="img-fluid" src="public/assets/img/logo.png" width="50px" ; height="50px" ; alt=""></center>
                <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">AHLY DAR EL SALAM FINANCE</h4>
              </div>
            </div>
            <?php
            // Au début de ta page login, après la balise <body>
            if (isset($_SESSION['error'])) {
              echo '<div class="error-message" style="color: red; padding: 10px; margin: 10px; border: 1px solid red; background-color: #ffe6e6;">';
              echo htmlspecialchars($_SESSION['error']);
              echo '</div>';

              // Supprime le message d'erreur après l'affichage
              unset($_SESSION['error']);
            }
            ?>
            <div class="card-body">
              <form role="form" class="text-start" method="post" action="./?page=user">
                <input type="hidden" name="instruction" value="login" />
                <div class="input-group input-group-outline my-3">
                  <label class="form-label">Nom Utilisateur</label>
                  <input type="text" class="form-control" name="username" required>
                </div>
                <div class="input-group input-group-outline mb-3">
                  <label class="form-label">Mot de Passe</label>
                  <input type="password" class="form-control" name="password" required>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn bg-gradient-success w-100 my-4 mb-2">Connexion</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
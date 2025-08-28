<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?> <div class="container-fluid py-2">
  <div class="row">
    <div class="col-xl-1 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-2 ps-3">
          <div class="d-flex justify-content-between">
            <div class="icon icon-md icon-shape bg-gradient-success shadow-dark shadow text-center border-radius-lg">
              <i class="material-symbols-rounded opacity-10">account_circle</i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-9 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-2 ps-3">
          <div class="d-flex justify-content-between">
            <div>
              <p class="text-sm mb-0 text-capitalize"></p>
              <h4 class="mb-0">Compte N° <?= $_SESSION['numeroCompte']; ?><br><?= $_SESSION['nomorg']; ?></h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="ms-3">
      <h3 class="mb-0 h4 font-weight-bolder"></h3>
    </div>
    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-2 ps-3">
          <div class="d-flex justify-content-between">
            <div>
              <p class="text-sm mb-0 text-capitalize">Solde disponible</p>
              <h4 class="mb-0"><?= $_SESSION['solde'] ?> FCFA</h4>
            </div>
            <div class="icon icon-md icon-shape bg-gradient-success shadow-dark shadow text-center border-radius-lg">
              <i class="material-symbols-rounded opacity-10">account_balance_wallet</i>
            </div>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-2 ps-3">
          <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">Compte Principale</span></p>
        </div>
      </div>
    </div>
    <div class="col-xl-4 col-sm-6">
      <div class="card">
        <div class="card-header p-2 ps-3">
          <div class="d-flex justify-content-between">
            <div>
              <p class="text-sm mb-0 text-capitalize">Rémunération mensuelle</p>
              <h4 class="mb-0">0 FCFA</h4>
            </div>
            <div class="icon icon-md icon-shape bg-gradient-success shadow-dark shadow text-center border-radius-lg">
              <i class="material-symbols-rounded opacity-10">trending_up</i>
            </div>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-2 ps-3">
          <p class="mb-0 text-sm">Taux appliqué : <span class="text-success font-weight-bolder"> 5%</span> sur votre solde</p>
        </div>
      </div>
    </div>

    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-2 ps-3">
          <div class="d-flex justify-content-between">
            <div>
              <p class="text-sm mb-0 text-capitalize">Montant dû</p>
              <h4 class="mb-0">0 FCFA</h4>
            </div>
            <div class="icon icon-md icon-shape bg-gradient-success shadow-dark shadow text-center border-radius-lg">
              <i class="material-symbols-rounded opacity-10">warning</i>
            </div>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-2 ps-3">
          <p class="mb-0 text-sm">Nombre de Jours Restants: <span class="text-danger font-weight-bolder">0</span></p>
        </div>
      </div>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-xl-4 mb-xl-0 mb-4">
      <div class="card bg-transparent shadow-xl">
        <div class="overflow-hidden position-relative border-radius-xl">
          <img src="public/assets/img/illustrations/pattern-tree.svg" class="position-absolute opacity-2 start-0 top-0 w-100 z-index-1 h-100" alt="pattern-tree">
          <span class="mask bg-gradient-dark opacity-10"></span>
          <div class="card-body position-relative z-index-1 p-3">
            <i class="material-symbols-rounded text-white p-2">wifi</i>Carte Ahly Dar El Salam Finance
            <?php
            $numeroCompte = $_SESSION['numeroCompte'];
            if (!empty($numeroCompte)) {
              // On regroupe en lot de 3 séparés par un espace
              $numeroFormate = trim(chunk_split($numeroCompte, 3, ' '));
            } ?>
            <h5 class="text-white mt-4 mb-5 pb-2">&nbsp;&nbsp;&nbsp;<?= trim(chunk_split($_SESSION['numeroCompte'], 3, ' ')); ?></h5>
            <div class="d-flex">
              <div class="d-flex">
                <div class="me-4">
                  <p class="text-white text-sm opacity-8 mb-0"></p>
                  <h6 class="text-white mb-0"><?= $_SESSION['nomorg']; ?></h6>
                </div>
                <div>
                  <p class="text-white text-sm opacity-8 mb-0">Expires</p>
                  <h6 class="text-white mb-0">05/27</h6>
                </div>
              </div>
              <div class="ms-auto w-20 d-flex align-items-end justify-content-end">
                <img class="w-60 mt-2" src="public/assets/img/logo.png" alt="logo">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-6">
      <div class="row">
        <div class="col-md-6 col-6">
          <div class="card">
            <div class="card-header mx-4 p-3 text-center">
              <div class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-lg">
                <i class="material-symbols-rounded opacity-10">account_balance</i>
              </div>
            </div>
            <div class="card-body pt-0 p-3 text-center">
              <h6 class="text-center mb-0">Mes Infos</h6>
              <span class="text-xs">Releve, Rib </span>
              <hr class="horizontal dark my-3">
              <h5 class="mb-0"></h5>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-6">
          <div class="card">
            <div class="card-header mx-4 p-3 text-center">
              <div class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-lg">
                <i class="material-symbols-rounded opacity-10">account_balance_wallet</i>
              </div>
            </div>
            <div class="card-body pt-0 p-3 text-center">
              <h6 class="text-center mb-0">Cotisation Mensuel</h6>
              <span class="text-xs"></span>
              <hr class="horizontal dark my-3">
              <h5 class="mb-0">0 FCFA</h5>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <br><br><br><br>
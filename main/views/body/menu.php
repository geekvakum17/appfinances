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
              <h4 class="mb-0">100.000 FCFA</h4>
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
              <h4 class="mb-0">10.000 FCFA</h4>
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
    <!--  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
          <div class="card-header p-2 ps-3">
            <div class="d-flex justify-content-between">
              <div>
                <p class="text-sm mb-0 text-capitalize">Today's Users</p>
                <h4 class="mb-0">2300</h4>
              </div>
              <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                <i class="material-symbols-rounded opacity-10">person</i>
              </div>
            </div>
          </div>
          <hr class="dark horizontal my-0">
          <div class="card-footer p-2 ps-3">
            <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+3% </span>than last month</p>
          </div>
        </div>
      </div> -->
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
                  <p class="text-white text-sm opacity-8 mb-0">Card Holder</p>
                  <h6 class="text-white mb-0">Jack Peterson</h6>
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
              <h6 class="text-center mb-0">Salary</h6>
              <span class="text-xs">Belong Interactive</span>
              <hr class="horizontal dark my-3">
              <h5 class="mb-0">2000 FCFA</h5>
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
              <h6 class="text-center mb-0">Portefeuile</h6>
              <span class="text-xs">Freelance Payment</span>
              <hr class="horizontal dark my-3">
              <h5 class="mb-0">455.00 FCFA</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 mt-4">
      <div class="card h-100 mb-4">
        <div class="card-header pb-0 px-3">
          <div class="row">
            <div class="col-md-6">
              <h6 class="mb-0">Your Transaction's</h6>
            </div>
            <div class="col-md-6 d-flex justify-content-start justify-content-md-end align-items-center">
              <i class="material-symbols-rounded me-2 text-lg">date_range</i>
              <small>23 - 30 March 2020</small>
            </div>
          </div>
        </div>
        <div class="card-body pt-4 p-3">
          <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Newest</h6>
          <ul class="list-group">
            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
              <div class="d-flex align-items-center">
                <button class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i class="material-symbols-rounded text-lg">expand_more</i></button>
                <div class="d-flex flex-column">
                  <h6 class="mb-1 text-dark text-sm">Netflix</h6>
                  <span class="text-xs">27 March 2020, at 12:30 PM</span>
                </div>
              </div>
              <div class="d-flex align-items-center text-danger text-gradient text-sm font-weight-bold">
                - $ 2,500
              </div>
            </li>
            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
              <div class="d-flex align-items-center">
                <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i class="material-symbols-rounded text-lg">expand_less</i></button>
                <div class="d-flex flex-column">
                  <h6 class="mb-1 text-dark text-sm">Apple</h6>
                  <span class="text-xs">27 March 2020, at 04:30 AM</span>
                </div>
              </div>
              <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                + $ 2,000
              </div>
            </li>
          </ul>
          <h6 class="text-uppercase text-body text-xs font-weight-bolder my-3">Yesterday</h6>
          <ul class="list-group">
            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
              <div class="d-flex align-items-center">
                <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i class="material-symbols-rounded text-lg">expand_less</i></button>
                <div class="d-flex flex-column">
                  <h6 class="mb-1 text-dark text-sm">Stripe</h6>
                  <span class="text-xs">26 March 2020, at 13:45 PM</span>
                </div>
              </div>
              <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                + $ 750
              </div>
            </li>
            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
              <div class="d-flex align-items-center">
                <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i class="material-symbols-rounded text-lg">expand_less</i></button>
                <div class="d-flex flex-column">
                  <h6 class="mb-1 text-dark text-sm">HubSpot</h6>
                  <span class="text-xs">26 March 2020, at 12:30 PM</span>
                </div>
              </div>
              <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                + $ 1,000
              </div>
            </li>
            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
              <div class="d-flex align-items-center">
                <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i class="material-symbols-rounded text-lg">expand_less</i></button>
                <div class="d-flex flex-column">
                  <h6 class="mb-1 text-dark text-sm">Creative Tim</h6>
                  <span class="text-xs">26 March 2020, at 08:30 AM</span>
                </div>
              </div>
              <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                + $ 2,500
              </div>
            </li>
            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
              <div class="d-flex align-items-center">
                <button class="btn btn-icon-only btn-rounded btn-outline-dark mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i class="material-symbols-rounded text-lg">priority_high</i></button>
                <div class="d-flex flex-column">
                  <h6 class="mb-1 text-dark text-sm">Webflow</h6>
                  <span class="text-xs">26 March 2020, at 05:00 AM</span>
                </div>
              </div>
              <div class="d-flex align-items-center text-dark text-sm font-weight-bold">
                Pending
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-6 mt-4">
      <div class="card">
        <div class="card-header pb-0 px-3">
          <h6 class="mb-0">Billing Information</h6>
        </div>
        <div class="card-body pt-4 p-3">
          <ul class="list-group">
            <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
              <div class="d-flex flex-column">
                <h6 class="mb-3 text-sm">Oliver Liam</h6>
                <span class="mb-2 text-xs">Company Name: <span class="text-dark font-weight-bold ms-sm-2">Viking Burrito</span></span>
                <span class="mb-2 text-xs">Email Address: <span class="text-dark ms-sm-2 font-weight-bold">oliver@burrito.com</span></span>
                <span class="text-xs">VAT Number: <span class="text-dark ms-sm-2 font-weight-bold">FRB1235476</span></span>
              </div>
              <div class="ms-auto text-end">
                <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i class="material-symbols-rounded text-sm me-2">delete</i>Delete</a>
                <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;"><i class="material-symbols-rounded text-sm me-2">edit</i>Edit</a>
              </div>
            </li>
            <li class="list-group-item border-0 d-flex p-4 mb-2 mt-3 bg-gray-100 border-radius-lg">
              <div class="d-flex flex-column">
                <h6 class="mb-3 text-sm">Lucas Harper</h6>
                <span class="mb-2 text-xs">Company Name: <span class="text-dark font-weight-bold ms-sm-2">Stone Tech Zone</span></span>
                <span class="mb-2 text-xs">Email Address: <span class="text-dark ms-sm-2 font-weight-bold">lucas@stone-tech.com</span></span>
                <span class="text-xs">VAT Number: <span class="text-dark ms-sm-2 font-weight-bold">FRB1235476</span></span>
              </div>
              <div class="ms-auto text-end">
                <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i class="material-symbols-rounded text-sm me-2">delete</i>Delete</a>
                <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;"><i class="material-symbols-rounded text-sm me-2">edit</i>Edit</a>
              </div>
            </li>
            <li class="list-group-item border-0 d-flex p-4 mb-2 mt-3 bg-gray-100 border-radius-lg">
              <div class="d-flex flex-column">
                <h6 class="mb-3 text-sm">Ethan James</h6>
                <span class="mb-2 text-xs">Company Name: <span class="text-dark font-weight-bold ms-sm-2">Fiber Notion</span></span>
                <span class="mb-2 text-xs">Email Address: <span class="text-dark ms-sm-2 font-weight-bold">ethan@fiber.com</span></span>
                <span class="text-xs">VAT Number: <span class="text-dark ms-sm-2 font-weight-bold">FRB1235476</span></span>
              </div>
              <div class="ms-auto text-end">
                <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i class="material-symbols-rounded text-sm me-2">delete</i>Delete</a>
                <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;"><i class="material-symbols-rounded text-sm me-2">edit</i>Edit</a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
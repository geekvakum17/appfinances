<br><br>
<!-- Liste des paliers (remplie dynamiquement par JS) -->
<div class="container-fluid px-2 px-md-4">
  <div class="card card-body mx-2 mx-md-2 mt-n6">
    <div class="row">
      <div class="col-12 mt-4">
        <div class="mb-5 ps-3">
          <h3 class="mb-1">LES DIFFÉRENTS PALIERS DE PRÊT</h3>
          <p class="text-sm">
            Chez AHLY DAR EL SALAM FINANCE, nous avons conçu un système de prêt évolutif basé sur des paliers progressifs.
          </p>
        </div>
        <div class="row" id="paliersContainer"></div>
      </div>
    </div>
  </div>
</div>


<!-- Modal Demande de prêt -->
<!-- Modal Demande de prêt -->
<div class="modal fade" id="demandePretModal" tabindex="-1" aria-labelledby="demandePretLabel" aria-hidden="true">
  <div class="modal-dialog modal-md"> <!-- modal-md = taille réduite -->
    <div class="modal-content">

      <!-- En-tête -->
      <div class="modal-header">
        <h5 class="modal-title" id="demandePretLabel">Demande de prêt</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>

      <!-- Formulaire -->
      <form id="formDemandePret">
        <div class="modal-body">

          <!-- Champs non modifiables -->
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Type de prêt</label>
              <input type="text" class="form-control styled-readonly highlight-input" id="typePret" name="typePret" readonly>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Taux d'intérêt (%)</label>
              <input type="text" class="form-control styled-readonly highlight-input" id="taux" name="taux" readonly>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Frais</label>
              <input type="text" class="form-control styled-readonly highlight-input" id="frais" name="frais" readonly>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Durée min (mois)</label>
              <input type="text" class="form-control styled-readonly highlight-input" id="dureeMin" name="dureeMin" readonly>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Durée max (mois)</label>
              <input type="text" class="form-control styled-readonly highlight-input" id="dureeMax" name="dureeMax" readonly>
            </div>
          </div>

          <hr>

          <!-- Champs modifiables -->
          <div class="mb-3">
            <label for="montant" class="form-label">Montant demandé</label>
            <input type="number" class="form-control highlight-input" id="montant" name="montant" required>
          </div>
        </div>

        <!-- Pied -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-success">Faire la demande</button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- CSS -->
<style>
  /* Pour que readonly garde le même style */
  .styled-readonly[readonly] {
    background-color: #fff !important;
    /* blanc comme les champs modifiables */
    opacity: 1;
    /* éviter l’effet grisé */
    cursor: not-allowed;
  }
</style>


<!-- Style personnalisé -->
<style>
  .highlight-input {
    border: 2px solid #325385ff;
    border-radius: 6px;
    box-shadow: 0 0 4px rgba(25, 54, 98, 0.4);
    transition: 0.3s;
  }

  .highlight-input:focus {
    border-color: #198754;
    box-shadow: 0 0 6px rgba(25, 135, 84, 0.6);
    outline: none;
  }
</style>


<script>
  const BASE_URL = "<?= BASE_URL ?>"; // définie côté PHP

  async function chargerPaliers() {
    try {
      const res = await fetch(`${BASE_URL}main/api/getPaliers.php`);
      const raw = await res.text();
      console.log("Réponse brute API:", raw);

      if (!raw) throw new Error("⚠️ L’API n’a rien retourné !");

      let data;
      try {
        data = JSON.parse(raw);
      } catch (e) {
        throw new Error("⚠️ Réponse non JSON valide : " + e.message);
      }

      if (!data.success) {
        console.error(data.message);
        return;
      }

      const container = document.getElementById('paliersContainer');
      container.innerHTML = "";

      data.paliers.forEach(palier => {
        const col = document.createElement('div');
        col.className = "col-xl-4 col-md-6 mb-xl-0 mb-4";

        col.innerHTML = `
          <div class="card card-blog card-plain">
            <div class="card-body p-3">
              <h5>${palier.nomcpret}</h5>
              <ul>
                <li>Montant : ${palier.montantmin} - ${palier.montantmax} FCFA</li>
                <li>Taux d'intérêt : ${palier.tauxinteret}%</li>
                <li>Frais : ${palier.fraisoucprets} FCFA</li>
                <li>Durée min : ${palier.dureeminremb} mois</li>
                <li>Durée max : ${palier.dureemaxremb} mois</li>
              </ul>
              <div class="d-flex align-items-center justify-content-between">
                <button 
                  type="button" 
                  class="btn btn-outline-primary btn-sm mb-0 btnDemanderPret"
                  data-bs-toggle="modal" 
                  data-bs-target="#demandePretModal"
                  data-type="${palier.nomcpret}"
                  data-taux="${palier.tauxinteret}"
                  data-frais="${palier.fraisoucprets}"
                  data-dureemin="${palier.dureeminremb}"
                  data-dureemax="${palier.dureemaxremb}"
                >
                  Demander le Prêt
                </button>
              </div>
            </div>
          </div>
        `;

        container.appendChild(col);
      });

      // Attacher les événements après l'injection HTML
      document.querySelectorAll(".btnDemanderPret").forEach(btn => {
        btn.addEventListener("click", function() {
          document.getElementById("typePret").value = this.dataset.type;
          document.getElementById("taux").value = this.dataset.taux;
          document.getElementById("frais").value = this.dataset.frais;
          document.getElementById("dureeMin").value = this.dataset.dureemin;
          document.getElementById("dureeMax").value = this.dataset.dureemax;
        });
      });

    } catch (err) {
      console.error('Erreur lors du chargement des paliers:', err);
    }
  }

  // Charger au démarrage
  chargerPaliers();
</script>
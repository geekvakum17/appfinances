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

  <script>
    const BASE_URL = "<?= BASE_URL ?>"; // définie côté PHP

    async function chargerPaliers() {
      try {
        const res = await fetch(`${BASE_URL}main/api/getPaliers.php`);
        const raw = await res.text(); // lire brut pour debug
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
            <a href="javascript:;">
              <h5>${palier.nomcpret}</h5>
            </a>
            <p class="mb-4 text-sm">
              <ul>
                <li>Montant : ${palier.montantmin} - ${palier.montantmax} FCFA</li>
                <li>Taux d'intérêt : ${palier.tauxinteret}%</li>
                <li>Frais : ${palier.fraisoucprets}</li>
                <li>Durée min : ${palier.dureeminremb} mois</li>
                <li>Durée max : ${palier.dureemaxremb} mois</li>
              </ul>
            </p>
            <div class="d-flex align-items-center justify-content-between">
              <button type="button" class="btn btn-outline-primary btn-sm mb-0">
                Demander le Prêt
              </button>
            </div>
          </div>
        </div>
      `;

          container.appendChild(col);
        });

      } catch (err) {
        console.error('Erreur lors du chargement des paliers:', err);
      }
    }

    // Charger au démarrage
    chargerPaliers();
  </script>
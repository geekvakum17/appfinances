<?php
// Sécuriser la récupération de la variable POST
$id_paysresidence = filter_input(INPUT_POST, 'id_paysresidence', FILTER_SANITIZE_STRING);
$resultat = [];

if ($id_paysresidence !== null && $id_paysresidence !== false && $id_paysresidence !== '') {
  // On récupère la liste des villes pour le pays donné
  $resultat = $UserRequest->listVille($id_paysresidence);
}

?>

<select class="form-control btn-square" id="id_villeresidence" name="id_villeresidence" required>
  <option value="">-- Sélectionnez --</option>
  <?php if (!empty($resultat)) : ?>
    <?php foreach ($resultat as $data) : ?>
      <option value="<?= htmlspecialchars($data['id_ville']) ?>">
        <?= htmlspecialchars($data['libville']) ?>
      </option>
    <?php endforeach; ?>
  <?php else : ?>
    <option disabled>Aucune donnée disponible</option>
  <?php endif; ?>
</select>
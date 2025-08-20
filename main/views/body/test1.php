<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Espace Client • Microfinance</title>
  <meta name="description" content="Template espace client microfinance – HTML5, CSS, JS pur (responsive)." />
  <style>
    :root {
      --bg: #0f172a;
      /* slate-900 */
      --panel: #111827;
      /* gray-900 */
      --muted: #94a3b8;
      /* slate-400 */
      --text: #e5e7eb;
      /* gray-200 */
      --primary: #0ea5e9;
      /* sky-500 */
      --primary-600: #0284c7;
      /* sky-600 */
      --accent: #22c55e;
      /* green-500 */
      --danger: #ef4444;
      /* red-500 */
      --warning: #f59e0b;
      /* amber-500 */
      --border: #1f2937;
      /* gray-800 */
      --ring: rgba(14, 165, 233, .35);
      --radius: 14px;
      --shadow: 0 10px 30px rgba(0, 0, 0, .35);
    }

    * {
      box-sizing: border-box;
    }

    html,
    body {
      height: 100%;
    }

    body {
      margin: 0;
      font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji";
      color: var(--text);
      background: radial-gradient(1200px 600px at 20% -10%, rgba(14, 165, 233, .08), transparent 60%),
        radial-gradient(800px 400px at 100% 10%, rgba(34, 197, 94, .06), transparent 50%),
        var(--bg);
      letter-spacing: 0.1px;
    }

    /* Layout */
    .app {
      display: grid;
      grid-template-columns: 280px 1fr;
      grid-template-rows: 64px calc(100vh - 64px);
      grid-template-areas:
        "sidebar header"
        "sidebar main";
      min-height: 100vh;
    }

    header {
      grid-area: header;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 16px 0 10px;
      backdrop-filter: blur(8px);
      background: linear-gradient(0deg, rgba(17, 24, 39, .75), rgba(17, 24, 39, .75));
      border-bottom: 1px solid var(--border);
      position: sticky;
      top: 0;
      z-index: 20;
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .logo {
      width: 36px;
      height: 36px;
      border-radius: 10px;
      background: linear-gradient(135deg, var(--primary), var(--accent));
      display: grid;
      place-items: center;
      font-weight: 800;
      color: #001018;
      box-shadow: 0 6px 20px rgba(14, 165, 233, .35);
    }

    .brand h1 {
      font-size: 16px;
      margin: 0;
      letter-spacing: .4px;
    }

    .header-actions {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .search {
      display: flex;
      align-items: center;
      gap: 8px;
      background: var(--panel);
      border: 1px solid var(--border);
      padding: 8px 10px;
      border-radius: 12px;
      min-width: 260px;
    }

    .search input {
      width: 100%;
      background: transparent;
      border: none;
      color: var(--text);
      outline: none;
    }

    .icon-btn {
      background: var(--panel);
      border: 1px solid var(--border);
      color: var(--text);
      padding: 8px 10px;
      border-radius: 12px;
      cursor: pointer;
      transition: .2s ease;
    }

    .icon-btn:hover {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px var(--ring) inset;
    }

    /* Sidebar */
    aside {
      grid-area: sidebar;
      border-right: 1px solid var(--border);
      background: linear-gradient(180deg, rgba(2, 8, 23, .6), rgba(2, 8, 23, .4)), #020617;
      padding: 14px;
      position: sticky;
      top: 0;
      height: 100vh;
      overflow: auto;
    }

    .user-card {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px;
      border-radius: var(--radius);
      background: var(--panel);
      border: 1px solid var(--border);
    }

    .avatar {
      width: 40px;
      height: 40px;
      border-radius: 12px;
      background: #0b1220;
      display: grid;
      place-items: center;
      font-weight: 700;
    }

    .user-card small {
      color: var(--muted);
    }

    nav {
      margin-top: 16px;
      display: grid;
      gap: 6px;
    }

    .nav-link {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 12px;
      border-radius: 12px;
      text-decoration: none;
      color: var(--text);
      border: 1px solid transparent;
    }

    .nav-link:hover {
      background: #0b1220;
      border-color: var(--border);
    }

    .nav-link.active {
      background: linear-gradient(90deg, rgba(14, 165, 233, .12), transparent 80%);
      border-color: var(--primary-600);
    }

    .badge {
      margin-left: auto;
      font-size: 11px;
      background: rgba(14, 165, 233, .2);
      padding: 4px 8px;
      border-radius: 999px;
      color: var(--primary);
    }

    /* Main */
    main {
      grid-area: main;
      padding: 18px;
      overflow: auto;
    }

    .grid {
      display: grid;
      gap: 14px;
    }

    .cards {
      grid-template-columns: repeat(12, minmax(0, 1fr));
    }

    .card {
      background: linear-gradient(180deg, rgba(2, 6, 23, .65), rgba(2, 6, 23, .4));
      border: 1px solid var(--border);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      padding: 16px;
    }

    .card h3 {
      margin: 0 0 10px;
      font-size: 14px;
      color: var(--muted);
      font-weight: 600;
    }

    .stat {
      font-size: 22px;
      font-weight: 800;
      letter-spacing: .3px;
    }

    .sub {
      color: var(--muted);
      font-size: 12px;
    }

    .col-3 {
      grid-column: span 3 / span 3;
    }

    .col-4 {
      grid-column: span 4 / span 4;
    }

    .col-6 {
      grid-column: span 6 / span 6;
    }

    .col-8 {
      grid-column: span 8 / span 8;
    }

    .col-12 {
      grid-column: span 12 / span 12;
    }

    /* Tables */
    table {
      width: 100%;
      border-collapse: collapse;
    }

    thead th {
      text-align: left;
      font-size: 12px;
      text-transform: uppercase;
      letter-spacing: .6px;
      color: var(--muted);
      padding: 12px;
      border-bottom: 1px solid var(--border);
    }

    tbody td {
      padding: 12px;
      border-bottom: 1px solid var(--border);
    }

    tbody tr:hover {
      background: rgba(2, 8, 23, .45);
    }

    /* Forms */
    .form {
      display: grid;
      gap: 12px;
    }

    .row {
      display: grid;
      grid-template-columns: repeat(12, 1fr);
      gap: 12px;
    }

    .field {
      grid-column: span 6;
    }

    .field.full {
      grid-column: span 12;
    }

    label {
      font-size: 12px;
      color: var(--muted);
      display: block;
      margin-bottom: 6px;
    }

    input,
    select,
    textarea {
      width: 100%;
      background: #0b1220;
      color: var(--text);
      border: 1px solid var(--border);
      padding: 12px 10px;
      border-radius: 12px;
      outline: none;
      transition: border-color .18s, box-shadow .18s;
    }

    input:focus,
    select:focus,
    textarea:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px var(--ring);
    }

    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      cursor: pointer;
      border: 1px solid var(--border);
      background: #0b1220;
      color: var(--text);
      padding: 10px 14px;
      border-radius: 12px;
      transition: .2s;
    }

    .btn.primary {
      background: linear-gradient(90deg, var(--primary-600), var(--primary));
      border-color: transparent;
      color: #001018;
      font-weight: 700;
    }

    .btn.success {
      background: linear-gradient(90deg, #16a34a, #22c55e);
      border-color: transparent;
      color: #00150a;
      font-weight: 700;
    }

    .btn.danger {
      background: linear-gradient(90deg, #b91c1c, #ef4444);
      border-color: transparent;
      color: #1a0000;
      font-weight: 700;
    }

    .btn.ghost:hover {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px var(--ring) inset;
    }

    .toolbar {
      display: flex;
      align-items: center;
      gap: 10px;
      justify-content: space-between;
      margin-bottom: 10px;
    }

    /* Toast */
    .toast {
      position: fixed;
      right: 16px;
      bottom: 16px;
      background: #0b1220;
      border: 1px solid var(--border);
      padding: 14px 16px;
      border-radius: 12px;
      box-shadow: var(--shadow);
      display: none;
    }

    /* Modal */
    .modal {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, .6);
      display: none;
      align-items: center;
      justify-content: center;
      padding: 18px;
    }

    .modal .card {
      max-width: 520px;
      width: 100%;
    }

    /* Responsive */
    @media (max-width: 1024px) {
      .app {
        grid-template-columns: 84px 1fr;
      }

      aside {
        padding: 10px;
      }

      .user-card .meta {
        display: none;
      }

      .nav-text {
        display: none;
      }

      .search {
        min-width: 0;
        width: 42vw;
      }

      .col-3 {
        grid-column: span 6;
      }

      .col-4 {
        grid-column: span 6;
      }

      .col-6 {
        grid-column: span 12;
      }

      .col-8 {
        grid-column: span 12;
      }
    }

    @media (max-width: 640px) {
      header {
        position: sticky;
      }

      .app {
        grid-template-columns: 1fr;
        grid-template-areas: "header" "main";
      }

      aside {
        position: fixed;
        inset: 0 40% 0 0;
        transform: translateX(-100%);
        transition: .25s ease;
        z-index: 40;
      }

      aside.open {
        transform: translateX(0);
      }

      .row {
        grid-template-columns: 1fr;
      }

      .field {
        grid-column: 1/-1;
      }
    }
  </style>
</head>

<body>
  <div class="app" id="app">
    <!-- Sidebar -->
    <aside id="sidebar">
      <div class="user-card">
        <div class="avatar" id="avatar">AK</div>
        <div class="meta">
          <div style="font-weight:700">Ahoua Konan</div>
          <small>Client n° CLT-000245</small>
        </div>
      </div>
      <nav>
        <a class="nav-link active" href="#" data-view="overview">🏠 <span class="nav-text">Accueil</span></a>
        <a class="nav-link" href="#" data-view="accounts">💳 <span class="nav-text">Mes comptes</span></a>
        <a class="nav-link" href="#" data-view="transactions">📑 <span class="nav-text">Transactions</span></a>
        <a class="nav-link" href="#" data-view="transfer">🔁 <span class="nav-text">Virement</span></a>
        <a class="nav-link" href="#" data-view="loans">📄 <span class="nav-text">Demandes de prêt</span></a>
        <a class="nav-link" href="#" data-view="support">💬 <span class="nav-text">Support</span> <span class="badge" id="badgeSupport">2</span></a>
        <a class="nav-link" href="#" data-view="settings">⚙️ <span class="nav-text">Paramètres</span></a>
        <a class="nav-link" href="#" id="logout">⎋ <span class="nav-text">Déconnexion</span></a>
      </nav>
    </aside>

    <!-- Header -->
    <header>
      <div class="brand">
        <button class="icon-btn" id="menuBtn" aria-label="Ouvrir le menu">☰</button>
        <div class="logo">MF</div>
        <h1>Espace Client</h1>
      </div>
      <div class="header-actions">
        <div class="search"><span>🔍</span><input id="searchInput" placeholder="Rechercher une opération, compte…" /></div>
        <button class="icon-btn" id="notifyBtn" aria-label="Notifications">🔔</button>
        <button class="icon-btn" id="themeBtn" aria-label="Changer de thème">🌓</button>
      </div>
    </header>

    <!-- Main -->
    <main>
      <!-- OVERVIEW -->
      <section id="view-overview" class="grid">
        <div class="toolbar">
          <div>
            <h2 style="margin:0 0 6px">Bonjour, <span id="userFirstName">Ahoua</span> 👋</h2>
            <div class="sub">Aujourd'hui : <span id="today"></span></div>
          </div>
          <div style="display:flex; gap:10px">
            <button class="btn primary" data-view="transfer">Nouveau virement</button>
            <button class="btn ghost" data-view="loans">Demander un prêt</button>
          </div>
        </div>

        <div class="grid cards">
          <div class="card col-4">
            <h3>Solde total</h3>
            <div class="stat" id="totalBalance">—</div>
            <div class="sub" id="totalAccounts">— comptes</div>
          </div>
          <div class="card col-4">
            <h3>Dépenses (30 jours)</h3>
            <div class="stat" id="spent30">—</div>
            <div class="sub">Comparé au mois précédent</div>
          </div>
          <div class="card col-4">
            <h3>Revenus (30 jours)</h3>
            <div class="stat" id="income30">—</div>
            <div class="sub">Dernières opérations créditrices</div>
          </div>

          <div class="card col-8">
            <h3>Dernières transactions</h3>
            <table id="lastTxTable" aria-label="Dernières transactions">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Libellé</th>
                  <th>Type</th>
                  <th>Montant</th>
                  <th>Compte</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>

          <div class="card col-4">
            <h3>Cartes</h3>
            <div id="cardsList"></div>
          </div>
        </div>
      </section>

      <!-- ACCOUNTS -->
      <section id="view-accounts" class="grid" hidden>
        <div class="toolbar">
          <h2 style="margin:0">Mes comptes</h2>
          <div style="display:flex; gap:8px">
            <button class="btn" id="refreshAccounts">Actualiser</button>
            <button class="btn primary" data-view="transfer">Virement</button>
          </div>
        </div>
        <div class="grid cards" id="accountsGrid"></div>
      </section>

      <!-- TRANSACTIONS -->
      <section id="view-transactions" class="grid" hidden>
        <div class="toolbar">
          <h2 style="margin:0">Historique des transactions</h2>
          <div style="display:flex; gap:8px">
            <select id="filterAccount"></select>
            <select id="filterType">
              <option value="">Tous types</option>
              <option value="credit">Crédit</option>
              <option value="debit">Débit</option>
            </select>
            <input id="filterQuery" placeholder="Filtrer par libellé…" />
            <button class="btn" id="exportCsv">Exporter CSV</button>
          </div>
        </div>
        <div class="card col-12">
          <table id="txTable">
            <thead>
              <tr>
                <th>Date</th>
                <th>Libellé</th>
                <th>Type</th>
                <th>Montant</th>
                <th>Compte</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </section>

      <!-- TRANSFER -->
      <section id="view-transfer" class="grid" hidden>
        <div class="toolbar">
          <h2 style="margin:0">Effectuer un virement</h2>
        </div>
        <div class="card col-8">
          <form id="transferForm" class="form" novalidate>
            <div class="row">
              <div class="field">
                <label for="fromAccount">Depuis le compte</label>
                <select id="fromAccount" required></select>
              </div>
              <div class="field">
                <label for="toIban">Vers IBAN / N° compte</label>
                <input id="toIban" placeholder="CI12 3456 7890 1234 5678 90" required />
              </div>
              <div class="field">
                <label for="amount">Montant</label>
                <input id="amount" type="number" step="0.01" min="0" placeholder="0.00" required />
              </div>
              <div class="field">
                <label for="currency">Devise</label>
                <select id="currency">
                  <option value="XOF">XOF (CFA)</option>
                  <option value="EUR">EUR</option>
                  <option value="USD">USD</option>
                </select>
              </div>
              <div class="field full">
                <label for="label">Libellé</label>
                <input id="label" maxlength="60" placeholder="Motif du virement" />
              </div>
            </div>
            <div style="display:flex; gap:10px; justify-content:flex-end">
              <button type="reset" class="btn ghost">Annuler</button>
              <button type="submit" class="btn success">Confirmer</button>
            </div>
          </form>
        </div>
        <div class="card col-4">
          <h3>Conseils sécurité</h3>
          <ul style="margin:0; padding-left:18px; line-height:1.8">
            <li>Vérifiez l'IBAN du bénéficiaire.</li>
            <li>N'approuvez jamais un virement que vous n'avez pas initié.</li>
            <li>Activez la double authentification (2FA).</li>
          </ul>
        </div>
      </section>

      <!-- LOANS -->
      <section id="view-loans" class="grid" hidden>
        <div class="toolbar">
          <h2 style="margin:0">Demandes de prêt</h2>
        </div>
        <div class="card col-6">
          <form id="loanForm" class="form">
            <div class="row">
              <div class="field">
                <label for="loanAmount">Montant demandé</label>
                <input id="loanAmount" type="number" step="1000" min="0" required />
              </div>
              <div class="field">
                <label for="loanTerm">Durée (mois)</label>
                <input id="loanTerm" type="number" min="1" max="120" required />
              </div>
              <div class="field full">
                <label for="loanPurpose">Objet du prêt</label>
                <textarea id="loanPurpose" rows="3" required></textarea>
              </div>
            </div>
            <div style="display:flex; gap:10px; justify-content:flex-end">
              <button type="reset" class="btn ghost">Effacer</button>
              <button type="submit" class="btn primary">Soumettre</button>
            </div>
          </form>
        </div>
        <div class="card col-6">
          <h3>Simulateur (TAEG 12% indicatif)</h3>
          <div id="loanSimu" class="sub">Entrez montant et durée…</div>
        </div>
      </section>

      <!-- SUPPORT -->
      <section id="view-support" class="grid" hidden>
        <div class="toolbar">
          <h2 style="margin:0">Support & Messages</h2>
        </div>
        <div class="card col-8">
          <div id="messages" style="display:grid; gap:12px"></div>
          <form id="supportForm" class="form" style="margin-top:12px">
            <div class="row">
              <div class="field full"><label for="supportMsg">Votre message</label><textarea id="supportMsg" rows="3" required></textarea></div>
            </div>
            <div style="display:flex; gap:10px; justify-content:flex-end">
              <button class="btn primary">Envoyer</button>
            </div>
          </form>
        </div>
        <div class="card col-4">
          <h3>Centre d'aide</h3>
          <p class="sub">Consultez la FAQ, statut des services et guide sécurité.</p>
        </div>
      </section>

      <!-- SETTINGS -->
      <section id="view-settings" class="grid" hidden>
        <div class="toolbar">
          <h2 style="margin:0">Paramètres</h2>
        </div>
        <div class="card col-6">
          <h3>Profil</h3>
          <form id="profileForm" class="form">
            <div class="row">
              <div class="field"><label for="firstName">Prénom</label><input id="firstName" value="Ahoua" /></div>
              <div class="field"><label for="lastName">Nom</label><input id="lastName" value="Konan" /></div>
              <div class="field full"><label for="email">Email</label><input id="email" type="email" value="ahoua@example.com" /></div>
            </div>
            <div style="display:flex; gap:10px; justify-content:flex-end"><button class="btn success">Mettre à jour</button></div>
          </form>
        </div>
        <div class="card col-6">
          <h3>Sécurité</h3>
          <form id="securityForm" class="form">
            <div class="row">
              <div class="field full"><label for="newPass">Nouveau mot de passe</label><input id="newPass" type="password" /></div>
              <div class="field full"><label for="twoFA">Double authentification (2FA)</label>
                <select id="twoFA">
                  <option>désactivée</option>
                  <option>par SMS</option>
                  <option>via App</option>
                </select>
              </div>
            </div>
            <div style="display:flex; gap:10px; justify-content:flex-end"><button class="btn">Enregistrer</button></div>
          </form>
        </div>
      </section>
    </main>
  </div>

  <!-- Toast & Modal -->
  <div class="toast" id="toast" role="status" aria-live="polite"></div>
  <div class="modal" id="modal">
    <div class="card">
      <h3 id="modalTitle">Confirmer</h3>
      <p id="modalText" class="sub" style="margin:8px 0 12px"></p>
      <div style="display:flex; gap:10px; justify-content:flex-end">
        <button class="btn ghost" id="modalCancel">Annuler</button>
        <button class="btn success" id="modalOk">OK</button>
      </div>
    </div>
  </div>

  <script>
    // --- Utilities ---
    const qs = (sel, el = document) => el.querySelector(sel);
    const qsa = (sel, el = document) => [...el.querySelectorAll(sel)];
    const money = (v, c = "XOF") => new Intl.NumberFormat("fr-FR", {
      style: "currency",
      currency: c
    }).format(Number(v || 0));
    const fmtDate = (d) => new Date(d).toLocaleDateString('fr-FR', {
      day: '2-digit',
      month: '2-digit',
      year: '2-digit'
    });
    const todayLong = () => new Date().toLocaleDateString('fr-FR', {
      weekday: 'long',
      day: '2-digit',
      month: 'long',
      year: 'numeric'
    });

    const toast = (msg) => {
      const el = qs('#toast');
      el.textContent = msg;
      el.style.display = 'block';
      setTimeout(() => el.style.display = 'none', 3000);
    };
    const modal = {
      open(title, text) {
        qs('#modalTitle').textContent = title;
        qs('#modalText').textContent = text;
        qs('#modal').style.display = 'flex';
      },
      close() {
        qs('#modal').style.display = 'none';
      }
    };

    // --- Mock Data (à remplacer par vos appels API) ---
    const state = {
      user: {
        id: 'CLT-000245',
        firstName: 'Ahoua',
        lastName: 'Konan'
      },
      accounts: [{
          id: 'ACC-001',
          name: 'Compte courant',
          iban: 'CI62-0001-2345-6789',
          currency: 'XOF',
          balance: 4523000.50
        },
        {
          id: 'ACC-002',
          name: 'Épargne',
          iban: 'CI62-0001-9876-5432',
          currency: 'XOF',
          balance: 12500000.00
        },
        {
          id: 'ACC-003',
          name: 'USD Wallet',
          iban: 'US12-6789-0000-1111',
          currency: 'USD',
          balance: 930.40
        },
      ],
      cards: [{
          id: 'CARD-1',
          masked: '**** **** **** 2415',
          type: 'Visa',
          status: 'active',
          account: 'ACC-001'
        },
        {
          id: 'CARD-2',
          masked: '**** **** **** 9932',
          type: 'Mastercard',
          status: 'active',
          account: 'ACC-002'
        },
      ],
      transactions: [{
          id: 1,
          date: '2025-08-15',
          label: 'Dépôt agence',
          type: 'credit',
          amount: 200000,
          account: 'ACC-001'
        },
        {
          id: 2,
          date: '2025-08-14',
          label: 'Retrait DAB',
          type: 'debit',
          amount: -30000,
          account: 'ACC-001'
        },
        {
          id: 3,
          date: '2025-08-13',
          label: 'Transfert vers Épargne',
          type: 'debit',
          amount: -150000,
          account: 'ACC-001'
        },
        {
          id: 4,
          date: '2025-08-10',
          label: 'Salaire',
          type: 'credit',
          amount: 850000,
          account: 'ACC-001'
        },
        {
          id: 5,
          date: '2025-08-08',
          label: 'Paiement facture électricité',
          type: 'debit',
          amount: -42000,
          account: 'ACC-001'
        },
        {
          id: 6,
          date: '2025-08-07',
          label: 'Virement reçu – K. Koffi',
          type: 'credit',
          amount: 120000,
          account: 'ACC-002'
        },
        {
          id: 7,
          date: '2025-08-06',
          label: 'Achat boutique',
          type: 'debit',
          amount: -18000,
          account: 'ACC-002'
        },
        {
          id: 8,
          date: '2025-08-03',
          label: 'Conversion USD',
          type: 'debit',
          amount: -100,
          account: 'ACC-003'
        },
        {
          id: 9,
          date: '2025-08-02',
          label: 'Vente en ligne',
          type: 'credit',
          amount: 250,
          account: 'ACC-003'
        },
      ],
      messages: [{
          id: 'M1',
          from: 'Support',
          text: 'Votre demande #2451 a été reçue.',
          date: '2025-08-12'
        },
        {
          id: 'M2',
          from: 'Support',
          text: 'Mise à jour de sécurité le 20/08.',
          date: '2025-08-16'
        },
      ]
    };

    // --- Routing (views) ---
    function show(view) {
      qsa('[id^="view-"]').forEach(v => v.hidden = true);
      qs(`#view-${view}`).hidden = false;
      qsa('.nav-link').forEach(a => a.classList.toggle('active', a.dataset.view === view));
      if (window.innerWidth < 641) qs('#sidebar').classList.remove('open');
    }

    // --- Renderers ---
    function renderOverview() {
      qs('#today').textContent = todayLong();
      qs('#userFirstName').textContent = state.user.firstName;
      // Totaux
      const total = state.accounts.reduce((s, a) => s + (a.currency === 'XOF' ? a.balance : a.balance * (a.currency === 'USD' ? 600 : 655)), 0);
      qs('#totalBalance').textContent = money(total, 'XOF');
      qs('#totalAccounts').textContent = `${state.accounts.length} comptes`;
      const credits30 = state.transactions.filter(t => t.type === 'credit').reduce((s, t) => s + Math.abs(t.amount), 0);
      const debits30 = state.transactions.filter(t => t.type === 'debit').reduce((s, t) => s + Math.abs(t.amount), 0);
      qs('#income30').textContent = money(credits30, 'XOF');
      qs('#spent30').textContent = money(debits30, 'XOF');

      // Dernières tx
      const tbody = qs('#lastTxTable tbody');
      tbody.innerHTML = '';
      state.transactions.slice(0, 6).forEach(t => {
        const tr = document.createElement('tr');
        tr.innerHTML = `<td>${fmtDate(t.date)}</td><td>${t.label}</td><td>${t.type==='credit'?'Crédit':'Débit'}</td><td>${money(Math.abs(t.amount), t.currency||'XOF')}</td><td>${t.account}</td>`;
        tbody.appendChild(tr);
      });

      // Cartes
      const list = qs('#cardsList');
      list.innerHTML = '';
      state.cards.forEach(c => {
        const el = document.createElement('div');
        el.style.cssText = 'background:#0b1220;border:1px solid var(--border);border-radius:12px;padding:12px;margin-bottom:8px';
        el.innerHTML = `<div style="display:flex;justify-content:space-between;align-items:center"><div><strong>${c.type}</strong><div class="sub">${c.masked}</div></div><span class="badge">${c.status}</span></div>`;
        list.appendChild(el);
      });
    }

    function renderAccounts() {
      const grid = qs('#accountsGrid');
      grid.innerHTML = '';
      state.accounts.forEach(a => {
        const card = document.createElement('div');
        card.className = 'card col-4';
        card.innerHTML = `<h3>${a.name}</h3>
          <div class="stat">${money(a.balance, a.currency)}</div>
          <div class="sub">${a.iban}</div>
          <div style="display:flex; gap:8px; margin-top:10px">
            <button class="btn primary" data-action="transfer" data-id="${a.id}">Virement</button>
            <button class="btn ghost" data-action="details" data-id="${a.id}">Détails</button>
          </div>`;
        grid.appendChild(card);
      });
    }

    function populateAccountSelects() {
      const sel = qs('#fromAccount');
      sel.innerHTML = '';
      state.accounts.forEach(a => {
        const o = document.createElement('option');
        o.value = a.id;
        o.textContent = `${a.name} – ${money(a.balance, a.currency)}`;
        sel.appendChild(o);
      });
      // Filtres
      const f = qs('#filterAccount');
      f.innerHTML = '<option value="">Tous comptes</option>';
      state.accounts.forEach(a => {
        const o = document.createElement('option');
        o.value = a.id;
        o.textContent = `${a.name}`;
        f.appendChild(o);
      });
    }

    function renderTransactions(list = state.transactions) {
      const tbody = qs('#txTable tbody');
      tbody.innerHTML = '';
      list.forEach(t => {
        const tr = document.createElement('tr');
        tr.innerHTML = `<td>${fmtDate(t.date)}</td><td>${t.label}</td><td>${t.type==='credit'?'Crédit':'Débit'}</td><td>${money(Math.abs(t.amount), t.currency||'XOF')}</td><td>${t.account}</td>`;
        tbody.appendChild(tr);
      });
    }

    function renderMessages() {
      const wrap = qs('#messages');
      wrap.innerHTML = '';
      state.messages.forEach(m => {
        const card = document.createElement('div');
        card.className = 'card';
        card.innerHTML = `<div style="display:flex;justify-content:space-between"><strong>${m.from}</strong><span class="sub">${fmtDate(m.date)}</span></div><p style="margin:8px 0 0">${m.text}</p>`;
        wrap.appendChild(card);
      });
      qs('#badgeSupport').textContent = state.messages.length;
    }

    // --- Filters & Export ---
    function applyTxFilters() {
      const acc = qs('#filterAccount').value;
      const type = qs('#filterType').value;
      const q = qs('#filterQuery').value.toLowerCase();
      let list = state.transactions;
      if (acc) list = list.filter(t => t.account === acc);
      if (type) list = list.filter(t => t.type === type);
      if (q) list = list.filter(t => t.label.toLowerCase().includes(q));
      renderTransactions(list);
    }

    function exportCSV() {
      const headers = ['Date', 'Libellé', 'Type', 'Montant', 'Compte'];
      const rows = qsa('#txTable tbody tr').map(tr => [...tr.children].map(td => '"' + td.textContent.replace('"', '""') + '"'));
      const csv = [headers.map(h => '"' + h + '"').join(','), ...rows.map(r => r.join(','))].join('\n');
      const blob = new Blob([csv], {
        type: 'text/csv;charset=utf-8;'
      });
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = 'transactions.csv';
      a.click();
      URL.revokeObjectURL(url);
      toast('Export CSV prêt ✅');
    }

    // --- Forms handlers ---
    function onTransferSubmit(e) {
      e.preventDefault();
      const from = qs('#fromAccount').value;
      const iban = qs('#toIban').value.trim();
      const amount = parseFloat(qs('#amount').value);
      const cur = qs('#currency').value;
      if (!from || !iban || !(amount > 0)) return toast('Veuillez compléter le formulaire.');
      const acc = state.accounts.find(a => a.id === from);
      if (!acc) return toast('Compte introuvable.');
      if (acc.balance < amount && acc.currency === cur) return toast('Solde insuffisant.');
      modal.open('Confirmer le virement', `${money(amount, cur)} vers ${iban}. Continuer ?`);
      const ok = () => {
        // Mock: MAJ solde et ajout transaction
        acc.balance -= amount;
        state.transactions.unshift({
          id: Date.now(),
          date: new Date().toISOString().slice(0, 10),
          label: qs('#label').value || 'Virement sortant',
          type: 'debit',
          amount: -amount,
          account: acc.id
        });
        renderOverview();
        renderAccounts();
        applyTxFilters();
        populateAccountSelects();
        toast('Virement envoyé ✅');
        modal.close();
        e.target.reset();
        show('overview');
        qs('#modalOk').removeEventListener('click', ok);
        qs('#modalCancel').removeEventListener('click', cancel);
      };
      const cancel = () => {
        modal.close();
        qs('#modalOk').removeEventListener('click', ok);
        qs('#modalCancel').removeEventListener('click', cancel);
      };
      qs('#modalOk').addEventListener('click', ok);
      qs('#modalCancel').addEventListener('click', cancel);
    }

    function onLoanChange() {
      const a = parseFloat(qs('#loanAmount').value || 0);
      const m = parseInt(qs('#loanTerm').value || 0, 10);
      if (!a || !m) return qs('#loanSimu').textContent = 'Entrez montant et durée…';
      const i = 0.12 / 12; // 12% / an
      const mensualite = (a * i) / (1 - Math.pow(1 + i, -m));
      const total = mensualite * m;
      qs('#loanSimu').textContent = `Mensualité estimée: ${money(mensualite,'XOF')} • Coût total: ${money(total,'XOF')}`;
    }

    // --- Global events ---
    function initEvents() {
      // Navigation
      qsa('.nav-link').forEach(a => a.addEventListener('click', (e) => {
        e.preventDefault();
        show(a.dataset.view);
      }));
      qsa('[data-view]').forEach(btn => btn.addEventListener('click', () => show(btn.dataset.view)));
      // Sidebar toggle (mobile)
      qs('#menuBtn').addEventListener('click', () => qs('#sidebar').classList.toggle('open'));
      // Theme toggle
      qs('#themeBtn').addEventListener('click', () => document.body.classList.toggle('light'));
      // Search (simple highlight via filter)
      qs('#searchInput').addEventListener('input', () => {
        qs('#filterQuery').value = qs('#searchInput').value;
        applyTxFilters();
      });
      // Accounts grid CTA
      qs('#accountsGrid').addEventListener('click', (e) => {
        const btn = e.target.closest('button[data-action]');
        if (!btn) return;
        if (btn.dataset.action === 'transfer') {
          show('transfer');
          qs('#fromAccount').value = btn.dataset.id;
        }
        if (btn.dataset.action === 'details') {
          toast('Détails du compte ' + btn.dataset.id);
        }
      });
      // Filters
      ['filterAccount', 'filterType', 'filterQuery'].forEach(id => qs('#' + id).addEventListener('input', applyTxFilters));
      qs('#exportCsv').addEventListener('click', exportCSV);
      // Forms
      qs('#transferForm').addEventListener('submit', onTransferSubmit);
      qs('#supportForm').addEventListener('submit', (e) => {
        e.preventDefault();
        const txt = qs('#supportMsg').value.trim();
        if (!txt) return;
        state.messages.unshift({
          id: Date.now(),
          from: 'Vous',
          text: txt,
          date: new Date().toISOString().slice(0, 10)
        });
        renderMessages();
        e.target.reset();
        toast('Message envoyé ✅');
      });
      qs('#profileForm').addEventListener('submit', (e) => {
        e.preventDefault();
        toast('Profil mis à jour ✅');
      });
      qs('#securityForm').addEventListener('submit', (e) => {
        e.preventDefault();
        toast('Paramètres de sécurité enregistrés ✅');
      });
      ['loanAmount', 'loanTerm'].forEach(id => qs('#' + id).addEventListener('input', onLoanChange));
      // Logout
      qs('#logout').addEventListener('click', (e) => {
        e.preventDefault();
        toast('Déconnecté (démo)');
      });
    }

    // --- Init ---
    function init() {
      qs('#avatar').textContent = `${state.user.firstName[0]}${state.user.lastName[0]}`.toUpperCase();
      populateAccountSelects();
      renderOverview();
      renderAccounts();
      renderTransactions();
      renderMessages();
      initEvents();
    }

    document.addEventListener('DOMContentLoaded', init);
  </script>

  <style>
    /* Light theme (toggle) */
    body.light {
      --bg: #f5f7fb;
      --panel: #fff;
      --text: #0f172a;
      --muted: #475569;
      --border: #e5e7eb;
      --ring: rgba(2, 132, 199, .25);
    }

    body.light .logo {
      color: #02222e;
    }

    body.light tbody tr:hover {
      background: #f1f5f9;
    }

    body.light .btn.primary,
    body.light .btn.success,
    body.light .btn.danger {
      color: white;
    }
  </style>
</body>

</html>
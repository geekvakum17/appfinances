<?php
// Variables globales de configuration

// URL de base de l'application (à adapter selon l'environnement)
define('BASE_URL', 'http://localhost:8888/appfinances/');
define('BASE_REDIRECT', 'location:' . BASE_URL);

// Si tu souhaites basculer facilement entre local et production,
// tu peux utiliser une variable d'environnement (ex: via .env) ou un flag ici :

// Exemple simple :
// $isProduction = false;
// if ($isProduction) {
//     define('BASE_URL', 'https://app.ahlydarelsalamfinance.com/');
//     define('BASE_REDIRECT', 'location:' . BASE_URL);
// }

// Usage :
// header(BASE_REDIRECT);

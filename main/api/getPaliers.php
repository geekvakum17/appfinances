<?php
// main/api/getPaliers.php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../models/dependances.php';
require_once __DIR__ . '/../models/request/UserRequest.php';

try {
  // $UserRequest = new UserRequest(); // instanciation si nécessaire
  $paliers = $UserRequest->getPaliersPret();

  echo json_encode([
    'success' => true,
    'paliers' => $paliers
  ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode([
    'success' => false,
    'message' => $e->getMessage()
  ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}

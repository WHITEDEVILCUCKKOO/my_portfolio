<?php
// Edit database credentials here.
const ABH_DB_HOST = 'localhost';
const ABH_DB_NAME = 'abhi_portfolio';
const ABH_DB_USER = 'root';
const ABH_DB_PASS = '';
session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax', 'secure' => !empty($_SERVER['HTTPS'])]);
if (session_status() === PHP_SESSION_NONE) session_start();
$abhPdo = new PDO('mysql:host=' . ABH_DB_HOST . ';dbname=' . ABH_DB_NAME . ';charset=utf8mb4', ABH_DB_USER, ABH_DB_PASS,
  [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false]);
function abh_e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function abh_csrf() { if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32)); return $_SESSION['csrf']; }
function abh_csrf_ok() { return isset($_POST['csrf'], $_SESSION['csrf']) && hash_equals($_SESSION['csrf'], (string)$_POST['csrf']); }
function abh_url($u) { return preg_match('~^https?://~i', $u) ? $u : ''; }
function abh_path($u) { return preg_match('~^(https?://|assets/)~i', $u) ? $u : ''; }

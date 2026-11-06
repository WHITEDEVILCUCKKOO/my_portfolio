<?php
// One-time: creates the first admin. DELETE THIS FILE after use.
require __DIR__ . '/../config.php';
if ($abhPdo->query('SELECT COUNT(*) FROM admins')->fetchColumn() > 0) { http_response_code(403); exit('Admin already exists. Delete setup.php.'); }
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && abh_csrf_ok()) {
  $u = trim($_POST['username'] ?? ''); $p = (string)($_POST['password'] ?? '');
  if (!preg_match('/^[A-Za-z0-9_.-]{3,50}$/', $u) || strlen($p) < 12) $msg = 'Username: 3-50 letters/numbers. Password: at least 12 characters.';
  else { $abhPdo->prepare('INSERT INTO admins(username,password_hash) VALUES(?,?)')->execute([$u, password_hash($p, PASSWORD_DEFAULT)]); exit('Admin created. Delete admin/setup.php now, then <a href="login.php">log in</a>.'); }
}
?><!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Setup</title><link rel="stylesheet" href="../assets/style.css"></head>
<body class="abh-body"><div class="abh-adm"><h1 class="abh-h2">Create admin</h1><p class="abh-bad" <?= $msg ? '' : 'hidden' ?>><?= abh_e($msg) ?></p>
<form method="post"><input type="hidden" name="csrf" value="<?= abh_e(abh_csrf()) ?>"><label>Username<input name="username" required></label><label>Password (12+ characters)<input type="password" name="password" required minlength="12" autocomplete="new-password"></label><button>Create admin</button></form></div></body></html>

<?php
require __DIR__ . '/../config.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!abh_csrf_ok()) $msg = 'Session expired. Try again.';
  elseif (($_SESSION['tries'] ?? 0) >= 5 && time() - ($_SESSION['last'] ?? 0) < 300) $msg = 'Too many attempts. Wait 5 minutes.';
  else {
    $s = $abhPdo->prepare('SELECT id, password_hash FROM admins WHERE username = ?'); $s->execute([trim($_POST['username'] ?? '')]); $a = $s->fetch();
    if ($a && password_verify((string)($_POST['password'] ?? ''), $a['password_hash'])) { session_regenerate_id(true); $_SESSION['admin'] = (int)$a['id']; $_SESSION['tries'] = 0; header('Location: index.php'); exit; }
    $_SESSION['tries'] = ($_SESSION['tries'] ?? 0) + 1; $_SESSION['last'] = time(); $msg = 'Invalid username or password.';
  }
}
?><!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex"><title>Admin login</title><link rel="stylesheet" href="../assets/style.css"></head>
<body class="abh-body"><div class="abh-adm"><h1 class="abh-h2">Admin login</h1><p class="abh-bad" <?= $msg ? '' : 'hidden' ?>><?= abh_e($msg) ?></p>
<form method="post"><input type="hidden" name="csrf" value="<?= abh_e(abh_csrf()) ?>"><label>Username<input name="username" required autocomplete="username"></label><label>Password<input type="password" name="password" required autocomplete="current-password"></label><button>Log in</button></form></div></body></html>

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
?><!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex"><title>Admin login</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Space+Grotesk:wght@700&display=swap" rel="stylesheet"><script>try{var tt=localStorage.getItem('abhTheme');document.documentElement.setAttribute('data-theme',tt==='light'?'light':'dark')}catch(e){document.documentElement.setAttribute('data-theme','dark')}</script><link rel="stylesheet" href="../assets/admin.css"></head>
<body class="abm-body"><button type="button" class="abm-btn" data-abh-theme-btn style="position:fixed;top:1rem;right:1rem;z-index:5"></button><div class="abm-auth"><div class="abm-auth-card">
<div class="abm-brand">Abhi<span>.</span> admin</div><h1 class="abm-h" style="font-size:1.6rem;margin-bottom:1.2rem">Welcome back</h1>
<?php if ($msg): ?><p class="abm-toast abm-bad" style="animation:none"><?= abh_e($msg) ?></p><?php endif; ?>
<form class="abm-form" method="post"><input type="hidden" name="csrf" value="<?= abh_e(abh_csrf()) ?>">
<label>Username<input name="username" required autocomplete="username"></label>
<label>Password<input type="password" name="password" required autocomplete="current-password"></label>
<button class="abm-btn abm-btn-acc" style="justify-content:center">Log in</button></form></div></div><script src="../assets/ui.js"></script></body></html>

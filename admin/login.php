<?php
require __DIR__ . '/../config.php';
require_once __DIR__ . '/functions/logs.php';

// Record login activity in the same terminal_log table used by terminal-auth.php.
function abm_login_audit(PDO $pdo, string $event, ?int $adminId, string $detail): void {
  try {
    admin_logs_ensure($pdo);
    $ip = substr((string)($_SERVER['REMOTE_ADDR'] ?? ''), 0, 45);
    $ipHash = hash('sha256', ($ip ?: '0') . '|abh-term');
    $ua = substr((string)($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 255);
    $stmt = $pdo->prepare('INSERT INTO terminal_log (event, admin_id, detail, ip_hash, ip, user_agent) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$event, $adminId, substr($detail, 0, 255), $ipHash, $ip, $ua]);
  } catch (Throwable $e) {
    error_log('Admin login audit error: ' . $e->getMessage());
  }
}

require_once __DIR__ . '/functions/security.php';

$msg = '';
$ip = abm_security_ip();
$remaining = abm_security_remaining($abhPdo, $ip);
if ($remaining > 0) {
  http_response_code(429);
  $msg = 'Too many failed attempts. Try again in ' . ceil($remaining / 60) . ' minutes.';
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $remaining === 0) {
  if (!abh_csrf_ok()) {
    $msg = 'Session expired. Refresh the page and try again.';
  } else {
    $username = trim((string)($_POST['username'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    $s = $abhPdo->prepare('SELECT id, password_hash FROM admins WHERE username = ?');
    $s->execute([$username]);
    $a = $s->fetch(PDO::FETCH_ASSOC);
    $valid = $a && password_verify($password, (string)$a['password_hash']);
    // Check again after verification so an already blocked IP cannot reset its counter.
    $remaining = abm_security_remaining($abhPdo, $ip);
    if ($remaining > 0) {
      http_response_code(429);
      $msg = 'Too many failed attempts. Try again later.';
    } elseif ($valid) {
      abm_security_success($abhPdo, $ip);
      session_regenerate_id(true);
      $_SESSION['admin'] = (int)$a['id'];
      $_SESSION['tries'] = 0;
      abm_login_audit($abhPdo, 'login_ok', (int)$a['id'], 'admin login user=' . $username);
      header('Location: index.php');
      exit;
    } else {
      $remaining = abm_security_fail($abhPdo, $ip);
      abm_login_audit($abhPdo, 'login_fail', $a ? (int)$a['id'] : null, 'admin login user=' . $username);
      if ($remaining > 0) {
        http_response_code(429);
        abm_login_audit($abhPdo, 'login_block', $a ? (int)$a['id'] : null, 'admin login IP blocked');
        $msg = 'Too many failed attempts. This IP is blocked for 3 hours.';
      } else {
        $msg = 'Invalid username or password.';
      }
    }
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

<?php
require __DIR__ . '/config.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php#contact'); exit; }
if (!abh_csrf_ok()) { header('Location: index.php?err=3#contact'); exit; }
if (!empty($_POST['abh_hp_x'])) { header('Location: index.php?err=1#contact'); exit; } // honeypot (bots only)
$f = [];
foreach (['name', 'email', 'phone', 'subject', 'message'] as $k) $f[$k] = trim((string)($_POST[$k] ?? ''));
$bad = mb_strlen($f['name']) < 2 || mb_strlen($f['name']) > 100
  || !filter_var($f['email'], FILTER_VALIDATE_EMAIL) || mb_strlen($f['email']) > 150
  || ($f['phone'] !== '' && !preg_match('/^[+\d][\d\s()-]{6,25}$/', $f['phone']))
  || mb_strlen($f['subject']) < 3 || mb_strlen($f['subject']) > 150
  || mb_strlen($f['message']) < 10 || mb_strlen($f['message']) > 3000;
if ($bad) { header('Location: index.php?err=1#contact'); exit; }
if (abh_wait_left($abhPdo) > 0) { header('Location: index.php?wait=1#contact'); exit; }
try {
  $abhPdo->prepare('INSERT INTO messages(name,email,phone,subject,message) VALUES(?,?,?,?,?)')->execute(array_values($f));
  $abhPdo->prepare('REPLACE INTO contact_limits(ip_hash,last_at) VALUES(?,?)')->execute([abh_ip_hash(), time()]);
} catch (Throwable $e) { header('Location: index.php?err=2#contact'); exit; }
header('Location: index.php?sent=1#contact');

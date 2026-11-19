<?php
require __DIR__ . '/../config.php';
require_once __DIR__ . '/functions/logs.php';
if (!empty($_SESSION['admin'])) {
  try {
    admin_logs_ensure($abhPdo);
    $ip = substr((string)($_SERVER['REMOTE_ADDR'] ?? ''), 0, 45);
    $stmt = $abhPdo->prepare('INSERT INTO terminal_log (event, admin_id, detail, ip_hash, ip, user_agent) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute(['logout', (int)$_SESSION['admin'], 'admin panel logout', hash('sha256', ($ip ?: '0') . '|abh-term'), $ip, substr((string)($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 255)]);
  } catch (Throwable $e) {
    error_log('Admin logout audit error: ' . $e->getMessage());
  }
}
$_SESSION = []; session_destroy(); header('Location: login.php');

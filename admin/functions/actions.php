<?php
// Decides which function to run for a submitted form. Returns [success message, error message].

function admin_handle_post(PDO $pdo, string $t): array {
  if (!abh_csrf_ok()) { http_response_code(400); exit('Invalid request token.'); }
  $do = $_POST['do'] ?? '';
  $id = (int)($_POST['id'] ?? 0);
  $isTable = isset(admin_tables()[$t]);

  if ($t === 'security' && $do === 'unblock_ip') {
    $ip = trim((string)($_POST['ip'] ?? ''));
    if (!filter_var($ip, FILTER_VALIDATE_IP)) return ['', 'Invalid IP address.'];
    try {
      $pdo->beginTransaction();
      $q = $pdo->prepare('SELECT blocked_until FROM auth_ip_limits WHERE ip = ? FOR UPDATE');
      $q->execute([$ip]);
      $blockedUntil = $q->fetchColumn();
      if (!$blockedUntil) {
        $pdo->rollBack();
        return ['', 'This IP is not currently blocked.'];
      }
      $q = $pdo->prepare('UPDATE auth_ip_limits SET failed_attempts = 0, first_failed_at = NULL, blocked_until = NULL WHERE ip = ?');
      $q->execute([$ip]);
      $q = $pdo->prepare('INSERT INTO security_unblock_audit (ip, admin_id, action, note) VALUES (?, ?, ?, ?)');
      $q->execute([$ip, (int)$_SESSION['admin'], 'unblock', 'Manually unblocked from admin security page']);
      $pdo->commit();
      return ['IP ' . $ip . ' unblocked successfully.', ''];
    } catch (Throwable $e) {
      if ($pdo->inTransaction()) $pdo->rollBack();
      error_log('Security unblock failed: ' . $e->getMessage());
      return ['', 'Could not unblock IP. Check database migration and server logs.'];
    }
  }
  if ($t === 'settings') {
    admin_settings_save($pdo, $_POST['s'] ?? []);
    return ['Settings saved.', ''];
  }
  if ($t === 'password') {
    $r = admin_account_update($pdo, (int)$_SESSION['admin'], $_POST);
    return $r['ok'] ? [$r['msg'], ''] : ['', $r['msg']];
  }
  if ($t === 'messages' && $do === 'del') {
    admin_message_delete($pdo, $id);
    return ['Message deleted.', ''];
  }
  if ($isTable && $do === 'del') {
    $oldScreenshot = $t === 'projects' ? (string)((admin_item_find($pdo, $t, $id)['screenshot'] ?? '')) : '';
    admin_item_delete($pdo, $t, $id);
    if ($oldScreenshot) abm_project_remove_owned($oldScreenshot);
    return ['Deleted.', ''];
  }
  if ($isTable && $do === 'save') {
    try {
      if ($t === 'projects') abm_project_save($pdo, $id, $_POST);
      else ($id ? admin_item_update($pdo, $t, $id, $_POST) : admin_item_add($pdo, $t, $_POST));
    } catch (Throwable $e) { return ['', $e->getMessage()]; }
    return ['Saved.', ''];
  }
  return ['', ''];
}

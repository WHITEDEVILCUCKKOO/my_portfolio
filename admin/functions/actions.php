<?php
// Decides which function to run for a submitted form. Returns [success message, error message].

function admin_handle_post(PDO $pdo, string $t): array {
  if (!abh_csrf_ok()) { http_response_code(400); exit('Invalid request token.'); }
  $do = $_POST['do'] ?? '';
  $id = (int)($_POST['id'] ?? 0);
  $isTable = isset(admin_tables()[$t]);

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
    admin_item_delete($pdo, $t, $id);
    return ['Deleted.', ''];
  }
  if ($isTable && $do === 'save') {
    $id ? admin_item_update($pdo, $t, $id, $_POST) : admin_item_add($pdo, $t, $_POST);
    return ['Saved.', ''];
  }
  return ['', ''];
}

<?php
// Site settings (key / value pairs shown on the public site).

/** All settings rows. */
function admin_settings_all(PDO $pdo): array {
  return $pdo->query('SELECT * FROM settings ORDER BY skey')->fetchAll();
}

/** UPDATE settings. Only keys that already exist are changed. */
function admin_settings_save(PDO $pdo, array $values): void {
  $u = $pdo->prepare('UPDATE settings SET svalue = ? WHERE skey = ?');
  foreach ($values as $key => $val) $u->execute([trim((string)$val), (string)$key]);
}

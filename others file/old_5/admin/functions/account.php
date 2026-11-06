<?php
// Change the admin's login email and/or password.

/** UPDATE the logged-in admin. Returns ['ok' => bool, 'msg' => string]. */
function admin_account_update(PDO $pdo, int $adminId, array $post): array {
  $s = $pdo->prepare('SELECT password_hash FROM admins WHERE id = ?');
  $s->execute([$adminId]);
  $hash = $s->fetchColumn();
  $cur = (string)($post['current'] ?? '');
  $new = (string)($post['new'] ?? '');
  $user = trim((string)($post['username'] ?? ''));

  if (!$hash || !password_verify($cur, $hash)) return ['ok' => false, 'msg' => 'Current password is incorrect.'];
  if (!preg_match('/^[A-Za-z0-9_.@+-]{3,100}$/', $user)) return ['ok' => false, 'msg' => 'Enter a valid login email or username (3-100 characters, no spaces).'];
  if ($new !== '' && strlen($new) < 12) return ['ok' => false, 'msg' => 'New password must be at least 12 characters.'];
  if ($new !== '' && $new !== (string)($post['confirm'] ?? '')) return ['ok' => false, 'msg' => 'New passwords do not match.'];
  if ($new !== '' && $new === $cur) return ['ok' => false, 'msg' => 'New password must be different from the current one.'];

  try {
    $pdo->prepare('UPDATE admins SET username = ?, password_hash = ? WHERE id = ?')
        ->execute([$user, $new !== '' ? password_hash($new, PASSWORD_DEFAULT) : $hash, $adminId]);
  } catch (PDOException $e) {
    return ['ok' => false, 'msg' => 'That login is already in use.'];
  }
  session_regenerate_id(true);
  return ['ok' => true, 'msg' => 'Account updated.'];
}

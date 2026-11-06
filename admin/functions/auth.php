<?php
// Login check and current admin details.

/** Send the visitor to the login page unless an admin is logged in. */
function admin_require_login(): void {
  if (empty($_SESSION['admin'])) { header('Location: login.php'); exit; }
}

/** Login email/username of the logged-in admin. */
function admin_username(PDO $pdo): string {
  $s = $pdo->prepare('SELECT username FROM admins WHERE id = ?');
  $s->execute([$_SESSION['admin']]);
  return (string)$s->fetchColumn();
}

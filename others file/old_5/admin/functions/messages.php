<?php
// Contact-form messages.

/** Total number of messages. */
function admin_messages_count(PDO $pdo): int {
  return (int)$pdo->query('SELECT COUNT(*) FROM messages')->fetchColumn();
}

/** Newest messages first. */
function admin_messages_all(PDO $pdo, int $limit = 200): array {
  $s = $pdo->prepare('SELECT * FROM messages ORDER BY id DESC LIMIT ?');
  $s->bindValue(1, $limit, PDO::PARAM_INT);
  $s->execute();
  return $s->fetchAll();
}

/** The latest few messages (dashboard). */
function admin_messages_latest(PDO $pdo, int $n = 3): array {
  return admin_messages_all($pdo, $n);
}

/** DELETE one message. */
function admin_message_delete(PDO $pdo, int $id): void {
  $pdo->prepare('DELETE FROM messages WHERE id = ?')->execute([$id]);
}

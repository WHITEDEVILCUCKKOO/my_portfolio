<?php
// Add / update / delete / read for projects, skills, services and experience.
// Table and column names only ever come from admin_tables() (a fixed whitelist); values are always bound parameters.

/** Stop immediately if the table name is not in the whitelist. */
function admin_assert_table(string $t): void {
  if (!isset(admin_tables()[$t])) { http_response_code(400); exit('Unknown table.'); }
}

/** Clean one submitted value according to its field type. */
function admin_clean_value(string $type, $raw) {
  $x = trim((string)$raw);
  if ($type === 'int')  return (int)$x;
  if ($type === 'url')  return abh_url($x);
  if ($type === 'path') return abh_path($x);
  return mb_substr($x, 0, $type === 'area' ? 2000 : 255);
}

/** Cleaned values for every column of the table, in column order. */
function admin_item_values(string $t, array $post): array {
  $values = [];
  foreach (admin_tables()[$t] as $col => $type) $values[] = admin_clean_value($type, $post[$col] ?? '');
  return $values;
}

/** ADD a new row. */
function admin_item_add(PDO $pdo, string $t, array $post): void {
  admin_assert_table($t);
  $cols = array_keys(admin_tables()[$t]);
  $sql = "INSERT INTO `$t` (`" . implode('`,`', $cols) . '`) VALUES (' . implode(',', array_fill(0, count($cols), '?')) . ')';
  $pdo->prepare($sql)->execute(admin_item_values($t, $post));
}

/** UPDATE an existing row. */
function admin_item_update(PDO $pdo, string $t, int $id, array $post): void {
  admin_assert_table($t);
  $set = implode(',', array_map(fn($c) => "`$c` = ?", array_keys(admin_tables()[$t])));
  $pdo->prepare("UPDATE `$t` SET $set WHERE id = ?")->execute([...admin_item_values($t, $post), $id]);
}

/** DELETE a row. */
function admin_item_delete(PDO $pdo, string $t, int $id): void {
  admin_assert_table($t);
  $pdo->prepare("DELETE FROM `$t` WHERE id = ?")->execute([$id]);
}

/** One row by id, or null. */
function admin_item_find(PDO $pdo, string $t, int $id): ?array {
  admin_assert_table($t);
  $s = $pdo->prepare("SELECT * FROM `$t` WHERE id = ?");
  $s->execute([$id]);
  return $s->fetch() ?: null;
}

/** All rows of a table in display order. */
function admin_items_all(PDO $pdo, string $t): array {
  admin_assert_table($t);
  $order = isset(admin_tables()[$t]['sort_order']) ? 'sort_order, id' : 'id';
  return $pdo->query("SELECT * FROM `$t` ORDER BY $order")->fetchAll();
}

/** Number of rows in a table. */
function admin_items_count(PDO $pdo, string $t): int {
  admin_assert_table($t);
  return (int)$pdo->query("SELECT COUNT(*) FROM `$t`")->fetchColumn();
}

/** [title column, subtitle column] used on the cards. */
function admin_item_labels(string $t): array {
  $cols = array_keys(admin_tables()[$t]);
  return $t === 'skills' ? ['name', 'category'] : [$cols[0], $cols[1]];
}

/** Counts shown on the dashboard: every table plus messages. */
function admin_dashboard_counts(PDO $pdo): array {
  $out = [];
  foreach (array_keys(admin_tables()) as $t) $out[$t] = admin_items_count($pdo, $t);
  $out['messages'] = admin_messages_count($pdo);
  return $out;
}

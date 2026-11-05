<?php
require __DIR__ . '/../config.php';
if (empty($_SESSION['admin'])) { header('Location: login.php'); exit; }
// Whitelist of editable tables and fields (names below are the only ones ever put in SQL).
$T = [
 'projects'   => ['name'=>'text','category'=>'text','description'=>'area','tech'=>'text','live_url'=>'url','screenshot'=>'path','sort_order'=>'int'],
 'skills'     => ['category'=>'text','name'=>'text'],
 'services'   => ['title'=>'text','sort_order'=>'int'],
 'experience' => ['role'=>'text','company'=>'text','period'=>'text','details'=>'area','sort_order'=>'int'],
];
$t = $_GET['t'] ?? 'projects';
if (!isset($T[$t]) && $t !== 'settings' && $t !== 'messages') $t = 'projects';
$note = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!abh_csrf_ok()) { http_response_code(400); exit('Invalid request token.'); }
  $do = $_POST['do'] ?? '';
  if ($t === 'settings') {
    $u = $abhPdo->prepare('UPDATE settings SET svalue = ? WHERE skey = ?');
    foreach (($_POST['s'] ?? []) as $k => $val) $u->execute([trim((string)$val), (string)$k]);
    $note = 'Saved.';
  } elseif ($t === 'messages' && $do === 'del') {
    $abhPdo->prepare('DELETE FROM messages WHERE id = ?')->execute([(int)$_POST['id']]); $note = 'Deleted.';
  } elseif (isset($T[$t]) && $do === 'del') {
    $abhPdo->prepare("DELETE FROM `$t` WHERE id = ?")->execute([(int)$_POST['id']]); $note = 'Deleted.';
  } elseif (isset($T[$t]) && $do === 'save') {
    $vals = [];
    foreach ($T[$t] as $c => $ty) {
      $x = trim((string)($_POST[$c] ?? ''));
      $vals[] = $ty === 'int' ? (int)$x : ($ty === 'url' ? abh_url($x) : ($ty === 'path' ? abh_path($x) : ($ty === 'area' ? mb_substr($x, 0, 2000) : mb_substr($x, 0, 255))));
    }
    $cols = array_keys($T[$t]); $id = (int)($_POST['id'] ?? 0);
    if ($id) $abhPdo->prepare("UPDATE `$t` SET " . implode(',', array_map(fn($c) => "`$c` = ?", $cols)) . ' WHERE id = ?')->execute([...$vals, $id]);
    else $abhPdo->prepare("INSERT INTO `$t` (`" . implode('`,`', $cols) . '`) VALUES (' . implode(',', array_fill(0, count($cols), '?')) . ')')->execute($vals);
    $note = 'Saved.';
  }
}
$tok = abh_e(abh_csrf());
?><!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex"><title>Admin</title><link rel="stylesheet" href="../assets/style.css"></head>
<body class="abh-body"><div class="abh-adm">
<h1 class="abh-h2">Admin panel</h1>
<nav class="abh-adm-nav"><?php foreach (array_merge(array_keys($T), ['settings', 'messages']) as $n): ?><a href="?t=<?= $n ?>"<?= $n === $t ? ' style="border-color:#00D4FF"' : '' ?>><?= ucfirst($n) ?></a><?php endforeach; ?><a href="../index.php" target="_blank">View site</a><a href="logout.php">Log out</a></nav>
<?php if ($note): ?><p class="abh-ok" role="status"><?= $note ?></p><?php endif; ?>

<?php if ($t === 'settings'): ?>
<form method="post"><input type="hidden" name="csrf" value="<?= $tok ?>">
<?php foreach ($abhPdo->query('SELECT * FROM settings ORDER BY skey') as $r): ?><label><?= abh_e($r['skey']) ?><textarea name="s[<?= abh_e($r['skey']) ?>]" rows="2"><?= abh_e($r['svalue']) ?></textarea></label><?php endforeach; ?>
<button>Save settings</button></form>

<?php elseif ($t === 'messages'): ?>
<table><tr><th>From</th><th>Message</th><th></th></tr>
<?php foreach ($abhPdo->query('SELECT * FROM messages ORDER BY id DESC LIMIT 200') as $m): ?>
<tr><td><?= abh_e($m['name']) ?><br><?= abh_e($m['email']) ?><br><?= abh_e($m['phone']) ?><br><small><?= abh_e($m['created_at']) ?></small></td><td><strong><?= abh_e($m['subject']) ?></strong><br><?= nl2br(abh_e($m['message'])) ?></td>
<td><form method="post" class="abh-inline"><input type="hidden" name="csrf" value="<?= $tok ?>"><input type="hidden" name="do" value="del"><input type="hidden" name="id" value="<?= (int)$m['id'] ?>"><button class="abh-danger">Delete</button></form></td></tr>
<?php endforeach; ?></table>

<?php else:
  $edit = null;
  if (isset($_GET['edit'])) { $s = $abhPdo->prepare("SELECT * FROM `$t` WHERE id = ?"); $s->execute([(int)$_GET['edit']]); $edit = $s->fetch() ?: null; }
  $order = isset($T[$t]['sort_order']) ? 'sort_order, id' : 'id';
?>
<h2 class="abh-h3"><?= $edit ? 'Edit' : 'Add' ?> <?= $t ?></h2>
<form method="post"><input type="hidden" name="csrf" value="<?= $tok ?>"><input type="hidden" name="do" value="save"><input type="hidden" name="id" value="<?= (int)($edit['id'] ?? 0) ?>">
<?php foreach ($T[$t] as $c => $ty): $val = abh_e($edit[$c] ?? ($ty === 'int' ? 0 : '')); ?>
<label><?= $c ?><?php if ($ty === 'area'): ?><textarea name="<?= $c ?>" rows="4"><?= $val ?></textarea><?php else: ?><input name="<?= $c ?>" value="<?= $val ?>" type="<?= $ty === 'int' ? 'number' : 'text' ?>"><?php endif; ?></label>
<?php endforeach; ?>
<button>Save</button></form>
<table><?php foreach ($abhPdo->query("SELECT * FROM `$t` ORDER BY $order") as $r): ?>
<tr><td><?= abh_e($r[array_key_first($T[$t])]) ?></td><td><?= abh_e($r[array_keys($T[$t])[1]] ?? '') ?></td>
<td><a href="?t=<?= $t ?>&edit=<?= (int)$r['id'] ?>">Edit</a>
<form method="post" class="abh-inline" onsubmit="return confirm('Delete this item?')"><input type="hidden" name="csrf" value="<?= $tok ?>"><input type="hidden" name="do" value="del"><input type="hidden" name="id" value="<?= (int)$r['id'] ?>"><button class="abh-danger">Delete</button></form></td></tr>
<?php endforeach; ?></table>
<?php endif; ?>
</div></body></html>

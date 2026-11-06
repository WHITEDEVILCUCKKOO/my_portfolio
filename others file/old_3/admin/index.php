<?php
require __DIR__ . '/../config.php';
if (empty($_SESSION['admin'])) {
  header('Location: login.php');
  exit;
}
// Whitelist of editable tables/fields: only these names are ever placed in SQL.
$T = [
  'projects'   => ['name' => 'text', 'category' => 'text', 'description' => 'area', 'tech' => 'text', 'live_url' => 'url', 'screenshot' => 'path', 'sort_order' => 'int'],
  'skills'     => ['category' => 'text', 'name' => 'text'],
  'services'   => ['title' => 'text', 'sort_order' => 'int'],
  'experience' => ['role' => 'text', 'company' => 'text', 'period' => 'text', 'details' => 'area', 'sort_order' => 'int'],
];
$groups = ['Overview' => ['dashboard'], 'Portfolio content' => ['projects', 'skills', 'services', 'experience'], 'Other' => ['settings', 'messages', 'password']];
$icons = [
  'dashboard' => '<rect x="3" y="3" width="8" height="8" rx="2"/><rect x="13" y="3" width="8" height="5" rx="2"/><rect x="13" y="12" width="8" height="9" rx="2"/><rect x="3" y="15" width="8" height="6" rx="2"/>',
  'projects' => '<rect x="3" y="4" width="18" height="14" rx="2"/><path d="M3 9h18"/>',
  'skills' => '<path d="m8 8-4 4 4 4M16 8l4 4-4 4"/>',
  'services' => '<path d="M12 3l2.5 5.5L20 9l-4 4 1 6-5-3-5 3 1-6-4-4 5.5-.5z"/>',
  'experience' => '<rect x="3" y="7" width="18" height="13" rx="2"/><path d="M9 7V4h6v3"/>',
  'settings' => '<circle cx="12" cy="12" r="3"/><path d="M12 3v3M12 18v3M3 12h3M18 12h3"/>',
  'messages' => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
  'password' => '<rect x="5" y="11" width="14" height="9" rx="2"/><path d="M8 11V8a4 4 0 0 1 8 0v3"/>'
];
$t = $_GET['t'] ?? 'dashboard';
if (!isset($T[$t]) && !in_array($t, ['dashboard', 'settings', 'messages', 'password'], true)) $t = 'dashboard';
$note = '';
$bad = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!abh_csrf_ok()) {
    http_response_code(400);
    exit('Invalid request token.');
  }
  $do = $_POST['do'] ?? '';
  if ($t === 'settings') {
    $u = $abhPdo->prepare('UPDATE settings SET svalue = ? WHERE skey = ?');
    foreach (($_POST['s'] ?? []) as $k => $val) $u->execute([trim((string)$val), (string)$k]);
    $note = 'Settings saved.';
  } elseif ($t === 'password') {
    $s = $abhPdo->prepare('SELECT password_hash FROM admins WHERE id = ?');
    $s->execute([$_SESSION['admin']]);
    $h = $s->fetchColumn();
    $cur = (string)($_POST['current'] ?? '');
    $new = (string)($_POST['new'] ?? '');
    $nu = trim((string)($_POST['username'] ?? ''));
    if (!$h || !password_verify($cur, $h)) $bad = 'Current password is incorrect.';
    elseif (!preg_match('/^[A-Za-z0-9_.@+-]{3,100}$/', $nu)) $bad = 'Enter a valid login email or username (3-100 characters, no spaces).';
    elseif ($new !== '' && strlen($new) < 12) $bad = 'New password must be at least 12 characters.';
    elseif ($new !== '' && $new !== (string)($_POST['confirm'] ?? '')) $bad = 'New passwords do not match.';
    elseif ($new !== '' && $new === $cur) $bad = 'New password must be different from the current one.';
    else {
      try {
        $abhPdo->prepare('UPDATE admins SET username = ?, password_hash = ? WHERE id = ?')->execute([$nu, $new !== '' ? password_hash($new, PASSWORD_DEFAULT) : $h, $_SESSION['admin']]);
        session_regenerate_id(true);
        $note = 'Account updated.';
      } catch (PDOException $e) {
        $bad = 'That login is already in use.';
      }
    }
  } elseif ($t === 'messages' && $do === 'del') {
    $abhPdo->prepare('DELETE FROM messages WHERE id = ?')->execute([(int)$_POST['id']]);
    $note = 'Message deleted.';
  } elseif (isset($T[$t]) && $do === 'del') {
    $abhPdo->prepare("DELETE FROM `$t` WHERE id = ?")->execute([(int)$_POST['id']]);
    $note = 'Deleted.';
  } elseif (isset($T[$t]) && $do === 'save') {
    $vals = [];
    foreach ($T[$t] as $c => $ty) {
      $x = trim((string)($_POST[$c] ?? ''));
      $vals[] = $ty === 'int' ? (int)$x : ($ty === 'url' ? abh_url($x) : ($ty === 'path' ? abh_path($x) : ($ty === 'area' ? mb_substr($x, 0, 2000) : mb_substr($x, 0, 255))));
    }
    $cols = array_keys($T[$t]);
    $id = (int)($_POST['id'] ?? 0);
    if ($id) $abhPdo->prepare("UPDATE `$t` SET " . implode(',', array_map(fn($c) => "`$c` = ?", $cols)) . ' WHERE id = ?')->execute([...$vals, $id]);
    else $abhPdo->prepare("INSERT INTO `$t` (`" . implode('`,`', $cols) . '`) VALUES (' . implode(',', array_fill(0, count($cols), '?')) . ')')->execute($vals);
    $note = 'Saved.';
  }
}
$tok = abh_e(abh_csrf());
$msgCount = (int)$abhPdo->query('SELECT COUNT(*) FROM messages')->fetchColumn();
$u = $abhPdo->prepare('SELECT username FROM admins WHERE id = ?');
$u->execute([$_SESSION['admin']]);
$uname = (string)$u->fetchColumn();
$count = isset($T[$t]) ? (int)$abhPdo->query("SELECT COUNT(*) FROM `$t`")->fetchColumn() : 0;
$subs = ['projects' => "$count projects", 'skills' => "$count skills", 'services' => "$count services", 'experience' => "$count entries", 'settings' => 'Site details, contact info and text', 'messages' => "$msgCount messages from the contact form", 'password' => 'Update your login email or password', 'dashboard' => 'Overview of your portfolio'];
$isCrud = isset($T[$t]);
$edit = null;
if ($isCrud && isset($_GET['edit'])) {
  $s = $abhPdo->prepare("SELECT * FROM `$t` WHERE id = ?");
  $s->execute([(int)$_GET['edit']]);
  $edit = $s->fetch() ?: null;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="robots" content="noindex">
  <title>Admin | <?= ucfirst($t) ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">
  <script>
    try {
      var tt = localStorage.getItem('abhTheme');
      document.documentElement.setAttribute('data-theme', tt === 'light' ? 'light' : 'dark')
    } catch (e) {
      document.documentElement.setAttribute('data-theme', 'dark')
    }
  </script>
  <link rel="stylesheet" href="../assets/admin.css">
</head>

<body class="abm-body">
  <div class="abm-ov" id="abmOv"></div>
  <div class="abm-shell">
    <aside class="abm-side" id="abmSide">
      <div class="abm-brand">Abhi<span>.</span> admin</div>
      <nav class="abm-nav" aria-label="Admin">
        <?php foreach ($groups as $g => $items): ?><div class="abm-label"><?= $g ?></div>
          <?php foreach ($items as $n): ?><a href="?t=<?= $n ?>" class="<?= $n === $t ? 'abm-on' : '' ?>"><svg viewBox="0 0 24 24" aria-hidden="true"><?= $icons[$n] ?></svg><?= $n === 'password' ? 'Change password' : ucfirst($n) ?><?php if ($n === 'messages' && $msgCount): ?><span class="abm-badge"><?= $msgCount ?></span><?php endif; ?></a><?php endforeach; ?>
        <?php endforeach; ?>
      </nav>
      <div class="abm-user"><span class="abm-av"><?= abh_e(strtoupper(mb_substr($uname, 0, 1))) ?></span><span><?= abh_e($uname) ?><br><a href="logout.php" style="color:var(--abm-redc)">Log out</a></span></div>
    </aside>
    <main class="abm-main">
      <button class="abm-btn abm-menu" id="abmMenu" aria-controls="abmSide">Menu</button>
      <div class="abm-top">
        <div>
          <h1 class="abm-h abm-title"><?= $t === 'password' ? 'Change password' : ucfirst($t) ?></h1>
          <p class="abm-sub"><?= abh_e($subs[$t]) ?></p>
        </div>
        <div class="abm-acts"><button class="abm-btn" type="button" data-abh-theme-btn></button><a class="abm-btn" href="../index.php" target="_blank" rel="noopener">View site</a><?php if ($isCrud): ?><a class="abm-btn abm-btn-blue" href="?t=<?= $t ?>&new=1">+ Add new</a><?php endif; ?></div>
      </div>
      <?php if ($note): ?><p class="abm-toast" role="status"><?= abh_e($note) ?></p><?php endif; ?>
      <?php if ($bad): ?><p class="abm-toast abm-bad" role="alert"><?= abh_e($bad) ?></p><?php endif; ?>

      <?php if ($t === 'dashboard'): ?>
        <div class="abm-stats">
          <?php foreach (array_merge(array_keys($T), ['messages']) as $i => $n): $c = (int)$abhPdo->query('SELECT COUNT(*) FROM `' . $n . '`')->fetchColumn(); ?>
            <a class="abm-stat" href="?t=<?= $n ?>" style="--i:<?= $i ?>"><svg viewBox="0 0 24 24" aria-hidden="true"><?= $icons[$n] ?></svg><strong><?= $c ?></strong><span><?= ucfirst($n) ?></span></a>
          <?php endforeach; ?>
        </div>
        <h2 class="abm-h" style="font-size:1.2rem;margin:2rem 0 1rem">Latest messages</h2>
        <?php $lm = $abhPdo->query('SELECT * FROM messages ORDER BY id DESC LIMIT 3')->fetchAll();
        if (!$lm): ?><p class="abm-sub">No messages yet.</p><?php else: ?>
          <div class="abm-grid"><?php foreach ($lm as $i => $m): ?><article class="abm-card" style="--i:<?= $i ?>">
                <div class="abm-card-b">
                  <h3><?= abh_e($m['subject']) ?></h3>
                  <p><?= abh_e($m['name']) ?> &middot; <?= abh_e($m['email']) ?></p>
                  <p class="abm-msg"><?= abh_e(mb_strimwidth($m['message'], 0, 140, '...')) ?></p>
                </div>
              </article><?php endforeach; ?></div><?php endif; ?>

      <?php elseif ($t === 'settings'): ?>
        <form class="abm-form" method="post"><input type="hidden" name="csrf" value="<?= $tok ?>">
          <div class="abm-fields">
            <?php foreach ($abhPdo->query('SELECT * FROM settings ORDER BY skey') as $r): ?><label><?= abh_e($r['skey']) ?><textarea name="s[<?= abh_e($r['skey']) ?>]" rows="2"><?= abh_e($r['svalue']) ?></textarea></label><?php endforeach; ?>
          </div><button class="abm-btn abm-btn-acc" style="justify-self:start">Save settings</button>
        </form>

      <?php elseif ($t === 'password'): ?>
        <div class="abm-info"><span><small>Current login email</small><br><strong><?= abh_e($uname) ?></strong></span><span><small>Current password</small><br><strong>&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;</strong></span><small>Passwords are stored encrypted, so the saved password cannot be shown. Type it below to confirm any change.</small></div>
        <form class="abm-form abm-form-narrow" method="post" autocomplete="off"><input type="hidden" name="csrf" value="<?= $tok ?>">
          <label>Login email<input name="username" value="<?= abh_e($uname) ?>" required maxlength="100" autocomplete="username"></label>
          <label>Current password<span class="abm-pw"><input type="password" name="current" required autocomplete="current-password"><button type="button" class="abm-eye" data-eye>Show</button></span></label>
          <label>New password (optional, 12+ characters)<span class="abm-pw"><input type="password" name="new" minlength="12" autocomplete="new-password"><button type="button" class="abm-eye" data-eye>Show</button></span></label>
          <label>Confirm new password<span class="abm-pw"><input type="password" name="confirm" minlength="12" autocomplete="new-password"><button type="button" class="abm-eye" data-eye>Show</button></span></label>
          <button class="abm-btn abm-btn-acc" style="justify-self:start">Save changes</button>
        </form>

      <?php elseif ($t === 'messages'): ?>
        <div class="abm-grid">
          <?php foreach ($abhPdo->query('SELECT * FROM messages ORDER BY id DESC LIMIT 200') as $i => $m): ?>
            <article class="abm-card" style="--i:<?= min($i, 14) ?>">
              <div class="abm-card-b">
                <h3><?= abh_e($m['subject']) ?></h3>
                <p><?= abh_e($m['name']) ?> · <?= abh_e($m['email']) ?><?= $m['phone'] ? ' · ' . abh_e($m['phone']) : '' ?></p>
                <p><?= abh_e($m['created_at']) ?></p>
                <p class="abm-msg"><?= abh_e($m['message']) ?></p>
              </div>
              <div class="abm-card-f">
                <form method="post"><input type="hidden" name="csrf" value="<?= $tok ?>"><input type="hidden" name="do" value="del"><input type="hidden" name="id" value="<?= (int)$m['id'] ?>"><button class="abm-btn abm-btn-red">Delete</button></form>
              </div>
            </article>
          <?php endforeach; ?>
        </div>

      <?php else:
        $order = isset($T[$t]['sort_order']) ? 'sort_order, id' : 'id';
        $k = array_keys($T[$t]);
        $fa = $t === 'skills' ? 'name' : $k[0];
        $fb = $t === 'skills' ? 'category' : $k[1];
      ?>
        <input class="abm-search" id="abmSearch" type="search" placeholder="Search <?= $t ?>..." aria-label="Search">
        <div class="abm-grid" id="abmGrid">
          <?php foreach ($abhPdo->query("SELECT * FROM `$t` ORDER BY $order") as $i => $r): ?>
            <article class="abm-card" style="--i:<?= min($i, 14) ?>">
              <?php if ($t === 'projects'): $sh = abh_path($r['screenshot']); ?><div class="abm-thumb"><?php if ($sh): ?><img src="<?= abh_e(preg_match('~^assets/~', $sh) ? '../' . $sh : $sh) ?>" alt="" loading="lazy"><?php else: ?><span><?= abh_e(mb_substr($r['name'], 0, 1)) ?></span><?php endif; ?></div><?php endif; ?>
              <div class="abm-card-b">
                <h3><?= abh_e($r[$fa]) ?></h3>
                <p><?= abh_e($r[$fb]) ?></p>
                <?php if ($t === 'projects'): ?><span class="abm-pill <?= $r['live_url'] ? 'abm-ok' : '' ?>"><?= $r['live_url'] ? 'Live link added' : 'No live link' ?></span><?php endif; ?>
              </div>
              <div class="abm-card-f"><a class="abm-btn" href="?t=<?= $t ?>&edit=<?= (int)$r['id'] ?>">Edit</a>
                <form method="post" onsubmit="return confirm('Delete this item?')"><input type="hidden" name="csrf" value="<?= $tok ?>"><input type="hidden" name="do" value="del"><input type="hidden" name="id" value="<?= (int)$r['id'] ?>"><button class="abm-btn abm-btn-red">Delete</button></form>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
        <dialog class="abm-dlg" id="abmDlg" <?= ($edit || isset($_GET['new'])) ? 'data-auto' : '' ?>>
          <h2 class="abm-h" style="font-size:1.4rem;margin-bottom:1rem"><?= $edit ? 'Edit' : 'Add' ?> <?= $t ?></h2>
          <form class="abm-form" method="post" action="?t=<?= $t ?>"><input type="hidden" name="csrf" value="<?= $tok ?>"><input type="hidden" name="do" value="save"><input type="hidden" name="id" value="<?= (int)($edit['id'] ?? 0) ?>">
            <?php foreach ($T[$t] as $c => $ty): $val = abh_e($edit[$c] ?? ($ty === 'int' ? 0 : '')); ?>
              <label><?= $c ?><?php if ($ty === 'area'): ?><textarea name="<?= $c ?>" rows="4"><?= $val ?></textarea><?php else: ?><input name="<?= $c ?>" value="<?= $val ?>" type="<?= $ty === 'int' ? 'number' : 'text' ?>"><?php endif; ?></label>
            <?php endforeach; ?>
            <div class="abm-acts"><button class="abm-btn abm-btn-acc">Save</button><a class="abm-btn" href="?t=<?= $t ?>">Cancel</a></div>
          </form>
        </dialog>
      <?php endif; ?>
    </main>
  </div>
  <script>
    (function() {
      var side = document.getElementById('abmSide'),
        ov = document.getElementById('abmOv'),
        btn = document.getElementById('abmMenu');

      function tog(o) {
        side.classList.toggle('abm-open', o);
        ov.classList.toggle('abm-open', o);
      }
      btn.addEventListener('click', function() {
        tog(!side.classList.contains('abm-open'));
      });
      ov.addEventListener('click', function() {
        tog(false);
      });
      var d = document.getElementById('abmDlg');
      if (d && d.hasAttribute('data-auto') && d.showModal) d.showModal();
      var s = document.getElementById('abmSearch');
      if (s) s.addEventListener('input', function() {
        var q = s.value.toLowerCase();
        document.querySelectorAll('#abmGrid .abm-card').forEach(function(c) {
          c.style.display = c.textContent.toLowerCase().indexOf(q) > -1 ? '' : 'none';
        });
      });
    })();
  </script>
  <script src="../assets/ui.js"></script>
</body>

</html>
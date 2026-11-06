<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex"><title>Admin | <?= ucfirst($t) ?></title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet"><script>try{var tt=localStorage.getItem('abhTheme');document.documentElement.setAttribute('data-theme',tt==='light'?'light':'dark')}catch(e){document.documentElement.setAttribute('data-theme','dark')}</script><link rel="stylesheet" href="../assets/admin.css"></head>
<body class="abm-body"><div class="abm-ov" id="abmOv"></div>
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
    <div><h1 class="abm-h abm-title"><?= $t === 'password' ? 'Change password' : ucfirst($t) ?></h1><p class="abm-sub"><?= abh_e($subtitle) ?></p></div>
    <div class="abm-acts"><button class="abm-btn" type="button" data-abh-theme-btn></button><a class="abm-btn" href="../index.php" target="_blank" rel="noopener">View site</a><?php if ($isCrud): ?><a class="abm-btn abm-btn-blue" href="?t=<?= $t ?>&new=1">+ Add new</a><?php endif; ?></div>
  </div>
  <?php if ($note): ?><p class="abm-toast" role="status"><?= abh_e($note) ?></p><?php endif; ?>
  <?php if ($bad): ?><p class="abm-toast abm-bad" role="alert"><?= abh_e($bad) ?></p><?php endif; ?>

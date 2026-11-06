<?php
require __DIR__ . '/config.php';
$S = [];
foreach ($abhPdo->query('SELECT skey, svalue FROM settings') as $r) $S[$r['skey']] = $r['svalue'];
$v = fn($k) => abh_e($S[$k] ?? '');
$skills = [];
foreach ($abhPdo->query('SELECT category, name FROM skills ORDER BY id') as $r) $skills[$r['category']][] = $r['name'];
$backend = $skills['API & Backend'] ?? [];
$services = $abhPdo->query('SELECT title FROM services ORDER BY sort_order, id')->fetchAll(PDO::FETCH_COLUMN);
$projects = $abhPdo->query('SELECT * FROM projects ORDER BY sort_order, id')->fetchAll();
$exp = $abhPdo->query('SELECT * FROM experience ORDER BY sort_order, id')->fetchAll();
$cv = abh_path($S['cv_url'] ?? '');
$wait = abh_wait_left($abhPdo);
$stack = array_filter(array_map('trim', explode(',', $S['hero_stack'] ?? '')));
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= $v('name') ?> | <?= $v('title') ?></title>
<meta name="description" content="<?= $v('site_description') ?>">
<meta property="og:title" content="<?= $v('name') ?> | <?= $v('title') ?>">
<meta property="og:description" content="<?= $v('site_description') ?>">
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=JetBrains+Mono&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">
<script>try{document.documentElement.className+=' abh-js';var tt=localStorage.getItem('abhTheme');document.documentElement.setAttribute('data-theme',tt==='light'?'light':'dark')}catch(e){document.documentElement.setAttribute('data-theme','dark')}</script>
<link rel="stylesheet" href="assets/style.css">
</head>
<body class="abh-body">
<header class="abh-head"><div class="abh-wrap abh-head-in">
  <a class="abh-logo" href="#home"><?= $v('name') ?><span>.</span></a>
  <nav class="abh-nav" aria-label="Main"><a href="#about">About</a><a href="#skills">Skills</a><a href="#services">Services</a><a href="#projects">Projects</a><?php if ($exp): ?><a href="#experience">Experience</a><?php endif; ?><a href="#backend">Backend</a><a href="#contact">Contact</a></nav>
  <button class="abh-theme" type="button" data-abh-theme-btn aria-label="Switch day or night theme"></button>
</div></header>
<main>
<section class="abh-hero" id="home"><div class="abh-wrap abh-hero-grid">
  <div>
    <p class="abh-role"><?= $v('title') ?></p>
    <h1 class="abh-h1"><?= $v('hero_heading') ?></h1>
    <p class="abh-sub"><?= $v('hero_sub') ?></p>
    <div class="abh-actions">
      <a class="abh-btn abh-btn-pri" href="#projects">View My Work</a>
      <a class="abh-btn abh-btn-sec" href="#contact">Contact Me</a>
      <?php if ($cv): ?><a class="abh-btn abh-btn-sec" href="<?= abh_e($cv) ?>" download>Download CV</a><?php endif; ?>
    </div>
  </div>
  <div class="abh-panel" aria-label="Main technologies">
    <div class="abh-panel-bar"><i></i><i></i><i></i><span>stack.config</span></div>
    <ul class="abh-stack"><?php foreach ($stack as $s): ?><li><?= abh_e($s) ?></li><?php endforeach; ?></ul>
  </div>
</div></section>

<section class="abh-sec" id="about"><div class="abh-wrap">
  <h2 class="abh-h2">About me</h2>
  <p class="abh-lead"><?= $v('about') ?></p>
</div></section>

<section class="abh-sec abh-alt" id="skills"><div class="abh-wrap">
  <h2 class="abh-h2">Technical skills</h2>
  <div class="abh-grid abh-grid-3">
  <?php foreach ($skills as $cat => $items): ?>
    <div class="abh-card"><h3 class="abh-h3"><?= abh_e($cat) ?></h3>
      <ul class="abh-chips"><?php foreach ($items as $i): ?><li><?= abh_e($i) ?></li><?php endforeach; ?></ul></div>
  <?php endforeach; ?>
  </div>
</div></section>

<section class="abh-sec" id="services"><div class="abh-wrap">
  <h2 class="abh-h2">Services</h2>
  <div class="abh-grid abh-grid-4"><?php foreach ($services as $s): ?><div class="abh-card abh-svc"><?= abh_e($s) ?></div><?php endforeach; ?></div>
</div></section>

<section class="abh-sec abh-alt" id="projects"><div class="abh-wrap">
  <h2 class="abh-h2">Featured projects</h2>
  <div class="abh-grid abh-grid-3">
  <?php foreach ($projects as $p): $shot = abh_path($p['screenshot']); $url = abh_url($p['live_url']); ?>
    <article class="abh-card abh-proj">
      <div class="abh-shot"><?php if ($shot): ?><img src="<?= abh_e($shot) ?>" alt="<?= abh_e($p['name']) ?> screenshot" loading="lazy"><?php else: ?><span><?= abh_e(mb_substr($p['name'], 0, 1)) ?></span><?php endif; ?></div>
      <div class="abh-proj-body">
        <h3 class="abh-h3"><?= abh_e($p['name']) ?></h3>
        <p class="abh-cat"><?= abh_e($p['category']) ?></p>
        <p><?= abh_e($p['description']) ?></p>
        <?php $tech = array_filter(array_map('trim', explode(',', $p['tech']))); if ($tech): ?><ul class="abh-chips"><?php foreach ($tech as $t): ?><li><?= abh_e($t) ?></li><?php endforeach; ?></ul><?php endif; ?>
        <?php if ($url): ?><a class="abh-btn abh-btn-sec abh-btn-sm" href="<?= abh_e($url) ?>" target="_blank" rel="noopener noreferrer">Live Website</a><?php else: ?><span class="abh-soon">Link coming soon</span><?php endif; ?>
      </div>
    </article>
  <?php endforeach; ?>
  </div>
</div></section>

<?php if ($exp): ?>
<section class="abh-sec" id="experience"><div class="abh-wrap">
  <h2 class="abh-h2">Work experience</h2>
  <?php foreach ($exp as $e): ?><div class="abh-card abh-exp"><h3 class="abh-h3"><?= abh_e($e['role']) ?><?= $e['company'] ? ' · ' . abh_e($e['company']) : '' ?></h3><p class="abh-cat"><?= abh_e($e['period']) ?></p><p><?= nl2br(abh_e($e['details'])) ?></p></div><?php endforeach; ?>
</div></section>
<?php endif; ?>

<section class="abh-sec abh-alt" id="backend"><div class="abh-wrap">
  <h2 class="abh-h2">API development &amp; backend expertise</h2>
  <p class="abh-lead"><?= $v('backend_text') ?></p>
  <ul class="abh-chips"><?php foreach ($backend as $b): ?><li><?= abh_e($b) ?></li><?php endforeach; ?></ul>
</div></section>

<section class="abh-sec" id="contact"><div class="abh-wrap abh-contact">
  <div>
    <h2 class="abh-h2">Contact</h2>
    <p class="abh-lead">Tell me about your website or web application.</p>
    <?php if ($S['email'] ?? ''): ?><p>Email: <a href="mailto:<?= $v('email') ?>"><?= $v('email') ?></a></p><?php endif; ?>
    <?php if ($S['phone'] ?? ''): ?><p>Phone: <?= $v('phone') ?></p><?php endif; ?>
  </div>
  <form class="abh-form" id="abhForm" data-wait="<?= (int)$wait ?>" method="post" action="contact.php">
    <?php if (isset($_GET['sent'])): ?><p class="abh-ok" role="status">Thanks, your message was sent.</p><?php elseif (isset($_GET['wait'])): ?><p class="abh-bad" role="alert">You already sent a message recently. Please wait for the timer below.</p><?php elseif (isset($_GET['err'])): ?><p class="abh-bad" role="alert"><?= (int)$_GET['err'] === 2 ? 'Your message could not be saved. Please try again later.' : ((int)$_GET['err'] === 3 ? 'Session expired. Reload the page and try again.' : 'Please check the form: all fields except phone are required.') ?></p><?php endif; ?>
    <input type="hidden" name="csrf" value="<?= abh_e(abh_csrf()) ?>">
    <input class="abh-hp" type="text" name="abh_hp_x" tabindex="-1" autocomplete="off" aria-hidden="true">
    <div class="abh-row"><label>Name<input name="name" required minlength="2" maxlength="100" autocomplete="name"></label><label>Email<input type="email" name="email" required maxlength="150" autocomplete="email"></label></div>
    <div class="abh-row"><label>Phone (optional)<input type="tel" name="phone" maxlength="30" autocomplete="tel"></label><label>Subject<input name="subject" required minlength="3" maxlength="150"></label></div>
    <label>Message<textarea name="message" rows="5" required minlength="10" maxlength="3000"></textarea></label>
    <button class="abh-btn abh-btn-pri" id="abhSend" type="submit">Send Message</button>
    <p class="abh-wait" id="abhWait" role="timer" hidden></p>
  </form>
</div></section>
</main>
<footer class="abh-foot"><div class="abh-wrap abh-foot-in">
  <div><strong><?= $v('name') ?></strong><br><?= $v('title') ?></div>
  <nav aria-label="Footer"><a href="#about">About</a> <a href="#projects">Projects</a> <a href="#contact">Contact</a></nav>
  <div><?php foreach (['github' => 'GitHub', 'linkedin' => 'LinkedIn'] as $k => $l): if (abh_url($S[$k] ?? '')): ?><a href="<?= $v($k) ?>" target="_blank" rel="noopener noreferrer"><?= $l ?></a> <?php endif; endforeach; ?></div>
  <small>&copy; <?= date('Y') ?> <?= $v('name') ?>. All rights reserved.</small>
</div></footer>
<script src="assets/ui.js"></script>
</body>
</html>

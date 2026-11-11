<?php
/* ONE SECTION ONLY (no header/footer). Include where you want it:  <?php include 'abh-section.php'; ?>
   Uses your $S, $backend, $projects, $services, $exp, $skills, $wait, $v and abh_* helpers (fallbacks included). */
if (!function_exists('abh_e')) {
  function abh_e($s)
  {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
  }
}
if (!function_exists('abh_path')) {
  function abh_path($p)
  {
    return trim((string)$p);
  }
}
if (!function_exists('abh_url')) {
  function abh_url($u)
  {
    $u = trim((string)$u);
    return preg_match('~^https?://~i', $u) ? $u : '';
  }
}
if (!function_exists('abh_csrf')) {
  function abh_csrf()
  {
    if (session_status() === PHP_SESSION_NONE) @session_start();
    return $_SESSION['csrf'] ??= bin2hex(random_bytes(16));
  }
}
$S        = $S ?? ['name' => 'Abhi', 'role' => 'Developer', 'email' => 'you@example.com', 'phone' => '', 'backend_text' => 'I build secure REST APIs, authentication flows and database-backed systems.'];
$v        = $v ?? fn($k) => abh_e($S[$k] ?? '');
$wait     = $wait ?? 0;
$backend  = $backend ?? ['REST APIs', 'PHP / Laravel', 'MySQL', 'JWT & OAuth'];
$services = $services ?? ['Custom website development', 'API development', 'Admin dashboards'];
$projects = $projects ?? [['name' => 'Sample project', 'category' => 'Web app', 'description' => 'Describe the project here.', 'tech' => 'PHP, MySQL', 'screenshot' => '', 'live_url' => '']];
$exp      = $exp ?? [];
$skills   = $skills ?? ['Backend' => ['PHP', 'Laravel', 'MySQL'], 'Frontend' => ['HTML', 'CSS', 'JavaScript']];
$DATA = [
  'name' => $S['name'] ?? 'Abhi',
  'role' => $S['role'] ?? 'Developer',
  'backend_text' => $S['backend_text'] ?? '',
  'backend' => array_values($backend),
  'services' => array_values($services),
  'projects' => array_map(fn($p) => [
    'name' => $p['name'],
    'category' => $p['category'],
    'description' => $p['description'],
    'tech' => $p['tech'],
    'shot' => abh_path($p['screenshot'] ?? ''),
    'url' => abh_url($p['live_url'] ?? '')
  ], array_values($projects)),
  'exp' => array_values($exp),
  'skills' => $skills
];
?>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Roboto+Condensed:wght@400;500;700&display=swap');

  #abhx {
    --ink: #ece6de;
    --mute: #8d857b;
    --teal: #37b6c9;
    --vio: #9b7bff;
    --amber: #c4915c;
    --gold: #f0b45b;
    --blue: #3aa0ff;
    --ac: #c4915c;
    --rgb: 196, 145, 92;
    --lt: #d6a46c;
    --dk: #7a5230;
    --rose: #e4608f;
    --grn: #4fd18b;
    --edge: rgba(var(--rgb), .22);
    --card: #15120f;
    --ui: 'Inter', system-ui, sans-serif;
    --cond: 'Roboto Condensed', 'Arial Narrow', sans-serif;
    position: relative;
    isolation: isolate;
    overflow: hidden;
    min-height: 780px;
    padding: clamp(110px, 13vw, 150px) clamp(14px, 3vw, 24px);
    background: radial-gradient(ellipse 55% 45% at 50% 18%, rgba(var(--rgb), .16), transparent 70%), #0b0a09;
    color: var(--ink);
    font: 400 14px/1.55 var(--ui);
    box-sizing: border-box
  }

  #abhx::before,
  #abhx::after {
    content: "";
    position: absolute;
    left: 50%;
    top: -260px;
    border-radius: 50%;
    border: 1px solid rgba(var(--rgb), .09);
    transform: translateX(-50%);
    pointer-events: none;
    z-index: -1
  }

  #abhx::before {
    width: 1100px;
    height: 1100px
  }

  #abhx::after {
    width: 880px;
    height: 880px;
    top: -150px
  }

  #abhx *,
  #abhx *::before,
  #abhx *::after {
    box-sizing: border-box
  }

  #abhx h2,
  #abhx h3,
  #abhx p,
  #abhx ul {
    margin: 0;
    padding: 0
  }

  #abhx button,
  #abhx input,
  #abhx textarea {
    font: inherit;
    color: inherit
  }

  #abhx button {
    cursor: pointer;
    background: none;
    border: 0;
    text-align: left
  }

  #abhx :focus-visible {
    outline: 2px solid var(--teal);
    outline-offset: 2px
  }

  #abhx .tb {
    position: absolute;
    top: 18px;
    right: 24px;
    display: flex;
    gap: 8px;
    z-index: 3
  }

  #abhx .ib,
  #abhx .pill {
    padding: 8px 14px;
    border-radius: 10px;
    border: 1px solid var(--edge);
    background: var(--card);
    font-weight: 600;
    transition: border-color .2s
  }

  #abhx .ib:hover,
  #abhx .pill:hover {
    border-color: var(--ac)
  }

  #abhx .tree {
    position: relative;
    max-width: 1240px;
    margin: 0 auto
  }

  #abhx .lines {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    overflow: visible;
    z-index: 0
  }

  #abhx .lines path {
    fill: none;
    stroke: rgba(var(--rgb), .25);
    stroke-width: 1.2
  }

  #abhx .lines path.on {
    stroke: var(--ac);
    stroke-width: 2;
    filter: drop-shadow(0 0 6px var(--ac))
  }

  #abhx .lines circle {
    fill: var(--ac)
  }

  #abhx .hub {
    text-align: center;
    position: relative;
    z-index: 1;
    margin-bottom: clamp(70px, 8vw, 110px)
  }

  #abhx .hub b {
    font: 600 20px/1.2 var(--cond);
    display: block
  }

  #abhx .hub span {
    color: var(--mute)
  }

  #abhx .orb {
    display: block;
    width: 96px;
    height: 96px;
    margin: 14px auto 0;
    border-radius: 50%;
    background: radial-gradient(circle at 35% 30%, #d9c8ff, var(--vio) 45%, #3a2a8c);
    box-shadow: 0 0 40px 8px rgba(155, 123, 255, .4);
    position: relative
  }

  #abhx .orb::before {
    content: "";
    position: absolute;
    inset: -14px;
    border-radius: 50%;
    background: conic-gradient(from 0deg, transparent, var(--lt), transparent 40%, var(--ac), transparent);
    -webkit-mask: radial-gradient(circle, transparent 58%, #000 60%, #000 66%, transparent 68%);
    mask: radial-gradient(circle, transparent 58%, #000 60%, #000 66%, transparent 68%);
    animation: abhxspin 14s linear infinite
  }

  @keyframes abhxspin {
    to {
      transform: rotate(360deg)
    }
  }

  @keyframes abhxfade {
    from {
      opacity: .2;
      transform: translateY(8px)
    }
  }

  #abhx .row {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 14px;
    margin-bottom: clamp(72px, 10vw, 130px);
    position: relative;
    z-index: 1
  }

  #abhx .row.cats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(170px, 1fr))
  }

  #abhx .row.cats .nd {
    max-width: none
  }

  #abhx .row.col,
  #abhx .row.cats.col {
    display: flex;
    margin-bottom: 90px
  }

  #abhx .row.col .nd {
    min-width: 160px;
    padding: 8px 16px
  }

  #abhx .nd {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 170px;
    max-width: 250px;
    padding: 12px 16px;
    border-radius: 12px;
    background: var(--card);
    border: 1px solid var(--edge);
    transition: border-color .2s, box-shadow .2s
  }

  #abhx .nd:hover {
    border-color: rgba(var(--rgb), .6)
  }

  #abhx .nd.on {
    border-color: var(--ac);
    box-shadow: 0 0 22px rgba(var(--rgb), .3)
  }

  #abhx .nd i {
    width: 9px;
    height: 9px;
    border-radius: 50%;
    flex: none;
    background: currentColor;
    box-shadow: 0 0 10px currentColor
  }

  #abhx .nd strong {
    font: 500 22px/1 var(--cond);
    color: var(--ink);
    min-width: 22px
  }

  #abhx .nd span {
    min-width: 0
  }

  #abhx .nd b {
    display: block;
    font: 500 14px/1.3 var(--ui);
    color: var(--ink);
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap
  }

  #abhx .nd small {
    display: block;
    color: var(--mute);
    font-size: 11.5px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap
  }

  #abhx .info {
    position: relative;
    z-index: 1;
    max-width: 860px;
    margin: 0 auto;
    padding: 26px;
    border-radius: 20px;
    background: linear-gradient(160deg, rgba(var(--rgb), .16), rgba(20, 16, 12, .88));
    border: 1px solid var(--edge);
    box-shadow: 0 20px 60px rgba(0, 0, 0, .5)
  }

  #abhx .info.swap {
    animation: abhxfade .35s
  }

  #abhx .kick {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--mute);
    margin-bottom: 8px
  }

  #abhx .kick i {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--ac)
  }

  #abhx .info h2 {
    font: 500 clamp(22px, 4vw, 28px)/1.2 var(--cond);
    margin-bottom: 10px;
    color: var(--ink)
  }

  #abhx .info h3 {
    font: 500 15px var(--cond);
    margin: 18px 0 8px;
    color: var(--mute)
  }

  #abhx .info p {
    color: #d6cec5;
    margin-bottom: 10px
  }

  #abhx .info a {
    color: var(--teal)
  }

  #abhx .sub {
    color: var(--mute) !important;
    font-size: 12.5px
  }

  #abhx .badge {
    display: inline-block;
    padding: 2px 10px;
    border-radius: 6px;
    font-size: 12px;
    background: rgba(79, 209, 139, .15);
    color: var(--grn);
    border: 1px solid rgba(79, 209, 139, .4);
    margin-bottom: 10px
  }

  #abhx .badge.soon {
    background: rgba(var(--rgb), .15);
    color: var(--ac);
    border-color: rgba(var(--rgb), .4)
  }

  #abhx .pj {
    display: grid;
    grid-template-columns: 240px 1fr;
    gap: 22px
  }

  #abhx .shot {
    height: 170px;
    border-radius: 12px;
    background: #0f0d0b;
    border: 1px solid var(--edge);
    display: grid;
    place-items: center;
    overflow: hidden;
    font: 500 54px var(--cond);
    color: var(--ac)
  }

  #abhx .shot img {
    width: 100%;
    height: 100%;
    object-fit: cover
  }

  #abhx .tiles {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 10px;
    margin: 14px 0
  }

  #abhx .tile {
    padding: 14px;
    border-radius: 12px;
    background: #100e0c;
    border: 1px solid var(--edge)
  }

  #abhx button.tile:hover {
    border-color: var(--ac)
  }

  #abhx .tile b {
    font: 500 28px/1 var(--cond);
    display: block;
    margin-bottom: 4px
  }

  #abhx .tile span {
    color: var(--mute);
    font-size: 12.5px
  }

  #abhx .chips {
    list-style: none;
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin: 0 0 12px
  }

  #abhx .chips li,
  #abhx .chips button {
    padding: 4px 11px;
    border-radius: 999px;
    font-size: 12.5px;
    background: rgba(var(--rgb), .1);
    border: 1px solid rgba(var(--rgb), .3)
  }

  #abhx .chips button:hover {
    border-color: var(--teal)
  }

  #abhx .btn {
    display: inline-block;
    padding: 10px 18px;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    border: 1px solid var(--edge);
    background: var(--card);
    color: var(--ink) !important;
    transition: border-color .2s
  }

  #abhx .btn:hover {
    border-color: var(--ac)
  }

  #abhx .btn.pri {
    background: linear-gradient(135deg, var(--ac), var(--dk));
    border-color: var(--ac)
  }

  #abhx .btn[disabled] {
    opacity: .55;
    cursor: not-allowed
  }

  #abhx .info.cton {
    padding: 0;
    background: none;
    border: 0;
    box-shadow: none;
    max-width: 980px
  }

  #abhx .ct {
    display: grid;
    grid-template-columns: 5fr 7fr;
    border-radius: 24px;
    overflow: hidden;
    border: 1px solid var(--edge);
    box-shadow: 0 24px 70px rgba(0, 0, 0, .55);
    text-align: left
  }

  #abhx .ct-l {
    padding: 38px;
    background: linear-gradient(160deg, var(--lt), var(--ac));
    color: #1a1208
  }

  #abhx .ct-l h2 {
    font: 600 38px/1.1 var(--cond) !important;
    color: #1a1208 !important;
    margin: 0 0 14px !important
  }

  #abhx .ct-l p {
    color: #2b1d0e !important;
    margin-bottom: 22px !important
  }

  #abhx .ct-l a {
    display: block;
    font: 600 17px var(--ui);
    color: #1a1208 !important;
    text-decoration: none;
    border-top: 1px solid rgba(26, 18, 8, .3);
    padding: 14px 0;
    overflow-wrap: anywhere
  }

  #abhx .ct-r {
    padding: 36px;
    background: #12100d
  }

  #abhx .abh-form {
    display: grid;
    gap: 20px
  }

  #abhx .abh-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 22px
  }

  #abhx .abh-form label {
    display: grid;
    gap: 2px;
    font-size: 12px;
    color: var(--mute)
  }

  #abhx .abh-form input,
  #abhx .abh-form textarea {
    width: 100%;
    padding: 8px 0;
    background: none;
    border: 0;
    border-bottom: 1px solid rgba(var(--rgb), .35);
    border-radius: 0;
    resize: vertical;
    color: var(--ink)
  }

  #abhx .abh-form input:focus,
  #abhx .abh-form textarea:focus {
    border-bottom-color: var(--ac);
    outline: 0
  }

  #abhx .abh-hp {
    position: absolute !important;
    left: -9999px !important;
    width: 1px !important;
    height: 1px !important;
    opacity: 0
  }

  #abhx .abh-ok {
    color: var(--grn) !important
  }

  #abhx .abh-bad {
    color: var(--rose) !important
  }

  #abhx .send {
    justify-self: start;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 13px 24px;
    border-radius: 999px;
    background: var(--ac);
    color: #1a1208;
    font-weight: 700;
    transition: transform .2s
  }

  #abhx .send:hover {
    transform: translateY(-2px)
  }

  #abhx .send[disabled] {
    opacity: .55;
    cursor: not-allowed;
    transform: none
  }

  #abhx .ask {
    position: relative;
    z-index: 1;
    display: flex;
    gap: 8px;
    max-width: 860px;
    margin: 18px auto 0;
    padding: 8px;
    border-radius: 18px;
    background: var(--card);
    border: 1px solid var(--edge)
  }

  #abhx .ask input {
    flex: 1;
    min-width: 0;
    padding: 10px 14px;
    border-radius: 12px;
    border: 0;
    background: #ece6de;
    color: #16110d
  }

  #abhx .ask button {
    width: 42px;
    border-radius: 12px;
    background: var(--dk);
    display: grid;
    place-items: center;
    text-align: center;
    font-size: 18px
  }

  @media(max-width:900px) {
    #abhx .row.cats {
      grid-template-columns: repeat(3, 1fr)
    }

    #abhx .nd {
      min-width: 0
    }

    #abhx .pj {
      grid-template-columns: 200px 1fr
    }

    #abhx .ct {
      grid-template-columns: 1fr
    }
  }

  @media(max-width:700px) {
    #abhx .row {
      gap: 10px
    }

    #abhx .row.cats {
      grid-template-columns: repeat(2, 1fr)
    }

    #abhx .row:not(.cats) .nd {
      flex: 1 1 calc(50% - 10px);
      min-width: 0;
      max-width: none
    }

    #abhx .nd {
      padding: 10px 12px;
      gap: 9px
    }

    #abhx .nd strong {
      font-size: 19px
    }

    #abhx .pj,
    #abhx .abh-row {
      grid-template-columns: 1fr
    }

    #abhx .ct-l,
    #abhx .ct-r {
      padding: 24px
    }

    #abhx .ct-l h2 {
      font-size: 30px !important
    }

    #abhx .info {
      padding: 18px
    }

    #abhx .tb {
      top: 12px;
      right: 12px
    }

    #abhx .ask input {
      font-size: 16px
    }
  }

  @media(max-width:380px) {
    #abhx .row:not(.cats) .nd {
      flex-basis: 100%
    }
  }

  #abhx .aur {
    position: absolute;
    left: 0;
    right: 0;
    margin: 0 auto;
    top: 4%;
    width: min(900px, 92%);
    height: 520px;
    border-radius: 50%;
    background: radial-gradient(closest-side, rgba(var(--rgb), .16), transparent);
    filter: blur(30px);
    z-index: -1;
    pointer-events: none;
    animation: abhxdrift 16s ease-in-out infinite alternate;
    transition: background .6s
  }

  #abhx .row {
    transition: filter .6s, opacity .6s
  }

  #abhx .row[data-age="1"],
  #abhx .row[data-age="2"] {
    opacity: .72
  }

  #abhx .row[data-age="3"] {
    opacity: .5;
    filter: blur(2.5px)
  }

  #abhx .row[data-age]:hover,
  #abhx .row[data-age]:focus-within {
    opacity: 1;
    filter: none
  }

  #abhx .nd {
    transition: border-color .5s, box-shadow .5s, transform .25s, background .5s
  }

  #abhx .nd:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 26px rgba(var(--rgb), .22)
  }

  #abhx .nd.on {
    animation: abhxon 3.2s ease-in-out infinite
  }

  #abhx .row.new .nd {
    animation: abhxrise .6s cubic-bezier(.2, .75, .25, 1) both;
    animation-delay: calc(var(--i, 0)*80ms)
  }

  #abhx .info {
    transition: border-color .5s
  }

  #abhx .info.swap {
    animation: abhxfade .4s ease both, abhxglow .9s ease-out
  }

  #abhx .orb {
    animation: abhxpulse 4s ease-in-out infinite
  }

  #abhx .lines path {
    transition: stroke .5s
  }

  #abhx .lines path.draw {
    stroke-dasharray: 1;
    stroke-dashoffset: 1;
    animation: abhxdraw .8s ease forwards
  }

  #abhx:not(.in) .row.new .nd,
  #abhx:not(.in) .lines path.draw {
    animation-play-state: paused
  }

  @keyframes abhxrise {
    from {
      opacity: 0;
      transform: translateY(22px) scale(.94)
    }

    to {
      opacity: 1;
      transform: none
    }
  }

  @keyframes abhxdraw {
    to {
      stroke-dashoffset: 0
    }
  }

  @keyframes abhxpulse {

    0%,
    100% {
      box-shadow: 0 0 40px 8px rgba(155, 123, 255, .4)
    }

    50% {
      box-shadow: 0 0 64px 16px rgba(155, 123, 255, .62)
    }
  }

  @keyframes abhxon {

    0%,
    100% {
      box-shadow: 0 0 18px rgba(var(--rgb), .28)
    }

    50% {
      box-shadow: 0 0 32px rgba(var(--rgb), .52)
    }
  }

  @keyframes abhxglow {
    0% {
      box-shadow: 0 0 0 0 rgba(var(--rgb), .5)
    }

    100% {
      box-shadow: 0 0 0 24px rgba(var(--rgb), 0)
    }
  }

  @keyframes abhxdrift {
    from {
      transform: translate(-8%, 0) scale(1)
    }

    to {
      transform: translate(8%, 6%) scale(1.15)
    }
  }

  @media(prefers-reduced-motion:reduce) {
    #abhx * {
      animation: none !important;
      transition: none !important
    }

    #abhx .lines circle {
      display: none
    }
  }
</style>

<section id="abhx" aria-label="Portfolio map">
  <div class="aur"></div>
  <div class="tb"><button class="ib" data-reset aria-label="Reset" title="Reset">&#10227;</button><button class="pill" data-hire>Hire me</button></div>
  <div class="tree">
    <svg class="lines" aria-hidden="true"></svg>
    <div class="hub"><b><?= abh_e($DATA['name']) ?></b><span><?= abh_e($DATA['role']) ?></span><button class="orb" data-reset aria-label="Back to overview"></button></div>
    <div class="rows"></div>
    <div class="info" aria-live="polite"></div>
  </div>
  <form class="ask" role="search"><input name="q" placeholder="Ask a question, e.g. Laravel or pricing" aria-label="Ask a question" autocomplete="off"><button aria-label="Send">&#10148;</button></form>

  <template class="tplc">
    <div class="ct">
      <div class="ct-l">
        <h2>Let&rsquo;s build something together</h2>
        <p>Tell me about your website or web application and I will reply with a plan.</p>
        <?php if ($S['email'] ?? ''): ?><a href="mailto:<?= $v('email') ?>"><?= $v('email') ?></a><?php endif; ?>
        <?php if ($S['phone'] ?? ''): ?><a href="tel:<?= $v('phone') ?>"><?= $v('phone') ?></a><?php endif; ?>
      </div>
      <div class="ct-r">
        <form class="abh-form" id="abhForm" data-wait="<?= (int)$wait ?>" method="post" action="contact.php">
          <?php if (isset($_GET['sent'])): ?><p class="abh-ok" role="status">Thanks, your message was sent.</p><?php elseif (isset($_GET['wait'])): ?><p class="abh-bad" role="alert">You already sent a message recently. Please wait for the timer below.</p><?php elseif (isset($_GET['err'])): ?><p class="abh-bad" role="alert"><?= (int)$_GET['err'] === 2 ? 'Your message could not be saved. Please try again later.' : ((int)$_GET['err'] === 3 ? 'Session expired. Reload the page and try again.' : 'Please check the form: all fields except phone are required.') ?></p><?php endif; ?>
          <input type="hidden" name="csrf" value="<?= abh_e(abh_csrf()) ?>">
          <input class="abh-hp" type="text" name="abh_hp_x" tabindex="-1" autocomplete="off" aria-hidden="true">
          <div class="abh-row"><label>Name<input name="name" required minlength="2" maxlength="100" autocomplete="name"></label><label>Email<input type="email" name="email" required maxlength="150" autocomplete="email"></label></div>
          <div class="abh-row"><label>Phone (optional)<input type="tel" name="phone" maxlength="30" autocomplete="tel"></label><label>Subject<input name="subject" required minlength="3" maxlength="150"></label></div>
          <label>Message<textarea name="message" rows="4" required minlength="10" maxlength="3000"></textarea></label>
          <button class="send" id="abhSend" type="submit">Send message <span aria-hidden="true">&#10148;</span></button>
          <p class="abh-wait sub" id="abhWait" role="timer" hidden></p>
        </form>
      </div>
    </div>
  </template>
</section>

<script>
  (function() {
    const D = <?= json_encode($DATA, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
    const R = document.getElementById('abhx'),
      $ = s => R.querySelector(s),
      P = D.projects;
    const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#39;'
    } [c]));
    const split = t => String(t || '').split(',').map(x => x.trim()).filter(Boolean);
    const chips = a => a.length ? `<ul class="chips">${a.map(x => `<li>${esc(x)}</li>`).join('')}</ul>` : '';
    const kick = a => `<div class="kick"><i></i>${esc(a)}</div>`;
    const STOP = ['and', 'the', 'for', 'custom', 'website', 'web', 'app', 'development', 'design'];
    const relP = t => {
      const w = String(t).toLowerCase().split(/[^a-z0-9+#.]+/).filter(x => x.length > 2 && !STOP.includes(x)).map(x => x.replace(/s$/, ''));
      return P.filter(p => {
        const h = (p.name + ' ' + p.category + ' ' + p.description + ' ' + p.tech).toLowerCase();
        return w.some(x => h.includes(x));
      }).slice(0, 8);
    };

    /* Info panels: the tree above already lists related items, so the panel never repeats them. */
    const projInfo = p => `<div class="pj"><div class="shot">${p.shot ? `<img src="${esc(p.shot)}" alt="${esc(p.name)} screenshot">` : esc(p.name.slice(0,1))}</div><div>${kick('Featured project')}<h2>${esc(p.name)}</h2>
  <span class="badge${p.url?'':' soon'}">${p.url ? 'Live' : 'Link coming soon'}</span><p class="sub">${esc(p.category)}</p><p>${esc(p.description)}</p>
  ${p.url ? `<a class="btn pri" href="${esc(p.url)}" target="_blank" rel="noopener noreferrer">Live Website</a>` : ''}</div></div>`;
    const termInfo = (t, label, more = '') => {
      const n = relP(t).length;
      return `${kick(label)}<h2>${esc(t)}</h2>${more}<p class="sub">${n ? `Used in ${n} project${n > 1 ? 's' : ''}. See them in the row above.` : 'No project is linked to this yet.'}</p><button class="btn" data-quote="${esc(t)}">Ask about ${esc(t)}</button>`;
    };

    const projNode = p => ({
      t: p.name,
      s: p.category,
      info: () => projInfo(p),
      kids: () => split(p.tech).map(techNode)
    });
    const techNode = t => ({
      t,
      s: 'Technology',
      info: () => termInfo(t, 'Technology'),
      kids: () => relP(t).map(projNode)
    });
    const skillNode = t => ({
      t,
      s: 'Skill',
      info: () => termInfo(t, 'Skill'),
      kids: () => relP(t).map(projNode)
    });
    const groupNode = ([k, v]) => ({
      t: k,
      s: v.length + ' skills',
      info: () => `${kick('Technical skills')}<h2>${esc(k)}</h2><p class="sub">${v.length} skills. Pick one in the row above.</p>`,
      kids: () => v.map(skillNode)
    });
    const svcNode = s => ({
      t: s,
      s: 'Service',
      info: () => `${kick('Service')}<h2>${esc(s)}</h2><p>Need this for your website or web application? Send a short brief and I will reply with a plan.</p><button class="btn pri" data-quote="${esc(s)}">Get a quote</button>`,
      kids: () => [...relP(s).map(projNode), {
        t: 'Get a quote',
        s: 'Contact',
        act: s
      }]
    });
    const backNode = b => ({
      t: b,
      s: 'Backend',
      info: () => termInfo(b, 'API & backend', `<p>${esc(D.backend_text)}</p>`),
      kids: () => relP(b).map(projNode)
    });
    const lineNode = (l, e) => ({
      t: l.slice(0, 44),
      s: 'Detail',
      info: () => `${kick('Work experience')}<h2>${esc(e.role)}</h2><p>${esc(l)}</p>`,
      kids: () => []
    });
    const expNode = e => ({
      t: e.role,
      s: e.company || e.period,
      info: () => `${kick('Work experience')}<h2>${esc(e.role)}</h2><p class="sub">${esc(e.company)}${e.company && e.period ? ' · ' : ''}${esc(e.period)}</p><p>${esc(e.details).replace(/\n/g,'<br>')}</p>`,
      kids: () => String(e.details || '').split(/\n+/).map(x => x.trim()).filter(Boolean).slice(0, 6).map(l => lineNode(l, e))
    });
    const catInfo = (l, n) => () => `${kick(l)}<h2>${esc(l)}</h2><p class="sub">${n} item${n === 1 ? '' : 's'}. Pick one in the row above to see details.</p>`;
    const CATS = [{
        t: 'Featured projects',
        n: P.length,
        kids: () => P.map(projNode),
        info: catInfo('Featured projects', P.length)
      },
      {
        t: 'Services',
        n: D.services.length,
        kids: () => D.services.map(svcNode),
        info: catInfo('Services', D.services.length)
      },
      {
        t: 'Technical skills',
        n: Object.keys(D.skills).length,
        kids: () => Object.entries(D.skills).map(groupNode),
        info: catInfo('Technical skills', Object.keys(D.skills).length)
      },
      {
        t: 'API & backend',
        n: D.backend.length,
        kids: () => D.backend.map(backNode),
        info: catInfo('API & backend', D.backend.length)
      },
      ...(D.exp.length ? [{
        t: 'Work experience',
        n: D.exp.length,
        kids: () => D.exp.map(expNode),
        info: catInfo('Work experience', D.exp.length)
      }] : []),
      {
        t: 'Contact',
        n: '@',
        form: true,
        kids: () => [],
        info: () => ''
      }
    ];
    const LAST = CATS.length - 1,
      COL = ['--teal', '--vio', '--gold', '--rose', '--grn', '--blue'],
      MAXD = 4;
    const TH = [{
        ac: '#37b6c9',
        rgb: '55,182,201',
        lt: '#6fdcec',
        dk: '#17606d'
      }, {
        ac: '#9b7bff',
        rgb: '155,123,255',
        lt: '#bfaeff',
        dk: '#4a3399'
      }, {
        ac: '#f0b45b',
        rgb: '240,180,91',
        lt: '#ffd08a',
        dk: '#8a5a14'
      },
      {
        ac: '#e4608f',
        rgb: '228,96,143',
        lt: '#f594b4',
        dk: '#8a2a52'
      }, {
        ac: '#4fd18b',
        rgb: '79,209,139',
        lt: '#8cebb8',
        dk: '#1d6b43'
      }, {
        ac: '#3aa0ff',
        rgb: '58,160,255',
        lt: '#7ec3ff',
        dk: '#2a4fb0'
      }
    ];
    const DEF = {
      ac: '#c4915c',
      rgb: '196,145,92',
      lt: '#d6a46c',
      dk: '#7a5230'
    };
    const TK = {
      'Featured projects': 0,
      'Services': 1,
      'Technical skills': 2,
      'API & backend': 3,
      'Work experience': 4,
      'Contact': 5
    };
    CATS.forEach(c => {
      const i = TK[c.t];
      c.c = COL[i];
      c.th = TH[i];
    });
    let path = [],
      rows = [],
      pre = null;

    /* Children of a node, never repeating anything already on the path or already in the same row. */
    const kidsOf = (n, chain) => {
      if (chain.length >= MAXD) return [];
      if (!n.K) {
        const seen = new Set(chain.map(x => x.t.toLowerCase()));
        n.K = [];
        n.kids().forEach(k => {
          const key = k.t.toLowerCase();
          if (!seen.has(key)) {
            seen.add(key);
            k.c = n.c;
            n.K.push(k);
          }
        });
      }
      return n.K;
    };

    function lines() {
      const T = $('.tree'),
        pos = (el, bot) => {
          let x = el.offsetWidth / 2,
            y = bot ? el.offsetHeight : 0;
          for (let e = el; e && e !== T; e = e.offsetParent) {
            x += e.offsetLeft;
            y += e.offsetTop;
          }
          return [x, y];
        };
      const els = [...R.querySelectorAll('.row')];
      let off = '',
        on = '',
        act = '';
      els.forEach((row, d) => {
        const par = d ? els[d - 1].querySelector('.nd.on') : $('.orb');
        if (!par) return;
        const a = pos(par, 1),
          fresh = row.classList.contains('new');
        row.querySelectorAll('.nd').forEach(n => {
          const b = pos(n, 0),
            m = (a[1] + b[1]) / 2,
            dd = `M${a[0]} ${a[1]}C${a[0]} ${m} ${b[0]} ${m} ${b[0]} ${b[1]}`,
            isOn = n.classList.contains('on'),
            el = `<path pathLength="1" class="${isOn ? 'on' : ''}${fresh || n.dataset.fresh ? ' draw' : ''}" d="${dd}"/>`;
          if (isOn) {
            on += el;
            act = dd;
          } else off += el;
        });
      });
      $('.lines').innerHTML = off + on + (act ? `<circle r="3.5"><animateMotion dur="2.8s" repeatCount="indefinite" path="${act}"/></circle>` : '');
    }

    function contact() {
      const info = $('.info');
      info.innerHTML = '';
      info.appendChild($('.tplc').content.cloneNode(true));
      const f = $('#abhForm');
      if (pre) {
        if (pre.subject) f.subject.value = pre.subject;
        if (pre.msg) f.message.value = pre.msg;
      }
      const n = +f.dataset.wait,
        w = $('#abhWait'),
        b = $('#abhSend');
      if (n > 0 && /[?&]wait/.test(location.search)) {
        let t = n;
        b.disabled = true;
        w.hidden = false;
        const tick = () => {
          w.textContent = `You can send another message in ${t}s`;
          if (t-- <= 0) {
            clearInterval(id);
            b.disabled = false;
            w.hidden = true;
          }
        };
        const id = setInterval(tick, 1000);
        tick();
      }
    }
    /* height of a fixed/sticky site header, so scrolling never hides the tree behind it */
    function headGap() {
      let h = 0;
      document.querySelectorAll('header,nav,[class*="header"],[class*="navbar"]').forEach(el => {
        if (R.contains(el)) return;
        const cs = getComputedStyle(el);
        if (cs.position === 'fixed' || cs.position === 'sticky') {
          const b = el.getBoundingClientRect();
          if (b.top <= 24 && b.bottom > 0) h = Math.max(h, b.bottom);
        }
      });
      return h + 24;
    }

    function settle() {
      const g = headGap();
      if (!path.length) {
        const t = R.getBoundingClientRect().top;
        if (t < g - 60) scrollBy({
          top: t - g + 60,
          behavior: 'smooth'
        });
        return;
      }
      const row = R.querySelectorAll('.row')[path.length - 1];
      if (!row) return;
      const top = row.getBoundingClientRect().top;
      if (top < g + 10 || top > innerHeight * .5) scrollBy({
        top: top - g - 30,
        behavior: 'smooth'
      });
    }
    const reduce = matchMedia('(prefers-reduced-motion:reduce)').matches,
      keys = new Map();

    function runCounts() {
      R.querySelectorAll('strong[data-n]').forEach(el => {
        const n = +el.dataset.n;
        el.removeAttribute('data-n');
        if (reduce) {
          el.textContent = n;
          return;
        }
        let s = null;
        const f = t => {
          s ??= t;
          const p = Math.min(1, (t - s) / 800);
          el.textContent = Math.round(n * (1 - Math.pow(1 - p, 3)));
          if (p < 1) requestAnimationFrame(f);
        };
        requestAnimationFrame(f);
      });
    }

    function render(go) {
      const L = path.length;
      rows = [CATS];
      path.forEach((n, d) => {
        const k = kidsOf(n, path.slice(0, d + 1));
        if (k.length) rows.push(k);
      });
      const th = (path[0] && path[0].th) || DEF;
      for (const k in th) R.style.setProperty('--' + k, th[k]); /* each tab has its own colours */
      const want = rows.map((r, d) => d + '|' + path.slice(0, d).map(x => x.t).join('>')),
        box = $('.rows');
      keys.forEach((el, k) => {
        if (!want.includes(k)) {
          el.remove();
          keys.delete(k);
        }
      });
      rows.forEach((row, d) => {
        let el = keys.get(want[d]);
        if (!el) {
          el = document.createElement('div');
          el.className = 'row new' + (d ? '' : ' cats');
          el.innerHTML = row.map((n, j) => `<button class="nd" data-d="${d}" data-j="${j}" style="color:var(${n.c});--i:${j}"><i></i>${n.n != null ? (typeof n.n === 'number' ? `<strong data-n="${n.n}">0</strong>` : `<strong>${n.n}</strong>`) : ''}<span><b>${esc(n.t)}</b>${n.s ? `<small>${esc(n.s)}</small>` : ''}</span></button>`).join('');
          keys.set(want[d], el);
          setTimeout(() => el.classList.remove('new'), 1500);
        }
        box.appendChild(el);
        el.dataset.age = d < L - 1 ? L - 1 - d : 0; /* 1-2 steps back stay visible, older ones blur */
        el.querySelectorAll('.nd').forEach((b, j) => {
          const on = path[d] === row[j];
          if (on && !b.classList.contains('on')) {
            b.dataset.fresh = 1;
            setTimeout(() => delete b.dataset.fresh, 1000);
          }
          b.classList.toggle('on', on);
          b.setAttribute('aria-expanded', on);
        });
      });
      if (R.classList.contains('in')) runCounts();
      const last = path[L - 1],
        info = $('.info');
      info.className = 'info';
      void info.offsetWidth;
      info.classList.add('swap');
      if (last && last.form) {
        info.classList.add('cton');
        contact();
      } else info.innerHTML = last ? last.info() : `${kick('Profile')}<h2>${esc(D.name)}</h2><p>${esc(D.role)}</p><div class="tiles">${CATS.map((c,i) => c.form ? '' : `<button class="tile" data-cat="${i}"><b>${c.n}</b><span>${esc(c.t)}</span></button>`).join('')}</div><h3>Backend expertise</h3><p>${esc(D.backend_text)}</p>${chips(D.backend)}<button class="btn pri" data-cat="${LAST}">Start a project</button>`;
      requestAnimationFrame(() => {
        lines();
        if (go) settle();
      });
    }
    const openContact = (subject, msg) => {
      pre = {
        subject,
        msg
      };
      path = [CATS[LAST]];
      render(true);
    };
    R.addEventListener('click', e => {
      let b;
      if ((b = e.target.closest('.nd'))) {
        const d = +b.dataset.d,
          n = rows[d][+b.dataset.j],
          L = path.length;
        if (n.act) return openContact('Enquiry: ' + n.act);
        pre = null;
        if (path[d] === n) path = path.slice(0, d); /* tap the open card again: close it */
        else path = path.slice(0, d).concat(n);
        render(true);
      } else if ((b = e.target.closest('[data-cat]'))) {
        pre = null;
        path = [CATS[+b.dataset.cat]];
        render(true);
      } else if ((b = e.target.closest('[data-quote]'))) openContact('Enquiry: ' + b.dataset.quote);
      else if (e.target.closest('[data-hire]')) openContact();
      else if (e.target.closest('[data-reset]')) {
        pre = null;
        path = [];
        render(true);
      }
    });
    $('.ask').addEventListener('submit', e => {
      e.preventDefault();
      const raw = e.target.q.value.trim(),
        q = raw.toLowerCase();
      if (!q) return;
      const has = n => (n.t + ' ' + (n.s || '')).toLowerCase().includes(q) || n.info().toLowerCase().includes(q);
      for (let i = 0; i < LAST; i++) {
        const items = kidsOf(CATS[i], [CATS[i]]);
        for (const it of items)
          if (has(it)) {
            pre = null;
            path = [CATS[i], it];
            return render(true);
          }
        for (const it of items)
          for (const k of kidsOf(it, [CATS[i], it]))
            if (!k.act && (k.t + ' ' + k.s).toLowerCase().includes(q)) {
              pre = null;
              path = [CATS[i], it, k];
              return render(true);
            }
      }
      openContact(raw.slice(0, 150), raw);
    });
    const T = $('.tree');
    let lw = 0;
    if ('ResizeObserver' in window) new ResizeObserver(() => {
      if (T.offsetWidth !== lw) {
        lw = T.offsetWidth;
        lines();
      }
    }).observe(T);
    else addEventListener('resize', lines);
    document.fonts?.ready.then(lines);
    if ('IntersectionObserver' in window) {
      const io = new IntersectionObserver(es => {
        if (es.some(e => e.isIntersecting)) {
          R.classList.add('in');
          runCounts();
          io.disconnect();
        }
      }, {
        threshold: .05
      });
      io.observe(R);
    } else {
      R.classList.add('in');
      runCounts();
    }
    if (/[?&](sent|wait|err)/.test(location.search)) path = [CATS[LAST]];
    render(false);
  })();
</script>
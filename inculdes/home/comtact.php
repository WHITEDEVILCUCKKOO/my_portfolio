<?php
/* ONE SECTION ONLY (id="contact"). Include where you want it:  <?php include 'abh-contact.php'; ?>
   Uses your $S (email, phone, github, linkedin, hero_stack), $services, $projects, $exp, $skills, $wait, $v and abh_* helpers.
   The form keeps your backend contract: POST contact.php with csrf, abh_hp_x (honeypot), name, email, phone, subject, message,
   and the ?sent / ?wait / ?err messages + wait timer. Without your variables it falls back to your real data from abhi_portfolio.sql. */
if (!function_exists('abh_e')) {
  function abh_e($s)
  {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
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
$S = $S ?? ['name' => 'Abhi', 'github' => 'https://github.com/WHITEDEVILCUCKKOO', 'hero_stack' => 'PHP,Python,Flask,Django,MySQL,REST APIs'];
$v = $v ?? fn($k) => abh_e($S[$k] ?? '');
$wait = $wait ?? 0;
$services = $services ?? ['Website Design', 'Frontend Development', 'PHP Development', 'Python Development', 'Flask & Django Development', 'API & REST API Development', 'Database Management', 'E-commerce Development', 'Admin Panel Development', 'Website Maintenance', 'Hosting & Deployment'];
$stack = array_values(array_filter(array_map('trim', explode(',', (string)($S['hero_stack'] ?? '')))));
/* real data fallbacks (from abhi_portfolio.sql) used only when your page does not define the variables */
$P = $projects ?? array_map(fn($r) => ['name' => $r[0], 'category' => $r[1], 'live_url' => $r[2]], [
  ['Vedayur Healthcare', 'Healthcare Website', 'https://vedayurhealthcare.com/'],
  ['Eagletfly', 'Education / Institute Website', 'https://eagletflysolutions.com/'],
  ['King Digital', 'Marketing Website', ''],
  ['Prudentia Learning', 'Learning Platform', ''],
  ['King Digital', 'Business Website', 'https://www.kingdigital.in/'],
  ['Shivam Uniform', 'E-commerce Website', 'https://shivamuniform.com/'],
  ['Groom Car', 'Car Rental Website', 'https://www.groomcar.co.in/'],
  ['Daur Productions', 'Creative Production Website', 'https://daurproductions.com/'],
  ['PythonAnywhere Web Application', 'Python Web Application', 'https://abhicuckoo404.pythonanywhere.com/']
]);
$E = $exp ?? [['role' => 'Web Developer', 'company' => 'Bhaum Technologies', 'period' => '9 Months'], ['role' => 'Web Developer & Web Designer', 'company' => 'King Digital', 'period' => '4']];
$SK = $skills ?? ['Languages' => ['PHP', 'Python', 'C', 'C++', 'JavaScript', 'SQL'], 'Frontend' => ['HTML5', 'CSS3', 'Bootstrap', 'Responsive Web Design'], 'API & Backend' => ['Flask', 'Django', 'REST API Development', 'API Integration'], 'Database' => ['MySQL', 'SQL'], 'Tools & Hosting' => ['Git', 'GitHub', 'cPanel', 'FastPanel', 'XAMPP', 'Mpanel']];
$uniq = [];
foreach ($SK as $items) {
  foreach ((array)$items as $i) {
    $uniq[strtolower(trim((string)$i))] = 1;
  }
}
$recent = [];
foreach ($P as $r) {
  $u = abh_url($r['live_url'] ?? '');
  if ($u) {
    $recent[] = [$r['name'] ?? '', $r['category'] ?? '', $u];
  }
  if (count($recent) >= 3) break;
}
$stats = [[count($P), 'Projects'], [count($services), 'Services'], [count($uniq), 'Technologies'], [count($E), 'Roles']];
$ic = [
  'mail'     => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
  'phone'    => '<path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2Z"/>',
  'github'   => '<path d="m8 8-5 4 5 4M16 8l5 4-5 4M14 5l-4 14"/>',
  'linkedin' => '<path d="M10 14a4 4 0 0 0 5.7 0l3-3a4 4 0 0 0-5.7-5.7l-1 1M14 10a4 4 0 0 0-5.7 0l-3 3a4 4 0 0 0 5.7 5.7l1-1"/>',
];
$ways = [];
if (trim((string)($S['email'] ?? '')) !== '') {
  $ways[] = ['Email', $S['email'], 'mailto:' . $S['email'], 'mail', true, false];
}
if (trim((string)($S['phone'] ?? '')) !== '') {
  $ways[] = ['Phone', $S['phone'], 'tel:' . $S['phone'], 'phone', true, false];
}
if (abh_url($S['github'] ?? '')) {
  $ways[] = ['GitHub', preg_replace('~^https?://(www\.)?~i', '', rtrim($S['github'], '/')), $S['github'], 'github', false, true];
}
if (abh_url($S['linkedin'] ?? '')) {
  $ways[] = ['LinkedIn', preg_replace('~^https?://(www\.)?~i', '', rtrim($S['linkedin'], '/')), $S['linkedin'], 'linkedin', false, true];
}
?>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Roboto+Condensed:wght@500;600;700&display=swap');

  @property --abhca {
    syntax: '<angle>';
    initial-value: 0deg;
    inherits: false
  }

  #abhc {
    --ink: #ece6de;
    --mute: #8d857b;
    --edge: rgba(196, 145, 92, .24);
    --ac: #3aa0ff;
    --ac2: #22c4ff;
    --cond: 'Roboto Condensed', 'Arial Narrow', sans-serif;
    --px: clamp(14px, 3vw, 24px);
    --py: clamp(80px, 10vw, 130px);
    --p: .5;
    --e: 1;
    position: relative;
    isolation: isolate;
    padding: var(--py) var(--px);
    background: #0b0a09;
    color: var(--ink);
    font: 400 14px/1.55 'Inter', system-ui, sans-serif;
    box-sizing: border-box
  }

  #abhc *,
  #abhc *::before,
  #abhc *::after {
    box-sizing: border-box
  }

  #abhc h2,
  #abhc h3,
  #abhc p,
  #abhc ul,
  #abhc fieldset,
  #abhc legend {
    margin: 0;
    padding: 0;
    border: 0
  }

  #abhc ul {
    list-style: none
  }

  #abhc a {
    color: inherit;
    text-decoration: none
  }

  #abhc button,
  #abhc input,
  #abhc textarea {
    font: inherit;
    color: inherit
  }

  #abhc :focus-visible {
    outline: 2px solid var(--ac2);
    outline-offset: 3px
  }

  /* scroll progress bar (sits under your sticky header) */
  #abhc .prog {
    position: sticky;
    top: var(--hg, 0px);
    z-index: 6;
    height: 0;
    margin: calc(-1*var(--py)) calc(-1*var(--px)) var(--py)
  }

  #abhc .prog i {
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    height: 3px;
    transform-origin: left;
    transform: scaleX(var(--p));
    background: linear-gradient(90deg, var(--ac2), var(--ac), #c4915c);
    box-shadow: 0 0 12px rgba(34, 196, 255, .6)
  }

  /* background layer: clipped on its own, so the sticky column keeps working */
  #abhc .fx {
    position: absolute;
    inset: 0;
    z-index: -1;
    overflow: hidden;
    pointer-events: none
  }

  #abhc .bg {
    position: absolute;
    inset: 0;
    background-image: linear-gradient(rgba(196, 145, 92, .05) 1px, transparent 1px), linear-gradient(90deg, rgba(196, 145, 92, .05) 1px, transparent 1px);
    background-size: 56px 56px;
    background-position: 0 calc(var(--p)*-90px);
    -webkit-mask: radial-gradient(ellipse 70% 60% at 50% 40%, #000, transparent 80%);
    mask: radial-gradient(ellipse 70% 60% at 50% 40%, #000, transparent 80%)
  }

  #abhc .blob {
    position: absolute;
    border-radius: 50%;
    filter: blur(70px);
    animation: abhcdrift 16s ease-in-out infinite alternate
  }

  #abhc .b1 {
    width: 480px;
    height: 480px;
    left: -120px;
    top: 10%;
    background: rgba(196, 145, 92, .16);
    translate: 0 calc((var(--p) - .5)*-160px)
  }

  #abhc .b2 {
    width: 520px;
    height: 520px;
    right: -140px;
    bottom: 0;
    background: rgba(58, 160, 255, .15);
    animation-delay: -6s;
    translate: 0 calc((var(--p) - .5)*140px)
  }

  #abhc .wrap {
    max-width: 1180px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: minmax(0, 5fr) minmax(0, 7fr);
    gap: clamp(28px, 5vw, 64px);
    align-items: start
  }

  #abhc .side {
    position: sticky;
    top: var(--top, 110px);
    min-width: 0
  }

  #abhc .side.unpin {
    position: static
  }

  #abhc .rv {
    opacity: 0;
    transform: translateY(26px);
    transition: opacity .8s ease, transform .8s cubic-bezier(.2, .75, .25, 1);
    transition-delay: calc(var(--d, 0)*110ms)
  }

  #abhc.on .rv {
    opacity: 1;
    transform: none
  }

  #abhc .rf {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity .6s ease, transform .6s cubic-bezier(.2, .75, .25, 1);
    transition-delay: calc(var(--i, 0)*50ms)
  }

  #abhc .rf.in {
    opacity: 1;
    transform: none
  }

  #abhc .eyebrow {
    display: flex;
    align-items: center;
    gap: 12px;
    color: #c4915c;
    font: 600 12px/1 'Inter', sans-serif;
    letter-spacing: .22em;
    text-transform: uppercase;
    margin-bottom: 16px
  }

  #abhc .eyebrow::before {
    content: "";
    width: 34px;
    height: 2px;
    background: #c4915c
  }

  #abhc h2 {
    font: 700 clamp(44px, 5.6vw, 88px)/1.02 'Inter', sans-serif;
    letter-spacing: -.035em;
    color: #9a9a9a
  }

  #abhc .rot {
    display: inline-grid;
    vertical-align: bottom;
    overflow: hidden;
    padding-bottom: .08em
  }

  #abhc .rot>span {
    grid-area: 1/1;
    opacity: 0;
    transform: translateY(70%);
    background: linear-gradient(100deg, var(--ac2), var(--ac) 40%, #c4915c 80%, var(--ac2));
    background-size: 220% 100%;
    background-position: calc(var(--p)*100%) 0;
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    animation: abhcword 10s infinite;
    animation-delay: calc(var(--k)*2.5s)
  }

  #abhc .dot {
    color: #c4915c
  }

  #abhc .lead {
    margin-top: 16px;
    max-width: 440px;
    color: #a79f94;
    font-size: 16px
  }

  #abhc .ways {
    display: grid;
    gap: 10px;
    margin-top: clamp(20px, 3vw, 30px)
  }

  #abhc .way {
    display: flex;
    align-items: center;
    gap: 6px;
    border-radius: 16px;
    background: #14110e;
    border: 1px solid var(--edge);
    transition: transform .3s, border-color .3s, box-shadow .3s
  }

  #abhc .way:hover {
    transform: translateY(-3px);
    border-color: var(--ac);
    box-shadow: 0 14px 34px -14px rgba(58, 160, 255, .5)
  }

  #abhc .way a {
    flex: 1;
    min-width: 0;
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 12px 16px
  }

  #abhc .ico {
    flex: none;
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: grid;
    place-items: center;
    background: linear-gradient(135deg, rgba(34, 196, 255, .2), rgba(58, 160, 255, .12));
    color: var(--ac2)
  }

  #abhc .ico svg {
    width: 20px;
    height: 20px
  }

  #abhc .way small {
    display: block;
    color: var(--mute);
    font-size: 11.5px;
    letter-spacing: .08em;
    text-transform: uppercase
  }

  #abhc .way b {
    display: block;
    font-weight: 600;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap
  }

  #abhc .cp {
    flex: none;
    width: 34px;
    height: 34px;
    margin-right: 12px;
    display: grid;
    place-items: center;
    border-radius: 10px;
    border: 1px solid var(--edge);
    background: none;
    color: #d8d0c6;
    cursor: pointer;
    transition: border-color .2s, background .2s, color .2s
  }

  #abhc .cp svg {
    width: 16px;
    height: 16px
  }

  #abhc .cp:hover {
    border-color: var(--ac);
    background: rgba(58, 160, 255, .12)
  }

  #abhc .cp.ok {
    border-color: #4fd18b;
    color: #4fd18b
  }

  #abhc .go {
    flex: none;
    margin-right: 16px;
    color: var(--mute);
    transition: transform .25s, color .25s
  }

  #abhc .way:hover .go {
    transform: translate(3px, -3px);
    color: var(--ac2)
  }

  #abhc .note {
    margin-top: 14px;
    color: var(--mute)
  }

  #abhc .stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 8px;
    margin-top: 14px
  }

  #abhc .stats li {
    padding: 12px 10px;
    border-radius: 14px;
    text-align: center;
    background: linear-gradient(160deg, rgba(196, 145, 92, .1), rgba(20, 16, 12, .6));
    border: 1px solid rgba(196, 145, 92, .2);
    transition: transform .3s, border-color .3s
  }

  #abhc .stats li:hover {
    transform: translateY(-3px);
    border-color: #c4915c
  }

  #abhc .stats b {
    display: block;
    font: 600 28px/1 var(--cond);
    color: #fff
  }

  #abhc .stats span {
    display: block;
    margin-top: 4px;
    color: var(--mute);
    font-size: 11px;
    letter-spacing: .06em;
    text-transform: uppercase
  }

  #abhc .tabs {
    position: relative;
    display: flex;
    gap: 4px;
    margin-top: 18px;
    border-bottom: 1px solid var(--edge)
  }

  #abhc .tabs button {
    padding: 9px 14px;
    color: var(--mute);
    border: 0;
    background: none;
    cursor: pointer;
    font-weight: 600;
    font-size: 13px;
    transition: color .2s
  }

  #abhc .tabs button:hover,
  #abhc .tabs button[aria-selected="true"] {
    color: #fff
  }

  #abhc .ink {
    position: absolute;
    left: 0;
    bottom: -1px;
    height: 2px;
    width: 0;
    background: linear-gradient(90deg, var(--ac2), var(--ac));
    transition: left .35s cubic-bezier(.2, .75, .25, 1), width .35s cubic-bezier(.2, .75, .25, 1)
  }

  #abhc .tabp {
    min-height: 128px;
    padding-top: 14px
  }

  #abhc .tabp:not([hidden]) {
    animation: abhcslide .4s cubic-bezier(.2, .75, .25, 1)
  }

  #abhc .lst {
    display: grid;
    gap: 8px
  }

  #abhc .lst a,
  #abhc .lst li>div {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 9px 12px;
    border-radius: 12px;
    background: #100e0b;
    border: 1px solid rgba(196, 145, 92, .16);
    transition: border-color .25s, transform .25s
  }

  #abhc .lst a:hover {
    border-color: var(--ac);
    transform: translateX(4px)
  }

  #abhc .lst b {
    font-weight: 600;
    display: block
  }

  #abhc .lst small {
    color: var(--mute);
    font-size: 12px
  }

  #abhc .lst .ar {
    color: var(--mute);
    transition: color .2s, transform .2s
  }

  #abhc .lst a:hover .ar {
    color: var(--ac2);
    transform: translate(2px, -2px)
  }

  #abhc .tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px
  }

  #abhc .tags li {
    padding: 4px 12px;
    border-radius: 999px;
    font-size: 12.5px;
    background: rgba(196, 145, 92, .08);
    border: 1px solid rgba(196, 145, 92, .3);
    transition: transform .2s, border-color .2s
  }

  #abhc .tags li:hover {
    transform: translateY(-2px);
    border-color: #c4915c
  }

  #abhc .card {
    position: relative;
    padding: clamp(20px, 3.5vw, 38px);
    border-radius: 26px;
    background: linear-gradient(160deg, #1a1612, #0e0c0a);
    border: 1px solid var(--edge);
    box-shadow: 0 30px 80px rgba(0, 0, 0, .55);
    scale: calc(.95 + var(--e)*.05)
  }

  #abhc .card::before {
    content: "";
    position: absolute;
    inset: -1px;
    border-radius: inherit;
    padding: 1.5px;
    background: conic-gradient(from var(--abhca), transparent 0 65%, var(--ac2), var(--ac), transparent);
    -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
    -webkit-mask-composite: xor;
    mask: linear-gradient(#000 0 0) content-box exclude, linear-gradient(#000 0 0);
    opacity: 0;
    transition: opacity .4s;
    animation: abhcspin 5s linear infinite;
    pointer-events: none
  }

  #abhc .card:focus-within::before {
    opacity: 1
  }

  #abhc .card::after {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: inherit;
    background: radial-gradient(420px circle at var(--mx, 50%) var(--my, 0%), rgba(58, 160, 255, .12), transparent 60%);
    opacity: 0;
    transition: opacity .3s;
    pointer-events: none
  }

  #abhc .card:hover::after {
    opacity: 1
  }

  #abhc .card h3 {
    font: 600 clamp(22px, 3vw, 28px)/1.2 var(--cond);
    margin: 0 0 4px
  }

  #abhc .card .sub {
    color: var(--mute);
    margin-bottom: 18px
  }

  #abhc .abh-form {
    display: grid;
    gap: 16px
  }

  #abhc .pick legend {
    color: var(--mute);
    font-size: 12px;
    letter-spacing: .12em;
    text-transform: uppercase;
    margin-bottom: 10px
  }

  #abhc .pick div {
    display: flex;
    flex-wrap: wrap;
    gap: 8px
  }

  #abhc .pick button {
    padding: 6px 13px;
    border-radius: 999px;
    border: 1px solid var(--edge);
    background: #100e0b;
    font-size: 12.5px;
    cursor: pointer;
    transition: transform .2s, border-color .2s, background .2s
  }

  #abhc .pick button:hover {
    transform: translateY(-2px);
    border-color: var(--ac)
  }

  #abhc .pick button[aria-pressed="true"] {
    background: linear-gradient(135deg, var(--ac2), var(--ac));
    border-color: transparent;
    color: #04121a;
    font-weight: 600
  }

  #abhc .abh-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px
  }

  #abhc .f {
    position: relative;
    display: block
  }

  #abhc .f input,
  #abhc .f textarea {
    width: 100%;
    padding: 23px 14px 8px;
    border-radius: 12px;
    background: #0f0d0b;
    border: 1px solid var(--edge);
    color: var(--ink);
    transition: border-color .25s, box-shadow .25s
  }

  #abhc .f textarea {
    resize: vertical;
    min-height: 130px
  }

  #abhc .f span {
    position: absolute;
    left: 15px;
    top: 15px;
    color: var(--mute);
    pointer-events: none;
    transform-origin: left top;
    transition: transform .2s, color .2s
  }

  #abhc .f input:focus+span,
  #abhc .f input:not(:placeholder-shown)+span,
  #abhc .f textarea:focus+span,
  #abhc .f textarea:not(:placeholder-shown)+span {
    transform: translateY(-10px) scale(.76);
    color: var(--ac2)
  }

  #abhc .f input:focus,
  #abhc .f textarea:focus {
    outline: 0;
    border-color: var(--ac);
    box-shadow: 0 0 0 3px rgba(58, 160, 255, .18)
  }

  #abhc .f input:user-invalid,
  #abhc .f textarea:user-invalid {
    border-color: #e4608f
  }

  #abhc .cnt {
    position: absolute;
    right: 12px;
    bottom: 8px;
    font-size: 11px;
    color: var(--mute);
    pointer-events: none;
    font-style: normal
  }

  #abhc .cnt.hi {
    color: #f0b45b
  }

  #abhc .abh-hp {
    position: absolute !important;
    left: -9999px !important;
    width: 1px !important;
    height: 1px !important;
    opacity: 0
  }

  #abhc .abh-ok,
  #abhc .abh-bad {
    padding: 12px 14px;
    border-radius: 12px;
    font-weight: 500;
    animation: abhcpop .45s cubic-bezier(.2, .75, .25, 1)
  }

  #abhc .abh-ok {
    background: rgba(79, 209, 139, .12);
    border: 1px solid rgba(79, 209, 139, .4);
    color: #4fd18b
  }

  #abhc .abh-bad {
    background: rgba(228, 96, 143, .12);
    border: 1px solid rgba(228, 96, 143, .4);
    color: #f594b4
  }

  #abhc .send {
    position: relative;
    overflow: hidden;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 15px 28px;
    border: 0;
    border-radius: 14px;
    font-weight: 700;
    color: #04121a;
    background: linear-gradient(135deg, var(--ac2), var(--ac));
    box-shadow: 0 12px 30px rgba(34, 196, 255, .28);
    cursor: pointer;
    transition: transform .25s, box-shadow .25s
  }

  #abhc .send::after {
    content: "";
    position: absolute;
    top: 0;
    bottom: 0;
    width: 60px;
    left: -80px;
    background: linear-gradient(100deg, transparent, rgba(255, 255, 255, .5), transparent);
    transform: skewX(-20deg)
  }

  #abhc .send:hover {
    transform: translateY(-3px);
    box-shadow: 0 18px 40px rgba(34, 196, 255, .4)
  }

  #abhc .send:hover::after {
    animation: abhcshine .8s
  }

  #abhc .send svg {
    width: 18px;
    height: 18px;
    transition: transform .25s
  }

  #abhc .send:hover svg {
    transform: translateX(4px)
  }

  #abhc .send[disabled] {
    opacity: .6;
    cursor: not-allowed;
    transform: none
  }

  #abhc .send.busy svg {
    animation: abhcspinr .8s linear infinite
  }

  #abhc .abh-wait {
    color: var(--mute)
  }

  @keyframes abhcdrift {
    from {
      transform: translate(0, 0) scale(1)
    }

    to {
      transform: translate(50px, 30px) scale(1.15)
    }
  }

  @keyframes abhcspin {
    to {
      --abhca: 360deg
    }
  }

  @keyframes abhcshine {
    to {
      left: 130%
    }
  }

  @keyframes abhcpop {
    from {
      opacity: 0;
      transform: scale(.96) translateY(6px)
    }
  }

  @keyframes abhcspinr {
    to {
      transform: rotate(360deg)
    }
  }

  @keyframes abhcslide {
    from {
      opacity: 0;
      transform: translateX(14px)
    }
  }

  @keyframes abhcword {
    0% {
      opacity: 0;
      transform: translateY(70%)
    }

    4%,
    21% {
      opacity: 1;
      transform: none
    }

    25%,
    100% {
      opacity: 0;
      transform: translateY(-70%)
    }
  }

  @media(max-width:960px) {
    #abhc .wrap {
      grid-template-columns: 1fr
    }

    #abhc .side {
      position: static
    }

    #abhc .lead {
      max-width: 560px
    }

    #abhc h2 {
      font-size: clamp(44px, 11vw, 84px)
    }
  }

  @media(max-width:560px) {
    #abhc .abh-row {
      grid-template-columns: 1fr
    }

    #abhc .send {
      width: 100%;
      justify-content: center
    }

    #abhc .stats {
      grid-template-columns: repeat(2, 1fr)
    }

    #abhc .tabs button {
      padding: 9px 10px
    }
  }

  @media(prefers-reduced-motion:reduce) {

    #abhc *,
    #abhc *::before,
    #abhc *::after {
      animation: none !important;
      transition: none !important
    }

    #abhc .rv,
    #abhc .rf {
      opacity: 1;
      transform: none
    }

    #abhc .rot>span:first-child {
      opacity: 1;
      transform: none
    }
  }
</style>

<section id="contact" aria-labelledby="abhcT" style="scroll-margin-top:90px">
  <div id="abhc">
    <div style="display: none;" class="prog" aria-hidden="true"><i></i></div>
    <div class="fx" aria-hidden="true">
      <div class="bg"></div>
      <div class="blob b1"></div>
      <div class="blob b2"></div>
    </div>
    <div class="wrap">
      <aside class="side">
        <p class="eyebrow rv">Get in touch</p>
        <h2 id="abhcT" class="rv" style="--d:1" aria-label="Let’s talk">Let&rsquo;s <span class="rot" aria-hidden="true"><span style="--k:0">talk</span><span style="--k:1">build</span><span style="--k:2">design</span><span style="--k:3">launch</span></span><span class="dot" aria-hidden="true">.</span></h2>
        <p class="lead rv" style="--d:2">Tell me about your website or web application.</p>

        <?php if ($ways): ?>
          <ul class="ways">
            <?php foreach ($ways as $i => [$label, $value, $href, $icon, $copy, $ext]): ?>
              <li class="rv" style="--d:<?= $i + 3 ?>">
                <div class="way">
                  <a href="<?= abh_e($href) ?>" <?= $ext ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
                    <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?= $ic[$icon] ?></svg></span>
                    <span style="min-width:0"><small><?= abh_e($label) ?></small><b><?= abh_e($value) ?></b></span>
                  </a>
                  <?php if ($copy): ?><button class="cp" type="button" data-copy="<?= abh_e($value) ?>" aria-label="Copy <?= abh_e($label) ?>"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="9" y="9" width="11" height="11" rx="2" />
                        <path d="M5 15V6a2 2 0 0 1 2-2h9" />
                      </svg></button>
                  <?php else: ?><span class="go" aria-hidden="true">&#8599;</span><?php endif; ?>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php else: ?><p class="note rv" style="--d:3">Use the form and I will get back to you.</p><?php endif; ?>

        <ul class="stats rv" style="--d:5">
          <?php foreach ($stats as [$n, $l]): ?><li><b data-n="<?= (int)$n ?>">0</b><span><?= abh_e($l) ?></span></li><?php endforeach; ?>
        </ul>

        <div class="rv" style="--d:6">
          <div class="tabs" role="tablist" aria-label="More about me">
            <button type="button" role="tab" id="abhct0" aria-controls="abhcp0" aria-selected="true">Recent work</button>
            <button type="button" role="tab" id="abhct1" aria-controls="abhcp1" aria-selected="false" tabindex="-1">Experience</button>
            <?php if ($stack): ?><button type="button" role="tab" id="abhct2" aria-controls="abhcp2" aria-selected="false" tabindex="-1">Stack</button><?php endif; ?>
            <i class="ink"></i>
          </div>
          <div class="tabp" id="abhcp0" role="tabpanel" aria-labelledby="abhct0">
            <ul class="lst"><?php foreach ($recent as [$n, $c, $u]): ?><li><a href="<?= abh_e($u) ?>" target="_blank" rel="noopener noreferrer"><span><b><?= abh_e($n) ?></b><small><?= abh_e($c) ?></small></span><span class="ar" aria-hidden="true">&#8599;</span></a></li><?php endforeach; ?></ul>
          </div>
          <div class="tabp" id="abhcp1" role="tabpanel" aria-labelledby="abhct1" hidden>
            <ul class="lst"><?php foreach ($E as $e): $per = trim((string)($e['period'] ?? ''));
                              $sub = trim(($e['company'] ?? '') . ((($e['company'] ?? '') !== '' && preg_match('~[a-z]~i', $per)) ? ' · ' : '') . (preg_match('~[a-z]~i', $per) ? $per : '')); ?><li>
                  <div><span><b><?= abh_e($e['role'] ?? '') ?></b><small><?= abh_e($sub) ?></small></span></div>
                </li><?php endforeach; ?></ul>
          </div>
          <?php if ($stack): ?><div class="tabp" id="abhcp2" role="tabpanel" aria-labelledby="abhct2" hidden>
              <ul class="tags"><?php foreach ($stack as $t): ?><li><?= abh_e($t) ?></li><?php endforeach; ?></ul>
            </div><?php endif; ?>
        </div>
      </aside>

      <div class="card rv" style="--d:2">
        <div class="rf" style="--i:0">
          <h3>Send me a message</h3>
          <p class="sub">All fields except phone are required.</p>
        </div>
        <form class="abh-form" id="abhForm" data-wait="<?= (int)$wait ?>" method="post" action="contact.php">
          <?php if (isset($_GET['sent'])): ?><p class="abh-ok" role="status">Thanks, your message was sent.</p><?php elseif (isset($_GET['wait'])): ?><p class="abh-bad" role="alert">You already sent a message recently. Please wait for the timer below.</p><?php elseif (isset($_GET['err'])): ?><p class="abh-bad" role="alert"><?= (int)$_GET['err'] === 2 ? 'Your message could not be saved. Please try again later.' : ((int)$_GET['err'] === 3 ? 'Session expired. Reload the page and try again.' : 'Please check the form: all fields except phone are required.') ?></p><?php endif; ?>
          <input type="hidden" name="csrf" value="<?= abh_e(abh_csrf()) ?>">
          <input class="abh-hp" type="text" name="abh_hp_x" tabindex="-1" autocomplete="off" aria-hidden="true">

          <?php if ($services): ?>
            <fieldset class="pick rf" style="--i:1">
              <legend>What do you need?</legend>
              <div><?php foreach (array_slice($services, 0, 12) as $s): ?><button type="button" aria-pressed="false" data-s="<?= abh_e($s) ?>"><?= abh_e($s) ?></button><?php endforeach; ?></div>
            </fieldset>
          <?php endif; ?>

          <div class="abh-row rf" style="--i:2">
            <label class="f"><input name="name" placeholder=" " required minlength="2" maxlength="100" autocomplete="name"><span>Name</span></label>
            <label class="f"><input type="email" name="email" placeholder=" " required maxlength="150" autocomplete="email"><span>Email</span></label>
          </div>
          <div class="abh-row rf" style="--i:3">
            <label class="f"><input type="tel" name="phone" placeholder=" " maxlength="30" autocomplete="tel"><span>Phone (optional)</span></label>
            <label class="f"><input name="subject" placeholder=" " required minlength="3" maxlength="150"><span>Subject</span></label>
          </div>
          <label class="f rf" style="--i:4"><textarea name="message" placeholder=" " rows="5" required minlength="10" maxlength="3000"></textarea><span>Message</span><i class="cnt" aria-hidden="true">0 / 3000</i></label>

          <div class="rf" style="--i:5"><button class="send" id="abhSend" type="submit"><span>Send message</span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M5 12h14M13 6l6 6-6 6" />
              </svg></button></div>
          <p class="abh-wait" id="abhWait" role="timer" hidden></p>
        </form>
      </div>
    </div>
  </div>
</section>

<script>
  (function() {
    var S = document.getElementById('abhc');
    if (!S) return;
    var $ = function(s) {
        return S.querySelector(s)
      },
      $$ = function(s) {
        return [].slice.call(S.querySelectorAll(s))
      };
    var f = $('form'),
      subj = f.subject,
      msg = f.message,
      cnt = $('.cnt'),
      btn = $('.send'),
      w = $('#abhWait'),
      chips = $$('.pick button'),
      side = $('.side'),
      card = $('.card');
    var reduce = matchMedia('(prefers-reduced-motion:reduce)').matches;

    /* header height (fixed/sticky site header), so the progress bar and the pinned column sit below it */
    function hb() {
      var h = 0;
      document.querySelectorAll('header,nav,[class*="header"],[class*="navbar"]').forEach(function(el) {
        if (S.contains(el)) return;
        var cs = getComputedStyle(el);
        if (cs.position === 'fixed' || cs.position === 'sticky') {
          var b = el.getBoundingClientRect();
          if (b.top <= 24 && b.bottom > 0) h = Math.max(h, b.bottom)
        }
      });
      return h
    }

    function fit() {
      var h = hb();
      S.style.setProperty('--hg', h + 'px');
      S.style.setProperty('--top', (h + 16) + 'px');
      side.classList.toggle('unpin', innerWidth <= 960 || side.offsetHeight > innerHeight - h - 32)
    } /* pin only when it fits the screen */

    /* scroll-linked effects: --p = how far the section has passed, --e = how far the form has come into view */
    var raf = 0;

    function onScroll() {
      if (raf) return;
      raf = requestAnimationFrame(function() {
        raf = 0;
        var r = S.getBoundingClientRect(),
          vh = innerHeight,
          c = card.getBoundingClientRect();
        S.style.setProperty('--p', Math.min(1, Math.max(0, (vh - r.top) / (r.height + vh))).toFixed(4));
        S.style.setProperty('--e', Math.min(1, Math.max(0, (vh - c.top) / (vh * .55))).toFixed(3))
      })
    }
    if (!reduce) {
      addEventListener('scroll', onScroll, {
        passive: true
      });
      onScroll()
    }
    addEventListener('resize', function() {
      fit();
      onScroll()
    });
    fit();
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(fit);

    /* subject chips */
    function sync() {
      chips.forEach(function(b) {
        b.setAttribute('aria-pressed', b.dataset.s === subj.value)
      })
    }

    function setSubject(t) {
      subj.value = t;
      sync();
      subj.dispatchEvent(new Event('input', {
        bubbles: true
      }))
    }
    chips.forEach(function(b) {
      b.addEventListener('click', function() {
        setSubject(b.getAttribute('aria-pressed') === 'true' ? '' : b.dataset.s)
      })
    });
    subj.addEventListener('input', sync);

    function count() {
      cnt.textContent = msg.value.length + ' / 3000';
      cnt.classList.toggle('hi', msg.value.length > 2700)
    }
    msg.addEventListener('input', count);
    count();

    /* copy buttons */
    S.addEventListener('click', function(e) {
      var b = e.target.closest('[data-copy]');
      if (!b) return;
      var t = b.dataset.copy;

      function done() {
        b.classList.add('ok');
        setTimeout(function() {
          b.classList.remove('ok')
        }, 1600)
      }
      if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(t).then(done, function() {})
      } else {
        var i = document.createElement('input');
        i.value = t;
        document.body.appendChild(i);
        i.select();
        try {
          document.execCommand('copy');
          done()
        } catch (x) {}
        i.remove()
      }
    });

    /* tabs */
    var tabs = $$('[role=tab]'),
      ink = $('.ink');

    function inkTo(t) {
      ink.style.left = t.offsetLeft + 'px';
      ink.style.width = t.offsetWidth + 'px'
    }

    function pickTab(t) {
      tabs.forEach(function(x) {
        var on = x === t;
        x.setAttribute('aria-selected', on);
        x.tabIndex = on ? 0 : -1;
        document.getElementById(x.getAttribute('aria-controls')).hidden = !on
      });
      inkTo(t);
      fit()
    }
    tabs.forEach(function(t, i) {
      t.addEventListener('click', function() {
        pickTab(t)
      });
      t.addEventListener('keydown', function(e) {
        var n = e.key === 'ArrowRight' ? 1 : e.key === 'ArrowLeft' ? -1 : 0;
        if (n) {
          var x = tabs[(i + n + tabs.length) % tabs.length];
          x.focus();
          pickTab(x)
        }
      })
    });
    inkTo(tabs[0]);
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(function() {
      inkTo(tabs.filter(function(x) {
        return x.getAttribute('aria-selected') === 'true'
      })[0])
    });

    /* other sections can send an enquiry here: <a href="#contact" data-subject="..."> or dispatchEvent(new CustomEvent('abh:enquire',{detail:{subject:'...'}})) */
    function enquire(t) {
      if (t) setSubject(t);
      setTimeout(function() {
        msg.focus({
          preventScroll: true
        })
      }, 700)
    }
    document.addEventListener('click', function(e) {
      var a = e.target.closest && e.target.closest('a[href="#contact"][data-subject]');
      if (a) enquire(a.dataset.subject)
    });
    addEventListener('abh:enquire', function(e) {
      enquire(e.detail && e.detail.subject)
    });

    /* spotlight on the form card + magnetic send button (mouse only) */
    if (!reduce && matchMedia('(hover:hover)').matches) {
      card.addEventListener('pointermove', function(e) {
        var r = card.getBoundingClientRect();
        card.style.setProperty('--mx', (e.clientX - r.left) + 'px');
        card.style.setProperty('--my', (e.clientY - r.top) + 'px')
      });
      btn.addEventListener('pointermove', function(e) {
        var r = btn.getBoundingClientRect();
        btn.style.translate = ((e.clientX - r.left - r.width / 2) * .12) + 'px ' + ((e.clientY - r.top - r.height / 2) * .25) + 'px'
      });
      btn.addEventListener('pointerleave', function() {
        btn.style.translate = ''
      })
    }

    /* sending state + wait timer */
    f.addEventListener('submit', function() {
      if (f.checkValidity()) {
        btn.classList.add('busy');
        btn.disabled = true;
        btn.firstChild.textContent = 'Sending...'
      }
    });
    addEventListener('pageshow', function() {
      btn.classList.remove('busy');
      btn.disabled = false;
      btn.firstChild.textContent = 'Send message'
    });
    var n = +f.dataset.wait;
    if (n > 0 && /[?&]wait/.test(location.search)) {
      var t = n;
      btn.disabled = true;
      w.hidden = false;
      var tick = function() {
        w.textContent = 'You can send another message in ' + t + 's';
        if (t-- <= 0) {
          clearInterval(id);
          btn.disabled = false;
          w.hidden = true
        }
      };
      var id = setInterval(tick, 1000);
      tick()
    }

    /* reveal on scroll: section pieces, then each form field as it comes into view; stats count up */
    function counts() {
      $$('b[data-n]').forEach(function(el) {
        var n = +el.dataset.n;
        el.removeAttribute('data-n');
        if (reduce) {
          el.textContent = n;
          return
        }
        var s = null;
        var st = function(ts) {
          s = s || ts;
          var p = Math.min(1, (ts - s) / 900);
          el.textContent = Math.round(n * (1 - Math.pow(1 - p, 3)));
          if (p < 1) requestAnimationFrame(st)
        };
        requestAnimationFrame(st)
      })
    }
    if ('IntersectionObserver' in window) {
      var io = new IntersectionObserver(function(es) {
        if (es.some(function(x) {
            return x.isIntersecting
          })) {
          S.classList.add('on');
          counts();
          io.disconnect()
        }
      }, {
        threshold: .1
      });
      io.observe(S);
      var io2 = new IntersectionObserver(function(es) {
        es.forEach(function(x) {
          if (x.isIntersecting) {
            x.target.classList.add('in');
            io2.unobserve(x.target)
          }
        })
      }, {
        threshold: .2
      });
      $$('.rf').forEach(function(el) {
        io2.observe(el)
      })
    } else {
      S.classList.add('on');
      counts();
      $$('.rf').forEach(function(el) {
        el.classList.add('in')
      })
    }
  })();
</script>
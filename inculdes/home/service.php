<?php
/* ONE SECTION ONLY. Include where you want it:  <?php include 'abh-products.php'; ?>
   Shows your real $projects rows (name, category, description, tech, live_url, screenshot) as products.
   If $projects is not defined, your real data from abhi_portfolio.sql is used, so it also works standalone.
   Optional: $products (custom rows with price etc.), $S['products_title'], $S['products_text'], $products_auto_shot = true */
if (!function_exists('abh_e'))    { function abh_e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); } }
if (!function_exists('abh_path')) { function abh_path($p){ return trim((string)$p); } }
if (!function_exists('abh_url'))  { function abh_url($u){ $u = trim((string)$u); return preg_match('~^https?://~i', $u) ? $u : ''; } }
$S = $S ?? [];
$products_auto_shot = $products_auto_shot ?? false;   /* true = use free WordPress mShots previews for projects with no screenshot */
$REAL = [   /* your real rows from abhi_portfolio.sql (ordered by sort_order, id) */
  ['name' => 'Vedayur Healthcare', 'category' => 'Healthcare Website', 'description' => 'Healthcare website development, enquiry forms, PHP integration, hosting and email configuration.', 'tech' => 'PHP', 'live_url' => 'https://vedayurhealthcare.com/', 'screenshot' => ''],
  ['name' => 'Eagletfly', 'category' => 'Education / Institute Website', 'description' => 'Institute website development, admin panel, course management, banner management, video management and database integration.', 'tech' => '', 'live_url' => 'https://eagletflysolutions.com/', 'screenshot' => ''],
  ['name' => 'King Digital', 'category' => 'Marketing Website', 'description' => '', 'tech' => 'Php', 'live_url' => '', 'screenshot' => ''],
  ['name' => 'Prudentia Learning', 'category' => 'Learning Platform', 'description' => 'Landing page development, deck page development and UI improvements.', 'tech' => '', 'live_url' => '', 'screenshot' => ''],
  ['name' => 'King Digital', 'category' => 'Business Website', 'description' => 'Website development, UI improvements, URL rewriting, maintenance and technical troubleshooting.', 'tech' => '.htaccess', 'live_url' => 'https://www.kingdigital.in/', 'screenshot' => ''],
  ['name' => 'Shivam Uniform', 'category' => 'E-commerce Website', 'description' => 'E-commerce website development, product management, category management, image uploads and MySQL database operations.', 'tech' => 'MySQL', 'live_url' => 'https://shivamuniform.com/', 'screenshot' => ''],
  ['name' => 'Groom Car', 'category' => 'Car Rental Website', 'description' => 'Website project.', 'tech' => '', 'live_url' => 'https://www.groomcar.co.in/', 'screenshot' => ''],
  ['name' => 'Daur Productions', 'category' => 'Creative Production Website', 'description' => 'Website project.', 'tech' => '', 'live_url' => 'https://daurproductions.com/', 'screenshot' => ''],
  ['name' => 'PythonAnywhere Web Application', 'category' => 'Python Web Application', 'description' => 'Web application hosted on PythonAnywhere. Framework and features to be confirmed.', 'tech' => 'Python', 'live_url' => 'https://abhicuckoo404.pythonanywhere.com/', 'screenshot' => ''],
];
$grouping = !isset($products);   /* products built from projects: filter by Websites / Web apps / E-commerce */
if ($grouping) {
    $products = [];
    foreach (array_values($projects ?? $REAL) as $n => $r) {
        $products[] = ['name' => $r['name'] ?? '', 'category' => $r['category'] ?? '', 'description' => $r['description'] ?? '', 'tech' => $r['tech'] ?? '',
                       'buy_url' => $r['live_url'] ?? '', 'image' => $r['screenshot'] ?? '', 'featured' => $n === 0 ? 1 : 0];
    }
}
$grp = function ($c) { if (preg_match('~e-?commerce|shop|store~i', $c)) return 'E-commerce'; if (preg_match('~application|platform|\bapp\b~i', $c)) return 'Web apps'; return 'Websites'; };
$PAL = [['#37b6c9', '55,182,201'], ['#9b7bff', '155,123,255'], ['#f0b45b', '240,180,91'], ['#e4608f', '228,96,143'], ['#4fd18b', '79,209,139'], ['#3aa0ff', '58,160,255']];
$ucf = fn($x) => mb_strtoupper(mb_substr($x, 0, 1)) . mb_substr($x, 1);
$items = []; $cats = [];
foreach (array_values($products) as $p) {
    $sub = trim((string)($p['category'] ?? '')) ?: 'Other';
    $cat = $grouping ? $grp($sub) : $sub;
    if (!in_array($cat, $cats, true)) { $cats[] = $cat; }
    $desc = trim((string)($p['description'] ?? ''));
    if (array_key_exists('features', $p)) { $f = $p['features']; if (is_string($f)) { $f = preg_split('~[\r\n,]+~', $f); } $ftl = "What's included"; }
    elseif ($grouping) { $d = rtrim($desc, '. '); $f = strpos($d, ',') !== false ? array_map($ucf, array_filter(array_map('trim', preg_split('~\s*,\s*(?:and\s+)?|\s+and\s+~i', $d)))) : []; $ftl = 'Work done'; }
    else { $f = []; $ftl = ''; }
    $price = trim((string)($p['price'] ?? '')); $old = trim((string)($p['old_price'] ?? ''));
    $pn = (float)preg_replace('~[^0-9.]~', '', $price); $on = (float)preg_replace('~[^0-9.]~', '', $old);
    $buy = abh_url($p['buy_url'] ?? ''); $img = abh_path($p['image'] ?? '');
    if ($img === '' && $buy !== '' && $products_auto_shot) { $img = 'https://s.wordpress.com/mshots/v1/' . rawurlencode($buy) . '?w=900&h=560'; }
    $items[] = ['name' => (string)($p['name'] ?? ''), 'cat' => $cat, 'sub' => $sub, 'ci' => array_search($cat, $cats, true) % count($PAL), 'price' => $price, 'old' => $old, 'pn' => $pn,
      'off' => ($on > $pn && $pn > 0) ? (int)round((1 - $pn / $on) * 100) : 0, 'desc' => $desc, 'feat' => array_values(array_filter(array_map('trim', (array)$f))), 'ftl' => $ftl,
      'tech' => array_values(array_filter(array_map('trim', explode(',', (string)($p['tech'] ?? ''))))), 'img' => $img, 'buy' => $buy, 'live' => $buy !== '',
      'cta' => $p['cta'] ?? ($price !== '' ? 'Buy now' : 'Visit live website'), 'badge' => trim((string)($p['badge'] ?? '')), 'wide' => !empty($p['featured'])];
}
foreach ($items as &$it) { $it['ci'] = array_search($it['cat'], $cats, true) % count($PAL); } unset($it);
$hasPrice = (bool)array_filter($items, fn($i) => $i['price'] !== '');
$hasLive  = (bool)array_filter($items, fn($i) => $i['live']);
$title = $S['products_title'] ?? 'Products';
$text  = $S['products_text'] ?? 'Websites and web applications I have built. Open any one to see the work done and visit the live site.';
?>
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Roboto+Condensed:wght@400;500;700&display=swap');
#abhp{--ink:#ece6de;--mute:#8d857b;--edge:rgba(196,145,92,.22);--card:#14110e;--cond:'Roboto Condensed','Arial Narrow',sans-serif;position:relative;isolation:isolate;overflow:hidden;scroll-margin-top:90px;padding:clamp(80px,10vw,130px) clamp(14px,3vw,24px);background:radial-gradient(ellipse 55% 40% at 50% 0,rgba(196,145,92,.15),transparent 70%),#0b0a09;color:var(--ink);font:400 14px/1.55 'Inter',system-ui,sans-serif;box-sizing:border-box}
#abhp *,#abhp *::before,#abhp *::after{box-sizing:border-box}
#abhp h2,#abhp h3,#abhp p,#abhp ul{margin:0;padding:0}#abhp ul{list-style:none}
#abhp a{color:inherit;text-decoration:none}
#abhp button,#abhp select{font:inherit;color:inherit}
#abhp :focus-visible{outline:2px solid #37b6c9;outline-offset:3px}
#abhp .wrap{max-width:1240px;margin:0 auto}
#abhp .eyebrow{display:flex;align-items:center;gap:12px;color:#c4915c;font:600 12px/1 'Inter',sans-serif;letter-spacing:.22em;text-transform:uppercase;margin-bottom:16px}
#abhp .eyebrow::before{content:"";width:34px;height:2px;background:#c4915c}
#abhp h2{font:700 clamp(38px,7vw,76px)/1 'Inter',sans-serif;letter-spacing:-.03em;background:linear-gradient(90deg,#9a9a9a,#8a6a47);-webkit-background-clip:text;background-clip:text;color:transparent}
#abhp .lead{max-width:560px;margin-top:16px;color:#8d857b;font-size:15px}
#abhp .bar{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:14px;margin:clamp(28px,4vw,44px) 0 26px}
#abhp .chips{display:flex;flex-wrap:wrap;gap:8px}
#abhp .chip{--c:#c4915c;display:inline-flex;align-items:center;gap:8px;padding:8px 14px;border-radius:999px;background:var(--card);border:1px solid var(--edge);cursor:pointer;transition:border-color .25s,background .25s,transform .25s}
#abhp .chip i{width:8px;height:8px;border-radius:50%;background:var(--c);box-shadow:0 0 8px var(--c)}
#abhp .chip small{color:var(--mute)}
#abhp .chip:hover{transform:translateY(-2px);border-color:var(--c)}
#abhp .chip[aria-pressed="true"]{border-color:var(--c);background:rgba(255,255,255,.05);box-shadow:0 0 18px -4px var(--c)}
#abhp .sort{display:flex;align-items:center;gap:8px;color:var(--mute)}
#abhp select{background:var(--card);border:1px solid var(--edge);border-radius:10px;padding:8px 12px;cursor:pointer}
#abhp .grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(min(100%,290px),1fr));gap:20px}
#abhp .grid.rows{display:flex;flex-direction:column}
#abhp .prow{display:flex;gap:20px;align-items:stretch}
#abhp .prow>.pd,#abhp .pd-sp{flex:1 1 0;min-width:0}
#abhp .pd-sp{visibility:hidden}
#abhp .pd{--c:#37b6c9;--cr:55,182,201;position:relative;display:flex;flex-direction:column;border-radius:20px;overflow:hidden;background:var(--card);border:1px solid var(--edge);transform:perspective(900px) rotateX(var(--rx,0deg)) rotateY(var(--ry,0deg));transition:flex-grow .55s cubic-bezier(.2,.75,.25,1),transform .2s ease-out,border-color .3s,box-shadow .3s;scroll-margin-top:110px;animation:pdrise .6s cubic-bezier(.2,.75,.25,1) backwards;animation-delay:calc(var(--i,0)*70ms)}
#abhp:not(.on) .pd{animation-play-state:paused}
#abhp .pd[hidden]{display:none}
#abhp .pd::before{content:"";position:absolute;inset:0;z-index:2;border-radius:inherit;background:radial-gradient(380px circle at var(--mx,50%) var(--my,0%),rgba(var(--cr),.2),transparent 55%);opacity:0;transition:opacity .3s;pointer-events:none}
#abhp .pd:hover{transform:perspective(900px) rotateX(var(--rx,0deg)) rotateY(var(--ry,0deg)) translateY(-6px);border-color:var(--c);box-shadow:0 22px 50px -18px rgba(var(--cr),.45)}
#abhp .pd:hover::before{opacity:1}
#abhp .pd-img{position:relative;aspect-ratio:16/10;display:grid;place-items:center;overflow:hidden;background:radial-gradient(circle at 30% 20%,rgba(var(--cr),.35),transparent 62%),linear-gradient(160deg,#1a1612,#0f0d0b);font:700 72px var(--cond);color:var(--c)}
#abhp .pd-img img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;transition:transform .6s}
#abhp .pd:hover .pd-img img{transform:scale(1.07)}
#abhp .badge{position:absolute;left:12px;top:12px;z-index:1;padding:3px 11px;border-radius:999px;font-size:11.5px;font-weight:700;color:#0b0a09;background:var(--c)}
#abhp .off{position:absolute;right:12px;top:12px;z-index:1;padding:3px 10px;border-radius:999px;font-size:11.5px;font-weight:700;background:rgba(0,0,0,.6);color:#fff;border:1px solid rgba(255,255,255,.2)}
#abhp .pd-body{display:flex;flex-direction:column;gap:8px;flex:1;padding:18px 20px 20px}
#abhp .pd-cat{display:flex;align-items:center;gap:8px;color:var(--mute);font-size:12px}
#abhp .pd-cat i{width:7px;height:7px;border-radius:50%;background:var(--c);box-shadow:0 0 8px var(--c)}
#abhp .pd h3{font:500 22px/1.2 var(--cond)}
#abhp .pd-desc{color:#b9b1a6;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
#abhp .pd-foot{margin-top:auto;padding-top:12px;display:flex;align-items:center;justify-content:space-between;gap:10px}
#abhp .price{font:600 24px/1 var(--cond);color:var(--c)}
#abhp .price s{margin-left:8px;font:400 13px 'Inter',sans-serif;color:var(--mute)}
#abhp .go{position:relative;z-index:4;background:none;border:0;padding:6px 0;cursor:pointer;color:#d8d0c6;font-weight:600;transition:transform .25s,color .25s}
#abhp .pd:hover .go{transform:translateX(5px);color:var(--c)}
#abhp .pd-hit{position:absolute;inset:0;z-index:3;width:100%;height:100%;background:none;border:0;cursor:pointer;border-radius:inherit}
#abhp .empty{padding:50px 10px;text-align:center;color:var(--mute)}
#abhp .btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:12px 22px;border-radius:12px;font-weight:700;border:1px solid var(--edge);background:var(--card);color:var(--ink)!important;cursor:pointer;transition:transform .25s,border-color .25s}
#abhp .btn:hover{transform:translateY(-2px);border-color:var(--c)}
#abhp .btn.pri{background:var(--c);color:#0b0a09!important;border-color:var(--c)}
#abhp dialog{--c:#37b6c9;--cr:55,182,201;width:min(960px,calc(100% - 24px));max-height:min(88vh,760px);padding:0;border:1px solid var(--edge);border-radius:22px;overflow:auto;background:#100e0b;color:var(--ink);box-shadow:0 40px 100px rgba(0,0,0,.7),0 0 70px -20px rgba(var(--cr),.5);font:400 14px/1.55 'Inter',system-ui,sans-serif}
#abhp dialog[open]{animation:pdpop .35s cubic-bezier(.2,.75,.25,1)}
#abhp dialog::backdrop{background:rgba(5,4,3,.78);backdrop-filter:blur(6px)}
#abhp .dl{display:grid;grid-template-columns:1fr 1fr}
#abhp .dl-img{position:relative;min-height:320px;display:grid;place-items:center;overflow:hidden;background:radial-gradient(circle at 30% 20%,rgba(var(--cr),.4),transparent 62%),linear-gradient(160deg,#1a1612,#0f0d0b);font:700 120px var(--cond);color:var(--c)}
#abhp .dl-img img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}
#abhp .dl-b{position:relative;padding:34px 30px 26px;display:flex;flex-direction:column;gap:12px}
#abhp .dl-x{position:absolute;right:14px;top:14px;width:38px;height:38px;border-radius:10px;background:var(--card);border:1px solid var(--edge);font-size:20px;cursor:pointer;transition:border-color .2s}
#abhp .dl-x:hover{border-color:var(--c)}
#abhp .dl-b h3{font:600 clamp(26px,4vw,34px)/1.15 var(--cond);padding-right:40px}
#abhp .dl-feat{display:grid;gap:8px;margin:4px 0}
#abhp .dl-feat li{position:relative;padding-left:26px;color:#d8d0c6}
#abhp .dl-feat li::before{content:"";position:absolute;left:0;top:.35em;width:14px;height:8px;border-left:2px solid var(--c);border-bottom:2px solid var(--c);transform:rotate(-45deg)}
#abhp .dl-act{display:flex;flex-wrap:wrap;gap:10px;margin-top:6px}
#abhp .dl-nav{margin-top:auto;padding-top:14px;display:flex;align-items:center;justify-content:space-between;color:var(--mute);border-top:1px solid var(--edge)}
#abhp .dl-nav button{width:38px;height:38px;border-radius:10px;background:var(--card);border:1px solid var(--edge);cursor:pointer;transition:border-color .2s}
#abhp .dl-nav button:hover{border-color:var(--c)}

@media(max-width:760px){#abhp .dl{grid-template-columns:1fr}#abhp .dl-img{min-height:200px;font-size:84px}#abhp .dl-b{padding:24px 20px}#abhp .bar{flex-direction:column;align-items:flex-start}}
#abhp h4{margin:0}
/* the focused (hovered / clicked) card grows; the others in its row share what is left */
#abhp .pd.is-focus{flex-grow:2;border-color:var(--c);box-shadow:0 22px 50px -18px rgba(var(--cr),.45)}
#abhp .grid.c2 .pd.is-focus{flex-grow:1.5}#abhp .grid.c1 .pd.is-focus{flex-grow:1}
#abhp .grid.c3 .pd.is-focus,#abhp .grid.c4 .pd.is-focus{flex-direction:row}
#abhp .grid.c3 .pd.is-focus .pd-img,#abhp .grid.c4 .pd.is-focus .pd-img{width:44%;flex:none;aspect-ratio:auto}
#abhp .pd.is-focus .pd-img{aspect-ratio:16/9}
#abhp .grid.c3 .pd.is-focus .pd-body,#abhp .grid.c4 .pd.is-focus .pd-body{justify-content:center;padding:24px}
#abhp .pd.is-focus h3{font-size:clamp(24px,2.6vw,32px)}
#abhp .pd.is-focus .pd-desc{-webkit-line-clamp:5}
#abhp .pd-ft{display:grid;gap:6px;max-height:0;opacity:0;overflow:hidden;color:#cfc7bc;font-size:13px;transition:max-height .5s,opacity .4s,margin .4s}
#abhp .pd.is-focus .pd-ft{max-height:220px;opacity:1;margin-top:4px}
#abhp .pd-ft li{position:relative;padding-left:20px}
#abhp .pd-ft li::before{content:"";position:absolute;left:0;top:.45em;width:10px;height:6px;border-left:2px solid var(--c);border-bottom:2px solid var(--c);transform:rotate(-45deg)}
#abhp .tech{display:flex;flex-wrap:wrap;gap:6px}
#abhp .tech li{padding:2px 10px;border-radius:999px;font-size:11.5px;background:rgba(var(--cr),.1);border:1px solid rgba(var(--cr),.35)}
#abhp .st{display:inline-flex;align-items:center;gap:7px;font-size:12.5px;font-weight:600;color:var(--mute)}
#abhp .st i{width:8px;height:8px;border-radius:50%;background:#f0b45b}
#abhp .st.on{color:#4fd18b}#abhp .st.on i{background:#4fd18b;box-shadow:0 0 8px #4fd18b;animation:stpulse 2s ease-in-out infinite}
#abhp .dl-ft{font:500 15px var(--cond);color:var(--mute);margin-top:6px}
#abhp .dl-ft[hidden],#abhp .dl-desc[hidden]{display:none}
@keyframes stpulse{50%{opacity:.35}}
@keyframes pdrise{from{opacity:0;transform:translateY(26px) scale(.96)}}
@keyframes pdpop{from{opacity:0;transform:translateY(24px) scale(.96)}}
@media(prefers-reduced-motion:reduce){#abhp *,#abhp *::before{animation:none!important;transition:none!important}}
</style>

<section id="products" aria-labelledby="abhpT">
<div id="abhp">
  <div class="wrap">
    <p class="eyebrow">Built by me</p>
    <h2 id="abhpT"><?= abh_e($title) ?></h2>
    <p class="lead"><?= abh_e($text) ?></p>

    <?php if ($items): ?>
    <div class="bar">
      <div class="chips" role="group" aria-label="Filter by category">
        <button class="chip" type="button" data-cat="all" aria-pressed="true"><i></i>All <small><?= count($items) ?></small></button>
        <?php foreach ($cats as $ci => $c): $n = count(array_filter($items, fn($i) => $i['cat'] === $c)); ?>
          <button class="chip" type="button" data-cat="<?= abh_e($c) ?>" aria-pressed="false" style="--c:<?= $PAL[$ci % count($PAL)][0] ?>"><i></i><?= abh_e($c) ?> <small><?= $n ?></small></button>
        <?php endforeach; ?>
      </div>
      <label class="sort">Sort
        <select id="abhpSort"><option value="feat">Featured</option><?php if ($hasPrice): ?><option value="lo">Price: low to high</option><option value="hi">Price: high to low</option><?php endif; ?><?php if ($hasLive): ?><option value="live">Live sites first</option><?php endif; ?><option value="az">Name: A to Z</option></select>
      </label>
    </div>

    <div class="grid">
      <?php foreach ($items as $n => $it): [$col, $rgb] = $PAL[$it['ci']]; ?>
      <article class="pd<?= $it['wide'] ? ' is-focus' : '' ?>" data-i="<?= $n ?>" data-cat="<?= abh_e($it['cat']) ?>" data-p="<?= $it['pn'] ?>" data-live="<?= $it['live'] ? 1 : 0 ?>" data-n="<?= abh_e(strtolower($it['name'])) ?>" style="--c:<?= $col ?>;--cr:<?= $rgb ?>;--i:<?= $n % 8 ?>">
        <div class="pd-img">
          <span aria-hidden="true"><?= abh_e(mb_substr($it['name'], 0, 1)) ?></span><?php if ($it['img']): ?><img src="<?= abh_e($it['img']) ?>" alt="<?= abh_e($it['name']) ?>" loading="lazy" onerror="this.remove()"><?php endif; ?>
          <?php if ($it['badge']): ?><span class="badge"><?= abh_e($it['badge']) ?></span><?php endif; ?>
          <?php if ($it['off']): ?><span class="off">-<?= $it['off'] ?>%</span><?php endif; ?>
        </div>
        <div class="pd-body">
          <p class="pd-cat"><i></i><?= abh_e($it['sub']) ?></p>
          <h3><?= abh_e($it['name']) ?></h3>
          <?php if ($it['desc']): ?><p class="pd-desc"><?= abh_e($it['desc']) ?></p><?php endif; ?>
          <?php if ($it['tech']): ?><ul class="tech"><?php foreach (array_slice($it['tech'], 0, 3) as $t): ?><li><?= abh_e($t) ?></li><?php endforeach; ?></ul><?php endif; ?>
          <?php if ($it['feat']): ?><ul class="pd-ft"><?php foreach (array_slice($it['feat'], 0, 4) as $f): ?><li><?= abh_e($f) ?></li><?php endforeach; ?></ul><?php endif; ?>
          <div class="pd-foot"><?php if ($it['price'] !== ''): ?><span class="price"><?= abh_e($it['price']) ?><?= $it['old'] ? '<s>' . abh_e($it['old']) . '</s>' : '' ?></span><?php else: ?><span class="st<?= $it['live'] ? ' on' : '' ?>"><i></i><?= $it['live'] ? 'Live' : 'Link coming soon' ?></span><?php endif; ?><button class="go" type="button" data-open>Details &rarr;</button></div>
        </div>
        <button class="pd-hit" type="button" aria-label="View details: <?= abh_e($it['name']) ?>"></button>
      </article>
      <?php endforeach; ?>
    </div>
    <p class="empty" hidden>No products in this category yet.</p>
    <?php else: ?>
    <p class="empty">Products coming soon.</p>
    <?php endif; ?>
  </div>

  <dialog aria-label="Product details">
    <div class="dl">
      <div class="dl-img"></div>
      <div class="dl-b">
        <button class="dl-x" type="button" aria-label="Close">&times;</button>
        <p class="pd-cat"></p><h3></h3><div class="dl-pr"></div><p class="dl-desc"></p><ul class="dl-tech tech"></ul><h4 class="dl-ft"></h4><ul class="dl-feat"></ul>
        <div class="dl-act"></div>
        <div class="dl-nav"><button type="button" data-d="-1" aria-label="Previous product">&larr;</button><span></span><button type="button" data-d="1" aria-label="Next product">&rarr;</button></div>
      </div>
    </div>
  </dialog>
</div>
</section>

<script>
(function(){
var S=document.getElementById('abhp'); if(!S)return;
var D=<?= json_encode($items, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
var PAL=<?= json_encode($PAL) ?>;
var grid=S.querySelector('.grid'); if(!grid)return;
var cards=[].slice.call(grid.querySelectorAll('.pd')), empty=S.querySelector('.empty'), dlg=S.querySelector('dialog'), cat='all', sort='feat', cur=-1;
var reduce=matchMedia('(prefers-reduced-motion:reduce)').matches;
var order=cards.slice(), focus=cards.filter(function(c){return c.classList.contains("is-focus")})[0], ncols=0;
function visible(){return order.filter(function(c){return !c.hidden})}
function replay(c){c.style.animation='none';void c.offsetWidth;c.style.animation=''}
function apply(){
  order=cards.slice().sort(function(a,b){
    var pa=+a.dataset.p,pb=+b.dataset.p;
    if(sort==='lo')return(pa||1e12)-(pb||1e12);
    if(sort==='hi')return(pb||-1)-(pa||-1);
    if(sort==='live')return(+b.dataset.live)-(+a.dataset.live)||(+a.dataset.i-+b.dataset.i);
    if(sort==='az')return a.dataset.n<b.dataset.n?-1:1;
    return+a.dataset.i-+b.dataset.i});
  var v=0;
  order.forEach(function(c){var show=cat==='all'||c.dataset.cat===cat;c.hidden=!show;if(show){c.style.setProperty('--i',v++%8)}});
  empty.hidden=v>0;
  layout(true);
}
function colCount(){var w=grid.clientWidth||S.clientWidth;return Math.max(1,Math.min(4,Math.floor((w+20)/290)))}
/* cards are placed in rows; the focused card is wider, its row-mates share the remaining width */
function layout(anim){
  var vis=visible();ncols=colCount();grid.className='grid rows c'+ncols;grid.textContent='';
  if(!vis.length)return;
  if(!focus||focus.hidden)focus=vis[0];
  cards.forEach(function(c){c.classList.toggle('is-focus',c===focus)});
  for(var i=0;i<vis.length;i+=ncols){
    var part=vis.slice(i,i+ncols),row=document.createElement('div');row.className='prow';
    part.forEach(function(c){row.appendChild(c)});
    for(var k=part.length;k<ncols;k++){var sp=document.createElement('div');sp.className='pd-sp';sp.setAttribute('aria-hidden','true');row.appendChild(sp)}
    grid.appendChild(row)}
  if(anim)vis.forEach(replay);
}
function setFocus(c,scroll){
  if(focus===c)return;focus=c;cards.forEach(function(x){x.classList.toggle('is-focus',x===c)});
  if(scroll)setTimeout(function(){var r=c.getBoundingClientRect();if(r.top<80||r.bottom>innerHeight)c.scrollIntoView({block:'nearest',behavior:reduce?'auto':'smooth'})},430)}
S.querySelectorAll('.chip').forEach(function(b){b.addEventListener('click',function(){
  cat=b.dataset.cat;S.querySelectorAll('.chip').forEach(function(x){x.setAttribute('aria-pressed',x===b)});apply()})});
S.querySelector('#abhpSort').addEventListener('change',function(e){sort=e.target.value;apply()});

/* hover spotlight + light tilt (mouse only) */
if(matchMedia('(hover:hover)').matches&&!reduce){cards.forEach(function(c){
  c.addEventListener('pointermove',function(e){var r=c.getBoundingClientRect(),x=(e.clientX-r.left)/r.width,y=(e.clientY-r.top)/r.height;
    c.style.setProperty('--mx',x*100+'%');c.style.setProperty('--my',y*100+'%');c.style.setProperty('--rx',((.5-y)*6).toFixed(2)+'deg');c.style.setProperty('--ry',((x-.5)*8).toFixed(2)+'deg')});
  c.addEventListener('pointerleave',function(){c.style.setProperty('--rx','0deg');c.style.setProperty('--ry','0deg')})})}

/* details popup */
function q(s){return dlg.querySelector(s)}
function fill(c){
  var p=D[+c.dataset.i], col=PAL[p.ci];
  dlg.style.setProperty('--c',col[0]);dlg.style.setProperty('--cr',col[1]);
  var im=q('.dl-img');im.textContent=(p.name||'?').charAt(0);
  if(p.img){var i=document.createElement('img');i.src=p.img;i.alt=p.name;i.onerror=function(){i.remove()};im.appendChild(i)}
  q('.pd-cat').textContent=p.sub;q('h3').textContent=p.name;
  var pr=q('.dl-pr');pr.textContent='';
  if(p.price){var sp=document.createElement('span');sp.className='price';sp.textContent=p.price;if(p.old){var s=document.createElement('s');s.textContent=p.old;sp.appendChild(s)}pr.appendChild(sp)}
  else{var st=document.createElement('span');st.className='st'+(p.live?' on':'');st.appendChild(document.createElement('i'));st.appendChild(document.createTextNode(p.live?'Live':'Link coming soon'));pr.appendChild(st)}
  var dd=q('.dl-desc');dd.textContent=p.desc;dd.hidden=!p.desc;
  var tu=q('.dl-tech');tu.textContent='';p.tech.forEach(function(t){var li=document.createElement('li');li.textContent=t;tu.appendChild(li)});
  var ft=q('.dl-ft');ft.textContent=p.feat.length?p.ftl:'';ft.hidden=!p.feat.length;
  var ul=q('.dl-feat');ul.textContent='';p.feat.forEach(function(f){var li=document.createElement('li');li.textContent=f;ul.appendChild(li)});
  var act=q('.dl-act');act.textContent='';
  if(p.buy){var a=document.createElement('a');a.className='btn pri';a.href=p.buy;a.target='_blank';a.rel='noopener noreferrer';a.textContent=p.cta;act.appendChild(a)}
  var e=document.createElement('a');e.className='btn'+(p.buy?'':' pri');e.href='#contact';e.textContent='Enquire about this';e.addEventListener('click',function(){dlg.close()});act.appendChild(e);
  var vis=visible();q('.dl-nav span').textContent=(vis.indexOf(c)+1)+' / '+vis.length;
}
function open(c){cur=cards.indexOf(c);fill(c);if(!dlg.open){dlg.showModal();document.documentElement.style.overflow='hidden'}}
function step(d){var vis=visible(),i=vis.indexOf(cards[cur]);if(i<0)return;var n=vis[(i+d+vis.length)%vis.length];cur=cards.indexOf(n);fill(n);dlg.scrollTop=0}
/* first tap/click makes a card big, tapping the big card (or its Details button) opens the popup */
cards.forEach(function(c){var hit=c.querySelector('.pd-hit'),go=c.querySelector('.go');
  hit.addEventListener('click',function(){if(c!==focus)setFocus(c,true);else open(c)});
  hit.addEventListener('focus',function(){var fv=false;try{fv=hit.matches(':focus-visible')}catch(e){}if(fv)setFocus(c,false)});
  go.addEventListener('click',function(){setFocus(c,false);open(c)})});
/* mouse hover: grow after a short pause; only real mouse movement counts, so layout changes cannot trigger it */
var lx=0,ly=0,ht=null,hc=null;
grid.addEventListener('pointermove',function(e){
  if(e.pointerType!=='mouse'||(e.clientX===lx&&e.clientY===ly))return;lx=e.clientX;ly=e.clientY;
  var c=e.target.closest&&e.target.closest('.pd');
  if(!c||c===focus){clearTimeout(ht);hc=null;return}
  if(c!==hc){hc=c;clearTimeout(ht);ht=setTimeout(function(){setFocus(c,false)},170)}});
grid.addEventListener('pointerleave',function(){clearTimeout(ht);hc=null});
var rt;addEventListener('resize',function(){clearTimeout(rt);rt=setTimeout(function(){if(colCount()!==ncols)layout(false)},150)});
layout(false);
q('.dl-x').addEventListener('click',function(){dlg.close()});
dlg.querySelectorAll('[data-d]').forEach(function(b){b.addEventListener('click',function(){step(+b.dataset.d)})});
dlg.addEventListener('click',function(e){if(e.target===dlg)dlg.close()});
dlg.addEventListener('close',function(){document.documentElement.style.overflow=''});
dlg.addEventListener('keydown',function(e){if(e.key==='ArrowRight')step(1);else if(e.key==='ArrowLeft')step(-1)});

if('IntersectionObserver' in window){var io=new IntersectionObserver(function(e){if(e.some(function(x){return x.isIntersecting})){S.classList.add('on');io.disconnect()}},{threshold:.08});io.observe(S)}else{S.classList.add('on')}
})();
</script>
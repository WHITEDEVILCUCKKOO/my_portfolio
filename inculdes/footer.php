<?php
/* Footer + closing tags. Put at the very end of your page (replaces your old <footer> ... </html>).
   Uses your $S, $v, $exp and abh_* helpers. */
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
$S = $S ?? [];
$v = $v ?? fn($k) => abh_e($S[$k] ?? '');
$sections = ['about' => 'About', 'skills' => 'Skills', 'services' => 'Services', 'projects' => 'Projects'];
if (!empty($exp)) {
  $sections['experience'] = 'Experience';
}
$sections += ['backend' => 'Backend', 'contact' => 'Contact'];
$conn = [];   /* key => [raw value, href, opens in new tab] */
if (($S['email'] ?? '') !== '') {
  $conn['email'] = [$S['email'], 'mailto:' . $S['email'], false];
}
if (($S['phone'] ?? '') !== '') {
  $conn['phone'] = [$S['phone'], 'tel:' . $S['phone'], false];
}
foreach (['github', 'linkedin'] as $k) {
  if (abh_url($S[$k] ?? '')) {
    $conn[$k] = [$S[$k], $S[$k], true];
  }
}
$host = preg_replace('~[^a-z0-9.:-]~i', '', $_SERVER['HTTP_HOST'] ?? 'localhost');
$slug = trim(strtolower(preg_replace('~[^a-z0-9]+~i', '-', strip_tags((string)($S['name'] ?? 'me')))), '-') ?: 'me';
$cmd  = "curl -s https://$host/api/$slug | jq";
$JS   = [
  'sections' => array_map(fn($id, $l) => ['id' => $id, 'label' => $l], array_keys($sections), $sections),
  'conn' => array_map(fn($c) => ['v' => $c[0], 'h' => $c[1], 'x' => $c[2]], $conn),
  'name' => $S['name'] ?? '',
  'title' => $S['title'] ?? '',
  'about' => $S['about'] ?? ($S['hero_sub'] ?? ''),
  'auth' => $terminal_auth_url ?? 'terminal-auth.php'
];

$N = 0;
$ln = function ($html, $d = 1) use (&$N) {
  echo '<div class="t-ln" style="--n:' . ($N++) . ';--d:' . $d . '">' . $html . '</div>';
};
$P = fn($c) => '<span class="p">' . $c . '</span>';
$K = fn($k) => '<span class="k">"' . $k . '"</span><span class="p">: </span>';
?>
<style>
  @import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&display=swap');

  #abhf {
    --m: 'JetBrains Mono', ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
    position: relative;
    overflow: hidden;
    padding: clamp(80px, 10vw, 120px) clamp(14px, 3vw, 24px) 28px;
    background: radial-gradient(ellipse 60% 45% at 50% 0, rgba(196, 145, 92, .15), transparent 70%), #0b0a09;
    color: #e6dfd6;
    font: 400 14px/1.6 'Inter', system-ui, sans-serif;
    box-sizing: border-box
  }

  #abhf *,
  #abhf *::before,
  #abhf *::after {
    box-sizing: border-box
  }

  #abhf p,
  #abhf form {
    margin: 0
  }

  #abhf a {
    color: inherit;
    text-decoration: none
  }

  #abhf :focus-visible {
    outline: 2px solid #37b6c9;
    outline-offset: 2px
  }

  #abhf .sr {
    position: absolute;
    width: 1px;
    height: 1px;
    overflow: hidden;
    clip: rect(0 0 0 0)
  }

  #abhf .t-win {
    position: relative;
    max-width: 920px;
    margin: 0 auto;
    border-radius: 18px;
    overflow: hidden;
    background: #0f0d0b;
    border: 1px solid rgba(196, 145, 92, .28);
    box-shadow: 0 30px 80px rgba(0, 0, 0, .6), 0 0 70px rgba(196, 145, 92, .09);
    font: 400 clamp(12px, 1.9vw, 14px)/1.7 var(--m);
    opacity: 0;
    transform: translateY(30px)
  }

  #abhf.in .t-win {
    opacity: 1;
    transform: none;
    transition: opacity .8s, transform .8s cubic-bezier(.2, .75, .25, 1)
  }

  #abhf .t-win::before {
    content: "";
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    height: 2px;
    background: linear-gradient(90deg, transparent, #c4915c, #37b6c9, #c4915c, transparent);
    background-size: 200% 100%;
    animation: tsweep 6s linear infinite
  }

  #abhf .t-bar {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 13px 16px;
    background: #16130f;
    border-bottom: 1px solid rgba(196, 145, 92, .18)
  }

  #abhf .t-bar i {
    width: 11px;
    height: 11px;
    border-radius: 50%;
    flex: none
  }

  #abhf .t-ttl {
    flex: 1;
    min-width: 0;
    margin-left: 8px;
    color: #8d857b;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap
  }

  #abhf .t-ok {
    flex: none;
    color: #4fd18b;
    border: 1px solid rgba(79, 209, 139, .4);
    background: rgba(79, 209, 139, .1);
    border-radius: 6px;
    padding: 0 8px;
    font-size: 11px
  }

  #abhf .t-body {
    padding: 20px clamp(14px, 3vw, 26px) 10px
  }

  #abhf .t-cmd {
    margin-bottom: 8px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis
  }

  #abhf .t-cmd b,
  #abhf .t-pr {
    color: #4fd18b;
    font-weight: 500
  }

  #abhf .t-pr {
    flex: none;
    white-space: nowrap;
    max-width: 60%;
    overflow: hidden;
    text-overflow: ellipsis
  }

  #abhf .t-pr.root {
    color: #e4608f
  }

  #abhf .t-in.pw {
    color: transparent;
    text-shadow: none
  }

  #abhf .t-type {
    display: inline-block;
    vertical-align: bottom;
    overflow: hidden;
    white-space: nowrap;
    max-width: calc(100% - 3ch);
    width: calc(var(--w)*1ch);
    animation: ttype 1.2s steps(30, end) backwards
  }

  #abhf .t-ln {
    padding-left: calc(var(--d, 1)*2ch);
    overflow-wrap: anywhere;
    opacity: 0;
    animation: tln .45s ease forwards;
    animation-delay: calc(1.1s + var(--n)*70ms)
  }

  #abhf:not(.in) .t-ln,
  #abhf:not(.in) .t-type {
    animation-play-state: paused
  }

  #abhf .k {
    color: #37b6c9
  }

  #abhf .s {
    color: #e0b07a
  }

  #abhf .p {
    color: #8d857b
  }

  #abhf a.s {
    border-radius: 4px;
    box-shadow: inset 0 -1px rgba(224, 176, 122, .4);
    transition: background .2s, color .2s
  }

  #abhf a.s:hover {
    background: rgba(224, 176, 122, .18);
    color: #fff
  }

  #abhf .t-out {
    max-height: 230px;
    overflow: auto;
    margin-top: 12px;
    color: #cfc7bc;
    scrollbar-width: thin;
    scrollbar-color: #3a2f22 transparent
  }

  #abhf .t-o {
    white-space: pre-wrap;
    overflow-wrap: anywhere;
    animation: tln .3s ease
  }

  #abhf .t-o a {
    color: #37b6c9;
    text-decoration: underline
  }

  #abhf .t-o.cmd {
    color: #8d857b
  }

  #abhf .t-o.dim {
    color: #8d857b
  }

  #abhf .t-o.hd {
    color: #37b6c9
  }

  #abhf .t-o.err {
    color: #e4608f
  }

  #abhf .t-o.ok {
    color: #4fd18b
  }

  #abhf .t-form {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 8px;
    padding-top: 12px;
    border-top: 1px dashed rgba(196, 145, 92, .2)
  }

  #abhf .t-in {
    flex: 1;
    min-width: 0;
    background: none;
    border: 0;
    color: #fff;
    font: inherit;
    caret-color: #c4915c;
    padding: 4px 0
  }

  #abhf .t-in:focus-visible {
    outline: 0
  }

  #abhf .t-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    padding: 12px clamp(14px, 3vw, 26px) 18px
  }

  #abhf .t-chip {
    font: inherit;
    color: #d8d0c6;
    background: rgba(196, 145, 92, .08);
    border: 1px solid rgba(196, 145, 92, .3);
    border-radius: 8px;
    padding: 3px 12px;
    cursor: pointer;
    transition: background .2s, transform .2s, border-color .2s
  }

  #abhf .t-chip:hover {
    background: rgba(196, 145, 92, .2);
    border-color: #c4915c;
    transform: translateY(-2px)
  }

  #abhf .t-stat {
    max-width: 920px;
    margin: 14px auto 0;
    display: flex;
    flex-wrap: wrap;
    border-radius: 10px;
    overflow: hidden;
    font: 500 12px/1 var(--m);
    opacity: 0;
    transform: translateY(14px)
  }

  #abhf.in .t-stat {
    opacity: 1;
    transform: none;
    transition: opacity .7s .6s, transform .7s .6s
  }

  #abhf .t-stat>* {
    padding: 11px 14px;
    display: block
  }

  #abhf .t-s1 {
    background: #c4915c;
    color: #1a1208
  }

  #abhf .t-s2 {
    background: #1d1914;
    color: #e6dfd6
  }

  #abhf .t-s3 {
    flex: 1;
    background: #14110e;
    color: #8d857b;
    min-width: 140px
  }

  #abhf .t-s4 {
    background: #14110e;
    color: #c4915c;
    letter-spacing: .08em;
    text-transform: uppercase
  }

  #abhf .t-s5 {
    background: #37b6c9;
    color: #04161a;
    font-weight: 700;
    border: 0;
    cursor: pointer;
    font: inherit;
    font-weight: 700;
    transition: background .2s
  }

  #abhf .t-s5:hover {
    background: #6fdcec
  }

  @keyframes ttype {
    from {
      width: 0
    }
  }

  @keyframes tln {
    from {
      opacity: 0;
      transform: translateX(-8px)
    }

    to {
      opacity: 1;
      transform: none
    }
  }

  @keyframes tsweep {
    to {
      background-position: 200% 0
    }
  }

  @media(max-width:560px) {
    #abhf .t-stat>* {
      flex: 1 1 100%
    }

    #abhf .t-s3 {
      min-width: 0
    }

    #abhf .t-ok {
      display: none
    }
  }

  @media(prefers-reduced-motion:reduce) {

    #abhf *,
    #abhf *::before {
      animation: none !important;
      transition: none !important
    }

    #abhf .t-win,
    #abhf .t-stat {
      opacity: 1;
      transform: none
    }

    #abhf .t-ln {
      opacity: 1
    }
  }
</style>

<footer id="abhf" aria-label="Site footer">
  <div class="t-win" role="group" aria-label="Contact terminal">
    <div class="t-bar"><i style="background:#e4608f"></i><i style="background:#f0b45b"></i><i style="background:#4fd18b"></i><span class="t-ttl"><?= $v('name') ?> &mdash; zsh</span><span class="t-ok">HTTP 200 OK</span></div>
    <div class="t-body">
      <div class="t-cmd"><b>$</b> <span class="t-type" style="--w:<?= strlen($cmd) ?>"><?= abh_e($cmd) ?></span></div>
      <?php
      $ln($P('{'), 0);
      $ent = [['name', 's', $v('name')], ['title', 's', $v('title')], ['tagline', 's', 'Creative mind. Clean code.'], ['sections', 'arr', $sections]];
      if ($conn) {
        $ent[] = ['contact', 'obj', $conn];
      }
      $last = count($ent) - 1;
      foreach ($ent as $i => [$k, $t, $val]) {
        $c = $i < $last ? $P(',') : '';
        if ($t === 's') {
          $ln($K($k) . '<span class="s">"' . $val . '"</span>' . $c);
        } elseif ($t === 'arr') {
          $ln($K($k) . $P('['));
          $m = count($val);
          $j = 0;
          foreach ($val as $id => $label) {
            $j++;
            $ln('<a class="s" href="#' . abh_e($id) . '">"' . abh_e($label) . '"</a>' . ($j < $m ? $P(',') : ''), 2);
          }
          $ln($P(']') . $c);
        } else {
          $ln($K($k) . $P('{'));
          $m = count($val);
          $j = 0;
          foreach ($val as $ck => [$raw, $href, $ext]) {
            $j++;
            $ln($K($ck) . '<a class="s" href="' . abh_e($href) . '"' . ($ext ? ' target="_blank" rel="noopener noreferrer"' : '') . '>"' . abh_e($raw) . '"</a>' . ($j < $m ? $P(',') : ''), 2);
          }
          $ln($P('}') . $c);
        }
      }
      $ln($P('}'), 0);
      ?>
      <div class="t-out" aria-live="polite">
        <div class="t-o cmd">Type <b>help</b> and press Enter, or tap a command below.</div>
      </div>
      <form class="t-form" autocomplete="off"><label class="sr" for="abhfIn">Type a command</label><span class="t-pr">visitor@portfolio:~$</span><input class="t-in" id="abhfIn" placeholder="try: help" autocapitalize="off" spellcheck="false" enterkeyhint="go"></form>
    </div>
    <div class="t-chips">
      <?php foreach (['help', 'ls', 'pwd', 'tree', 'cd projects', 'cd contact', 'email', 'github'] as $c): if (in_array($c, ['email', 'github'], true) && !isset($conn[$c])) continue; ?><button class="t-chip" type="button" data-cmd="<?= abh_e($c) ?>"><?= abh_e($c) ?></button><?php endforeach; ?>
    </div>
  </div>

  <div class="t-stat">
    <span class="t-s1">&copy; <?= date('Y') ?></span>
    <span class="t-s2"><?= $v('name') ?></span>
    <span class="t-s3">All rights reserved.</span>
    <span class="t-s4">Creative mind. Clean code.</span>
    <button class="t-s5" type="button" data-cmd="top">&uarr; top</button>
  </div>
</footer>

<script>
  (function() {
    var f = document.getElementById('abhf');
    if (!f) return;
    var D = <?= json_encode($JS, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
    var $ = function(q) {
        return f.querySelector(q)
      },
      out = $('.t-out'),
      inp = $('.t-in'),
      pr = $('.t-pr'),
      form = $('.t-form');
    var USER = 'visitor',
      HOST = 'portfolio',
      hist = [],
      hi = 0,
      cwd = '',
      prev = '',
      mode = 'shell',
      tries = 0,
      token = '',
      busy = false,
      label = '',
      t0 = Date.now();
    var ALIAS = {
      map: 'abhx',
      footer: 'abhf'
    };

    function ps1() {
      return innerWidth < 560 ? '~' + (cwd ? '/' + cwd : '') + '$' : USER + '@' + HOST + ':~' + (cwd ? '/' + cwd : '') + '$'
    }

    function setPr(t, root) {
      pr.textContent = t;
      pr.classList.toggle('root', !!root)
    }

    function print(parts, cls) {
      var d = document.createElement('div');
      d.className = 't-o ' + (cls || '');
      [].concat(parts).forEach(function(p) {
        if (typeof p === 'string') {
          d.appendChild(document.createTextNode(p))
        } else {
          var a = document.createElement('a');
          a.textContent = p.t;
          a.href = p.h;
          if (p.x) {
            a.target = '_blank';
            a.rel = 'noopener noreferrer'
          }
          d.appendChild(a)
        }
      });
      out.appendChild(d);
      out.scrollTop = out.scrollHeight
    }

    function lines(t, cls) {
      String(t).split('\n').forEach(function(l) {
        print(l, cls)
      })
    }

    function headGap() {
      var h = 0;
      document.querySelectorAll('header,nav,[class*="header"],[class*="navbar"]').forEach(function(el) {
        if (f.contains(el)) return;
        var cs = getComputedStyle(el);
        if (cs.position === 'fixed' || cs.position === 'sticky') {
          var b = el.getBoundingClientRect();
          if (b.top <= 24 && b.bottom > 0) h = Math.max(h, b.bottom)
        }
      });
      return h + 16
    }

    function scrollTo_(el) {
      window.scrollTo({
        top: el.getBoundingClientRect().top + pageYOffset - headGap(),
        behavior: 'smooth'
      })
    }

    /* scan the real page: every section / header / footer / main with an id, plus every in-page anchor target */
    function scan() {
      var seen = {},
        list = [];

      function add(el) {
        if (!el || !el.id || seen[el.id] || el.closest('.t-win') || el.id === 'abhcT') return;
        var r = el.getBoundingClientRect();
        if (!r.height) return;
        seen[el.id] = 1;
        list.push({
          id: el.id,
          el: el,
          tag: el.tagName.toLowerCase(),
          top: Math.round(r.top + pageYOffset),
          h: Math.round(r.height)
        })
      }
      document.querySelectorAll('section[id],main[id],header[id],footer[id],article[id]').forEach(add);
      document.querySelectorAll('a[href^="#"]').forEach(function(a) {
        var id = a.getAttribute('href').slice(1);
        if (id) add(document.getElementById(id))
      });
      return list.sort(function(a, b) {
        return a.top - b.top
      })
    }

    function here(list) {
      var y = pageYOffset + innerHeight * .35,
        c = '';
      list.forEach(function(s) {
        if (s.top <= y) c = s.id
      });
      return c
    }

    function find(name, list) {
      if (!name) return null;
      var n = String(name).replace(/^~?\/?#?/, '').replace(/\/$/, '').replace(/\.(txt|md)$/, '').toLowerCase();
      if (ALIAS[n]) n = ALIAS[n];
      var ex = list.filter(function(s) {
        return s.id.toLowerCase() === n
      });
      if (ex.length) return ex[0];
      var pf = list.filter(function(s) {
        return s.id.toLowerCase().indexOf(n) === 0
      });
      return pf.length === 1 ? pf[0] : null
    }

    function words(el) {
      return (el.innerText || el.textContent || '').replace(/\s+/g, ' ').trim()
    }

    function link(k, t) {
      var c = D.conn[k];
      if (!c) {
        print(k + ': not set', 'err');
        return
      }
      print([k + ': ', {
        t: c.v,
        h: c.h,
        x: c.x
      }], 'ok');
      if (t === 'open') window.open(c.h, '_blank', 'noopener,noreferrer');
      else if (t === 'mail') location.href = c.h
    }

    function uptime() {
      var s = Math.floor((Date.now() - t0) / 1000);
      return s < 60 ? s + ' sec' : Math.floor(s / 60) + ' min'
    }

    function cd(a) {
      var l = scan(),
        t = a[0];
      if (!t || t === '~' || t === '/' || t === '..' || t === '~/' || t === '../') {
        prev = cwd;
        cwd = '';
        window.scrollTo({
          top: 0,
          behavior: 'smooth'
        });
        return
      }
      if (t === '-') {
        var p = prev;
        prev = cwd;
        cwd = p;
        var s = find(p, l);
        if (s) scrollTo_(s.el);
        else window.scrollTo({
          top: 0,
          behavior: 'smooth'
        });
        print('/' + (cwd || ''), 'dim');
        return
      }
      var s = find(t, l);
      if (!s) {
        print('bash: cd: ' + t + ': No such file or directory', 'err');
        return
      }
      prev = cwd;
      cwd = s.id;
      scrollTo_(s.el)
    }

    var C = {
      help: function() {
        lines('Commands\n  pwd            where you are, plus a scan of every section on this page\n  ls [-l] [id]   list sections (or the headings inside one)\n  cd <id>        go to a section   (cd .. / cd ~ = top, cd - = previous)\n  cat <id>       read the text of a section\n  tree           section tree          grep <word>   search the page\n  whoami  id  hostname  uname [-a]  uptime  date  echo  env  neofetch\n  email  phone  github  linkedin       open <github|linkedin|id>\n  history  clear  exit\nTab completes, Up/Down = history, Ctrl+L clears, Ctrl+C cancels.')
      },
      pwd: function() {
        var l = scan(),
          c = here(l);
        cwd = c;
        setPr(ps1());
        print('/home/' + USER + (c ? '/' + c : ''));
        print('scanned ' + l.length + ' section' + (l.length === 1 ? '' : 's') + ' on this page:', 'dim');
        l.forEach(function(s) {
          print('  #' + (s.id + '          ').slice(0, 12) + '<' + s.tag + '>  y=' + s.top + '  h=' + s.h, 'dim')
        });
        print('use: cd <id>', 'dim')
      },
      ls: function(a) {
        var l = scan(),
          long = a.some(function(x) {
            return /^-[a-z]*l/.test(x)
          }),
          t = a.filter(function(x) {
            return x[0] !== '-'
          })[0];
        if (t) {
          var s = find(t, l);
          if (!s) {
            print('ls: cannot access \'' + t + '\': No such file or directory', 'err');
            return
          }
          var hs = [].slice.call(s.el.querySelectorAll('h1,h2,h3')).map(function(h) {
            return words(h)
          }).filter(Boolean);
          hs.length ? print(hs.map(function(h) {
            return h.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '') + '.txt'
          }).join('  ')) : print('(empty)', 'dim');
          return
        }
        if (!l.length) {
          print('(no sections found)', 'dim');
          return
        }
        long ? l.forEach(function(s) {
          print('dr-xr-xr-x  ' + (s.h + 'px').padStart(7) + '  ' + s.id + '/')
        }) : print(l.map(function(s) {
          return s.id + '/'
        }).join('  '))
      },
      tree: function() {
        var l = scan();
        print('.');
        l.forEach(function(s, i) {
          print((i === l.length - 1 ? '`-- ' : '|-- ') + s.id)
        });
        print(l.length + ' sections', 'dim')
      },
      cat: function(a) {
        var t = a[0];
        if (!t) {
          print('cat: missing file operand', 'err');
          return
        }
        var l = scan(),
          s = find(t, l);
        if (/^readme(\.md)?$/i.test(t)) {
          lines(D.name + '\n' + D.title + '\nCreative mind. Clean code.');
          return
        }
        if (!s) {
          if (/^about(\.txt)?$/i.test(t) && D.about) {
            lines(D.about);
            return
          }
          print('cat: ' + t + ': No such file or directory', 'err');
          return
        }
        var w = words(s.el);
        print(w.length > 700 ? w.slice(0, 700) + ' ...' : w);
        if (w.length > 700) print('(' + (w.length - 700) + ' more characters - use cd ' + s.id + ' to read it)', 'dim')
      },
      grep: function(a) {
        var q = a.join(' ').replace(/^["']|["']$/g, '').toLowerCase();
        if (!q) {
          print('usage: grep <word>', 'err');
          return
        }
        var res = [];
        scan().forEach(function(s) {
          if (s.id === 'abhf') return;
          var t = words(s.el).toLowerCase(),
            n = 0,
            i = -1;
          while ((i = t.indexOf(q, i + 1)) > -1) n++;
          if (n) res.push([s.id, n])
        });
        res.length ? res.sort(function(x, y) {
          return y[1] - x[1]
        }).forEach(function(r) {
          print(r[0] + ': ' + r[1] + ' match' + (r[1] > 1 ? 'es' : ''))
        }) : print('(no matches)', 'dim')
      },
      whoami: function() {
        print(USER)
      },
      id: function() {
        print('uid=1000(' + USER + ') gid=1000(' + USER + ') groups=1000(' + USER + ')')
      },
      hostname: function() {
        print(HOST)
      },
      uname: function(a) {
        print(a.indexOf('-a') > -1 ? 'Linux ' + HOST + ' 6.1.0-portfolio #1 SMP x86_64 GNU/Linux' : 'Linux')
      },
      uptime: function() {
        var d = new Date();
        print(' ' + d.toTimeString().slice(0, 8) + ' up ' + uptime() + ',  1 user')
      },
      date: function() {
        print(new Date().toString())
      },
      echo: function(a) {
        print(a.join(' ').replace(/^["']|["']$/g, ''))
      },
      env: function() {
        lines('USER=' + USER + '\nHOME=/home/' + USER + '\nSHELL=/bin/abhsh\nPWD=/home/' + USER + (cwd ? '/' + cwd : '') + '\nTERM=xterm-256color\nLANG=en_US.UTF-8')
      },
      neofetch: function() {
        lines(USER + '@' + HOST + '\n-----------------\nOS:       Portfolio OS\nHost:     ' + D.name + '\nRole:     ' + D.title + '\nShell:    abhsh\nSections: ' + scan().length + '\nUptime:   ' + uptime())
      },
      email: function() {
        link('email', 'mail')
      },
      phone: function() {
        link('phone', 'mail')
      },
      github: function() {
        link('github', 'open')
      },
      linkedin: function() {
        link('linkedin', 'open')
      },
      open: function(a) {
        var t = (a[0] || '').toLowerCase();
        if (!t) {
          print('usage: open <github|linkedin|email|id>', 'err');
          return
        }
        if (D.conn[t]) {
          link(t, t === 'email' || t === 'phone' ? 'mail' : 'open');
          return
        }
        var s = find(t, scan());
        s ? (cwd = s.id, scrollTo_(s.el)) : print('open: ' + t + ': not found', 'err')
      },
      top: function() {
        cd([])
      },
      history: function() {
        hist.forEach(function(h, i) {
          print((' ' + (i + 1)).slice(-4) + '  ' + h)
        })
      },
      clear: function() {
        out.innerHTML = ''
      },
      exit: function() {
        print('logout')
      },
      logout: function() {
        print('logout')
      },
      rm: function(a) {
        a.join(' ').indexOf('/') > -1 && /-\w*r/.test(a.join(' ')) ? lines('rm: it is dangerous to operate recursively on \'/\'\nrm: use --no-preserve-root to override this failsafe') : print('rm: cannot remove \'' + (a.filter(function(x) {
          return x[0] !== '-'
        })[0] || '') + '\': Permission denied', 'err')
      },
    };
    var NAMES = Object.keys(C).concat(['sudo', 'su', 'cd']);

    /* root login: sudo su / sudo -i / su -  ... asks for a password, the server checks it, then /admin opens */
    var ROOT = /^(sudo (su( -)?( root)?|-i|-s|bash|root( -i)?|-i -u root|-u root -i)|su( -)?( root)?|login( root)?)$/;

    function endPw() {
      mode = 'shell';
      busy = false;
      inp.type = 'text';
      inp.classList.remove('pw');
      inp.value = '';
      setPr(ps1());
      inp.placeholder = 'try: help'
    }

    function ask(l) {
      label = l;
      setPr(l + ' ');
      inp.type = 'password';
      inp.classList.add('pw');
      inp.setAttribute('autocomplete', 'new-password');
      inp.placeholder = '';
      inp.value = '';
      inp.focus()
    }

    function getToken() {
      return token ? Promise.resolve(token) : fetch(D.auth + '?init=1', {
        credentials: 'same-origin',
        cache: 'no-store'
      }).then(function(r) {
        if (!r.ok) throw 0;
        return r.json()
      }).then(function(j) {
        token = j.token;
        return token
      })
    }

    function verify(pw, again) {
      busy = true;
      getToken().then(function(t) {
          var b = new URLSearchParams();
          b.set('token', t);
          b.set('password', pw);
          return fetch(D.auth, {
            method: 'POST',
            body: b,
            credentials: 'same-origin',
            cache: 'no-store'
          }).then(function(r) {
            return r.json()
          })
        })
        .then(function(j) {
          busy = false;
          if (j.ok) {
            mode = 'done';
            busy = true;
            setPr('root@' + HOST + ':~#', true);
            inp.type = 'text';
            inp.classList.remove('pw');
            inp.disabled = true;
            print('Authentication successful.', 'ok');
            print('Opening ' + (j.redirect || '/admin/') + ' ...', 'dim');
            setTimeout(function() {
              location.href = j.redirect || '/admin/'
            }, 1100);
            return
          }
          if (j.locked) {
            print('sudo: too many authentication failures. Try again in ' + j.wait + 's', 'err');
            endPw();
            return
          }
          if (j.error === 'token' && !again) {
            token = '';
            verify(pw, true);
            return
          }
          if (j.error) {
            print('sudo: authentication service unavailable', 'err');
            endPw();
            return
          }
          tries++;
          if (tries >= 3) {
            print(label.indexOf('sudo') > -1 ? 'sudo: 3 incorrect password attempts' : 'su: Authentication failure', 'err');
            endPw()
          } else {
            print(label.indexOf('sudo') > -1 ? 'Sorry, try again.' : 'su: Authentication failure', 'err');
            ask(label)
          }
        })
        .catch(function() {
          busy = false;
          print('sudo: authentication service unavailable', 'err');
          endPw()
        })
    }

    function startRoot(raw) {
      tries = 0;
      mode = 'pw';
      ask(/^(su|login)( |$)/.test(raw) ? 'Password:' : '[sudo] password for ' + USER + ':')
    }

    function run(raw) {
      var c = raw.trim();
      if (!c) return;
      print(ps1() + ' ' + c, 'cmd');
      hist.push(c);
      hi = hist.length;
      var n = c.replace(/\s+/g, ' ');
      if (ROOT.test(n)) {
        startRoot(n);
        return
      }
      var a = n.split(' '),
        cmd = a.shift();
      if (cmd === 'sudo') {
        a.length ? print(USER + ' is not in the sudoers file.  This incident will be reported.', 'err') : print('usage: sudo [-i] [-s] command', 'err');
        return
      }
      if (cmd === 'su') {
        print('su: Authentication failure', 'err');
        return
      }
      if (cmd === 'cd') {
        cd(a);
        setPr(ps1());
        return
      }
      if (C.hasOwnProperty(cmd)) {
        C[cmd](a);
        setPr(ps1());
        return
      }
      var s = a.length ? null : scan().filter(function(x) {
        return x.id.toLowerCase() === n.toLowerCase()
      })[0]; /* typing a bare section id works like cd <id> */
      if (s) {
        prev = cwd;
        cwd = s.id;
        scrollTo_(s.el);
        setPr(ps1());
        return
      }
      print('bash: ' + cmd + ': command not found', 'err')
    }

    /* Tab completion for commands and section ids */
    function complete() {
      var v = inp.value,
        p = v.split(' '),
        last = p[p.length - 1],
        pool;
      if (p.length === 1) pool = NAMES;
      else if (/^(cd|cat|ls|open)$/.test(p[0])) pool = scan().map(function(s) {
        return s.id
      }).concat(['..', '~']);
      else return;
      var m = pool.filter(function(x) {
        return x.toLowerCase().indexOf(last.toLowerCase()) === 0
      });
      if (!m.length) return;
      if (m.length === 1) {
        p[p.length - 1] = m[0];
        inp.value = p.join(' ') + (p.length === 1 ? ' ' : '')
      } else {
        var pre = m[0];
        m.forEach(function(x) {
          while (x.toLowerCase().indexOf(pre.toLowerCase()) !== 0) pre = pre.slice(0, -1)
        });
        if (pre.length > last.length) {
          p[p.length - 1] = pre;
          inp.value = p.join(' ')
        } else {
          print(ps1() + ' ' + v, 'cmd');
          print(m.join('  '))
        }
      }
    }

    form.addEventListener('submit', function(e) {
      e.preventDefault();
      if (busy) return;
      var v = inp.value;
      inp.value = '';
      if (mode === 'pw') {
        print(label, 'cmd');
        verify(v);
        return
      }
      if (mode === 'shell') run(v)
    });
    inp.addEventListener('keydown', function(e) {
      if (e.ctrlKey && (e.key === 'c' || e.key === 'C')) {
        e.preventDefault();
        print(mode === 'pw' ? label + ' ^C' : ps1() + ' ' + inp.value + '^C', 'cmd');
        inp.value = '';
        if (mode === 'pw') endPw();
        return
      }
      if (mode !== 'shell') return;
      if (e.ctrlKey && (e.key === 'l' || e.key === 'L')) {
        e.preventDefault();
        out.innerHTML = '';
        return
      }
      if (e.key === 'Tab') {
        e.preventDefault();
        complete();
        return
      }
      if (e.key === 'ArrowUp' && hist.length) {
        e.preventDefault();
        hi = Math.max(0, hi - 1);
        inp.value = hist[hi]
      } else if (e.key === 'ArrowDown' && hist.length) {
        e.preventDefault();
        hi = Math.min(hist.length, hi + 1);
        inp.value = hist[hi] || ''
      }
    });
    f.addEventListener('click', function(e) {
      var b = e.target.closest('[data-cmd]');
      if (b && mode === 'shell' && !busy) run(b.getAttribute('data-cmd'))
    });
    setPr(ps1());
    addEventListener('resize', function() {
      if (mode === 'shell') setPr(ps1())
    });
    if ('IntersectionObserver' in window) {
      var io = new IntersectionObserver(function(e) {
        if (e.some(function(x) {
            return x.isIntersecting
          })) {
          f.classList.add('in');
          io.disconnect()
        }
      }, {
        threshold: .12
      });
      io.observe(f)
    } else {
      f.classList.add('in')
    }
  })();
</script>
<script src="assets/ui.js"></script>
</body>

</html>
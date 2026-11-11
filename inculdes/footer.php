<?php
/* Footer + closing tags. Put at the very end of your page (replaces your old <footer> ... </html>).
   Uses your $S, $v, $exp and abh_* helpers. */
if (!function_exists('abh_e'))   { function abh_e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); } }
if (!function_exists('abh_url')) { function abh_url($u){ $u = trim((string)$u); return preg_match('~^https?://~i', $u) ? $u : ''; } }
$S = $S ?? [];
$v = $v ?? fn($k) => abh_e($S[$k] ?? '');
$sections = ['about' => 'About', 'skills' => 'Skills', 'services' => 'Services', 'projects' => 'Projects'];
if (!empty($exp)) { $sections['experience'] = 'Experience'; }
$sections += ['backend' => 'Backend', 'contact' => 'Contact'];
$conn = [];   /* key => [raw value, href, opens in new tab] */
if (($S['email'] ?? '') !== '')  { $conn['email'] = [$S['email'], 'mailto:' . $S['email'], false]; }
if (($S['phone'] ?? '') !== '')  { $conn['phone'] = [$S['phone'], 'tel:' . $S['phone'], false]; }
foreach (['github', 'linkedin'] as $k) { if (abh_url($S[$k] ?? '')) { $conn[$k] = [$S[$k], $S[$k], true]; } }
$host = preg_replace('~[^a-z0-9.:-]~i', '', $_SERVER['HTTP_HOST'] ?? 'localhost');
$slug = trim(strtolower(preg_replace('~[^a-z0-9]+~i', '-', strip_tags((string)($S['name'] ?? 'me')))), '-') ?: 'me';
$cmd  = "curl -s https://$host/api/$slug | jq";
$JS   = ['sections' => array_map(fn($id, $l) => ['id' => $id, 'label' => $l], array_keys($sections), $sections),
         'conn' => array_map(fn($c) => ['v' => $c[0], 'h' => $c[1], 'x' => $c[2]], $conn), 'name' => $S['name'] ?? '', 'title' => $S['title'] ?? ''];

$N = 0;
$ln = function ($html, $d = 1) use (&$N) { echo '<div class="t-ln" style="--n:' . ($N++) . ';--d:' . $d . '">' . $html . '</div>'; };
$P = fn($c) => '<span class="p">' . $c . '</span>';
$K = fn($k) => '<span class="k">"' . $k . '"</span><span class="p">: </span>';
?>
<style>
@import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&display=swap');
#abhf{--m:'JetBrains Mono',ui-monospace,SFMono-Regular,Menlo,Consolas,monospace;position:relative;overflow:hidden;padding:clamp(80px,10vw,120px) clamp(14px,3vw,24px) 28px;background:radial-gradient(ellipse 60% 45% at 50% 0,rgba(196,145,92,.15),transparent 70%),#0b0a09;color:#e6dfd6;font:400 14px/1.6 'Inter',system-ui,sans-serif;box-sizing:border-box}
#abhf *,#abhf *::before,#abhf *::after{box-sizing:border-box}
#abhf p,#abhf form{margin:0}
#abhf a{color:inherit;text-decoration:none}
#abhf :focus-visible{outline:2px solid #37b6c9;outline-offset:2px}
#abhf .sr{position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0)}
#abhf .t-win{position:relative;max-width:920px;margin:0 auto;border-radius:18px;overflow:hidden;background:#0f0d0b;border:1px solid rgba(196,145,92,.28);box-shadow:0 30px 80px rgba(0,0,0,.6),0 0 70px rgba(196,145,92,.09);font:400 clamp(12px,1.9vw,14px)/1.7 var(--m);opacity:0;transform:translateY(30px)}
#abhf.in .t-win{opacity:1;transform:none;transition:opacity .8s,transform .8s cubic-bezier(.2,.75,.25,1)}
#abhf .t-win::before{content:"";position:absolute;left:0;right:0;top:0;height:2px;background:linear-gradient(90deg,transparent,#c4915c,#37b6c9,#c4915c,transparent);background-size:200% 100%;animation:tsweep 6s linear infinite}
#abhf .t-bar{display:flex;align-items:center;gap:8px;padding:13px 16px;background:#16130f;border-bottom:1px solid rgba(196,145,92,.18)}
#abhf .t-bar i{width:11px;height:11px;border-radius:50%;flex:none}
#abhf .t-ttl{flex:1;min-width:0;margin-left:8px;color:#8d857b;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
#abhf .t-ok{flex:none;color:#4fd18b;border:1px solid rgba(79,209,139,.4);background:rgba(79,209,139,.1);border-radius:6px;padding:0 8px;font-size:11px}
#abhf .t-body{padding:20px clamp(14px,3vw,26px) 10px}
#abhf .t-cmd{margin-bottom:8px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
#abhf .t-cmd b,#abhf .t-pr{color:#4fd18b;font-weight:500}
#abhf .t-type{display:inline-block;vertical-align:bottom;overflow:hidden;white-space:nowrap;max-width:calc(100% - 3ch);width:calc(var(--w)*1ch);animation:ttype 1.2s steps(30,end) backwards}
#abhf .t-ln{padding-left:calc(var(--d,1)*2ch);overflow-wrap:anywhere;opacity:0;animation:tln .45s ease forwards;animation-delay:calc(1.1s + var(--n)*70ms)}
#abhf:not(.in) .t-ln,#abhf:not(.in) .t-type{animation-play-state:paused}
#abhf .k{color:#37b6c9}#abhf .s{color:#e0b07a}#abhf .p{color:#8d857b}
#abhf a.s{border-radius:4px;box-shadow:inset 0 -1px rgba(224,176,122,.4);transition:background .2s,color .2s}
#abhf a.s:hover{background:rgba(224,176,122,.18);color:#fff}
#abhf .t-out{max-height:150px;overflow:auto;margin-top:12px;color:#cfc7bc;scrollbar-width:thin;scrollbar-color:#3a2f22 transparent}
#abhf .t-o{overflow-wrap:anywhere;animation:tln .3s ease}
#abhf .t-o a{color:#37b6c9;text-decoration:underline}
#abhf .t-o.cmd{color:#8d857b}#abhf .t-o.err{color:#e4608f}#abhf .t-o.ok{color:#4fd18b}
#abhf .t-form{display:flex;align-items:center;gap:8px;margin-top:8px;padding-top:12px;border-top:1px dashed rgba(196,145,92,.2)}
#abhf .t-in{flex:1;min-width:0;background:none;border:0;color:#fff;font:inherit;caret-color:#c4915c;padding:4px 0}
#abhf .t-in:focus-visible{outline:0}
#abhf .t-chips{display:flex;flex-wrap:wrap;gap:8px;padding:12px clamp(14px,3vw,26px) 18px}
#abhf .t-chip{font:inherit;color:#d8d0c6;background:rgba(196,145,92,.08);border:1px solid rgba(196,145,92,.3);border-radius:8px;padding:3px 12px;cursor:pointer;transition:background .2s,transform .2s,border-color .2s}
#abhf .t-chip:hover{background:rgba(196,145,92,.2);border-color:#c4915c;transform:translateY(-2px)}
#abhf .t-stat{max-width:920px;margin:14px auto 0;display:flex;flex-wrap:wrap;border-radius:10px;overflow:hidden;font:500 12px/1 var(--m);opacity:0;transform:translateY(14px)}
#abhf.in .t-stat{opacity:1;transform:none;transition:opacity .7s .6s,transform .7s .6s}
#abhf .t-stat>*{padding:11px 14px;display:block}
#abhf .t-s1{background:#c4915c;color:#1a1208}
#abhf .t-s2{background:#1d1914;color:#e6dfd6}
#abhf .t-s3{flex:1;background:#14110e;color:#8d857b;min-width:140px}
#abhf .t-s4{background:#14110e;color:#c4915c;letter-spacing:.08em;text-transform:uppercase}
#abhf .t-s5{background:#37b6c9;color:#04161a;font-weight:700;border:0;cursor:pointer;font:inherit;font-weight:700;transition:background .2s}
#abhf .t-s5:hover{background:#6fdcec}
@keyframes ttype{from{width:0}}
@keyframes tln{from{opacity:0;transform:translateX(-8px)}to{opacity:1;transform:none}}
@keyframes tsweep{to{background-position:200% 0}}
@media(max-width:560px){#abhf .t-stat>*{flex:1 1 100%}#abhf .t-s3{min-width:0}#abhf .t-ok{display:none}}
@media(prefers-reduced-motion:reduce){#abhf *,#abhf *::before{animation:none!important;transition:none!important}#abhf .t-win,#abhf .t-stat{opacity:1;transform:none}#abhf .t-ln{opacity:1}}
</style>

<footer id="abhf" aria-label="Site footer">
  <div class="t-win" role="group" aria-label="Contact terminal">
    <div class="t-bar"><i style="background:#e4608f"></i><i style="background:#f0b45b"></i><i style="background:#4fd18b"></i><span class="t-ttl"><?= $v('name') ?> &mdash; zsh</span><span class="t-ok">HTTP 200 OK</span></div>
    <div class="t-body">
      <div class="t-cmd"><b>$</b> <span class="t-type" style="--w:<?= strlen($cmd) ?>"><?= abh_e($cmd) ?></span></div>
      <?php
      $ln($P('{'), 0);
      $ent = [['name', 's', $v('name')], ['title', 's', $v('title')], ['tagline', 's', 'Creative mind. Clean code.'], ['sections', 'arr', $sections]];
      if ($conn) { $ent[] = ['contact', 'obj', $conn]; }
      $last = count($ent) - 1;
      foreach ($ent as $i => [$k, $t, $val]) {
          $c = $i < $last ? $P(',') : '';
          if ($t === 's') { $ln($K($k) . '<span class="s">"' . $val . '"</span>' . $c); }
          elseif ($t === 'arr') {
              $ln($K($k) . $P('['));
              $m = count($val); $j = 0;
              foreach ($val as $id => $label) { $j++; $ln('<a class="s" href="#' . abh_e($id) . '">"' . abh_e($label) . '"</a>' . ($j < $m ? $P(',') : ''), 2); }
              $ln($P(']') . $c);
          } else {
              $ln($K($k) . $P('{'));
              $m = count($val); $j = 0;
              foreach ($val as $ck => [$raw, $href, $ext]) { $j++;
                  $ln($K($ck) . '<a class="s" href="' . abh_e($href) . '"' . ($ext ? ' target="_blank" rel="noopener noreferrer"' : '') . '>"' . abh_e($raw) . '"</a>' . ($j < $m ? $P(',') : ''), 2); }
              $ln($P('}') . $c);
          }
      }
      $ln($P('}'), 0);
      ?>
      <div class="t-out" aria-live="polite"><div class="t-o cmd">Type <b>help</b> and press Enter, or tap a command below.</div></div>
      <form class="t-form" autocomplete="off"><label class="sr" for="abhfIn">Type a command</label><span class="t-pr">$</span><input class="t-in" id="abhfIn" placeholder="try: projects" autocapitalize="off" spellcheck="false" enterkeyhint="go"></form>
    </div>
    <div class="t-chips">
      <?php foreach (['help', 'ls', 'projects', 'contact', 'email', 'github', 'top'] as $c): if (in_array($c, ['email', 'github'], true) && !isset($conn[$c])) continue; ?><button class="t-chip" type="button" data-cmd="<?= $c ?>"><?= $c ?></button><?php endforeach; ?>
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
(function(){
var f=document.getElementById('abhf'); if(!f)return;
var D=<?= json_encode($JS, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
var out=f.querySelector('.t-out'), inp=f.querySelector('.t-in'), hist=[], hi=0;
function print(parts,cls){var d=document.createElement('div');d.className='t-o '+(cls||'');[].concat(parts).forEach(function(p){
  if(typeof p==='string'){d.appendChild(document.createTextNode(p))}else{var a=document.createElement('a');a.textContent=p.t;a.href=p.h;if(p.x){a.target='_blank';a.rel='noopener noreferrer'}d.appendChild(a)}});
  out.appendChild(d);out.scrollTop=out.scrollHeight}
function headGap(){var h=0;document.querySelectorAll('header,nav,[class*="header"],[class*="navbar"]').forEach(function(el){if(f.contains(el))return;var cs=getComputedStyle(el);
  if(cs.position==='fixed'||cs.position==='sticky'){var b=el.getBoundingClientRect();if(b.top<=24&&b.bottom>0)h=Math.max(h,b.bottom)}});return h+16}
function go(id){var el=document.getElementById(id);if(!el){print('no such section: #'+id,'err');return}
  print('-> scrolling to #'+id,'ok');window.scrollTo({top:el.getBoundingClientRect().top+window.pageYOffset-headGap(),behavior:'smooth'})}
function link(k,label,t){var c=D.conn[k];if(!c){print(k+' is not set','err');return}
  print([label+': ',{t:c.v,h:c.h,x:c.x}],'ok');if(t==='open')window.open(c.h,'_blank','noopener,noreferrer');else if(t==='mail')location.href=c.h}
var C={
 help:function(){print('commands:');print('  ls  whoami  email  phone  github  linkedin  top  clear');print('  or a section name: '+D.sections.map(function(s){return s.id}).join('  '))},
 ls:function(){print(D.sections.map(function(s){return s.id+'/'}).join('  '))},
 whoami:function(){print(D.name+' - '+D.title)},
 email:function(){link('email','email','mail')},phone:function(){link('phone','phone','mail')},
 github:function(){link('github','github','open')},linkedin:function(){link('linkedin','linkedin','open')},
 top:function(){print('-> back to top','ok');window.scrollTo({top:0,behavior:'smooth'})},
 clear:function(){out.innerHTML=''}
};
function run(raw){var c=raw.trim();if(!c)return;print('$ '+c,'cmd');hist.push(c);hi=hist.length;
  var w=c.toLowerCase().replace(/^cd\s+/,'').replace(/^#/,'').replace(/\/$/,'');
  if(C.hasOwnProperty(w))C[w]();else if(D.sections.some(function(s){return s.id===w}))go(w);else print('command not found: '+c+'  (type help)','err')}
f.querySelector('.t-form').addEventListener('submit',function(e){e.preventDefault();run(inp.value);inp.value=''});
inp.addEventListener('keydown',function(e){if(e.key==='ArrowUp'&&hist.length){e.preventDefault();hi=Math.max(0,hi-1);inp.value=hist[hi]}
  else if(e.key==='ArrowDown'&&hist.length){e.preventDefault();hi=Math.min(hist.length,hi+1);inp.value=hist[hi]||''}});
f.addEventListener('click',function(e){var b=e.target.closest('[data-cmd]');if(b)run(b.getAttribute('data-cmd'))});
if('IntersectionObserver' in window){var io=new IntersectionObserver(function(e){if(e.some(function(x){return x.isIntersecting})){f.classList.add('in');io.disconnect()}},{threshold:.12});io.observe(f)}else{f.classList.add('in')}
})();
</script>
<script src="assets/ui.js"></script>
</body>

</html>
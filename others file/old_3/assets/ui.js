(function () {
  "use strict";
  var root = document.documentElement;
  var btns = [].slice.call(document.querySelectorAll('[data-abh-theme-btn]'));
  function paint() { var l = root.getAttribute('data-theme') === 'light'; btns.forEach(function (b) { b.textContent = l ? '\u263E Night' : '\u2600 Day'; b.setAttribute('aria-pressed', String(l)); }); }
  btns.forEach(function (b) { b.addEventListener('click', function () {
    var n = root.getAttribute('data-theme') === 'light' ? 'dark' : 'light'; root.setAttribute('data-theme', n);
    try { localStorage.setItem('abhTheme', n); } catch (e) {} paint(); }); });
  paint();
  [].forEach.call(document.querySelectorAll('[data-eye]'), function (b) { b.addEventListener('click', function () {
    var i = b.parentNode.querySelector('input'), s = i.type === 'password'; i.type = s ? 'text' : 'password'; b.textContent = s ? 'Hide' : 'Show'; }); });
  if ('IntersectionObserver' in window && !matchMedia('(prefers-reduced-motion: reduce)').matches) {
    var io = new IntersectionObserver(function (en) { en.forEach(function (e) { if (e.isIntersecting) {
      var t = e.target; t.classList.add('abh-in'); io.unobserve(t); setTimeout(function () { t.style.transitionDelay = ''; }, 1000); } }); }, { threshold: .12 });
    [].forEach.call(document.querySelectorAll('.abh-h2,.abh-lead,.abh-card,.abh-panel'), function (el, i) {
      el.classList.add('abh-rv'); el.style.transitionDelay = (i % 4) * 70 + 'ms'; io.observe(el); });
  }
  var f = document.getElementById('abhForm');
  if (f) {
    var w = parseInt(f.getAttribute('data-wait'), 10) || 0, btn = document.getElementById('abhSend'), out = document.getElementById('abhWait');
    if (w > 0) { var end = Date.now() + w * 1000; btn.disabled = true; out.hidden = false;
      (function tick() { var s = Math.max(0, Math.round((end - Date.now()) / 1000));
        if (s <= 0) { btn.disabled = false; out.hidden = true; return; }
        out.textContent = 'You can send another message in ' + Math.floor(s / 60) + ':' + ('0' + (s % 60)).slice(-2);
        setTimeout(tick, 1000); })(); }
  }
})();

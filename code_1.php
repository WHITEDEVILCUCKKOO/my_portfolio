<style>
  #nhi-specialities {
    --nhi-green: #00B85A;
    --nhi-green-dark: #079B59;
    --nhi-navy: #102B46;
    --nhi-text: #536273;
    --nhi-muted: #7C8996;
    --nhi-light: #F3FAF7;
    --nhi-border: #E4EEE8;

    position: relative;
    isolation: isolate;
    width: 100%;
    padding: 0 0 90px;
    overflow: hidden;
    background: #fff;
    color: var(--nhi-text);
    font-family: 'Poppins', sans-serif;
    line-height: 1.6;
  }

  #nhi-specialities,
  #nhi-specialities * {
    box-sizing: border-box;
  }

  #nhi-specialities a {
    text-decoration: none;
  }

  #nhi-specialities h2,
  #nhi-specialities h3,
  #nhi-specialities p {
    margin: 0;
    padding: 0;
  }

  #nhi-specialities .nhi-specialities-bg {
    position: absolute;
    z-index: -1;
    inset: 0 0 auto;
    height: 490px;
    background: linear-gradient(180deg, #F1FAF5 0%, #F9FCFA 65%, #FFFFFF 100%);
    pointer-events: none;
  }

  #nhi-specialities .nhi-specialities-bg:before {
    content: "";
    position: absolute;
    width: 420px;
    height: 420px;
    top: -235px;
    right: -100px;
    border: 55px solid rgba(0, 184, 90, .055);
    border-radius: 50%;
  }

  #nhi-specialities .nhi-specialities-bg:after {
    content: "";
    position: absolute;
    width: 260px;
    height: 260px;
    top: 120px;
    left: -180px;
    border: 38px solid rgba(16, 43, 70, .035);
    border-radius: 50%;
  }

  #nhi-specialities .nhi-specialities-wrap {
    position: relative;
    z-index: 1;
    width: 100%;
    max-width: 1240px;
    margin: 0 auto;
    padding: 0 24px;
  }

  /* HEADER */

  #nhi-specialities .nhi-specialities-head {
    display: grid;
    grid-template-columns: 1.1fr .9fr;
    align-items: end;
    gap: 55px;
    margin-bottom: 43px;
  }

  #nhi-specialities .nhi-specialities-kicker {
    display: inline-flex;
    align-items: center;
    gap: 11px;
    margin-bottom: 15px;
    color: var(--nhi-green-dark);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
  }

  #nhi-specialities .nhi-specialities-kicker:before {
    content: "";
    width: 34px;
    height: 2px;
    background: var(--nhi-green);
  }

  #nhi-specialities .nhi-specialities-title {
    max-width: 650px;
    color: var(--nhi-navy);
    font-size: 42px;
    font-weight: 700;
    line-height: 1.2;
    letter-spacing: -1.4px;
  }

  #nhi-specialities .nhi-specialities-title span {
    color: var(--nhi-green-dark);
  }

  #nhi-specialities .nhi-specialities-heading-line {
    width: 58px;
    height: 4px;
    margin-top: 19px;
    border-radius: 20px;
    background: linear-gradient(90deg, var(--nhi-green), rgba(0, 184, 90, .12));
  }

  #nhi-specialities .nhi-specialities-desc {
    max-width: 475px;
    padding: 5px 0 5px 21px;
    border-left: 3px solid var(--nhi-green);
    color: var(--nhi-text);
    font-size: 14px;
    line-height: 1.95;
  }

  /* FILTER */

  #nhi-specialities .nhi-specialities-filter-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    margin-bottom: 15px;
  }

  #nhi-specialities .nhi-specialities-filter-label {
    color: var(--nhi-navy);
    font-size: 13px;
    font-weight: 700;
  }

  #nhi-specialities .nhi-specialities-tabs {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
    margin-bottom: 29px;
  }

  #nhi-specialities .nhi-specialities-tab {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    padding: 10px 16px;
    border: 1px solid #DFEAE4;
    border-radius: 50px;
    background: #fff;
    color: var(--nhi-navy);
    font-family: inherit;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
    cursor: pointer;
    transition: all .25s ease;
  }

  #nhi-specialities .nhi-specialities-tab small {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 21px;
    height: 21px;
    padding: 0 5px;
    border-radius: 50px;
    background: #EDF8F1;
    color: var(--nhi-green-dark);
    font-size: 10px;
    font-weight: 700;
  }

  #nhi-specialities .nhi-specialities-tab:hover {
    border-color: var(--nhi-green);
    color: var(--nhi-green-dark);
    transform: translateY(-2px);
  }

  #nhi-specialities .nhi-specialities-tab[aria-pressed="true"] {
    border-color: var(--nhi-navy);
    background: var(--nhi-navy);
    color: #fff;
    box-shadow: 0 5px 15px rgba(16, 43, 70, .13);
  }

  #nhi-specialities .nhi-specialities-tab[aria-pressed="true"] small {
    background: rgba(255, 255, 255, .16);
    color: #A6F2C8;
  }

  #nhi-specialities .nhi-specialities-tab:focus-visible {
    outline: 3px solid rgba(0, 184, 90, .3);
    outline-offset: 3px;
  }

  /* GRID */

  #nhi-specialities .nhi-specialities-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 24px;
    align-items: stretch;
  }

  /* CARD */

  #nhi-specialities .nhi-specialities-card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    overflow: hidden;
    border: 1px solid var(--nhi-border);
    border-radius: 15px;
    background: #fff;
    box-shadow: 0 5px 22px rgba(16, 43, 70, .055);
    animation: nhiSpecAppear .4s ease both;
    animation-delay: calc(var(--i)*30ms);
    transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
  }

  #nhi-specialities .nhi-specialities-card:hover {
    transform: translateY(-6px);
    border-color: rgba(0, 184, 90, .5);
    box-shadow: 0 17px 38px rgba(16, 43, 70, .11);
  }

  @keyframes nhiSpecAppear {
    from {
      opacity: 0;
      transform: translateY(13px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* IMAGE */

  #nhi-specialities .nhi-specialities-media {
    position: relative;
    width: 100%;
    height: 205px;
    flex: none;
    overflow: hidden;
    isolation: isolate;
    background: #EAF6EF;
  }

  #nhi-specialities .nhi-specialities-media:before {
    content: "";
    position: absolute;
    z-index: 0;
    width: 230px;
    height: 230px;
    top: -125px;
    right: -85px;
    border: 28px solid rgba(0, 184, 90, .12);
    border-radius: 50%;
    pointer-events: none;
  }

  #nhi-specialities .nhi-specialities-media:after {
    content: "";
    position: absolute;
    z-index: 2;
    inset: 0;
    background: linear-gradient(180deg, rgba(16, 43, 70, 0) 35%, rgba(16, 43, 70, .35) 100%);
    pointer-events: none;
  }

  #nhi-specialities .nhi-specialities-tile {
    position: absolute;
    z-index: 1;
    left: 50%;
    top: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 92px;
    height: 92px;
    margin: -52px 0 0 -46px;
    border-radius: 24px;
    background: linear-gradient(135deg, #00B85A, #079B59);
    box-shadow: 0 10px 24px rgba(7, 155, 89, .28);
    transition: transform .5s cubic-bezier(.2, .7, .2, 1);
  }

  #nhi-specialities .nhi-specialities-media img {
    display: block;
    width: 56px;
    height: 56px;
    max-width: 56px;
    max-height: 56px;
    object-fit: contain;
    filter: invert(1);
  }

  #nhi-specialities .nhi-specialities-card:hover .nhi-specialities-tile {
    transform: scale(1.055);
  }

  /* PLACEHOLDER */

  #nhi-specialities .nhi-specialities-placeholder {
    position: absolute;
    z-index: 1;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #EAF8F0, #D5EEE1);
  }

  #nhi-specialities .nhi-specialities-placeholder svg {
    width: 58px;
    height: 58px;
    fill: none;
    stroke: var(--nhi-green-dark);
    stroke-width: 1.35;
    opacity: .65;
  }

  /* BADGES */

  #nhi-specialities .nhi-specialities-cat {
    position: absolute;
    z-index: 3;
    left: 16px;
    bottom: 14px;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 6px 12px;
    border: 1px solid rgba(255, 255, 255, .25);
    border-radius: 30px;
    background: rgba(7, 155, 89, .94);
    color: #fff;
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
  }

  #nhi-specialities .nhi-specialities-cat:before {
    content: "";
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #B8F5D3;
  }

  #nhi-specialities .nhi-specialities-no {
    position: absolute;
    z-index: 3;
    top: 14px;
    right: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 35px;
    height: 35px;
    border: 1px solid rgba(255, 255, 255, .65);
    border-radius: 50%;
    background: rgba(255, 255, 255, .91);
    color: var(--nhi-navy);
    font-size: 10px;
    font-weight: 700;
    box-shadow: 0 3px 12px rgba(0, 0, 0, .07);
  }

  /* CONTENT */

  #nhi-specialities .nhi-specialities-body {
    display: flex;
    flex: 1;
    flex-direction: column;
    align-items: flex-start;
    padding: 20px 21px 19px;
  }

  #nhi-specialities .nhi-specialities-name {
    width: 100%;
    min-height: 52px;
    margin-bottom: 9px !important;
    color: var(--nhi-navy);
    font-size: 16px;
    font-weight: 700;
    line-height: 1.48;
    letter-spacing: -.25px;
  }

  #nhi-specialities .nhi-specialities-text {
    display: -webkit-box;
    width: 100%;
    min-height: 72px;
    margin-bottom: 16px !important;
    overflow: hidden;
    color: #687786;
    font-size: 12px;
    font-weight: 400;
    line-height: 1.85;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
  }

  /* LINK */

  #nhi-specialities .nhi-specialities-more {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
    margin-top: auto;
    padding-top: 13px;
    border-top: 1px solid #EDF2EF;
    color: var(--nhi-green-dark);
    font-size: 12px;
    font-weight: 700;
    transition: color .25s ease;
  }

  #nhi-specialities .nhi-specialities-more span {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 26px;
    height: 26px;
    margin-left: auto;
    border-radius: 50%;
    background: #EAF8F0;
    color: var(--nhi-green-dark);
    font-size: 16px;
    transition: all .25s ease;
  }

  #nhi-specialities .nhi-specialities-card:hover .nhi-specialities-more {
    color: var(--nhi-navy);
  }

  #nhi-specialities .nhi-specialities-card:hover .nhi-specialities-more span {
    background: var(--nhi-green);
    color: #fff;
    transform: translateX(3px);
  }

  #nhi-specialities .nhi-specialities-card-link {
    position: absolute;
    z-index: 4;
    inset: 0;
    border-radius: 15px;
  }

  #nhi-specialities .nhi-specialities-card-link:focus-visible {
    outline: 3px solid var(--nhi-green);
    outline-offset: -4px;
  }

  /* VIEW ALL */

  #nhi-specialities .nhi-specialities-tgl {
    display: flex;
    justify-content: center;
    margin-top: 36px;
  }

  #nhi-specialities .nhi-specialities-tgl[hidden] {
    display: none !important;
  }

  #nhi-specialities .nhi-specialities-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    min-width: 220px;
    padding: 14px 24px;
    border: 1px solid var(--nhi-navy);
    border-radius: 8px;
    background: var(--nhi-navy);
    color: #fff;
    font-family: inherit;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all .25s ease;
  }

  #nhi-specialities .nhi-specialities-btn:hover {
    border-color: var(--nhi-green-dark);
    background: var(--nhi-green-dark);
    box-shadow: 0 8px 20px rgba(0, 184, 90, .17);
    transform: translateY(-2px);
  }

  #nhi-specialities .nhi-specialities-btn svg {
    width: 15px;
    height: 15px;
    fill: none;
    stroke: currentColor;
    stroke-width: 2;
    transition: transform .25s ease;
  }

  #nhi-specialities .nhi-specialities-btn[aria-expanded="true"] svg {
    transform: rotate(180deg);
  }

  #nhi-specialities .nhi-specialities-btn:focus-visible {
    outline: 3px solid rgba(0, 184, 90, .35);
    outline-offset: 3px;
  }

  /* TABLET */

  @media(max-width:1024px) {
    #nhi-specialities {
      padding: 0 0 75px;
    }

    #nhi-specialities .nhi-specialities-head {
      gap: 30px;
    }

    #nhi-specialities .nhi-specialities-title {
      font-size: 35px;
    }

    #nhi-specialities .nhi-specialities-grid {
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 20px;
    }

    #nhi-specialities .nhi-specialities-media {
      height: 210px;
    }
  }

  /* MOBILE */

  @media(max-width:640px) {
    #nhi-specialities {
      padding: 0 0 58px;
    }

    #nhi-specialities .nhi-specialities-wrap {
      padding: 0 16px;
    }

    #nhi-specialities .nhi-specialities-head {
      grid-template-columns: 1fr;
      gap: 17px;
      margin-bottom: 30px;
    }

    #nhi-specialities .nhi-specialities-kicker {
      margin-bottom: 12px;
      font-size: 10px;
      letter-spacing: 1.5px;
    }

    #nhi-specialities .nhi-specialities-kicker:before {
      width: 27px;
    }

    #nhi-specialities .nhi-specialities-title {
      font-size: 29px;
      line-height: 1.25;
      letter-spacing: -.7px;
    }

    #nhi-specialities .nhi-specialities-heading-line {
      width: 48px;
      height: 3px;
      margin-top: 15px;
    }

    #nhi-specialities .nhi-specialities-desc {
      padding-left: 15px;
      font-size: 12.5px;
      line-height: 1.85;
    }

    #nhi-specialities .nhi-specialities-filter-label {
      font-size: 12px;
    }

    #nhi-specialities .nhi-specialities-tabs {
      flex-wrap: nowrap;
      overflow-x: auto;
      gap: 8px;
      margin: 0 -16px 22px;
      padding: 0 16px 9px;
      scrollbar-width: none;
      -webkit-overflow-scrolling: touch;
    }

    #nhi-specialities .nhi-specialities-tabs::-webkit-scrollbar {
      display: none;
    }

    #nhi-specialities .nhi-specialities-tab {
      flex: none;
      padding: 9px 13px;
      font-size: 11px;
    }

    #nhi-specialities .nhi-specialities-grid {
      grid-template-columns: 1fr;
      gap: 17px;
    }

    #nhi-specialities .nhi-specialities-card {
      border-radius: 13px;
    }

    #nhi-specialities .nhi-specialities-media {
      height: 210px;
    }

    #nhi-specialities .nhi-specialities-body {
      padding: 18px 18px 17px;
    }

    #nhi-specialities .nhi-specialities-name {
      min-height: 0;
      margin-bottom: 8px !important;
      font-size: 15px;
    }

    #nhi-specialities .nhi-specialities-text {
      min-height: 0;
      margin-bottom: 13px !important;
      font-size: 12px;
    }

    #nhi-specialities .nhi-specialities-more {
      padding-top: 11px;
    }

    #nhi-specialities .nhi-specialities-tgl {
      margin-top: 26px;
    }

    #nhi-specialities .nhi-specialities-btn {
      width: 100%;
      min-width: 0;
    }
  }

  /* SMALL MOBILE */

  @media(max-width:380px) {
    #nhi-specialities .nhi-specialities-media {
      height: 185px;
    }

    #nhi-specialities .nhi-specialities-title {
      font-size: 26px;
    }
  }

  /* REDUCED MOTION */

  @media(prefers-reduced-motion:reduce) {

    #nhi-specialities *,
    #nhi-specialities *:before,
    #nhi-specialities *:after {
      animation: none !important;
      transition: none !important;
      scroll-behavior: auto !important;
    }
  }
</style>

<section id="nhi-specialities" aria-labelledby="nhi-specialities-title">

  <div class="nhi-specialities-bg" aria-hidden="true"></div>

  <div class="nhi-specialities-wrap">

    <header class="nhi-specialities-head">

      <div class="nhi-specialities-heading">
        <div class="nhi-specialities-kicker">Our Expertise</div>

        <h2 class="nhi-specialities-title" id="nhi-specialities-title">
          Comprehensive
          <span>Medical Specialities</span>
        </h2>

        <div class="nhi-specialities-heading-line"></div>
      </div>

      <p class="nhi-specialities-desc">
        Explore our wide range of medical specialities and advanced healthcare services, delivered by experienced medical professionals with a focus on quality patient care.
      </p>

    </header>

    <div class="nhi-specialities-filter-head">
      <span class="nhi-specialities-filter-label">
        Explore Our Departments
      </span>
    </div>

    <div
      class="nhi-specialities-tabs"
      id="nhi-specialities-tabs"
      role="group"
      aria-label="Filter medical specialities">
    </div>

    <div
      class="nhi-specialities-grid"
      id="nhi-specialities-grid"
      aria-live="polite">
    </div>

    <div class="nhi-specialities-tgl" id="nhi-specialities-tgl" hidden>

      <button
        class="nhi-specialities-btn"
        type="button"
        id="nhi-specialities-btn"
        aria-expanded="false">

        <span id="nhi-specialities-btnt"></span>

        <svg viewBox="0 0 16 16" aria-hidden="true">
          <path d="M3 6l5 5 5-5" />
        </svg>

      </button>
    </div>

  </div>
</section>



<script>
  (function() {

    'use strict';

    var root = document.getElementById('nhi-specialities');

    if (!root || root.dataset.initialized === 'true') {
      return;
    }

    root.dataset.initialized = 'true';

    /* WEBSITE SETTINGS */

    var BASE = '/';
    var PAGE = BASE + 'specializations/';
    var LIMIT = 9;

    /* ALL 16 MEDICAL SPECIALITIES + CORRECT IMAGES */

    var S = @json($nhiSpecData, JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

    /* ELEMENT REFERENCES */

    var $ = function(id) {
      return root.querySelector('#' + id);
    };

    var grid = $('nhi-specialities-grid');
    var tabs = $('nhi-specialities-tabs');
    var tgl = $('nhi-specialities-tgl');
    var btn = $('nhi-specialities-btn');
    var btnt = $('nhi-specialities-btnt');

    var cat = 'All';
    var expanded = false;

    var CATS = @json($nhiCats, JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

    /* SAFE HTML TEXT */

    function esc(s) {
      return String(s == null ? '' : s).replace(/[&<>"']/g, function(c) {
        return {
          '&': '&amp;',
          '<': '&lt;',
          '>': '&gt;',
          '"': '&quot;',
          "'": '&#39;'
        } [c];
      });
    }

    /* CATEGORY COUNTS */

    function count(c) {
      if (c === 'All') {
        return S.length;
      }

      return S.filter(function(s) {
        return s[1] === c;
      }).length;
    }

    /* CREATE FILTER TABS */

    tabs.innerHTML = CATS.map(function(c) {

      var label = c === 'All' ? 'All Specialities' : c;

      return '' +
        '<button' +
        ' type="button"' +
        ' class="nhi-specialities-tab"' +
        ' data-c="' + esc(c) + '"' +
        ' aria-pressed="' + (c === cat ? 'true' : 'false') + '">' +
        esc(label) +
        '<small>' + count(c) + '</small>' +
        '</button>';

    }).join('');

    /* IMAGE FALLBACK */

    var PLACEHOLDER = '' +
      '<div class="nhi-specialities-placeholder" aria-hidden="true">' +
      '<svg viewBox="0 0 64 64">' +
      '<path d="M32 56s-22-13-22-31a13 13 0 0122-8 13 13 0 0122 8c0 18-22 31-22 31z"/>' +
      '<path d="M32 21v20M22 31h20"/>' +
      '</svg>' +
      '</div>';

    /* CREATE CARD */

    function createCard(s, i) {

      var idx = S.indexOf(s) + 1;
      var imageURL = s[3];
      var pageURL = s[2];

      return '' +
        '<article class="nhi-specialities-card" style="--i:' + i + '">'

        +
        '<div class="nhi-specialities-media">'

        +
        PLACEHOLDER

        +
        '<span class="nhi-specialities-tile">' +
        '<img' +
        ' src="' + esc(imageURL) + '"' +
        ' alt="' + esc(s[0] + ' – National Heart Institute') + '"' +
        ' width="56"' +
        ' height="56"' +
        ' loading="lazy"' +
        ' decoding="async"' +
        '>' +
        '</span>'

        +
        '<span class="nhi-specialities-cat">' +
        esc(s[1]) +
        '</span>'

        +
        '<span class="nhi-specialities-no" aria-hidden="true">' +
        (idx < 10 ? '0' : '') + idx +
        '</span>'

        +
        '</div>'

        +
        '<div class="nhi-specialities-body">'

        +
        '<h3 class="nhi-specialities-name">' +
        esc(s[0]) +
        '</h3>'

        +
        '<p class="nhi-specialities-text">' +
        esc(s[4]) +
        '</p>'

        +
        '<span class="nhi-specialities-more" aria-hidden="true">' +
        'Explore Department' +
        '<span>→</span>' +
        '</span>'

        +
        '</div>'

        +
        '<a' +
        ' class="nhi-specialities-card-link"' +
        ' href="' + esc(pageURL) + '"' +
        ' aria-label="Explore ' + esc(s[0]) + ' at National Heart Institute">' +
        '</a>'

        +
        '</article>';
    }

    /* RENDER CARDS */

    function render() {

      var list = cat === 'All' ?
        S :
        S.filter(function(s) {
          return s[1] === cat;
        });

      var visible = (cat === 'All' && !expanded) ?
        list.slice(0, LIMIT) :
        list;

      grid.innerHTML = visible.map(function(s, i) {
        return createCard(s, i);
      }).join('');

      /* IMAGE LOAD FALLBACK */

      grid.querySelectorAll('.nhi-specialities-media img').forEach(function(im) {

        var media = im.closest('.nhi-specialities-media');
        var placeholder = media.querySelector('.nhi-specialities-placeholder');
        var tile = im.parentElement;

        function loaded() {
          if (placeholder) {
            placeholder.style.display = 'none';
          }
        }

        function failed() {
          tile.style.display = 'none';
          if (placeholder) {
            placeholder.style.display = 'flex';
          }
        }

        im.addEventListener('load', loaded, {
          once: true
        });
        im.addEventListener('error', failed, {
          once: true
        });

        if (im.complete) {
          if (im.naturalWidth > 0) {
            loaded();
          } else {
            failed();
          }
        }

      });

      /* VIEW ALL BUTTON */

      var hasMore = (cat === 'All' && list.length > LIMIT);

      tgl.hidden = !hasMore;

      if (hasMore) {

        btnt.textContent = expanded ?
          'Show Fewer Specialities' :
          'View All ' + list.length + ' Specialities';

        btn.setAttribute('aria-expanded', String(expanded));
      }

      /* ACTIVE FILTER */

      tabs.querySelectorAll('.nhi-specialities-tab').forEach(function(b) {

        b.setAttribute(
          'aria-pressed',
          String(b.dataset.c === cat)
        );

      });

    }

    /* FILTER CLICK */

    tabs.addEventListener('click', function(e) {

      var b = e.target.closest('button[data-c]');

      if (!b || !tabs.contains(b)) {
        return;
      }

      cat = b.dataset.c;
      expanded = false;

      render();

    });

    /* VIEW ALL / SHOW FEWER */

    btn.addEventListener('click', function() {

      expanded = !expanded;
      render();

    });

    /* INITIAL RENDER */

    render();

  })();
</script>
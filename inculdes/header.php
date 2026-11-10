<body class="abh-body">



  <style>
    /* ==================================
   ABHI GLASSMORPHISM HEADER
================================== */

    .abh-glass-head {
      position: sticky;
      top: 0;
      z-index: 999;
      padding: 13px 0;
      background: transparent;
      border: 0;
      isolation: isolate;
    }

    .abh-glass-head::after {
      content: "";
      position: absolute;
      inset: 0;
      z-index: -1;
      background: linear-gradient(90deg,
          transparent,
          var(--abh-glow),
          transparent);
      opacity: .55;
      pointer-events: none;
    }

    .abh-glass-inner {
      min-height: 68px;
      height: auto !important;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 20px;
      padding: 10px 17px;
      border: 1px solid rgba(148, 163, 184, .20);
      border-radius: 19px;

      background: rgba(17, 28, 46, .67);
      backdrop-filter: blur(24px) saturate(160%);
      -webkit-backdrop-filter: blur(24px) saturate(160%);

      box-shadow:
        0 10px 40px rgba(0, 0, 0, .16),
        inset 0 1px 0 rgba(255, 255, 255, .07);

      transition:
        background .35s ease,
        border-color .35s ease,
        box-shadow .35s ease,
        padding .35s ease;
    }

    :root[data-theme="light"] .abh-glass-inner {
      background: rgba(255, 255, 255, .72);
      border-color: rgba(15, 23, 42, .12);
      box-shadow:
        0 10px 35px rgba(15, 23, 42, .08),
        inset 0 1px 0 rgba(255, 255, 255, .9);
    }

    /* Logo */

    .abh-glass-logo {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      flex-shrink: 0;
      color: var(--abh-text);
      text-decoration: none;
      font: 700 1.3rem "Space Grotesk", sans-serif;
      letter-spacing: -.6px;
    }

    .abh-glass-logo i {
      color: var(--abh-cyan);
      font-style: normal;
    }

    .abh-glass-mark {
      width: 37px;
      height: 37px;
      color: var(--abh-cyan);
      transition: transform .4s ease, filter .4s ease;
    }

    .abh-glass-mark svg {
      width: 100%;
      height: 100%;
    }

    .abh-glass-logo:hover .abh-glass-mark {
      transform: rotate(-8deg) scale(1.08);
      filter: drop-shadow(0 0 8px var(--abh-cyan));
    }

    /* Navigation Glass Pill */

    .abh-glass-nav {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 4px;
      padding: 5px;
      border-radius: 14px;
      border: 1px solid rgba(148, 163, 184, .12);
      background: rgba(255, 255, 255, .035);
    }

    .abh-body .abh-glass-nav a {
      position: relative;
      padding: 9px 11px;
      border-radius: 9px;
      color: var(--abh-mute);
      text-decoration: none;
      font-size: .84rem;
      font-weight: 550;
      white-space: nowrap;
      transition: color .3s ease, background .3s ease;
    }

    .abh-body .abh-glass-nav a:hover {
      color: var(--abh-cyan);
      background: var(--abh-glow);
    }

    /* Actions */

    .abh-glass-actions {
      display: flex;
      align-items: center;
      gap: 10px;
      flex-shrink: 0;
    }

    /* Theme Button */

    .abh-glass-head .abh-theme {
      height: 39px;
      padding: 0 12px;
      border-radius: 11px;
      background: rgba(255, 255, 255, .045);
      border: 1px solid rgba(148, 163, 184, .22);
      color: var(--abh-text);
      font-size: .78rem;
    }

    /* CTA */

    .abh-body .abh-glass-cta {
      height: 40px;
      padding: 0 15px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      border-radius: 11px;
      color: #06101E;
      text-decoration: none;
      font-size: .84rem;
      font-weight: 700;

      background: linear-gradient(110deg,
          var(--abh-cyan),
          var(--abh-blue));

      box-shadow: 0 5px 20px rgba(0, 212, 255, .17);
      transition: transform .3s ease, box-shadow .3s ease;
    }

    .abh-glass-cta svg {
      width: 16px;
      height: 16px;
      transition: transform .3s ease;
    }

    .abh-glass-cta:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(0, 212, 255, .3);
    }

    .abh-glass-cta:hover svg {
      transform: translateX(4px);
    }

    /* Mobile Toggle */

    .abh-glass-toggle {
      display: none;
      width: 40px;
      height: 40px;
      place-items: center;
      border-radius: 11px;
      border: 1px solid var(--abh-line);
      background: var(--abh-glow);
      color: var(--abh-cyan);
      cursor: pointer;
    }

    .abh-glass-toggle svg {
      width: 22px;
      height: 22px;
    }

    .abh-icon-close {
      display: none;
    }

    /* Scroll Effect */

    .abh-glass-head.abh-scrolled .abh-glass-inner {
      background: rgba(11, 17, 32, .91);
      border-color: rgba(0, 212, 255, .25);
      box-shadow: 0 12px 35px rgba(0, 0, 0, .22);
    }

    :root[data-theme="light"] .abh-glass-head.abh-scrolled .abh-glass-inner {
      background: rgba(246, 249, 252, .95);
    }

    /* Tablet and Mobile */

    @media (max-width: 900px) {

      .abh-glass-head {
        padding: 9px 0;
      }

      .abh-glass-inner {
        min-height: 62px;
      }

      .abh-glass-toggle {
        display: grid;
      }

      .abh-glass-nav {
        position: absolute;
        top: calc(100% + 7px);
        left: 20px;
        right: 20px;

        display: flex;
        flex-direction: column;
        align-items: stretch;
        gap: 5px;
        padding: 13px;

        border: 1px solid rgba(0, 212, 255, .2);
        border-radius: 17px;

        background: rgba(11, 17, 32, .94);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);

        box-shadow: 0 20px 50px rgba(0, 0, 0, .35);

        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transform: translateY(-12px) scale(.98);

        transition:
          opacity .3s ease,
          visibility .3s ease,
          transform .3s ease;

        max-height: calc(100dvh - 100px);
        overflow-y: auto;
      }

      :root[data-theme="light"] .abh-glass-nav {
        background: rgba(246, 249, 252, .96);
      }

      .abh-glass-nav.abh-nav-open {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
        transform: translateY(0) scale(1);
      }

      .abh-body .abh-glass-nav a {
        padding: 12px 15px;
        font-size: .93rem;
        border: 1px solid transparent;
      }

      .abh-body .abh-glass-nav a:hover {
        border-color: var(--abh-line);
      }

      .abh-glass-toggle[aria-expanded="true"] .abh-icon-menu {
        display: none;
      }

      .abh-glass-toggle[aria-expanded="true"] .abh-icon-close {
        display: block;
      }
    }

    @media (max-width: 480px) {

      .abh-glass-inner {
        padding: 9px 11px;
        gap: 8px;
      }

      .abh-glass-logo {
        font-size: 1.12rem;
        gap: 7px;
      }

      .abh-glass-mark {
        width: 32px;
        height: 32px;
      }

      .abh-glass-actions {
        gap: 7px;
      }

      .abh-glass-head .abh-theme {
        width: 38px;
        padding: 0;
        font-size: 0;
      }

      .abh-glass-head .abh-theme::before {
        content: "☼";
        font-size: 17px;
      }

      .abh-glass-head .abh-theme[aria-pressed="true"]::before {
        content: "☾";
      }

      .abh-body .abh-glass-cta {
        display: none;
      }
    }

    @media (prefers-reduced-motion: reduce) {

      .abh-glass-head,
      .abh-glass-head *,
      .abh-glass-head *::before,
      .abh-glass-head *::after {
        transition: none !important;
        animation: none !important;
      }
    }
  </style>
  <header class="abh-head abh-glass-head" id="abhHeader">
    <div class="abh-wrap abh-glass-inner">

      <!-- Logo -->
      <a href="#home" class="abh-glass-logo">
        <span class="abh-glass-mark">
          <svg viewBox="0 0 40 40" fill="none">
            <rect x="1" y="1" width="38" height="38" rx="12"
              stroke="currentColor" stroke-width="1.4" />
            <path d="M10 29L20 10L30 29M14 22H26"
              stroke="currentColor" stroke-width="2.4"
              stroke-linecap="round" />
          </svg>
        </span>
        <span><?= $v('name') ?><i>.</i></span>
      </a>

      <!-- Glass Navigation -->
      <nav class="abh-glass-nav" id="abhNav">
        <a href="#about">About</a>
        <a href="#skills">Skills</a>
        <a href="#services">Services</a>
        <a href="#projects">Projects</a>

        <?php if ($exp): ?>
          <a href="#experience">Experience</a>
        <?php endif; ?>

        <a href="#backend">Backend</a>
        <a href="#contact">Contact</a>
      </nav>

      <!-- Actions -->
      <div class="abh-glass-actions">

        <button class="abh-theme"
          type="button"
          data-abh-theme-btn
          aria-label="Switch day or night theme">
          ☀ Day
        </button>

        <a href="#contact" class="abh-glass-cta">
          Let's Talk
          <svg viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2">
            <path d="M5 12H19M12 5L19 12L12 19" />
          </svg>
        </a>

        <button class="abh-glass-toggle"
          id="abhMenuBtn"
          type="button"
          aria-label="Open menu"
          aria-expanded="false"
          aria-controls="abhNav">
          <svg class="abh-icon-menu" viewBox="0 0 24 24"
            fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round">
            <path d="M4 7H20M4 12H20M4 17H20" />
          </svg>
          <svg class="abh-icon-close" viewBox="0 0 24 24"
            fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round">
            <path d="M6 6L18 18M18 6L6 18" />
          </svg>
        </button>

      </div>
    </div>
  </header>
  <script>
    /* GLASS HEADER INTERACTIONS */

    (function() {
      "use strict";

      const header = document.getElementById("abhHeader");
      const menuBtn = document.getElementById("abhMenuBtn");
      const nav = document.getElementById("abhNav");

      if (!header) return;

      // Scroll effect
      function handleScroll() {
        header.classList.toggle(
          "abh-scrolled",
          window.scrollY > 25
        );
      }

      window.addEventListener("scroll", handleScroll, {
        passive: true
      });

      handleScroll();

      // Mobile menu
      if (menuBtn && nav) {

        function closeMenu() {
          menuBtn.setAttribute("aria-expanded", "false");
          menuBtn.setAttribute("aria-label", "Open menu");
          nav.classList.remove("abh-nav-open");
        }

        menuBtn.addEventListener("click", function() {
          const open =
            menuBtn.getAttribute("aria-expanded") === "true";

          menuBtn.setAttribute("aria-expanded", String(!open));
          menuBtn.setAttribute(
            "aria-label",
            open ? "Open menu" : "Close menu"
          );

          nav.classList.toggle("abh-nav-open", !open);
        });

        nav.querySelectorAll("a").forEach(function(link) {
          link.addEventListener("click", closeMenu);
        });

        document.addEventListener("click", function(e) {
          if (!header.contains(e.target)) {
            closeMenu();
          }
        });

        document.addEventListener("keydown", function(e) {
          if (e.key === "Escape") {
            closeMenu();
            menuBtn.focus();
          }
        });

        window.addEventListener("resize", function() {
          if (window.innerWidth > 900) {
            closeMenu();
          }
        });
      }

    })();
  </script>
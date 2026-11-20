<?php /* Complete header replacement: paste this whole block where the OLD header style+markup+script were. */ ?>
<style>
  /* ABH header v2 — isolated from old .abh-glass-* rules */
  #abhHeader.abhx-header {
    position: sticky !important;
    top: 0 !important;
    z-index: 9999 !important;
    display: block !important;
    width: 100% !important;
    padding: 12px 18px !important;
    margin: 0 !important;
    background: rgba(10, 9, 9, .92) !important;
    border: 0 !important;
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    box-sizing: border-box
  }

  #abhHeader .abhx-shell,
  #abhHeader .abhx-shell * {
    box-sizing: border-box
  }

  #abhHeader .abhx-shell {
    position: relative;
    max-width: 1190px;
    width: 100%;
    min-height: 68px;
    margin: 0 auto;
    padding: 10px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    border: 1px solid rgba(244, 172, 99, .22);
    border-radius: 16px;
    background: linear-gradient(115deg, #211a16, #111010 65%, #211914);
    box-shadow: 0 12px 34px rgba(0, 0, 0, .3)
  }

  #abhHeader.abhx-scrolled .abhx-shell {
    border-color: rgba(247, 176, 96, .45);
    box-shadow: 0 14px 36px rgba(0, 0, 0, .43)
  }

  #abhHeader .abhx-brand {
    display: inline-flex !important;
    align-items: center !important;
    gap: 10px !important;
    flex: 0 0 auto;
    text-decoration: none !important;
    color: #f8eee5 !important;
    font: 750 22px/1.1 'Space Grotesk', Inter, Arial, sans-serif !important;
    letter-spacing: -.7px
  }

  #abhHeader .abhx-brand-icon {
    display: grid !important;
    place-items: center !important;
    width: 40px !important;
    height: 40px !important;
    min-width: 40px !important;
    min-height: 40px !important;
    border: 1px solid rgba(250, 173, 89, .4);
    border-radius: 12px;
    background: rgba(255, 170, 80, .09);
    color: #ffb86e
  }

  #abhHeader .abhx-brand-icon svg {
    display: block !important;
    width: 25px !important;
    height: 25px !important;
    max-width: 25px !important;
    max-height: 25px !important;
    overflow: visible !important;
    flex: none !important
  }

  #abhHeader .abhx-brand-dot {
    color: #f8aa61
  }

  #abhHeader .abhx-nav {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 3px;
    min-width: 0;
    padding: 5px;
    border: 1px solid rgba(255, 180, 105, .11);
    border-radius: 12px;
    background: rgba(0, 0, 0, .26)
  }

  #abhHeader .abhx-nav a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 36px;
    padding: 7px 10px;
    border-radius: 8px;
    color: #c6b7aa !important;
    text-decoration: none !important;
    white-space: nowrap;
    font: 550 12px/1.2 Inter, Arial, sans-serif !important;
    transition: background .2s, color .2s
  }

  #abhHeader .abhx-nav a:hover,
  #abhHeader .abhx-nav a.abhx-active {
    background: rgba(242, 158, 78, .13);
    color: #ffbd7e !important
  }

  #abhHeader .abhx-actions {
    display: flex;
    align-items: center;
    gap: 9px;
    flex: 0 0 auto
  }

  #abhHeader .abhx-theme,
  #abhHeader .abhx-toggle {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 39px;
    padding: 0 12px;
    border: 1px solid rgba(240, 175, 112, .25);
    border-radius: 10px;
    background: rgba(255, 255, 255, .04);
    color: #f4e3d4;
    font: 600 12px Inter, Arial, sans-serif;
    cursor: pointer
  }

  #abhHeader .abhx-cta {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    min-height: 40px;
    padding: 0 15px;
    border-radius: 10px;
    background: linear-gradient(110deg, #ffc17b, #e3984d);
    color: #251509 !important;
    text-decoration: none !important;
    font: 750 12px Inter, Arial, sans-serif !important;
    white-space: nowrap;
    box-shadow: 0 5px 20px rgba(226, 140, 55, .18)
  }

  #abhHeader .abhx-cta svg {
    width: 16px !important;
    height: 16px !important;
    max-width: 16px !important;
    max-height: 16px !important;
    flex: none !important
  }

  #abhHeader .abhx-toggle {
    display: none;
    width: 40px;
    padding: 0
  }

  #abhHeader .abhx-toggle svg {
    display: block !important;
    width: 21px !important;
    height: 21px !important;
    max-width: 21px !important;
    max-height: 21px !important
  }

  #abhHeader .abhx-close {
    display: none !important
  }

  #abhHeader .abhx-toggle[aria-expanded="true"] .abhx-bars {
    display: none !important
  }

  #abhHeader .abhx-toggle[aria-expanded="true"] .abhx-close {
    display: block !important
  }

  :root[data-theme="light"] #abhHeader.abhx-header {
    background: rgba(248, 244, 239, .94) !important
  }

  :root[data-theme="light"] #abhHeader .abhx-shell {
    background: linear-gradient(110deg, #fffaf5, #f3ebe2);
    border-color: #dfc7b1
  }

  :root[data-theme="light"] #abhHeader .abhx-brand {
    color: #33271e !important
  }

  :root[data-theme="light"] #abhHeader .abhx-nav {
    background: rgba(90, 52, 20, .05)
  }

  :root[data-theme="light"] #abhHeader .abhx-nav a {
    color: #665346 !important
  }

  :root[data-theme="light"] #abhHeader .abhx-theme,
  :root[data-theme="light"] #abhHeader .abhx-toggle {
    color: #3d2b1d;
    border-color: #d9bda3
  }

  @media(max-width:1100px) {
    #abhHeader .abhx-shell {
      gap: 9px;
      padding: 9px 12px
    }

    #abhHeader .abhx-nav a {
      padding: 7px 7px;
      font-size: 11px !important
    }
  }

  @media(max-width:950px) {
    #abhHeader .abhx-toggle {
      display: inline-flex
    }

    #abhHeader .abhx-nav {
      position: absolute;
      top: calc(100% + 9px);
      left: 0;
      right: 0;
      z-index: 20;
      display: none;
      flex-direction: column;
      align-items: stretch;
      gap: 4px;
      padding: 12px;
      background: #1a1512;
      border: 1px solid rgba(244, 172, 99, .32);
      box-shadow: 0 20px 40px rgba(0, 0, 0, .4);
      border-radius: 14px;
      max-height: calc(100dvh - 110px);
      overflow-y: auto
    }

    #abhHeader .abhx-nav.abhx-open {
      display: flex
    }

    #abhHeader .abhx-nav a {
      justify-content: flex-start;
      font-size: 14px !important;
      padding: 13px 14px
    }

    :root[data-theme="light"] #abhHeader .abhx-nav {
      background: #fff9f2
    }
  }

  @media(max-width:520px) {
    #abhHeader.abhx-header {
      padding: 9px 10px !important
    }

    #abhHeader .abhx-shell {
      min-height: 62px;
      padding: 8px 10px
    }

    #abhHeader .abhx-brand {
      font-size: 19px !important;
      gap: 7px !important
    }

    #abhHeader .abhx-brand-icon {
      width: 35px !important;
      height: 35px !important;
      min-width: 35px !important;
      min-height: 35px !important
    }

    #abhHeader .abhx-theme {
      padding: 0 9px
    }

    #abhHeader .abhx-cta {
      display: none
    }

    #abhHeader .abhx-actions {
      gap: 6px
    }
  }

  @media(prefers-reduced-motion:reduce) {

    #abhHeader *,
    #abhHeader *::before,
    #abhHeader *::after {
      transition: none !important
    }
  }
</style>
<header id="abhHeader" class="abhx-header">
  <div class="abhx-shell">
    <a class="abhx-brand" href="#home" aria-label="Go to home">
      <span class="abhx-brand-icon" aria-hidden="true"><svg width="25" height="25" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M7 31L20 8L33 31M12 23H28" stroke="currentColor" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round" />
        </svg></span>
      <span><?= $v('name') ?><span class="abhx-brand-dot">.</span></span>
    </a>
    <nav class="abhx-nav" id="abhNav" aria-label="Main navigation">
      <a href="#about">About</a><a href="#skills">Skills</a><a href="#services">Services</a><a href="#projects">Projects</a>
      <?php if ($exp): ?><a href="#experience">Experience</a><?php endif; ?>
      <a href="#backend">Backend</a><a href="#contact">Contact</a>
    </nav>
    <div class="abhx-actions">
      <button class="abhx-theme abh-theme" type="button" data-abh-theme-btn aria-label="Switch day or night theme">☀ Day</button>
      <a href="#contact" class="abhx-cta">Let's Talk <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M5 12h14m-7-7 7 7-7 7" />
        </svg></a>
      <button id="abhMenuBtn" class="abhx-toggle" type="button" aria-controls="abhNav" aria-expanded="false" aria-label="Open menu"><svg class="abhx-bars" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
          <path d="M4 7h16M4 12h16M4 17h16" />
        </svg><svg class="abhx-close" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
          <path d="M5 5l14 14M19 5 5 19" />
        </svg></button>
    </div>
  </div>
</header>
<script>
  (function() {
    'use strict';
    const header = document.getElementById('abhHeader'),
      btn = document.getElementById('abhMenuBtn'),
      nav = document.getElementById('abhNav');
    if (!header || !btn || !nav) return;

    function close() {
      nav.classList.remove('abhx-open');
      btn.setAttribute('aria-expanded', 'false');
      btn.setAttribute('aria-label', 'Open menu')
    }
    btn.addEventListener('click', () => {
      const opening = btn.getAttribute('aria-expanded') !== 'true';
      btn.setAttribute('aria-expanded', String(opening));
      btn.setAttribute('aria-label', opening ? 'Close menu' : 'Open menu');
      nav.classList.toggle('abhx-open', opening)
    });
    nav.querySelectorAll('a').forEach(a => a.addEventListener('click', close));
    document.addEventListener('click', e => {
      if (!header.contains(e.target)) close()
    });
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape') close()
    });
    window.addEventListener('resize', () => {
      if (innerWidth > 950) close()
    });
    const links = [...nav.querySelectorAll('a[href^="#"]')];
    let queued = false;

    function update() {
      queued = false;
      header.classList.toggle('abhx-scrolled', scrollY > 20);
      let current = '';
      for (const a of links) {
        const target = document.getElementById(a.hash.slice(1));
        if (target && target.getBoundingClientRect().top < 190) current = a.hash
      }
      links.forEach(a => a.classList.toggle('abhx-active', a.hash === current))
    }
    addEventListener('scroll', () => {
      if (!queued) {
        queued = true;
        requestAnimationFrame(update)
      }
    }, {
      passive: true
    });
    update();
  })();
</script>
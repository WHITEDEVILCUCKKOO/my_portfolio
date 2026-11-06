
<body class="abh-body">
  <header class="abh-head">
    <div class="abh-wrap abh-head-in">
      <a class="abh-logo" href="#home"><?= $v('name') ?><span>.</span></a>
      <nav class="abh-nav" aria-label="Main"><a href="#about">About</a><a href="#skills">Skills</a><a href="#services">Services</a><a href="#projects">Projects</a><?php if ($exp): ?><a href="#experience">Experience</a><?php endif; ?><a href="#backend">Backend</a><a href="#contact">Contact</a></nav>
      <button class="abh-theme" type="button" data-abh-theme-btn aria-label="Switch day or night theme"></button>
    </div>
  </header>


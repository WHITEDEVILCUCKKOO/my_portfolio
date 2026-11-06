    <section class="abh-hero" id="home">
      <div class="abh-wrap abh-hero-grid">
        <div>
          <p class="abh-role"><?= $v('title') ?></p>
          <h1 class="abh-h1"><?= $v('hero_heading') ?></h1>
          <p class="abh-sub"><?= $v('hero_sub') ?></p>
          <div class="abh-actions">
            <a class="abh-btn abh-btn-pri" href="#projects">View My Work</a>
            <a class="abh-btn abh-btn-sec" href="#contact">Contact Me</a>
            <?php if ($cv): ?><a class="abh-btn abh-btn-sec" href="<?= abh_e($cv) ?>" download>Download CV</a><?php endif; ?>
          </div>
        </div>
        <div class="abh-panel" aria-label="Main technologies">
          <div class="abh-panel-bar"><i></i><i></i><i></i><span>stack.config</span></div>
          <ul class="abh-stack"><?php foreach ($stack as $s): ?><li><?= abh_e($s) ?></li><?php endforeach; ?></ul>
        </div>
      </div>
    </section>


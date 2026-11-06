
    <section class="abh-sec abh-alt" id="projects">
      <div class="abh-wrap">
        <h2 class="abh-h2">Featured projects</h2>
        <div class="abh-grid abh-grid-3">
          <?php foreach ($projects as $p): $shot = abh_path($p['screenshot']);
            $url = abh_url($p['live_url']); ?>
            <article class="abh-card abh-proj">
              <div class="abh-shot"><?php if ($shot): ?><img src="<?= abh_e($shot) ?>" alt="<?= abh_e($p['name']) ?> screenshot" loading="lazy"><?php else: ?><span><?= abh_e(mb_substr($p['name'], 0, 1)) ?></span><?php endif; ?></div>
              <div class="abh-proj-body">
                <h3 class="abh-h3"><?= abh_e($p['name']) ?></h3>
                <p class="abh-cat"><?= abh_e($p['category']) ?></p>
                <p><?= abh_e($p['description']) ?></p>
                <?php $tech = array_filter(array_map('trim', explode(',', $p['tech'])));
                if ($tech): ?><ul class="abh-chips"><?php foreach ($tech as $t): ?><li><?= abh_e($t) ?></li><?php endforeach; ?></ul><?php endif; ?>
                <?php if ($url): ?><a class="abh-btn abh-btn-sec abh-btn-sm" href="<?= abh_e($url) ?>" target="_blank" rel="noopener noreferrer">Live Website</a><?php else: ?><span class="abh-soon">Link coming soon</span><?php endif; ?>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

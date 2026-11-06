

    <?php if ($exp): ?>
      <section class="abh-sec" id="experience">
        <div class="abh-wrap">
          <h2 class="abh-h2">Work experience</h2>
          <?php foreach ($exp as $e): ?><div class="abh-card abh-exp">
              <h3 class="abh-h3"><?= abh_e($e['role']) ?><?= $e['company'] ? ' · ' . abh_e($e['company']) : '' ?></h3>
              <p class="abh-cat"><?= abh_e($e['period']) ?></p>
              <p><?= nl2br(abh_e($e['details'])) ?></p>
            </div><?php endforeach; ?>
        </div>
      </section>
    <?php endif; ?>

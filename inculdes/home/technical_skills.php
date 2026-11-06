
    <section class="abh-sec abh-alt" id="skills">
      <div class="abh-wrap">
        <h2 class="abh-h2">Technical skills</h2>
        <div class="abh-grid abh-grid-3">
          <?php foreach ($skills as $cat => $items): ?>
            <div class="abh-card">
              <h3 class="abh-h3"><?= abh_e($cat) ?></h3>
              <ul class="abh-chips"><?php foreach ($items as $i): ?><li><?= abh_e($i) ?></li><?php endforeach; ?></ul>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>




  <div class="abm-stats">
  <?php $i = 0; foreach (admin_dashboard_counts($abhPdo) as $n => $c): ?>
    <a class="abm-stat" href="?t=<?= $n ?>" style="--i:<?= $i++ ?>"><svg viewBox="0 0 24 24" aria-hidden="true"><?= $icons[$n] ?></svg><strong><?= $c ?></strong><span><?= ucfirst($n) ?></span></a>
  <?php endforeach; ?></div>
  <h2 class="abm-h" style="font-size:1.2rem;margin:2rem 0 1rem">Latest messages</h2>
  <?php $lm = admin_messages_latest($abhPdo, 3); if (!$lm): ?><p class="abm-sub">No messages yet.</p><?php else: ?>
  <div class="abm-grid"><?php foreach ($lm as $i => $m): ?><article class="abm-card" style="--i:<?= $i ?>"><div class="abm-card-b"><h3><?= abh_e($m['subject']) ?></h3><p><?= abh_e($m['name']) ?> &middot; <?= abh_e($m['email']) ?></p><p class="abm-msg"><?= abh_e(mb_strimwidth($m['message'], 0, 140, '...')) ?></p></div></article><?php endforeach; ?></div><?php endif; ?>


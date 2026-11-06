  <div class="abm-grid">
  <?php foreach (admin_messages_all($abhPdo, 200) as $i => $m): ?>
    <article class="abm-card" style="--i:<?= min($i, 14) ?>"><div class="abm-card-b"><h3><?= abh_e($m['subject']) ?></h3>
      <p><?= abh_e($m['name']) ?> · <?= abh_e($m['email']) ?><?= $m['phone'] ? ' · ' . abh_e($m['phone']) : '' ?></p><p><?= abh_e($m['created_at']) ?></p><p class="abm-msg"><?= abh_e($m['message']) ?></p></div>
      <div class="abm-card-f"><form method="post"><input type="hidden" name="csrf" value="<?= $tok ?>"><input type="hidden" name="do" value="del"><input type="hidden" name="id" value="<?= (int)$m['id'] ?>"><button class="abm-btn abm-btn-red">Delete</button></form></div></article>
  <?php endforeach; ?>
  </div>

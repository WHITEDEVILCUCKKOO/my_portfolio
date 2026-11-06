  <form class="abm-form" method="post"><input type="hidden" name="csrf" value="<?= $tok ?>"><div class="abm-fields">
  <?php foreach (admin_settings_all($abhPdo) as $r): ?><label><?= abh_e($r['skey']) ?><textarea name="s[<?= abh_e($r['skey']) ?>]" rows="2"><?= abh_e($r['svalue']) ?></textarea></label><?php endforeach; ?>
  </div><button class="abm-btn abm-btn-acc" style="justify-self:start">Save settings</button></form>

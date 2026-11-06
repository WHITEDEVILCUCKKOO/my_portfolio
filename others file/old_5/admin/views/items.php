<?php [$fa, $fb] = admin_item_labels($t); ?>
  <input class="abm-search" id="abmSearch" type="search" placeholder="Search <?= $t ?>..." aria-label="Search">
  <div class="abm-grid" id="abmGrid">
  <?php foreach (admin_items_all($abhPdo, $t) as $i => $r): ?>
    <article class="abm-card" style="--i:<?= min($i, 14) ?>">
      <?php if ($t === 'projects'): $sh = abh_path($r['screenshot']); ?><div class="abm-thumb"><?php if ($sh): ?><img src="<?= abh_e(preg_match('~^assets/~', $sh) ? '../' . $sh : $sh) ?>" alt="" loading="lazy"><?php else: ?><span><?= abh_e(mb_substr($r['name'], 0, 1)) ?></span><?php endif; ?></div><?php endif; ?>
      <div class="abm-card-b"><h3><?= abh_e($r[$fa]) ?></h3><p><?= abh_e($r[$fb]) ?></p>
        <?php if ($t === 'projects'): ?><span class="abm-pill <?= $r['live_url'] ? 'abm-ok' : '' ?>"><?= $r['live_url'] ? 'Live link added' : 'No live link' ?></span><?php endif; ?></div>
      <div class="abm-card-f"><a class="abm-btn" href="?t=<?= $t ?>&edit=<?= (int)$r['id'] ?>">Edit</a>
        <form method="post" onsubmit="return confirm('Delete this item?')"><input type="hidden" name="csrf" value="<?= $tok ?>"><input type="hidden" name="do" value="del"><input type="hidden" name="id" value="<?= (int)$r['id'] ?>"><button class="abm-btn abm-btn-red">Delete</button></form></div>
    </article>
  <?php endforeach; ?>
  </div>
  <dialog class="abm-dlg" id="abmDlg" <?= ($edit || isset($_GET['new'])) ? 'data-auto' : '' ?>>
    <h2 class="abm-h" style="font-size:1.4rem;margin-bottom:1rem"><?= $edit ? 'Edit' : 'Add' ?> <?= $t ?></h2>
    <form class="abm-form" method="post" action="?t=<?= $t ?>"><input type="hidden" name="csrf" value="<?= $tok ?>"><input type="hidden" name="do" value="save"><input type="hidden" name="id" value="<?= (int)($edit['id'] ?? 0) ?>">
    <?php foreach ($T[$t] as $c => $ty): $val = abh_e($edit[$c] ?? ($ty === 'int' ? 0 : '')); ?>
      <label><?= $c ?><?php if ($ty === 'area'): ?><textarea name="<?= $c ?>" rows="4"><?= $val ?></textarea><?php else: ?><input name="<?= $c ?>" value="<?= $val ?>" type="<?= $ty === 'int' ? 'number' : 'text' ?>"><?php endif; ?></label>
    <?php endforeach; ?>
      <div class="abm-acts"><button class="abm-btn abm-btn-acc">Save</button><a class="abm-btn" href="?t=<?= $t ?>">Cancel</a></div></form>
  </dialog>

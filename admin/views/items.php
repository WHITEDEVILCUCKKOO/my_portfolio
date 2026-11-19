<?php [$fa, $fb] = admin_item_labels($t); ?>
<input class="abm-search" id="abmSearch" type="search" placeholder="Search <?= abh_e($t) ?>..." aria-label="Search">
<div class="abm-grid" id="abmGrid">
  <?php foreach (admin_items_all($abhPdo, $t) as $i => $r): ?>
    <article class="abm-card" style="--i:<?= min($i, 14) ?>">
      <?php if ($t === 'projects'): $sh = abh_path($r['screenshot'] ?? ''); ?>
        <div class="abm-thumb">
          <?php if ($sh): ?>
            <img src="<?= abh_e(preg_match('~^assets/~', $sh) ? '../' . $sh : $sh) ?>" alt="<?= abh_e($r['name'] ?? 'Project') ?> screenshot" loading="lazy">
          <?php else: ?>
            <span><?= abh_e(mb_substr($r['name'] ?? '', 0, 1)) ?></span>
          <?php endif; ?>
        </div>
      <?php endif; ?>
      <div class="abm-card-b">
        <h3><?= abh_e($r[$fa] ?? '') ?></h3>
        <p><?= abh_e($r[$fb] ?? '') ?></p>
        <?php if ($t === 'projects'): ?>
          <span class="abm-pill <?= !empty($r['live_url']) ? 'abm-ok' : '' ?>">
            <?= !empty($r['live_url']) ? 'Live link added' : 'No live link' ?>
          </span>
          <?php $projectActive = ($r['status'] ?? 'Active') === 'Active'; ?>
          <span class="abm-pill <?= $projectActive ? 'abm-ok' : 'abm-project-inactive' ?>">
            <?= $projectActive ? '● Active — Visible' : '● Inactive — Hidden' ?>
          </span>
        <?php endif; ?>
      </div>
      <div class="abm-card-f">
        <a class="abm-btn" href="?t=<?= abh_e($t) ?>&amp;edit=<?= (int)$r['id'] ?>">Edit</a>
        <form method="post" onsubmit="return confirm('Delete this item?')">
          <input type="hidden" name="csrf" value="<?= $tok ?>">
          <input type="hidden" name="do" value="del">
          <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
          <button class="abm-btn abm-btn-red">Delete</button>
        </form>
      </div>
    </article>
  <?php endforeach; ?>
</div>
<dialog class="abm-dlg" id="abmDlg" <?= ($edit || isset($_GET['new'])) ? 'data-auto' : '' ?>>
  <h2 class="abm-h" style="font-size:1.4rem;margin-bottom:1rem"><?= $edit ? 'Edit' : 'Add' ?> <?= abh_e($t) ?></h2>
  <form class="abm-form" method="post" enctype="multipart/form-data" action="?t=<?= abh_e($t) ?>">
    <input type="hidden" name="csrf" value="<?= $tok ?>">
    <input type="hidden" name="do" value="save">
    <input type="hidden" name="id" value="<?= (int)($edit['id'] ?? 0) ?>">

    <?php if ($t === 'projects'): ?>
      <div class="abm-screen-tools">
        <strong>Website full-page screenshot</strong>
        <?php if (!empty($edit['screenshot'])): ?>
          <a href="<?= abh_e(preg_match('~^assets/~', $edit['screenshot']) ? '../' . $edit['screenshot'] : $edit['screenshot']) ?>" target="_blank" rel="noopener">View current screenshot</a>
        <?php endif; ?>
        <label><input type="radio" name="screenshot_mode" value="keep" checked> Keep current screenshot / no image</label>
        <label><input type="radio" name="screenshot_mode" value="upload"> Upload image manually</label>
        <input type="file" name="project_screenshot" id="abmProjectImage" accept="image/png,image/jpeg,image/webp">
        <label><input type="radio" name="screenshot_mode" value="capture"> Automatically capture full page from Live URL</label>
        <small>Automatic capture uses the live_url field and requires Node.js + Playwright on the server. Upload limit: 12 MB.</small>
      </div>

      <label>Project Visibility
        <select name="status" required>
          <option value="Active" <?= (($edit['status'] ?? 'Active') === 'Active') ? 'selected' : '' ?>>Active — Show on Portfolio</option>
          <option value="Inactive" <?= (($edit['status'] ?? 'Active') === 'Inactive') ? 'selected' : '' ?>>Inactive — Hide from Portfolio</option>
        </select>
      </label>
    <?php endif; ?>

    <?php foreach ($T[$t] as $c => $ty): $val = abh_e($edit[$c] ?? ($ty === 'int' ? 0 : '')); ?>
      <?php if ($t === 'projects' && ($c === 'screenshot' || $c === 'status')) continue; ?>
      <label><?= abh_e($c) ?>
        <?php if ($ty === 'area'): ?>
          <textarea name="<?= abh_e($c) ?>" rows="4"><?= $val ?></textarea>
        <?php else: ?>
          <input name="<?= abh_e($c) ?>" value="<?= $val ?>" type="<?= $ty === 'int' ? 'number' : 'text' ?>">
        <?php endif; ?>
      </label>
    <?php endforeach; ?>
    <div class="abm-acts">
      <button class="abm-btn abm-btn-acc">Save</button>
      <a class="abm-btn" href="?t=<?= abh_e($t) ?>">Cancel</a>
    </div>
  </form>
</dialog>
<?php if ($t === 'projects'): ?>
  <dialog class="abm-dlg abm-image-dialog" id="abmImagePreview">
    <button type="button" class="abm-btn" id="abmImageClose">Close preview</button>
    <img id="abmImageFull" alt="Full-page website screenshot">
  </dialog>
  <script>
  (function(){
    var d=document.getElementById('abmImagePreview'), image=document.getElementById('abmImageFull');
    document.querySelectorAll('#abmGrid .abm-thumb img').forEach(function(img){
      img.style.cursor='zoom-in';img.title='View full-page screenshot';
      img.addEventListener('click',function(){image.src=img.src;d.showModal();});
    });
    document.getElementById('abmImageClose').addEventListener('click',function(){d.close();});
    d.addEventListener('click',function(e){if(e.target===d)d.close();});
    var file=document.getElementById('abmProjectImage');
    if(file)file.addEventListener('change',function(){if(file.files.length){var radio=document.querySelector('input[name="screenshot_mode"][value="upload"]');if(radio)radio.checked=true;}});
  })();
  </script>
<?php endif; ?>

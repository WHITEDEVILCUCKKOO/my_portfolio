<?php
/* admin/views/logs.php - the "Logs" page. Opened with  admin/?t=logs  (see the 4 small edits for admin/index.php). */
$f = admin_logs_filters();
$sum = admin_logs_summary($abhPdo);
$res = admin_logs_fetch($abhPdo, $f);
$events = admin_logs_events();
$url = function (array $over = []) use ($f) {
    $q = array_merge(['t' => 'logs', 'ev' => $f['ev'], 'q' => $f['q'], 'p' => $f['page']], $over);
    return '?' . http_build_query(array_filter($q, fn($v) => $v !== '' && $v !== null));
};
?>
<style>
.lg{--b:rgba(128,128,128,.28);font-size:14px}
.lg *{box-sizing:border-box}
.lg-cards{display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:12px;margin:0 0 16px}
.lg-card{padding:14px 16px;border:1px solid var(--b);border-radius:12px}
.lg-card b{display:block;font-size:26px;line-height:1.1}
.lg-card span{opacity:.7;font-size:12.5px}
.lg-filter{display:flex;flex-wrap:wrap;gap:8px;margin:0 0 14px;align-items:center}
.lg-filter select,.lg-filter input{padding:8px 10px;border:1px solid var(--b);border-radius:8px;background:transparent;color:inherit;font:inherit}
.lg-filter input[type=search]{flex:1;min-width:180px}
.lg-btn{padding:8px 14px;border:1px solid var(--b);border-radius:8px;background:transparent;color:inherit;font:inherit;cursor:pointer;text-decoration:none}
.lg-wrap{overflow-x:auto;border:1px solid var(--b);border-radius:12px}
.lg-t{width:100%;border-collapse:collapse;min-width:780px}
.lg-t th,.lg-t td{padding:10px 12px;text-align:left;border-bottom:1px solid var(--b);vertical-align:top}
.lg-t th{font-size:12px;text-transform:uppercase;letter-spacing:.06em;opacity:.7;white-space:nowrap}
.lg-t tr:last-child td{border-bottom:0}
.lg-ip{font-family:ui-monospace,Menlo,Consolas,monospace;white-space:nowrap}
.lg-sub{display:block;opacity:.65;font-size:12px}
.lg-badge{display:inline-block;padding:2px 10px;border-radius:999px;font-size:12px;font-weight:600;white-space:nowrap}
.lg-ok{background:rgba(46,204,113,.18);color:#27ae60}
.lg-bad{background:rgba(231,76,60,.18);color:#e74c3c}
.lg-warn{background:rgba(241,196,15,.2);color:#c99700}
.lg-info{background:rgba(52,152,219,.18);color:#3498db}
.lg-mute{background:rgba(128,128,128,.18)}
.lg-pg{display:flex;flex-wrap:wrap;gap:6px;margin:14px 0 0;align-items:center}
.lg-pg a,.lg-pg span{padding:6px 12px;border:1px solid var(--b);border-radius:8px;text-decoration:none;color:inherit}
.lg-pg .off{opacity:.4}
.lg-empty{padding:30px;text-align:center;opacity:.7}
</style>

<?php
$abmLogTab = (($_GET['logtab'] ?? '') === 'commands') ? 'commands' : 'activity';
$abmCmdAudit = null;
$abmCmdError = '';
if ($abmLogTab === 'commands') {
    try { $abmCmdAudit = admin_command_audit_fetch($abhPdo); }
    catch (Throwable $e) {
        error_log('Command audit view: ' . $e->getMessage());
        $abmCmdError = 'Command history could not be loaded. Check the terminal_command_audit table.';
    }
}
?>
<style>
.lg-tabs{display:flex;gap:10px;flex-wrap:wrap;margin:0 0 18px}
.lg-tabs a{display:inline-block;padding:10px 15px;border:1px solid rgba(128,128,128,.3);border-radius:10px;text-decoration:none;color:inherit}
.lg-tabs a.lg-selected{background:rgba(0,190,230,.14);border-color:rgba(0,190,230,.55);font-weight:700}
.lg-command{max-width:430px;white-space:pre-wrap;overflow-wrap:anywhere;font-family:ui-monospace,Consolas,monospace}
.lg-actor{overflow-wrap:anywhere}
</style>
<div class="lg-tabs" aria-label="Log categories">
  <a class="<?= $abmLogTab === 'activity' ? 'lg-selected' : '' ?>" href="?t=logs&amp;logtab=activity">Login &amp; Activity</a>
  <a class="<?= $abmLogTab === 'commands' ? 'lg-selected' : '' ?>" href="?t=logs&amp;logtab=commands">Terminal Commands</a>
</div>
<?php if ($abmLogTab === 'commands'): ?>
<div class="lg">
  <form class="lg-filter" method="get">
    <input type="hidden" name="t" value="logs">
    <input type="hidden" name="logtab" value="commands">
    <select name="outcome" id="lgCommandOutcome" aria-label="Command outcome">
      <option value="">All results</option>
      <?php foreach (['success' => 'Success', 'failed' => 'Failed', 'denied' => 'Denied'] as $value => $title): ?>
        <option value="<?= abh_e($value) ?>" <?= ($abmCmdAudit['outcome'] ?? '') === $value ? 'selected' : '' ?>><?= abh_e($title) ?></option>
      <?php endforeach; ?>
    </select>
    <input type="search" name="cq" value="<?= abh_e($abmCmdAudit['q'] ?? '') ?>" placeholder="Search command, IP or username" aria-label="Search terminal commands">
    <button class="lg-btn" type="submit">Search</button>
    <a class="lg-btn" href="?t=logs&amp;logtab=commands">Reset</a>
  </form>
  <script>
  (function () {
    'use strict';
    var outcome = document.getElementById('lgCommandOutcome');
    if (!outcome || !outcome.form) return;
    outcome.addEventListener('change', function () {
      // Apply the selected result immediately, keeping the current search query.
      // Page is intentionally omitted from the filter form so results start on page 1.
      if (typeof outcome.form.requestSubmit === 'function') {
        outcome.form.requestSubmit();
      } else {
        outcome.form.submit();
      }
    });
  })();
  </script>
  <div class="lg-wrap">
    <?php if ($abmCmdError !== ''): ?>
      <div class="lg-empty"><?= abh_e($abmCmdError) ?></div>
    <?php elseif (!$abmCmdAudit['rows']): ?>
      <div class="lg-empty">No terminal commands found for this filter.</div>
    <?php else: ?>
      <table class="lg-t">
        <thead><tr><th>Time (DB)</th><th>Command</th><th>Result</th><th>Admin / User</th><th>IP address</th><th>Source</th></tr></thead>
        <tbody>
          <?php foreach ($abmCmdAudit['rows'] as $row):
            $cls = ['success' => 'ok', 'failed' => 'bad', 'denied' => 'warn'][$row['outcome']] ?? 'mute';
            $actor = $row['actor_snapshot'] !== '' ? $row['actor_snapshot'] : ($row['current_username'] ?: 'visitor');
            $browserReported = strncmp((string)$row['command_text'], 'browser: ', 9) === 0;
          ?>
          <tr>
            <td style="white-space:nowrap"><?= abh_e($row['created_at']) ?></td>
            <td class="lg-command"><?= abh_e($row['command_text']) ?></td>
            <td><span class="lg-badge lg-<?= abh_e($cls) ?>"><?= abh_e(ucfirst($row['outcome'])) ?></span></td>
            <td class="lg-actor"><?= abh_e($actor) ?><?php if ($row['admin_id'] !== null): ?><span class="lg-sub">Admin #<?= (int)$row['admin_id'] ?></span><?php endif; ?></td>
            <td class="lg-ip"><?= abh_e($row['ip'] !== '' ? $row['ip'] : '-') ?></td>
            <td><?= $browserReported ? 'Browser reported' : 'Server action' ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
  <?php if ($abmCmdAudit):
    $commandPageUrl = static function(int $page) use ($abmCmdAudit): string {
        return '?' . http_build_query(['t'=>'logs', 'logtab'=>'commands', 'outcome'=>$abmCmdAudit['outcome'], 'cq'=>$abmCmdAudit['q'], 'cp'=>$page]);
    };
  ?>
    <div class="lg-pg">
      <?php if ($abmCmdAudit['page'] > 1): ?><a href="<?= abh_e($commandPageUrl($abmCmdAudit['page'] - 1)) ?>">&larr; Newer</a><?php endif; ?>
      <span>Page <?= (int)$abmCmdAudit['page'] ?> of <?= (int)$abmCmdAudit['pages'] ?> &middot; <?= (int)$abmCmdAudit['total'] ?> commands</span>
      <?php if ($abmCmdAudit['page'] < $abmCmdAudit['pages']): ?><a href="<?= abh_e($commandPageUrl($abmCmdAudit['page'] + 1)) ?>">Older &rarr;</a><?php endif; ?>
    </div>
  <?php endif; ?>
</div>
<?php else: ?>
<div class="lg">
  <div class="lg-cards">
    <div class="lg-card"><b><?= (int)$sum['logins'] ?></b><span>Logins, last 24 h</span></div>
    <div class="lg-card"><b><?= (int)$sum['fails'] ?></b><span>Failed logins, last 24 h</span></div>
    <div class="lg-card"><b><?= (int)$sum['ips'] ?></b><span>Different IPs, last 7 days</span></div>
    <div class="lg-card"><b style="font-size:20px"><?= abh_e(admin_logs_ago($sum['last_age'])) ?></b><span>Last successful login</span></div>
  </div>

  <form class="lg-filter" method="get">
    <input type="hidden" name="t" value="logs">
    <select name="ev" id="lgEventFilter" aria-label="Event">
      <option value="">All events</option>
      <?php foreach ($events as $k => [$label, $cls]): ?>
        <option value="<?= abh_e($k) ?>" <?= $f['ev'] === $k ? 'selected' : '' ?>><?= abh_e($label) ?></option>
      <?php endforeach; ?>
    </select>
    <input type="search" name="q" value="<?= abh_e($f['q']) ?>" placeholder="Search IP, user, details, browser" aria-label="Search">
    <button class="lg-btn" type="submit">Filter</button>
    <a class="lg-btn" href="?t=logs">Reset</a>
    <label style="margin-left:auto;display:flex;gap:6px;align-items:center"><input type="checkbox" id="lgAuto"> Auto-refresh (30 s)</label>
  </form>

  <div class="lg-wrap">
    <?php if (!$res['rows']): ?>
      <div class="lg-empty">No log entries<?= ($f['ev'] !== '' || $f['q'] !== '') ? ' for this filter' : ' yet. Log in once from the footer terminal and it will appear here' ?>.</div>
    <?php else: ?>
      <table class="lg-t">
        <thead><tr><th>Time</th><th>Event</th><th>User</th><th>IP address</th><th>Device</th><th>Details</th></tr></thead>
        <tbody>
        <?php foreach ($res['rows'] as $r):
            [$label, $cls] = $events[$r['event']] ?? [$r['event'], 'mute'];
            [$br, $os, $dev] = admin_logs_ua((string)$r['user_agent']); ?>
          <tr>
            <td style="white-space:nowrap"><?= abh_e($r['created_at']) ?><span class="lg-sub"><?= abh_e(admin_logs_ago((int)$r['age'])) ?></span></td>
            <td><span class="lg-badge lg-<?= abh_e($cls) ?>"><?= abh_e($label) ?></span></td>
            <td><?= $r['username'] !== null ? abh_e($r['username']) : '<span class="lg-sub">-</span>' ?></td>
            <td class="lg-ip"><?= abh_e(admin_logs_ip((string)$r['ip'], (string)$r['ip_hash'])) ?></td>
            <td title="<?= abh_e($r['user_agent']) ?>"><?= abh_e($br) ?> &middot; <?= abh_e($os) ?><span class="lg-sub"><?= abh_e($dev) ?></span></td>
            <td><?= abh_e($r['detail']) ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>

  <div class="lg-pg">
    <?php if ($res['page'] > 1): ?><a href="<?= abh_e($url(['p' => $res['page'] - 1])) ?>">&larr; Newer</a><?php else: ?><span class="off">&larr; Newer</span><?php endif; ?>
    <span>Page <?= (int)$res['page'] ?> of <?= (int)$res['pages'] ?> &middot; <?= (int)$res['total'] ?> entries (<?= (int)$sum['total'] ?> in total)</span>
    <?php if ($res['page'] < $res['pages']): ?><a href="<?= abh_e($url(['p' => $res['page'] + 1])) ?>">Older &rarr;</a><?php else: ?><span class="off">Older &rarr;</span><?php endif; ?>
  </div>
</div>
<script>
(function () {
  'use strict';
  var select = document.getElementById('lgEventFilter');
  if (select && select.form) {
    select.addEventListener('change', function () {
      // Changing event should show all rows for that event, not retain an old search.
      var search = select.form.querySelector('input[name="q"]');
      if (search) search.value = '';
      var page = select.form.querySelector('input[name="p"]');
      if (page) page.value = '1';
      select.form.submit();
    });
  }
  var checkbox = document.getElementById('lgAuto');
  if (!checkbox) return;
  var timer = null;
  checkbox.addEventListener('change', function () {
    clearTimeout(timer);
    if (checkbox.checked) timer = setTimeout(function () { location.reload(); }, 30000);
  });
})();
</script>

<?php endif; // end logtab selection ?>

<?php
// This page is reached only after admin_require_login() in admin/index.php.
$blockedIps = [];
$unblockHistory = [];
$securityLoadError = '';
try {
  $q = $abhPdo->query("SELECT ip, failed_attempts, first_failed_at, blocked_until, updated_at FROM auth_ip_limits WHERE blocked_until IS NOT NULL AND blocked_until > UTC_TIMESTAMP() ORDER BY blocked_until DESC LIMIT 200");
  $blockedIps = $q->fetchAll(PDO::FETCH_ASSOC);
  $q = $abhPdo->query("SELECT h.ip, h.action, h.note, h.created_at, COALESCE(a.username, CONCAT('Deleted admin #', h.admin_id)) AS admin_name FROM security_unblock_audit h LEFT JOIN admins a ON a.id = h.admin_id ORDER BY h.id DESC LIMIT 50");
  $unblockHistory = $q->fetchAll(PDO::FETCH_ASSOC);
} catch (Throwable $e) {
  error_log('Admin security page: ' . $e->getMessage());
  $securityLoadError = 'Security data could not be loaded. Check that Step 1 SQL migration was imported.';
}
?>
<style>
.abm-sec5{display:grid;gap:22px}.abm-sec5 *{box-sizing:border-box}.abm-sec5-card{background:var(--abm-panel,#101827);border:1px solid var(--abm-line,#28384f);border-radius:16px;padding:20px;min-width:0}.abm-sec5-heading{font-size:19px;font-weight:700;margin:0 0 8px;color:var(--abm-text,#f8fafc)}.abm-sec5-muted{color:var(--abm-mute,#94a3b8);font-size:13px}.abm-sec5-table-wrap{overflow-x:auto;margin-top:16px}.abm-sec5-table{width:100%;border-collapse:collapse;min-width:690px;text-align:left;color:var(--abm-text,#f8fafc)}.abm-sec5-table th,.abm-sec5-table td{padding:13px 11px;border-bottom:1px solid var(--abm-line,#28384f);font-size:13px}.abm-sec5-table th{color:var(--abm-mute,#94a3b8);font-weight:600}.abm-sec5-ip{font-family:ui-monospace,SFMono-Regular,Consolas,monospace;overflow-wrap:anywhere}.abm-sec5-unblock{background:#dc3545;color:white;border:0;border-radius:9px;padding:9px 13px;cursor:pointer;font-weight:700}.abm-sec5-unblock:hover{background:#b91c1c}.abm-sec5-alert{border:1px solid #dc3545;padding:14px;border-radius:10px;color:#fda4af}.abm-sec5-count{font-size:32px;font-weight:700;color:var(--abm-text,#fff);margin:6px 0}.abm-sec5-empty{padding:20px 0;color:var(--abm-mute,#94a3b8)}@media(max-width:640px){.abm-sec5-card{padding:14px}.abm-sec5-heading{font-size:17px}}
</style>
<section class="abm-sec5" aria-label="IP security management">
  <?php if ($securityLoadError): ?><p class="abm-sec5-alert" role="alert"><?= abh_e($securityLoadError) ?></p><?php endif; ?>
  <div class="abm-sec5-card">
    <p class="abm-sec5-muted">Currently blocked IP addresses</p>
    <div class="abm-sec5-count"><?= count($blockedIps) ?><?= count($blockedIps) === 200 ? '+' : '' ?></div>
    <p class="abm-sec5-muted">4 failed logins within 15 minutes can block an IP for 3 hours. Times below are stored in UTC.</p>
  </div>
  <div class="abm-sec5-card">
    <h2 class="abm-sec5-heading">Blocked IP addresses</h2>
    <p class="abm-sec5-muted">Unblock removes the restriction and resets that IP's failed-login counter.</p>
    <?php if (!$blockedIps): ?><p class="abm-sec5-empty">No currently blocked IP addresses.</p><?php else: ?>
    <div class="abm-sec5-table-wrap"><table class="abm-sec5-table"><thead><tr><th>IP address</th><th>Failed attempts</th><th>First failed (UTC)</th><th>Blocked until (UTC)</th><th>Action</th></tr></thead><tbody>
      <?php foreach ($blockedIps as $r): ?>
      <tr><td class="abm-sec5-ip"><?= abh_e((string)$r['ip']) ?></td><td><?= (int)$r['failed_attempts'] ?></td><td><?= abh_e((string)$r['first_failed_at']) ?></td><td><?= abh_e((string)$r['blocked_until']) ?></td><td>
        <form method="post" onsubmit="return confirm('Unblock IP <?= abh_e((string)$r['ip']) ?> and reset failed attempts?');">
          <input type="hidden" name="csrf" value="<?= $tok ?>">
          <input type="hidden" name="do" value="unblock_ip">
          <input type="hidden" name="ip" value="<?= abh_e((string)$r['ip']) ?>">
          <button class="abm-sec5-unblock" type="submit">Unblock</button>
        </form>
      </td></tr>
      <?php endforeach; ?>
    </tbody></table></div>
    <?php endif; ?>
  </div>
  <div class="abm-sec5-card">
    <h2 class="abm-sec5-heading">Recent unblock history</h2>
    <p class="abm-sec5-muted">Latest 50 manual unblocks. These audit records remain after an IP is unblocked.</p>
    <?php if (!$unblockHistory): ?><p class="abm-sec5-empty">No manual unblock actions yet.</p><?php else: ?>
    <div class="abm-sec5-table-wrap"><table class="abm-sec5-table"><thead><tr><th>IP address</th><th>Admin</th><th>Action</th><th>Date (UTC)</th></tr></thead><tbody>
    <?php foreach ($unblockHistory as $r): ?><tr><td class="abm-sec5-ip"><?= abh_e((string)$r['ip']) ?></td><td><?= abh_e((string)$r['admin_name']) ?></td><td><?= abh_e((string)$r['action']) ?></td><td><?= abh_e((string)$r['created_at']) ?></td></tr><?php endforeach; ?>
    </tbody></table></div>
    <?php endif; ?>
  </div>
</section>

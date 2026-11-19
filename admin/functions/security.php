<?php
declare(strict_types=1);
// Shared IP login limiter. Use only REMOTE_ADDR unless a trusted reverse proxy is configured.
function abm_security_ip(): string {
    $ip = (string)($_SERVER['REMOTE_ADDR'] ?? '');
    return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '0.0.0.0';
}
function abm_security_remaining(PDO $db, string $ip): int {
    $q = $db->prepare('SELECT GREATEST(0, TIMESTAMPDIFF(SECOND, UTC_TIMESTAMP(), blocked_until)) FROM auth_ip_limits WHERE ip = ?');
    $q->execute([$ip]);
    return max(0, (int)$q->fetchColumn());
}
function abm_security_fail(PDO $db, string $ip): int {
    $db->beginTransaction();
    try {
        $q = $db->prepare('INSERT IGNORE INTO auth_ip_limits (ip, failed_attempts) VALUES (?, 0)'); $q->execute([$ip]);
        $q = $db->prepare('SELECT failed_attempts, first_failed_at, blocked_until FROM auth_ip_limits WHERE ip = ? FOR UPDATE');
        $q->execute([$ip]); $r = $q->fetch(PDO::FETCH_ASSOC);
        $now = new DateTimeImmutable('now', new DateTimeZone('UTC'));
        $blocked = !empty($r['blocked_until']) ? new DateTimeImmutable($r['blocked_until'], new DateTimeZone('UTC')) : null;
        if ($blocked && $blocked > $now) { $remaining = $blocked->getTimestamp() - $now->getTimestamp(); $db->commit(); return $remaining; }
        $first = !empty($r['first_failed_at']) ? new DateTimeImmutable($r['first_failed_at'], new DateTimeZone('UTC')) : null;
        $count = (!$first || $first < $now->modify('-15 minutes')) ? 1 : ((int)$r['failed_attempts'] + 1);
        $firstValue = $count === 1 ? $now->format('Y-m-d H:i:s') : $r['first_failed_at'];
        $until = $count >= 4 ? $now->modify('+3 hours')->format('Y-m-d H:i:s') : null;
        $q = $db->prepare('UPDATE auth_ip_limits SET failed_attempts=?, first_failed_at=?, blocked_until=? WHERE ip=?');
        $q->execute([$count, $firstValue, $until, $ip]);
        $db->commit(); return $until ? 10800 : 0;
    } catch (Throwable $e) { if ($db->inTransaction()) $db->rollBack(); throw $e; }
}
function abm_security_success(PDO $db, string $ip): void {
    $q = $db->prepare('UPDATE auth_ip_limits SET failed_attempts=0, first_failed_at=NULL, blocked_until=NULL WHERE ip=?');
    $q->execute([$ip]);
}

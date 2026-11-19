<?php
/* admin/functions/logs.php - terminal / login activity log (table `terminal_log`).
   Same style as the other files in admin/functions: plain functions that take the PDO. */

/* make sure the table and its `ip` column exist (safe to call on every request) */
function admin_logs_ensure(PDO $pdo): void
{
    static $done = false;
    if ($done) {
        return;
    }
    $done = true;
    try {
        $pdo->exec("CREATE TABLE IF NOT EXISTS `terminal_log` (`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, `event` varchar(30) NOT NULL, `admin_id` int(11) DEFAULT NULL, `detail` varchar(255) NOT NULL DEFAULT '', `ip_hash` char(64) NOT NULL, `ip` varchar(45) NOT NULL DEFAULT '', `user_agent` varchar(255) NOT NULL DEFAULT '', `created_at` timestamp NOT NULL DEFAULT current_timestamp(), PRIMARY KEY (`id`), KEY `ip_event_time` (`ip_hash`,`event`,`created_at`), KEY `admin_event` (`admin_id`,`event`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");
        if (!$pdo->query("SHOW COLUMNS FROM `terminal_log` LIKE 'ip'")->fetch()) {
            $pdo->exec("ALTER TABLE `terminal_log` ADD COLUMN `ip` varchar(45) NOT NULL DEFAULT '' AFTER `ip_hash`");
        }
    } catch (Throwable $e) {
        error_log('admin_logs_ensure: ' . $e->getMessage());
    }
}

/* event => [label, css class] */
function admin_logs_events(): array
{
    return [
        'login_ok'   => ['Login', 'ok'],
        'login_fail' => ['Failed login', 'bad'],
        'passwd'     => ['Password changed', 'warn'],
        'useradd'    => ['User created', 'info'],
        'usermod'    => ['User renamed', 'info'],
        'userdel'    => ['User deleted', 'bad'],
        'logout'     => ['Logout', 'mute'],
        'reset'      => ['Admin reset', 'warn'],
    ];
}

/* filters come from the query string: ?t=logs&ev=login_fail&q=127.0&p=2 */
function admin_logs_filters(): array
{
    $ev = (string)($_GET['ev'] ?? '');
    if (!isset(admin_logs_events()[$ev])) {
        $ev = '';
    }
    $q = mb_substr(trim((string)($_GET['q'] ?? '')), 0, 80);
    return ['ev' => $ev, 'q' => $q, 'page' => max(1, (int)($_GET['p'] ?? 1)), 'per' => 25];
}

function admin_logs_where(array $f, array &$args): string
{
    $w = [];
    if ($f['ev'] !== '') {
        $w[] = 'l.event = ?';
        $args[] = $f['ev'];
    }
    if ($f['q'] !== '') {
        $like = '%' . $f['q'] . '%';
        $w[] = '(l.ip LIKE ? OR l.detail LIKE ? OR l.user_agent LIKE ? OR a.username LIKE ?)';
        array_push($args, $like, $like, $like, $like);
    }
    return $w ? ' WHERE ' . implode(' AND ', $w) : '';
}

/* one page of rows + paging info; `age` = seconds since the event (computed by the database, so time zones never disagree) */
function admin_logs_fetch(PDO $pdo, array $f): array
{
    admin_logs_ensure($pdo);
    $args = [];
    $where = admin_logs_where($f, $args);
    $c = $pdo->prepare('SELECT COUNT(*) FROM terminal_log l LEFT JOIN admins a ON a.id = l.admin_id' . $where);
    $c->execute($args);
    $total = (int)$c->fetchColumn();
    $pages = max(1, (int)ceil($total / $f['per']));
    $page = min($f['page'], $pages);
    $off = ($page - 1) * $f['per'];
    $st = $pdo->prepare('SELECT l.id, l.event, l.admin_id, l.detail, l.ip, l.ip_hash, l.user_agent, l.created_at, TIMESTAMPDIFF(SECOND, l.created_at, NOW()) AS age, a.username
        FROM terminal_log l LEFT JOIN admins a ON a.id = l.admin_id' . $where . ' ORDER BY l.id DESC LIMIT ' . (int)$f['per'] . ' OFFSET ' . (int)$off);
    $st->execute($args);
    return ['rows' => $st->fetchAll(PDO::FETCH_ASSOC), 'total' => $total, 'page' => $page, 'pages' => $pages];
}

/* numbers for the cards at the top */
function admin_logs_summary(PDO $pdo): array
{
    admin_logs_ensure($pdo);
    $one = fn(string $sql): int => (int)$pdo->query($sql)->fetchColumn();
    $last = $pdo->query("SELECT TIMESTAMPDIFF(SECOND, created_at, NOW()) FROM terminal_log WHERE event = 'login_ok' ORDER BY id DESC LIMIT 1")->fetchColumn();
    return [
        'logins'   => $one("SELECT COUNT(*) FROM terminal_log WHERE event = 'login_ok' AND created_at > (NOW() - INTERVAL 1 DAY)"),
        'fails'    => $one("SELECT COUNT(*) FROM terminal_log WHERE event = 'login_fail' AND created_at > (NOW() - INTERVAL 1 DAY)"),
        'ips'      => $one("SELECT COUNT(DISTINCT ip_hash) FROM terminal_log WHERE created_at > (NOW() - INTERVAL 7 DAY)"),
        'total'    => $one('SELECT COUNT(*) FROM terminal_log'),
        'last_age' => $last === false ? null : (int)$last,
    ];
}

/* browser / OS / device from the user-agent string (no library needed) */
function admin_logs_ua(string $ua): array
{
    if ($ua === '') {
        return ['-', '-', '-'];
    }
    $b = 'Other';
    foreach ([['Edg/', 'Edge'], ['OPR/', 'Opera'], ['Firefox/', 'Firefox'], ['Chrome/', 'Chrome'], ['Safari/', 'Safari'], ['curl/', 'curl']] as [$k, $n]) {
        if (stripos($ua, $k) !== false) {
            $b = $n;
            break;
        }
    }
    $os = 'Other';
    foreach ([['Windows', 'Windows'], ['Android', 'Android'], ['iPhone', 'iOS'], ['iPad', 'iOS'], ['Mac OS', 'macOS'], ['Linux', 'Linux']] as [$k, $n]) {
        if (stripos($ua, $k) !== false) {
            $os = $n;
            break;
        }
    }
    if (preg_match('/bot|crawl|spider|curl|wget/i', $ua)) {
        $dev = 'Bot';
    } elseif (preg_match('/iPad|Tablet/i', $ua)) {
        $dev = 'Tablet';
    } elseif (preg_match('/Mobi|iPhone|Android/i', $ua)) {
        $dev = 'Mobile';
    } else {
        $dev = 'Desktop';
    }
    return [$b, $os, $dev];
}

function admin_logs_ago(?int $s): string
{
    if ($s === null) {
        return 'never';
    }
    $s = max(0, $s);
    if ($s < 60) {
        return $s . 's ago';
    }
    if ($s < 3600) {
        return floor($s / 60) . ' min ago';
    }
    if ($s < 86400) {
        return floor($s / 3600) . ' h ago';
    }
    return floor($s / 86400) . ' d ago';
}

/* readable IP; old rows (before the ip column existed) only have a hash */
function admin_logs_ip(string $ip, string $hash): string
{
    if ($ip === '') {
        return 'hash ' . substr($hash, 0, 8);
    }
    return in_array($ip, ['::1', '127.0.0.1'], true) ? $ip . ' (localhost)' : $ip;
}


/** Step 7: independently paginated terminal command audit. */
function admin_command_audit_fetch(PDO $pdo): array
{
    $allowed = ['success', 'failed', 'denied'];
    $outcome = (string)($_GET['outcome'] ?? '');
    if (!in_array($outcome, $allowed, true)) $outcome = '';
    $q = substr(trim((string)($_GET['cq'] ?? '')), 0, 100);
    $page = max(1, (int)($_GET['cp'] ?? 1));
    $where = [];
    $args = [];
    if ($outcome !== '') { $where[] = 'c.outcome = ?'; $args[] = $outcome; }
    if ($q !== '') {
        $where[] = '(c.command_text LIKE ? OR c.username LIKE ? OR c.ip LIKE ? OR a.username LIKE ?)';
        $like = '%' . str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $q) . '%';
        array_push($args, $like, $like, $like, $like);
    }
    $sqlWhere = $where ? ' WHERE ' . implode(' AND ', $where) : '';
    $join = ' FROM terminal_command_audit c LEFT JOIN admins a ON a.id = c.admin_id';
    $stmt = $pdo->prepare('SELECT COUNT(*)' . $join . $sqlWhere);
    $stmt->execute($args);
    $total = (int)$stmt->fetchColumn();
    $per = 25;
    $pages = max(1, (int)ceil($total / $per));
    $page = min($page, $pages);
    $offset = ($page - 1) * $per;
    $stmt = $pdo->prepare('SELECT c.id, c.created_at, c.command_text, c.outcome, c.username AS actor_snapshot, c.ip, c.admin_id, a.username AS current_username'
        . $join . $sqlWhere . ' ORDER BY c.id DESC LIMIT ' . $per . ' OFFSET ' . $offset);
    $stmt->execute($args);
    return ['rows' => $stmt->fetchAll(PDO::FETCH_ASSOC), 'total' => $total,
        'page' => $page, 'pages' => $pages, 'outcome' => $outcome, 'q' => $q];
}

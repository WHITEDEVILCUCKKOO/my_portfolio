<?php
declare(strict_types=1);
/* terminal-auth.php  -  put it next to contact.php (site root).
   Server side of the footer terminal. Passwords are checked here (bcrypt, password_verify) and never appear in a page.
   Users + passwords live in the existing `admins` table. Everything the terminal does is written to `terminal_log`. */

/* Reuses your config.php when it exists: DB_HOST / DB_NAME / DB_USER / DB_PASS constants, or a ready PDO in $pdo / $db / $conn / $dbh. */
ob_start(); try { @include_once __DIR__ . '/config.php'; } catch (Throwable $e) { } ob_end_clean();
$shared = null; foreach (['pdo', 'db', 'conn', 'dbh'] as $n) { if (isset($$n) && $$n instanceof PDO) { $shared = $$n; break; } }
$base = rtrim(dirname((string)($_SERVER['SCRIPT_NAME'] ?? '')), '/\\');
defined('DB_HOST') || define('DB_HOST', 'localhost');          /* XAMPP defaults, used only if config.php does not define them */
defined('DB_NAME') || define('DB_NAME', 'abhi_portfolio');
defined('DB_USER') || define('DB_USER', 'root');
defined('DB_PASS') || define('DB_PASS', '');
defined('ADMIN_URL') || define('ADMIN_URL', $base . '/admin/');   /* where the visitor is sent after logging in */
defined('ADMIN_SESSION_KEY') || define('ADMIN_SESSION_KEY', 'admin_id'); /* the $_SESSION key your admin pages check. '' = do not log in, just redirect */
defined('MAX_FAILS') || define('MAX_FAILS', 4);                /* wrong passwords allowed per IP ... */
defined('LOCK_SECONDS') || define('LOCK_SECONDS', 600);        /* ... within this many seconds */
defined('SESSION_MINUTES') || define('SESSION_MINUTES', 15);   /* the root shell closes after this much inactivity */

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
header('X-Content-Type-Options: nosniff');
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }

function out(array $a, int $code = 200) { http_response_code($code); echo json_encode($a); exit; }
function bad(string $err, int $code = 400) { if (isset($GLOBALS['terminal_audit_failure'])) { ($GLOBALS['terminal_audit_failure'])($err); } out(['ok' => false, 'error' => $err], $code); }
function validName(string $n): bool { return (bool)preg_match('/^[A-Za-z0-9._@+-]{3,60}$/', $n); }

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
if ($method === 'GET') {                                   /* terminal asks for a one-time token */
    if (isset($_GET['init'])) { $_SESSION['term_csrf'] = bin2hex(random_bytes(16)); out(['token' => $_SESSION['term_csrf']]); }
    out(['ok' => false], 400);
}
if ($method !== 'POST') { out(['ok' => false], 405); }

/* same-origin + token */
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if ($origin !== '' && parse_url($origin, PHP_URL_HOST) !== explode(':', (string)($_SERVER['HTTP_HOST'] ?? ''))[0]) { bad('origin', 403); }
$tok = (string)($_POST['token'] ?? '');
if (empty($_SESSION['term_csrf']) || !hash_equals((string)$_SESSION['term_csrf'], $tok)) { bad('token', 403); }

$action = (string)($_POST['action'] ?? '');
$iph = hash('sha256', ($_SERVER['REMOTE_ADDR'] ?? '0') . '|abh-term');
$ua = substr((string)($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 255);
$ipRaw = substr((string)($_SERVER['REMOTE_ADDR'] ?? ''), 0, 45);
require_once __DIR__ . '/admin/functions/security.php';
$ipRaw = abm_security_ip();
$iph = hash('sha256', $ipRaw . '|abh-term');

try {
    $pdo = $shared ?? new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => false]);
    if (empty($_SESSION['term_tbl2'])) {                    /* create terminal_log once if it is missing */
        $pdo->exec("CREATE TABLE IF NOT EXISTS `terminal_log` (`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, `event` varchar(30) NOT NULL, `admin_id` int(11) DEFAULT NULL, `detail` varchar(255) NOT NULL DEFAULT '', `ip_hash` char(64) NOT NULL, `ip` varchar(45) NOT NULL DEFAULT '', `user_agent` varchar(255) NOT NULL DEFAULT '', `created_at` timestamp NOT NULL DEFAULT current_timestamp(), PRIMARY KEY (`id`), KEY `ip_event_time` (`ip_hash`,`event`,`created_at`), KEY `admin_event` (`admin_id`,`event`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");
        if (!$pdo->query("SHOW COLUMNS FROM `terminal_log` LIKE 'ip'")->fetch()) { $pdo->exec("ALTER TABLE `terminal_log` ADD COLUMN `ip` varchar(45) NOT NULL DEFAULT '' AFTER `ip_hash`"); }
        $_SESSION['term_tbl2'] = 1;
    }
    $log = function (string $event, ?int $admin, string $detail) use ($pdo, $iph, $ua, $ipRaw): void {
        $pdo->prepare('INSERT INTO terminal_log (event, admin_id, detail, ip_hash, ip, user_agent) VALUES (?,?,?,?,?,?)')->execute([$event, $admin, substr($detail, 0, 255), $iph, $ipRaw, $ua]);
    };
    if (random_int(1, 50) === 1) { $pdo->exec('DELETE FROM terminal_log WHERE created_at < (NOW() - INTERVAL 90 DAY)'); }

    $audit = function (string $command, string $outcome, ?array $actor = null) use ($pdo, $ipRaw): void {
        $safe = substr(preg_replace('/[\x00-\x1f\x7f]/', ' ', $command), 0, 500);
        $pdo->prepare('INSERT INTO terminal_command_audit (admin_id, username, ip, command_text, outcome) VALUES (?,?,?,?,?)')->execute([
            $actor ? (int)$actor['id'] : null, $actor ? (string)$actor['name'] : '', $ipRaw, $safe, $outcome
        ]);
    };

    /* ---------- login: no user = "root" (any admin password works), user = that account only ---------- */
    if ($action === 'login') {
        $wait = abm_security_remaining($pdo, $ipRaw);
        if ($wait > 0) { $log('login_blocked', null, 'terminal login'); out(['ok' => false, 'locked' => true, 'wait' => $wait], 429); }

        $pw = (string)($_POST['password'] ?? ''); $user = trim((string)($_POST['user'] ?? ''));
        $row = null;
        if ($pw !== '' && strlen($pw) <= 200) {
            if ($user !== '') { $st = $pdo->prepare('SELECT id, username, password_hash FROM admins WHERE LOWER(username) = LOWER(?)'); $st->execute([$user]); $rows = $st->fetchAll(PDO::FETCH_ASSOC); }
            else { $rows = $pdo->query('SELECT id, username, password_hash FROM admins')->fetchAll(PDO::FETCH_ASSOC); }
            foreach ($rows as $x) { if (password_verify($pw, (string)$x['password_hash'])) { $row = $x; break; } }
        }
        if (!$row) { $log('login_fail', null, $user !== '' ? 'user=' . substr($user, 0, 100) : 'root'); $wait = abm_security_fail($pdo, $ipRaw); usleep(random_int(500000, 900000)); if ($wait > 0) { $log('ip_blocked', null, 'terminal login'); out(['ok' => false, 'locked' => true, 'wait' => $wait], 429); } out(['ok' => false], 401); }

        abm_security_success($pdo, $ipRaw);
        session_regenerate_id(true);
        $_SESSION['term_csrf'] = bin2hex(random_bytes(16));
        $_SESSION['term'] = ['id' => (int)$row['id'], 'name' => (string)$row['username'], 'until' => time() + SESSION_MINUTES * 60];
        if (ADMIN_SESSION_KEY !== '') { $_SESSION[ADMIN_SESSION_KEY] = (int)$row['id']; }
        $log('login_ok', (int)$row['id'], $user !== '' ? 'su ' . $user : 'root');
        out(['ok' => true, 'user' => $row['username'], 'redirect' => ADMIN_URL, 'token' => $_SESSION['term_csrf']]);
    }

    /* Browser-only simulated commands: audit client reports, NOT trusted execution outcomes. */
    if ($action === 'command_report') {
        $cmd = trim((string)($_POST['command'] ?? ''));
        if ($cmd === '' || strlen($cmd) > 500) bad('command');
        // Prevent automated spam of audit table from one browser session.
        $now = time();
        $rate = $_SESSION['term_audit_rate'] ?? ['start' => $now, 'count' => 0];
        if ($now - (int)$rate['start'] >= 60) { $rate = ['start' => $now, 'count' => 0]; }
        $rate['count']++;
        $_SESSION['term_audit_rate'] = $rate;
        if ($rate['count'] > 100) out(['ok' => false, 'error' => 'rate'], 429);
        if (preg_match('/(?:password|passwd|token|secret|apikey|api_key|authorization|cookie|\b(?:su|sudo|login)\b)/i', $cmd)) { $cmd = '[sensitive command redacted]'; }
        $me = $_SESSION['term'] ?? null;
        if (!is_array($me) || ($me['until'] ?? 0) < $now) { $me = null; }
        $result = (string)($_POST['result'] ?? 'failed');
        if (!in_array($result, ['success', 'failed', 'denied'], true)) $result = 'failed';
        $audit('browser: ' . $cmd, $result, $me);
        out(['ok' => true]);
    }

    /* ---------- everything below needs a logged-in root shell ---------- */
    $me = $_SESSION['term'] ?? null;
    if (!is_array($me) || ($me['until'] ?? 0) < time()) { unset($_SESSION['term']); bad('root', 403); }
    $_SESSION['term']['until'] = time() + SESSION_MINUTES * 60;
    $find = function (string $name) use ($pdo) { $s = $pdo->prepare('SELECT id, username FROM admins WHERE LOWER(username) = LOWER(?)'); $s->execute([$name]); return $s->fetch(PDO::FETCH_ASSOC) ?: null; };

    $auditable = ['passwd', 'useradd', 'usermod', 'userdel', 'users', 'last', 'logout'];
    if (in_array($action, $auditable, true)) {
        $GLOBALS['terminal_audit_failure'] = static function (string $reason) use ($audit, $action, $me): void {
            $audit($action . ' (' . substr($reason, 0, 40) . ')', 'failed', $me);
        };
    }
    switch ($action) {
        case 'passwd':
            $new = (string)($_POST['new'] ?? ''); $t = trim((string)($_POST['user'] ?? ''));
            $target = $t === '' ? ['id' => (int)$me['id'], 'username' => (string)$me['name']] : $find($t);
            if (!$target) { bad('nouser', 404); }
            if (strlen($new) < 8 || strlen($new) > 72 || strcasecmp($new, (string)$target['username']) === 0) { bad('weak'); }
            $pdo->prepare('UPDATE admins SET password_hash = ? WHERE id = ?')->execute([password_hash($new, PASSWORD_DEFAULT), (int)$target['id']]);
            $audit('passwd', 'success', $me);
            $log('passwd', (int)$target['id'], 'user=' . $target['username']);
            out(['ok' => true, 'user' => $target['username']]);

        case 'useradd':
            $n = trim((string)($_POST['user'] ?? '')); $new = (string)($_POST['new'] ?? '');
            if (!validName($n)) { bad('name'); }
            if ($find($n)) { bad('exists', 409); }
            if (strlen($new) < 8 || strlen($new) > 72 || strcasecmp($new, $n) === 0) { bad('weak'); }
            $pdo->prepare('INSERT INTO admins (username, password_hash) VALUES (?, ?)')->execute([$n, password_hash($new, PASSWORD_DEFAULT)]);
            $audit('useradd', 'success', $me);
            $log('useradd', (int)$pdo->lastInsertId(), 'user=' . $n);
            out(['ok' => true, 'user' => $n]);

        case 'usermod':
            $n = trim((string)($_POST['user'] ?? '')); $o = trim((string)($_POST['old'] ?? ''));
            $target = $o === '' ? ['id' => (int)$me['id'], 'username' => (string)$me['name']] : $find($o);
            if (!$target) { bad('nouser', 404); }
            if (!validName($n)) { bad('name'); }
            $dup = $find($n); if ($dup && (int)$dup['id'] !== (int)$target['id']) { bad('exists', 409); }
            $pdo->prepare('UPDATE admins SET username = ? WHERE id = ?')->execute([$n, (int)$target['id']]);
            if ((int)$target['id'] === (int)$me['id']) { $_SESSION['term']['name'] = $n; }
            $audit('usermod', 'success', $me);
            $log('usermod', (int)$target['id'], $target['username'] . ' -> ' . $n);
            out(['ok' => true, 'user' => $n]);

        case 'userdel':
            $target = $find(trim((string)($_POST['user'] ?? '')));
            if (!$target) { bad('nouser', 404); }
            if ((int)$target['id'] === (int)$me['id']) { bad('self'); }
            if ((int)$pdo->query('SELECT COUNT(*) FROM admins')->fetchColumn() <= 1) { bad('last'); }
            $pdo->prepare('DELETE FROM admins WHERE id = ?')->execute([(int)$target['id']]);
            $audit('userdel', 'success', $me);
            $log('userdel', (int)$target['id'], 'user=' . $target['username']);
            out(['ok' => true, 'user' => $target['username']]);

        case 'users':
            $audit('users', 'success', $me);
            out(['ok' => true, 'users' => $pdo->query("SELECT a.id, a.username, (SELECT MAX(l.created_at) FROM terminal_log l WHERE l.admin_id = a.id AND l.event = 'login_ok') AS last_login FROM admins a ORDER BY a.id")->fetchAll(PDO::FETCH_ASSOC)]);

        case 'last':
            $audit('last', 'success', $me);
            out(['ok' => true, 'rows' => $pdo->query('SELECT event, detail, created_at, LEFT(ip_hash, 8) AS ip FROM terminal_log ORDER BY id DESC LIMIT 15')->fetchAll(PDO::FETCH_ASSOC)]);

        case 'logout':
            $audit('logout', 'success', $me);
            $log('logout', (int)$me['id'], (string)$me['name']);
            unset($_SESSION['term']);
            if (ADMIN_SESSION_KEY !== '') { unset($_SESSION[ADMIN_SESSION_KEY]); }
            out(['ok' => true]);
    }
    $audit('unknown action: ' . substr($action, 0, 70), 'denied', $me);
    bad('action');
} catch (Throwable $e) {
    error_log('terminal-auth: ' . $e->getMessage());
    bad('server', 500);
}
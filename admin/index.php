<?php
// Admin controller: no logic here, only calls to the functions in admin/functions/ and the pages in admin/views/.
require __DIR__ . '/../config.php';
require __DIR__ . '/functions/load.php';
require_once __DIR__ . '/functions/logs.php';

admin_require_login();

$T      = admin_tables();
$groups = admin_groups();
$icons  = admin_icons();
$t      = admin_resolve_page($_GET['t'] ?? 'dashboard');
if (($_GET['t'] ?? '') === 'logs') { $t = 'logs'; }

$note = $bad = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') [$note, $bad] = admin_handle_post($abhPdo, $t);

$tok      = abh_e(abh_csrf());
$uname    = admin_username($abhPdo);
$msgCount = admin_messages_count($abhPdo);
$isCrud   = isset($T[$t]);
$count    = $isCrud ? admin_items_count($abhPdo, $t) : 0;
$subtitle = admin_subtitle($t, $count, $msgCount);
if ($t === 'logs') { $subtitle = 'Terminal login & activity log'; }
$edit     = ($isCrud && isset($_GET['edit'])) ? admin_item_find($abhPdo, $t, (int)$_GET['edit']) : null;

$pages = ['dashboard' => 'dashboard', 'settings' => 'settings', 'password' => 'account', 'messages' => 'messages','logs' => 'logs', 'security' => 'security'];

require __DIR__ . '/views/layout_top.php';
require __DIR__ . '/views/' . ($pages[$t] ?? 'items') . '.php';
require __DIR__ . '/views/layout_bottom.php';

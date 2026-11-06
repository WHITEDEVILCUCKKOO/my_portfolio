<?php
// Admin controller: no logic here, only calls to the functions in admin/functions/ and the pages in admin/views/.
require __DIR__ . '/../config.php';
require __DIR__ . '/functions/load.php';

admin_require_login();

$T      = admin_tables();
$groups = admin_groups();
$icons  = admin_icons();
$t      = admin_resolve_page($_GET['t'] ?? 'dashboard');

$note = $bad = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') [$note, $bad] = admin_handle_post($abhPdo, $t);

$tok      = abh_e(abh_csrf());
$uname    = admin_username($abhPdo);
$msgCount = admin_messages_count($abhPdo);
$isCrud   = isset($T[$t]);
$count    = $isCrud ? admin_items_count($abhPdo, $t) : 0;
$subtitle = admin_subtitle($t, $count, $msgCount);
$edit     = ($isCrud && isset($_GET['edit'])) ? admin_item_find($abhPdo, $t, (int)$_GET['edit']) : null;

$pages = ['dashboard' => 'dashboard', 'settings' => 'settings', 'password' => 'account', 'messages' => 'messages'];

require __DIR__ . '/views/layout_top.php';
require __DIR__ . '/views/' . ($pages[$t] ?? 'items') . '.php';
require __DIR__ . '/views/layout_bottom.php';

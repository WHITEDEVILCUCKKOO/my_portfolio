<?php
// What the admin panel manages: editable tables, sidebar menu, icons and page names.

/** Editable tables and the type of each column. Only these names are ever used in SQL. */
function admin_tables(): array {
  return [
 'projects'   => ['name'=>'text','category'=>'text','description'=>'area','tech'=>'text','live_url'=>'url','screenshot'=>'path','sort_order'=>'int'],
 'skills'     => ['category'=>'text','name'=>'text'],
 'services'   => ['title'=>'text','sort_order'=>'int'],
 'experience' => ['role'=>'text','company'=>'text','period'=>'text','details'=>'area','sort_order'=>'int'],
];
}

/** Sidebar menu groups. */
function admin_groups(): array {
  return ['Overview' => ['dashboard'], 'Portfolio content' => ['projects', 'skills', 'services', 'experience'], 'Other' => ['settings', 'messages', 'password']];
}

/** SVG icon shapes for the menu and dashboard. */
function admin_icons(): array {
  return [
 'dashboard' => '<rect x="3" y="3" width="8" height="8" rx="2"/><rect x="13" y="3" width="8" height="5" rx="2"/><rect x="13" y="12" width="8" height="9" rx="2"/><rect x="3" y="15" width="8" height="6" rx="2"/>',
 'projects' => '<rect x="3" y="4" width="18" height="14" rx="2"/><path d="M3 9h18"/>', 'skills' => '<path d="m8 8-4 4 4 4M16 8l4 4-4 4"/>',
 'services' => '<path d="M12 3l2.5 5.5L20 9l-4 4 1 6-5-3-5 3 1-6-4-4 5.5-.5z"/>', 'experience' => '<rect x="3" y="7" width="18" height="13" rx="2"/><path d="M9 7V4h6v3"/>',
 'settings' => '<circle cx="12" cy="12" r="3"/><path d="M12 3v3M12 18v3M3 12h3M18 12h3"/>', 'messages' => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
 'password' => '<rect x="5" y="11" width="14" height="9" rx="2"/><path d="M8 11V8a4 4 0 0 1 8 0v3"/>'];
}

/** Make sure the requested page exists, otherwise fall back to the dashboard. */
function admin_resolve_page($t): string {
  $t = (string)$t;
  return (isset(admin_tables()[$t]) || in_array($t, ['dashboard', 'settings', 'messages', 'password'], true)) ? $t : 'dashboard';
}

/** Sub-heading shown under the page title. */
function admin_subtitle(string $t, int $count, int $msgCount): string {
  return ['projects' => "$count projects", 'skills' => "$count skills", 'services' => "$count services", 'experience' => "$count entries", 'settings' => 'Site details, contact info and text', 'messages' => "$msgCount messages from the contact form", 'password' => 'Update your login email or password', 'dashboard' => 'Overview of your portfolio'][$t] ?? '';
}

<?php
// Loads every admin function file.
foreach (['schema', 'auth', 'crud', 'messages', 'settings', 'account', 'actions'] as $abmFile) {
  require __DIR__ . '/' . $abmFile . '.php';
}
unset($abmFile);

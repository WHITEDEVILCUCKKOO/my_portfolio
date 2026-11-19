<?php
// Loads every admin function file.
foreach ([
    'schema',
    'auth',
    'security',
    'crud',
    'project_images',
    'messages',
    'settings',
    'account',
    'actions'
] as $abmFile) {
    require_once __DIR__ . '/' . $abmFile . '.php';
}

unset($abmFile);
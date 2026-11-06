<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $v('name') ?> | <?= $v('title') ?></title>
  <meta name="description" content="<?= $v('site_description') ?>">
  <meta property="og:title" content="<?= $v('name') ?> | <?= $v('title') ?>">
  <meta property="og:description" content="<?= $v('site_description') ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=JetBrains+Mono&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">
  <script>
    try {
      document.documentElement.className += ' abh-js';
      var tt = localStorage.getItem('abhTheme');
      document.documentElement.setAttribute('data-theme', tt === 'light' ? 'light' : 'dark')
    } catch (e) {
      document.documentElement.setAttribute('data-theme', 'dark')
    }
  </script>
  <link rel="stylesheet" href="assets/style.css">
</head>



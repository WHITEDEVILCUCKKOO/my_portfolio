<?php
require __DIR__ . '/config.php';
$S = [];
foreach ($abhPdo->query('SELECT skey, svalue FROM settings') as $r) $S[$r['skey']] = $r['svalue'];
$v = fn($k) => abh_e($S[$k] ?? '');
$skills = [];
foreach ($abhPdo->query('SELECT category, name FROM skills ORDER BY id') as $r) $skills[$r['category']][] = $r['name'];
$backend = $skills['API & Backend'] ?? [];
$services = $abhPdo->query('SELECT title FROM services ORDER BY sort_order, id')->fetchAll(PDO::FETCH_COLUMN);
$projects = $abhPdo->query('SELECT * FROM projects ORDER BY sort_order, id')->fetchAll();
$exp = $abhPdo->query('SELECT * FROM experience ORDER BY sort_order, id')->fetchAll();
$cv = abh_path($S['cv_url'] ?? '');
$wait = abh_wait_left($abhPdo);
$stack = array_filter(array_map('trim', explode(',', $S['hero_stack'] ?? '')));
?>




<?php include_once'./inculdes/top_links.php' ?>
<?php include_once'./inculdes/header.php' ?>

<main>

  
  
  
  <?php include_once'./inculdes/home/hero.php' ?>
  <?php// include_once'./inculdes/home/about.php' ?>
  <?php include_once'./inculdes/home/technical_skills.php' ?>
  <?php include_once'./inculdes/home/service.php' ?>
  <?php include_once'./inculdes/home/featured_projects.php' ?>
  <?php include_once'./inculdes/home/work_experience.php' ?>
  <?php include_once'./inculdes/home/api_development_backend_expertise.php' ?>
  <?php include_once'./inculdes/home/comtact.php' ?>

  
  
  
  
</main>


<?php include_once'./inculdes/footer.php' ?>
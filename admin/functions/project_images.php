<?php
// Project screenshot handling. Paths stored in projects.screenshot (no schema change).
function abm_project_dir(): string { return dirname(__DIR__, 2) . '/assets/images/project_screenshots'; }
function abm_project_public(string $filename): string { return 'assets/images/project_screenshots/' . $filename; }
function abm_project_prepare_dir(): void {
  $dir = abm_project_dir();
  if (!is_dir($dir) && !mkdir($dir, 0755, true) && !is_dir($dir)) throw new RuntimeException('Cannot create screenshot folder.');
  if (!is_writable($dir)) throw new RuntimeException('Screenshot folder is not writable.');
  if (!is_file($dir . '/.htaccess')) @file_put_contents($dir . '/.htaccess', "Options -Indexes\n<FilesMatch \"\\.(php|phtml|phar|cgi|pl|sh)$\">\nRequire all denied\n</FilesMatch>\n");
}
function abm_project_upload(array $file): string {
  if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) throw new RuntimeException('Image upload failed (check upload_max_filesize and post_max_size).');
  if (($file['size'] ?? 0) > 12 * 1024 * 1024) throw new RuntimeException('Image must be 12 MB or smaller.');
  $tmp = $file['tmp_name'] ?? '';
  if (!is_uploaded_file($tmp)) throw new RuntimeException('Invalid uploaded image.');
  $mime = (new finfo(FILEINFO_MIME_TYPE))->file($tmp);
  $ext = ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'][$mime] ?? null;
  if (!$ext || !@getimagesize($tmp)) throw new RuntimeException('Upload a valid JPG, PNG or WebP image.');
  abm_project_prepare_dir();
  $name = bin2hex(random_bytes(16)) . '.' . $ext;
  if (!move_uploaded_file($tmp, abm_project_dir() . '/' . $name)) throw new RuntimeException('Could not save image.');
  @chmod(abm_project_dir() . '/' . $name, 0644);
  return abm_project_public($name);
}
function abm_project_validate_url(string $url): void {
  $p = parse_url($url);
  if (!$p || !in_array(strtolower($p['scheme'] ?? ''), ['http','https'], true) || empty($p['host']) || isset($p['user']) || isset($p['pass'])) throw new RuntimeException('Enter a valid public website URL.');
  $host = strtolower(trim($p['host'], '[]'));
  if ($host === 'localhost' || str_ends_with($host, '.localhost') || str_ends_with($host, '.local') || str_ends_with($host, '.internal')) throw new RuntimeException('Local/internal websites cannot be captured.');
  if (isset($p['port']) && !in_array((int)$p['port'], [80,443], true)) throw new RuntimeException('Only ports 80 and 443 are allowed.');
  if (filter_var($host, FILTER_VALIDATE_IP)) throw new RuntimeException('Use a public domain name, not an IP address.');
  $ips = @gethostbynamel($host);
  if (!$ips) throw new RuntimeException('Website domain could not be resolved.');
  foreach ($ips as $ip) if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) throw new RuntimeException('Private network addresses are not allowed.');
}
function abm_project_capture(string $url): string {
  abm_project_validate_url($url);
  if (!function_exists('proc_open')) throw new RuntimeException('Automatic capture needs PHP proc_open enabled.');
  abm_project_prepare_dir();
  $name = bin2hex(random_bytes(16)) . '.png';
  $target = abm_project_dir() . '/' . $name;
  $script = dirname(__DIR__) . '/tools/capture.js';
  $node = getenv('ABM_NODE_BIN') ?: 'node';
  $cmd = escapeshellarg($node) . ' ' . escapeshellarg($script) . ' ' . escapeshellarg($url) . ' ' . escapeshellarg($target);
  $pipes = [];
  $proc = @proc_open($cmd, [0=>['pipe','r'],1=>['pipe','w'],2=>['pipe','w']], $pipes, dirname(__DIR__));
  if (!is_resource($proc)) throw new RuntimeException('Cannot start screenshot helper.');
  fclose($pipes[0]);
  $stdout = stream_get_contents($pipes[1]); fclose($pipes[1]);
  $stderr = stream_get_contents($pipes[2]); fclose($pipes[2]);
  $status = proc_close($proc);
  if ($status !== 0 || !is_file($target) || filesize($target) === 0) { @unlink($target); throw new RuntimeException('Screenshot failed: ' . mb_substr(trim($stderr ?: $stdout), 0, 350)); }
  @chmod($target, 0644);
  return abm_project_public($name);
}
function abm_project_remove_owned(string $path): void {
  if (!preg_match('~^assets/images/project_screenshots/([a-f0-9]{32}\.(?:png|jpg|webp))$~', $path, $m)) return;
  @unlink(abm_project_dir() . '/' . $m[1]);
}
function abm_project_save(PDO $pdo, int $id, array $post): void {
  $old = $id ? admin_item_find($pdo, 'projects', $id) : null;
  if ($id && !$old) throw new RuntimeException('Project not found.');
  $previous = (string)($old['screenshot'] ?? '');
  $new = '';
  $mode = (string)($post['screenshot_mode'] ?? 'keep');
  if ($mode === 'upload') {
    if (($_FILES['project_screenshot']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) $new = abm_project_upload($_FILES['project_screenshot']);
    else throw new RuntimeException('Choose an image to upload.');
  } elseif ($mode === 'capture') {
    $new = abm_project_capture(trim((string)($post['live_url'] ?? '')));
  } elseif ($mode !== 'keep') throw new RuntimeException('Invalid screenshot option.');
  $post['screenshot'] = $new ?: $previous;
  try {
    if ($id) admin_item_update($pdo, 'projects', $id, $post);
    else admin_item_add($pdo, 'projects', $post);
  } catch (Throwable $e) { if ($new) abm_project_remove_owned($new); throw $e; }
  if ($new && $previous !== $new) abm_project_remove_owned($previous);
}

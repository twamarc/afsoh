<?php
$page_title = 'Conferences';
$page_name  = 'conferences';

require_once __DIR__ . '/includes/header.inc.php';

$candidates = [
    __DIR__ . '/includes/pages/conferences.inc.php',
    __DIR__ . '/pages/conferences.inc.php',
    __DIR__ . '/includes/conferences.inc.php',
    __DIR__ . '/conferences.html',
    __DIR__ . '/conferences.htm',
];

$included = false;
foreach ($candidates as $p) {
    if (is_file($p)) { include $p; $included = true; break; }
}

if (!$included): ?>
  <div class="container" style="max-width:1080px;margin:30px auto;">
    <h1><?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?></h1>
    <p>This section is ready. Add your content to one of:</p>
    <ul>
      <li>/includes/pages/conferences.inc.php</li>
      <li>/pages/conferences.inc.php</li>
      <li>/includes/conferences.inc.php</li>
      <li>/conferences.html or /conferences.htm</li>
    </ul>
  </div>
<?php endif;

require_once __DIR__ . '/includes/footer.inc.php';
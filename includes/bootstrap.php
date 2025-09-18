<?php
// Bootstrap for PHP 8 runtime
if (!defined('__BOOTSTRAPPED__')) {
  define('__BOOTSTRAPPED__', true);
  require_once __DIR__ . '/compat/legacy_compat.php';
  // If a local config exists, use it; else fall back to connect.inc.php
  if (file_exists(__DIR__ . '/connect.inc.php')) {
    require_once __DIR__ . '/connect.inc.php';
  }
}
?>

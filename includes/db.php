<?php
// Application database settings for local dev (Docker compose)
define('DB_HOST', getenv('DB_HOST') ?: 'db');
define('DB_NAME', getenv('DB_NAME') ?: 'app');
define('DB_USER', getenv('DB_USER') ?: 'app');
define('DB_PASS', getenv('DB_PASS') ?: 'app');
?>

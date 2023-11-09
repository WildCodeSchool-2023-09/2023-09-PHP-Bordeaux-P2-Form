<?php

session_start();
/* used for tests */
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
}
/* end used for tests */

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../config/debug.php';
if (file_exists(__DIR__ . '/../config/db.php')) {
    require_once __DIR__ . '/../config/db.php';
}
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/routing.php';

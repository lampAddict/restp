<?php

ini_set('display_errors', 'stderr');

use core\Dispatcher;

require_once('core/ClassLoader.php');

try {
    Dispatcher::obj()->main();
} catch (Exception $e) {
    error_log($e->getMessage() . "\n" . $e->getTraceAsString());
}
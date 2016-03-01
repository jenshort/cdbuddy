<?php

require_once('../vendor/autoload.php');

use SierraSql\App;

date_default_timezone_set("America/New_York");

// App($production = true, $queryLogging = false)
$app = new App(false, false);

$app->dispatch();

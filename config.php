<?php

define('ABSPATH', dirname(__FILE__));
define('UP_ABSPATH', ABSPATH . '/views/_uploads');
#define( 'HOME_URI', 'http://localhost.mvc-default' );
define('HOME_URI', '');
define('HOSTNAME', 'localhost');
define('DB_NAME', 'lab_mvc_default');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_CHARSET', 'utf8');
define('DEBUG', true);

require_once ABSPATH . '/loader.php';
?>
<?php
if (!isset($_SERVER['HTTP_HOST'])) {
   exit("Run this script from a browser.\n");
}

if (!defined('ROOT_DIR') || 
   !in_array(@$_SERVER['REMOTE_ADDR'], array(
    '127.0.0.1',
    '::1',
))) {
    header('HTTP/1.0 403 Forbidden');
    exit('Access to this script is forbidden.');
}



define('DB_NAME', ROOT_DIR.'/skysilk.db');
define('SITE_EMAIL', 'noreply@skysilk.com');
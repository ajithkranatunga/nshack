<?php
if (!defined('ABSPATH'))
    define('ABSPATH', dirname(__FILE__) . '/');

foreach (glob("lib/*.php") as $filename) {
    require_once($filename);
}
foreach (glob("Controller/*.php") as $filename) {
    require_once($filename);
}
foreach (glob("Api/*.php") as $filename) {
    require_once($filename);
}
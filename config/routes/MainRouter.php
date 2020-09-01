<?php

$dir = __DIR__ . '/subRoutes';

$catalog = opendir($dir);

while ($filename = readdir($catalog)) {
    $filename = $dir . '/' . $filename;
    include_once($filename);
}

closedir($catalog);
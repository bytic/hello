<?php

$params = [];

$params['paths'] = [
    'migrations' => dirname(__FILE__) . DIRECTORY_SEPARATOR . 'migrations',
    'seeds' => dirname(__FILE__) . DIRECTORY_SEPARATOR . 'seeds'
];

$params['environments'] = [];

return $params;

<?php

return new \Phalcon\Config(array(
    'database' => array(
        'adapter' => 'Mysql',
        'host' => 'localhost',
        'username' => 'root',
        'password' => 'alexis',
        'dbname' => 'test',
    ),
    'application' => array(
        'modelsDir' => implode(DIRECTORY_SEPARATOR, array(dirname(dirname(__FILE__)), 'lib','models', '')),
        'viewsDir' => implode(DIRECTORY_SEPARATOR, array(dirname(dirname(__FILE__)), 'views', '')),
        'baseUri' => '/api_rest_ejemplo1/',
    )
));


<?php

error_reporting(E_ERROR);

try {

	$config = include __DIR__ . '/../config/config.php';
	include __DIR__ . '/../config/services.php';
	include __DIR__ . '/../config/loader.php';
	$app = new \Phalcon\Mvc\Micro();
	$app->setDi($di);
	include __DIR__ . '/../app.php';
	$app->handle();

} catch (Phalcon\Exception $e) {
	echo $e->getMessage();
} catch (PDOException $e){
	echo $e->getMessage();
}

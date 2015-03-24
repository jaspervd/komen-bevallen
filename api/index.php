<?php
session_start();
date_default_timezone_set('Europe/Brussels');
define("WWW_ROOT",dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR);

require_once WWW_ROOT . 'classes' . DIRECTORY_SEPARATOR . 'Config.php';
require_once WWW_ROOT . 'dao' . DIRECTORY_SEPARATOR . 'UsersDAO.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$usersDAO = new UsersDAO();

function wrapJSON($array) {
	header('Content-Type: application/json');
	print json_encode($array);
	exit;
}

$app->post('/login/?', function() use ($app, $usersDAO) {
	$post = $app->request->post();
	if(empty($post)) {
		$post = (array) json_decode($app->request()->getBody());
	}

	$auth = $usersDAO->authenticate($post['email'], $post['password']);
	if(!empty($auth)) {
		unset($auth['password']);
		return wrapJSON($auth);
		exit;
	} else {
		http_response_code(401); // return unauthorized http code
		exit;
	}
});

$app->run();
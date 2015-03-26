<?php
session_start();
date_default_timezone_set('Europe/Brussels');
define("WWW_ROOT", dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

require_once WWW_ROOT . 'classes' . DIRECTORY_SEPARATOR . 'Util.php';
require_once WWW_ROOT . 'dao' . DIRECTORY_SEPARATOR . 'UsersDAO.php';
require_once WWW_ROOT . 'api' . DIRECTORY_SEPARATOR . 'Slim' . DIRECTORY_SEPARATOR . 'Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$usersDAO = new UsersDAO();

$app->get('/me/?', function() use ($usersDAO) {
    if(!empty($_SESSION['komen_bevallen']['user'])) {
        $user = $usersDAO->selectById($_SESSION['komen_bevallen']['user']['id']);
        unset($user['password']);
        return Util::json($user);
    } else {
        return Util::json(array());
    }
});

$app->delete('/users/:id/?', function($id) {
    if(!empty($_SESSION['komen_bevallen']['user']) && $_SESSION['komen_bevallen']['user']['id'] == $id) {
        unset($_SESSION['komen_bevallen']['user']);
        http_response_code(200);
        exit;
    } else {
        // return bad request http code (zie https://tools.ietf.org/html/rfc7231#section-6.5.1)
        http_response_code(401);
        exit;
    }
});
$app->run();

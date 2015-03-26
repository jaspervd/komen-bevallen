<?php
session_start();
date_default_timezone_set('Europe/Brussels');
define("WWW_ROOT", dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

require_once WWW_ROOT . 'classes' . DIRECTORY_SEPARATOR . 'Util.php';
require_once WWW_ROOT . 'dao' . DIRECTORY_SEPARATOR . 'UsersDAO.php';
require_once WWW_ROOT . 'dao' . DIRECTORY_SEPARATOR . 'PregnanciesDAO.php';
require_once WWW_ROOT . 'api' . DIRECTORY_SEPARATOR . 'Slim' . DIRECTORY_SEPARATOR . 'Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$usersDAO = new UsersDAO();
$pregnanciesDAO = new PregnanciesDAO();

// check if logged in, if so: return user
$app->get('/me/?', function() use ($usersDAO) {
    if(!empty($_SESSION['komen_bevallen']['user'])) {
        $user = $usersDAO->selectById($_SESSION['komen_bevallen']['user']['id']);
        unset($user['password']);
        return Util::json($user);
    } else {
        return Util::json(array());
    }
});

// logout
$app->delete('/users/:id/?', function($id) {
    if(!empty($_SESSION['komen_bevallen']['user']) && $_SESSION['komen_bevallen']['user']['id'] == $id) {
        unset($_SESSION['komen_bevallen']['user']);
        http_response_code(200);
        exit;
    } else {
        // return bad request http code (zie https://tools.ietf.org/html/rfc7231#section-6.5.1)
        http_response_code(400);
        exit;
    }
});

// forgot password
$app->post('/forgotpw/?', function() use ($app, $usersDAO) {
    $post = $app->request->post();
    if(empty($post)) {
        $post = (array) json_decode($app->request()->getBody());
    }

    if($usersDAO->checkExistingEmail($post['email'])) {
        // TODO: mail()
        http_response_code(200);
        exit;
    } else {
        http_response_code(400);
        exit;
    }
});

// sign up (register pregnancy)
$app->post('/pregnancies/?', function() use ($app, $pregnanciesDAO) {
    if(!empty($_SESSION['komen_bevallen']['user'])) {
        $post = $app->request->post();
        if(empty($post)) {
            $post = (array) json_decode($app->request()->getBody());
        }

    // TODO: Server side validatie + foto upload
        $photo_url = '//';
        $pregnancy = $pregnanciesDAO->insert($_SESSION['komen_bevallen']['user']['id'], $post['mother'], $post['partner'], $post['type'], $post['duedate'], $photo_url);

        if(!empty($pregnancy)) {
            return Util::json($pregnancy);
        } else {
            http_response_code(400);
            exit;
        }
    } else {
        http_response_code(403);
        exit;
    }
});

$app->run();

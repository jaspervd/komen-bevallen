<?php
session_start();
date_default_timezone_set('Europe/Brussels');
define("WWW_ROOT", dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

require_once WWW_ROOT . 'classes' . DIRECTORY_SEPARATOR . 'Util.php';
require_once WWW_ROOT . 'dao' . DIRECTORY_SEPARATOR . 'UsersDAO.php';
require_once WWW_ROOT . 'dao' . DIRECTORY_SEPARATOR . 'GroupsDAO.php';
require_once WWW_ROOT . 'dao' . DIRECTORY_SEPARATOR . 'RatingsDAO.php';
require_once WWW_ROOT . 'dao' . DIRECTORY_SEPARATOR . 'PhotosDAO.php';
require_once WWW_ROOT . 'api' . DIRECTORY_SEPARATOR . 'Slim' . DIRECTORY_SEPARATOR . 'Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$usersDAO = new UsersDAO();
$groupsDAO = new GroupsDAO();
$ratingsDAO = new RatingsDAO();
$photosDAO = new PhotosDAO();

// check if logged in, if so: return user
$app->get('/me/?', function() use ($usersDAO) {
    if(!empty($_SESSION['komen_bevallen']['user'])) {
        $user = $usersDAO->selectById($_SESSION['komen_bevallen']['user']['id']);
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

// groups
$app->get('/groups/:id', function($id) use ($groupsDAO) {
    if(!empty($_SESSION['komen_bevallen']['user'])) {
        return Util::json($ratingsDAO->selectByGroupId($id));
    } else {
        return Util::json(array());
    }
});

// ratings
$app->get('/ratings/:contender_id/?', function($contender_id) use ($ratingsDAO) {
    if(!empty($_SESSION['komen_bevallen']['user'])) {
        return Util::json($ratingsDAO->selectByContenderId($contender_id));
    } else {
        return Util::json(array());
    }
});

$app->get('/ratings/total/:group_id/?', function($group_id) use ($ratingsDAO) {
    if(!empty($_SESSION['komen_bevallen']['user'])) {
        return Util::json($ratingsDAO->selectByGroupId($group_id));
    } else {
        return Util::json(array());
    }
});

// photos
$app->get('/photos/:day/?', function($day) use ($photosDAO) {
    if(!empty($_SESSION['komen_bevallen']['user'])) {
        if(strtotime($day)) {
            return Util::json($photosDAO->selectByDay($day));
        } else {
            http_response_code(400);
            exit;
        }
    } else {
        return Util::json(array());
    }
});

$app->get('/photos/all/:group_id/?', function($group_id) use ($photosDAO) {
    if(!empty($_SESSION['komen_bevallen']['user'])) {
        return Util::json($photosDAO->selectByGroupId($group_id));
    } else {
        return Util::json(array());
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

$app->run();

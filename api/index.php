<?php
session_start();
date_default_timezone_set('Europe/Brussels');
define("WWW_ROOT", dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

require_once WWW_ROOT . 'classes' . DIRECTORY_SEPARATOR . 'Util.php';
require_once WWW_ROOT . 'dao' . DIRECTORY_SEPARATOR . 'AdminDAO.php';
require_once WWW_ROOT . 'dao' . DIRECTORY_SEPARATOR . 'UsersDAO.php';
require_once WWW_ROOT . 'dao' . DIRECTORY_SEPARATOR . 'GroupsDAO.php';
require_once WWW_ROOT . 'dao' . DIRECTORY_SEPARATOR . 'RatingsDAO.php';
require_once WWW_ROOT . 'dao' . DIRECTORY_SEPARATOR . 'PhotosDAO.php';
require_once WWW_ROOT . 'api' . DIRECTORY_SEPARATOR . 'Slim' . DIRECTORY_SEPARATOR . 'Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$adminDAO = new AdminDAO();
$usersDAO = new UsersDAO();
$groupsDAO = new GroupsDAO();
$ratingsDAO = new RatingsDAO();
$photosDAO = new PhotosDAO();

// get today
$app->get('/today/?', function () use ($adminDAO) {
    return Util::json($adminDAO->select());
});

// check if logged in, if so: return user
$app->get('/me/?', function () use ($usersDAO) {
    if (!empty($_SESSION['komen_bevallen']['user'])) {
        $user = $usersDAO->selectById($_SESSION['komen_bevallen']['user']['id']);
        return Util::json($user);
    }
    else {
        http_response_code(403);
        exit;
    }
});

$app->get('/users/:id/?', function ($id) use ($usersDAO) {
    if (!empty($_SESSION['komen_bevallen']['user'])) {
        $user = $usersDAO->selectById($id);
        return Util::json($user);
    }
    else {
        http_response_code(403);
        exit;
    }
});

// logout
$app->delete('/users/:id/?', function ($id) {
    if (!empty($_SESSION['komen_bevallen']['user']) && $_SESSION['komen_bevallen']['user']['id'] == $id) {
        unset($_SESSION['komen_bevallen']['user']);
        http_response_code(200);
        exit;
    }
    else {

        // return bad request http code (zie https://tools.ietf.org/html/rfc7231#section-6.5.1)
        http_response_code(400);
        exit;
    }
});

// groups
$app->get('/groups/:id', function ($id) use ($groupsDAO) {
    if (!empty($_SESSION['komen_bevallen']['user'])) {
        return Util::json($groupsDAO->selectById($id));
    }
    else {
        http_response_code(403);
        exit;
    }
});

// ratings
$app->get('/ratings/:contender_id/?', function ($contender_id) use ($ratingsDAO) {
    if (!empty($_SESSION['komen_bevallen']['user'])) {
        return Util::json($ratingsDAO->selectByContenderId($contender_id));
    }
    else {
        http_response_code(403);
        exit;
    }
});

$app->get('/ratings/total/:group_id/?', function ($group_id) use ($ratingsDAO) {
    if (!empty($_SESSION['komen_bevallen']['user'])) {
        return Util::json($ratingsDAO->selectByGroupId($group_id));
    }
    else {
        http_response_code(403);
        exit;
    }
});

// photos
$app->get('/photos/:contender_id/?', function ($contender_id) use ($photosDAO) {
    if (!empty($_SESSION['komen_bevallen']['user'])) {
        return Util::json($photosDAO->selectByContenderId($contender_id));
    }
    else {
        http_response_code(403);
        exit;
    }
});

$app->get('/photos/all/:group_id/?', function ($group_id) use ($photosDAO) {
    if (!empty($_SESSION['komen_bevallen']['user'])) {
        return Util::json($photosDAO->selectByGroupId($group_id));
    }
    else {
        http_response_code(403);
        exit;
    }
});

$app->post('/photos/?', function () use ($app, $usersDAO, $photosDAO) {
    if (!empty($_SESSION['komen_bevallen']['user'])) {
        $post = $app->request->post();
        if (empty($post)) {
            $post = (array)json_decode($app->request()->getBody());
        }

        $errors = array();
        $imageMimeTypes = array('image/jpeg', 'image/png', 'image/gif');
        if(empty($post['contender_id']) || is_nan($post['contender_id']) || empty($usersDAO->selectById($post['contender_id']))) {
            $errors['contender_id'] = 'Dit is geen geldig ID.';
        }
        if (strlen($_FILES['photo']['tmp_name']) == 0) {
            $errors['photo'] = 'Gelieve een foto in te voegen.';
        } elseif (in_array($_FILES['photo']['type'], $imageMimeTypes)) {
            $targetFile = WWW_ROOT . 'upload' . DIRECTORY_SEPARATOR . $_FILES['photo']['name'];
            $pos = strrpos($targetFile, '.');
            $filename = substr($targetFile, 0, $pos);
            $ext = substr($targetFile, $pos + 1);
            $i = 0;
            while (file_exists($targetFile)) {
                $i++;
                $targetFile = $filename . $i . '.' . $ext;
            }
        } else {
            $errors['photo'] = 'De "foto" die je probeerde up te loaden, is geen jpeg, png of gif bestand.';
        }

        if (empty($errors)) {
            move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile);
            return Util::json($photosDAO->insert($_SESSION['komen_bevallen']['user']['id'], $_SESSION['komen_bevallen']['user']['group_id'], str_replace(WWW_ROOT, '', $targetFile), $post['contender_id']));
            exit;
        }
        else {
            http_response_code(400);
            return Util::json($errors);
            exit;
        }
    }
    else {
        http_response_code(403);
        exit;
    }
});

// forgot password
$app->post('/forgotpw/?', function () use ($app, $usersDAO) {
    $post = $app->request->post();
    if (empty($post)) {
        $post = (array)json_decode($app->request()->getBody());
    }

    if ($usersDAO->checkExistingEmail($post['email'])) {

        // TODO: mail()
        http_response_code(200);
        exit;
    }
    else {
        http_response_code(400);
        exit;
    }
});

$app->run();

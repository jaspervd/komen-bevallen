<?php
session_start();
define("WWW_ROOT", dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

require_once WWW_ROOT . 'classes' . DIRECTORY_SEPARATOR . 'Util.php';
require_once WWW_ROOT . 'dao' . DIRECTORY_SEPARATOR . 'UsersDAO.php';
$errors = array();
$usersDAO = new UsersDAO();

//unset($_SESSION['komen_bevallen']['user']);

if (!empty($_POST['login'])) {
    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['login']['email'] = 'Geen geldig e-mailadres ingevuld.';
    }
    if (empty($_POST['password'])) {
        $errors['login']['password'] = 'Je hebt geen wachtwoord ingevuld.';
    }
    if (empty($errors)) {
        $user = $usersDAO->authenticate($_POST['email'], $_POST['password']);
        if (!empty($user)) {
            unset($user['password']);
            $_SESSION['komen_bevallen']['user'] = $user;
        }
        else {
            $errors['login'][] = 'Foute inloggegevens.';
        }
    }
}

if (!empty($_POST['register'])) {
    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['register']['email'] = 'Geen geldig e-mailadres ingevuld.';
    }
    if (empty($_POST['password'])) {
        $errors['register']['password'] = 'Je hebt geen wachtwoord ingevuld.';
    }
    else {
        if ($_POST['password'] !== $_POST['passwordconfirm']) {
            $errors['register']['passwordconfirm'] = 'De wachtwoorden komen niet overeen.';
        }
    }
    if (empty($_POST['mother'])) {
        $errors['register']['mother'] = 'Een baby zonder moeder... ???';
    }
    if (empty($_POST['partner'])) {
        $errors['register']['partner'] = 'Als je niet weet wie de vader is, schrijf je best "onbekend".';
    }
    // TODO: photo
    if (empty($_POST['type'])) {
        $errors['register']['type'] = 'Vul een type zwangerschap in.';
    }
    if (empty($_POST['duedate'])) {
        $errors['register']['duedate'] = 'Vul een verwachte bevallingsdatum in.';
    }
    if (empty($errors)) {
        $user = $usersDAO->register($_POST['email'], $_POST['password']);
        if (!empty($user)) {
            unset($user['password']);
            $_SESSION['komen_bevallen']['user'] = $user;
        }
        else {
            $errors['register'][] = 'Er is iets misgegaan tijdens het registreren.';
        }
    }
}

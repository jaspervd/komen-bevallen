<?php
session_start();
define("WWW_ROOT", dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

require_once WWW_ROOT . 'classes' . DIRECTORY_SEPARATOR . 'Util.php';
require_once WWW_ROOT . 'dao' . DIRECTORY_SEPARATOR . 'UsersDAO.php';
$errors = array();
$usersDAO = new UsersDAO();

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

    // TODO: FOTO UPLOAD
    if (empty($_POST['moeder'])) {
        $errors['register']['moeder'] = 'Zonder moeder geen kind, zonder kind geen bevalling.';
    }
    if (empty($_POST['partner'])) {
        $errors['register']['partner'] = 'Als je geen partner hebt vul je hier de vader in ("anoniem" als je niet weet wie).';
    }
    if (empty($_POST['duedate']) || !strtotime($_POST['duedate'])) {
        $errors['register']['duedate'] = 'Geen geldige datum.';
    }
    if (empty($_POST['street'])) {
        $errors['register']['street'] = 'Een kind moet toch ergens geboren worden?';
    }
    if (empty($_POST['streetnr'])) {
        $errors['register']['streetnr'] = 'Geef het huisnummer op.';
    }
    if (empty($_POST['city'])) {
        $errors['register']['city'] = 'Geef de gemeente op.';
    }
    if (empty($_POST['telephone'])) {
        $errors['register']['telephone'] = 'Geef je telefoonnummer op zodat mensen je kunnen bereiken.';
    }
    if (empty($errors)) {
        $user = $usersDAO->register($_POST['email'], $_POST['password'], $_POST['moeder'], $_POST['partner'], $_POST['duedate'], $_POST['street'], $_POST['streetnr'], $_POST['city'], $_POST['telephone']);
        if (!empty($user)) {
            unset($user['password']);
            $_SESSION['komen_bevallen']['user'] = $user;
        }
        else {
            $errors['login'][] = 'Foute inloggegevens.';
        }
    }
}

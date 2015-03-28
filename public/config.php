<?php
session_start();
define("WWW_ROOT", dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

require_once WWW_ROOT . 'classes' . DIRECTORY_SEPARATOR . 'Util.php';
require_once WWW_ROOT . 'dao' . DIRECTORY_SEPARATOR . 'UsersDAO.php';
require_once WWW_ROOT . 'dao' . DIRECTORY_SEPARATOR . 'GroupsDAO.php';
$errors = array();
$usersDAO = new UsersDAO();
$groupsDAO = new GroupsDAO();

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

if (!empty($_POST['signup'])) {
    $imageMimeTypes = array('image/jpeg', 'image/png', 'image/gif');
    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['register']['email'] = 'Geen geldig e-mailadres ingevuld.';
    } elseif(!empty($usersDAO->checkExistingEmail($_POST['email']))) {
        $errors['register']['email'] = 'Dit e-mailadres wordt al gebruikt, <a href="#forgotpw">wachtwoord vergeten?</a>.';
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
    if (strlen($_FILES['photo']['tmp_name']) == 0) {
        $errors['register']['photo'] = 'Gelieve een foto in te voegen.';
    } elseif (in_array($_FILES['photo']['type'], $imageMimeTypes)) {
        $size = getimagesize($_FILES['photo']['tmp_name']);
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
        $errors['register']['photo'] = 'De "foto" die je probeerde up te loaden, is geen jpeg, png of gif bestand.';
    }
    if (empty($_POST['type'])) {
        $errors['register']['type'] = 'Vul een type zwangerschap in.';
    }
    $duedate = strtotime($_POST['duedate']);
    if (empty($_POST['duedate']) || !$duedate || date('N', $duedate) > 4) { // if weekday is later than 4 (4 being Thursday)
        $errors['register']['duedate'] = 'Vul een geldige bevallingsdatum (maandag t/m donderdag) in.';
    }
    if (empty($errors)) {
        move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile);
        $groups = $groupsDAO->selectByWeek(date('W', $duedate));
        $group = [];
        if(!empty($groups)) {
            foreach($groups as $key => $value) {
                $dates = array_column($value['users'], 'duedate');
                if(!in_array(date('Y-m-d', $duedate), $dates)) {
                    $group = $value;
                    break;
                }
            }
        }
        if(empty($group)) {
            $group = $groupsDAO->insert(date('W', $duedate));
        }
        $user = $usersDAO->register($_POST['email'], $_POST['password'], $_POST['mother'], $_POST['partner'], str_replace(WWW_ROOT, '', $targetFile), $_POST['duedate'], $_POST['type'], $group['id']);
        if (!empty($user)) {
            unset($user['password']);
            $_SESSION['komen_bevallen']['user'] = $user;
            header('Location: #register/3');
            exit;
        }
        else {
            $errors['register'][] = 'Er is iets misgegaan tijdens het registreren.';
        }
    }
}

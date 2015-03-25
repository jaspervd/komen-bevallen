<?php
session_start();
define("WWW_ROOT", dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

require_once WWW_ROOT . 'classes' . DIRECTORY_SEPARATOR . 'Util.php';
require_once WWW_ROOT . 'dao' . DIRECTORY_SEPARATOR . 'AdminDAO.php';

$adminDAO = new AdminDAO();
$user = 'admin';
$password = '$w4g';

if (!empty($_POST['login'])) {
	if (!empty($_POST['username']) && $_POST['username'] === $user && !empty($_POST['password']) && $_POST['password'] === $password) {
		$_SESSION['komen_bevallen'] = '20/20';
	}
	else {
		$error = 'Shit, foute inloggegevens!';
	}
}

if (!empty($_SESSION['komen_bevallen'])) {
	$currentSettings = $adminDAO->select();
	if (!empty($_POST['edit'])) {
		$date = $_POST['date'];
		$finished = $_POST['finished'];

		if(empty($currentSettings)) {
			$currentSettings = $adminDAO->insert($date, $finished);
		} else {
			$currentSettings = $adminDAO->update($date, $finished);
		}
	}
}
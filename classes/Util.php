<?php
class Util {
	public static function encrypt($string) {
		return password_hash($string, PASSWORD_BCRYPT);
	}

	public static function json($array) {
		header('Content-Type: application/json');
		print json_encode($array);
		exit;
	}
}

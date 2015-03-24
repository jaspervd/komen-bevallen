<?php
class Util {
    public static function encrypt($string) {
    	return password_hash($string, PASSWORD_BCRYPT);
    }
}

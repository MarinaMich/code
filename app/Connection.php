<?php

namespace app;

use PDO;

class Connection {
	/*
	соединение с БД
	*/
	public static function make($config) {
		$pdo = new PDO("{$config['connection']};dbname={$config['database']};",
		 	$config['username'], 
		 	$config['password']);
		return $pdo;
	}
}	
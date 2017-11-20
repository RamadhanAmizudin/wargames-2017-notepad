<?php
require_once __DIR__ . '/init.php';
// if(isset($_SESSION) AND is_array($_SESSION)) {
	// foreach($_SESSION as $s) {
		// unset($_SESSION[$s]);
	// }
// }
session_destroy();
redirect('index.php');

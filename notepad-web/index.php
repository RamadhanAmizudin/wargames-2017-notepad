<?php
require_once '../init.php';
CheckHost();

if(!isAuth()) {
	redirect('login.php');
}

if(isPost()) {
	$sql = sprintf("UPDATE tbl_sites SET notes = '%s' WHERE id = %d", $mysql->real_escape_string(post('notes')), session('site_id'));
	$mysql->query($sql);
}

$data = $mysql->query("SELECT * FROM tbl_sites WHERE id = " . session('site_id'))->fetch_object();
$smarty->assign('user_data', $data);

if( !empty($data->templates) ) {
		// $smarty->render($data->templates);
		$tmpfname = tempnam("/tmp", "T");

		$handle = fopen($tmpfname, "w");
		fwrite($handle, $data->templates);
		fclose($handle);
		$smarty->display( $tmpfname );
		unlink($tmpfname);
	} else {
	$smarty->display( __DIR__ . '/default.tpl');
}


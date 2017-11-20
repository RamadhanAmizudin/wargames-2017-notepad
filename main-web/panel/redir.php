<?php
require_once __DIR__ . '/init.php';

if( get('id') ) {
	$sql = sprintf("SELECT url FROM tbl_sites WHERE id = %d", intval(get('id')));
	$res = $mysql->query($sql);
	if($res->num_rows > 0) {
		$data = $res->fetch_object();
		redirect('http://' . $data->url . ":8080");
	}
}
redirect('index.php');
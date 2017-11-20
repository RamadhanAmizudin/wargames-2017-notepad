<?php

function CheckHost() {
    global $mysql;
    if( server('HTTP_HOST') ) {
        $host = server('HTTP_HOST');
        // echo $host;
        if( stripos($host, 'notepad.wargames.my') === false ) {
            redirect('http://notepad.wargames.my');
        } else {
            $host = str_ireplace(':8080', "", $host);
            $sql = "SELECT * FROM tbl_sites WHERE url = '" . stripslashes($host) . "'";
            $res = $mysql->query($sql);
            if($res->num_rows > 0) {
                $data = $res->fetch_array();
                $_SESSION['site_id'] = $data['id'];
                if( !session('visited') ) {
                    $mysql->query("UPDATE tbl_sites SET visitor = visitor+1 WHERE id = " . $data['id']);
                    $_SESSION['visited'] = true;
                }
            } else {
                redirect('http://notepad.wargames.my');
            }
        }
    } else {
        redirect('http://notepad.wargames.my');
    }
}

function add_admin( $data = array() ) {
	global $mysql;
	$sql = sprintf("INSERT INTO tbl_users SET user_name = '%s', user_email = '%s', user_password = '%s', user_role = 2", 
		$data['user_name'], 
		$data['user_email'],
		pw($data['user_password'])
	);
	$mysql->query($sql);
}

function pw($str = '') {
    return password_hash($str, PASSWORD_BCRYPT);
}

function verifypw($str, $hash) {
    return password_verify($str, $hash);
}

function isAuth() {
    return (bool) session('auth', false);
}

function isPost() {
    return (bool) ($_SERVER['REQUEST_METHOD'] === 'POST');
}

function get($index, $default = false) {
    return element($index, $_GET, $default);
}

function post($index, $default = false) {
    return element($index, $_POST, $default);
}

function request($index, $default = false) {
    return element($index, $_REQUEST, $default);
}

function session($index, $default = false) {
    return element($index, $_SESSION, $default);
}

function server($index, $default = false) {
    return element($index, $_SERVER, $default);
}

function element($item, array $array, $default = false) {
    return array_key_exists($item, $array) ? $array[$item] : $default;
}

function elements($items, array $array, $default = false) {
        $return = array();
        is_array($items) OR $items = array($items);
        foreach ($items as $item) {
            $return[$item] = array_key_exists($item, $array) ? $array[$item] : $default;
        }
        return $return;
}

function redirect($uri = '', $method = 'auto', $code = NULL) {
    // IIS environment likely? Use 'refresh' for better compatibility
    if ($method === 'auto' && isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== FALSE) {
        $method = 'refresh';
    }
    elseif ($method !== 'refresh' && (empty($code) OR ! is_numeric($code))) {
        if (isset($_SERVER['SERVER_PROTOCOL'], $_SERVER['REQUEST_METHOD']) && $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.1')  {
            $code = ($_SERVER['REQUEST_METHOD'] !== 'GET')
                ? 303   // reference: http://en.wikipedia.org/wiki/Post/Redirect/Get
                : 307;
        } else {
            $code = 302;
        }
    }
    switch ($method) {
        case 'refresh':
            header('Refresh:0;url='.$uri);
            break;
        default:
            header('Location: '.$uri, TRUE, $code);
            break;
    }
    exit;
}

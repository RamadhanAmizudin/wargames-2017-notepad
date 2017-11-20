<?php
require_once '../init.php';
CheckHost();

if(isAuth()) {
  redirect('index.php');
}

$error = false;

if(isPost()) {
  if(post('email') and post('password')) {
    if(filter_var(post('email'), FILTER_VALIDATE_EMAIL)) {
      $sql = sprintf("SELECT * FROM tbl_sites WHERE email = '%s' AND id = %d LIMIT 1", $mysql->real_escape_string(post('email')), session('site_id'));
      $res = $mysql->query($sql);
      if($res->num_rows > 0) {
        $obj = $res->fetch_array();
        if( verifypw( post('password'), $obj['password'] ) ) {
          $_SESSION['auth'] = true;
          $_SESSION['token'] = sha1(serialize($_SERVER) . mt_rand() . LOGGED_IN_SALT);
          redirect('index.php');
        } else {
          $error = "Invalid email or password";
        }
      } else {
        $error = "Invalid email or password.";
      }
    } else {
      $error = "Invalid Email";
    }
  } else {
    $error = "Fill all field";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>NotepaD | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="http://notepad.wargames.my/panel/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="http://notepad.wargames.my/panel/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="http://notepad.wargames.my/panel/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="http://notepad.wargames.my/panel/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="http://notepad.wargames.my/panel/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="http://notepad.wargames.my/panel/index2.html"><b>Notepa</b>D</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    <?php if($error): ?>
    <p class="login-box-msg">
      <span class="label label-danger"><?php echo $error; ?></span>
    </p>
  <?php endif; ?>
    <form action="login.php" method="post">
      <div class="form-group has-feedback">
        <input type="email" name="email" class="form-control" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <!-- /.social-auth-links -->
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="http://notepad.wargames.my/panel/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="http://notepad.wargames.my/panel/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="http://notepad.wargames.my/panel/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>

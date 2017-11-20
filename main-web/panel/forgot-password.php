<?php
require_once __DIR__ . '/init.php';

if( session('panel_auth', false) ) {
	redirect('index.php');
}

$error = false;

if(isPost()) {
  switch(post('action')) {
    default: break;
    case 'reset':
        if( post('user_email') ) {
          $sql = sprintf("SELECT * FROM tbl_users WHERE user_email = '%s' LIMIT 1", $mysql->real_escape_string(post('user_email')));
          $res = $mysql->query($sql);
          if( $res->num_rows > 0 ) {
            $data = $res->fetch_object();
            $token = md5(serialize($_SERVER) . SECURE_AUTH_SALT . $data->user_email);
            $mysql->query("UPDATE tbl_users SET user_token = '" . $token . "' WHERE id = " . $data->id);
            $error = "Email has been sent! Enter token <a href='?action=verify'>here</a>";
          } else {
            $error = "Email doesnt exists";
          }
        } else {
          $error = "fill all field";
        }
      break;

    case 'verify':
        if( post('user_token') && post('user_password') && post('user_password_c') ) {
          $sql = sprintf("SELECT * FROM tbl_users WHERE user_token = '%s' LIMIT 1", $mysql->real_escape_string(post('user_token')));
          $res = $mysql->query($sql);
          if($res->num_rows > 0) {
            if( post("user_password_c") === post('user_password') ) {
              $sql = sprintf("UPDATE tbl_users SET user_password = '%s', user_token = NULL WHERE id = %d",
                pw(post('user_password')),
                $res->fetch_object()->id
              );
              $mysql->query($sql);
              $error = "Password has been changed";
            } else {
              $error = "Password confirmation doesnt match.";
            }
          } else {
            $error = "Invalid Token";
          }
        } else {
          $error = "fill all field";
        }
      break;
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
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

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
    <a href="index.php"><b>Notepa</b>D</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Enter your email</p>
    <?php if($error): ?>
    <p class="login-box-msg">
      <span class="label label-danger"><?php echo $error; ?></span>
    </p>
	<?php endif; ?>
    <form action="forgot-password.php" method="post">
<?php switch(request('action')): ?>
<?php case 'verify': ?>
      <input type="hidden" name="action" value="verify">
      <div class="form-group has-feedback">
        <input type="text" name="user_token" class="form-control" placeholder="Reset Token" value="<?php echo get('user_token');?>">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="user_password" class="form-control" placeholder="New Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="user_password_c" class="form-control" placeholder="Retype password">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Send</button>
        </div>
        <!-- /.col -->
      </div>
<?php break; ?>
<?php default: ?>
      <input type="hidden" name="action" value="reset">
      <div class="form-group has-feedback">
        <input type="email" name="user_email" class="form-control" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Send</button>
        </div>
        <!-- /.col -->
      </div>
<?php break; endswitch; ?>
    </form>

    <!-- /.social-auth-links -->

    <a href="login.php">I already have a membership</a><br>
    <a href="register.php" class="text-center">Register a new membership</a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
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

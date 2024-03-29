<?php
require_once __DIR__ . '/init.php';

if( session('panel_auth', false) ) {
	redirect('index.php');
}

$error = false;
if(isPost()) {
	if( post('user_name') && 
		post('user_email') && 
		post('user_password') && 
		post('user_password_c') ) {

		if( filter_var(post('user_email'), FILTER_VALIDATE_EMAIL) ) {
			$sql = sprintf("SELECT * FROM tbl_users WHERE user_email = '%s'", $mysql->real_escape_string(post('user_email')));
			$sql = $mysql->query($sql);
			if( $sql->num_rows > 0 ) {
				$error = "Email already exist";
			} else {
				if( post("user_password_c") === post('user_password') ) {
					$sql = sprintf("INSERT INTO tbl_users SET user_name = '%s', user_email = '%s', user_password = '%s'",
								$mysql->real_escape_string(post('user_name')),
								$mysql->real_escape_string(post('user_email')),
								pw(post('user_password'))
							);
					$mysql->query($sql);
					$error = "Successfuly register!";
				} else {
					$error = "Password confirmation doesnt match.";
				}
			}
		} else {
			$error = "Invalid email format";
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
  <title>NotepaD | Registration Page</title>
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
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="index2.html"><b>Notepa</b>D</a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Register a new membership</p>
    <?php if($error): ?>
    <p class="login-box-msg">
      <span class="label label-danger"><?php echo $error; ?></span>
    </p>
	<?php endif; ?>
    <form action="register.php" method="post">
      <div class="form-group has-feedback">
        <input type="text" name="user_name" class="form-control" placeholder="Full name">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="email" name="user_email" class="form-control" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="user_password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="user_password_c" class="form-control" placeholder="Retype password">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> I agree to the <a href="#">terms</a>
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <a href="login.php" class="text-center">I already have a membership</a>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

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

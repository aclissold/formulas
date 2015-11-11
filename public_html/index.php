<?php
session_start();
include_once 'dbconnect.php';

if(isset($_SESSION['user'])!="")
{
 header("Location: home.php");
}
if(isset($_POST['btn-login']))
{
 $email = mysql_real_escape_string($_POST['email']);
 $upass = mysql_real_escape_string($_POST['pass']);
 $res=mysql_query("SELECT * FROM USER WHERE USER_EMAIL='$email'");
 $row=mysql_fetch_array($res);
 if($row['USER_PASS']==md5($upass))
 {
  $_SESSION['user'] = $row['USER_ID'];
  header("Location: home.php");
 }
 else
 {
  ?>
        <script>alert('wrong details');</script>
        <?php
 }

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Log In | Formulas</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<link rel="stylesheet" href="css/form.css" type="text/css" />
	<link rel="stylesheet" href="css/katex.min.css" type="text/css" />
    <link href='https://fonts.googleapis.com/css?family=PT+Serif' rel='stylesheet' type='text/css'>
</head>
    <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
<body>
    <!-- Static navbar -->
    <nav class="navbar navbar-default navbar-static-top">
      <div class="navbar-header">
        <a class="navbar-brand navbar-brand-small tex" href="#" data-expr="f">f</a>
      </div>
    </nav>

    <div class="container">
      <form class="form form-login" method="post">
        <h2>Log in</h2>
        <input type="text" name="email" id="inputEmail" class="form-control" placeholder="email" required autofocus>
        <input type="password" name="pass" id="inputPassword" class="form-control" placeholder="password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="btn-login">Log In</button>
        <a href="register.php">Need an account? Register ›</a>
      </form>

    </div> <!-- /container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>

    <!-- KaTeX -->
    <script src="js/katex.min.js"></script>
    <script src="js/main.js"></script>
    <script type="text/javascript">
      startup();
    </script>
</body>
</html>

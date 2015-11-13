<?php
session_start();
include_once 'dbconnect.php';

if(!isset($_SESSION['user']))
{
 header("Location: index.php");
}
$res=mysql_query("SELECT * FROM USER WHERE USER_ID=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);

$formID = $_GET['FORM_ID'];
$result = mysql_query("SELECT *, USER.USER_NAME AS USERNAME, 
							CATEGORY.CAT_NAME AS CATEGORYNAME FROM FORMULA INNER JOIN USER ON USER.USER_ID=FORMULA.USER_ID 
							INNER JOIN CATEGORY ON FORMULA.CAT_ID=CATEGORY.CAT_ID WHERE FORMULA.FORM_ID='$formID'");
$formulaRow=mysql_fetch_array($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Details | Formulas</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<link rel="stylesheet" href="css/details.css" type="text/css" />
	<link rel="stylesheet" href="css/katex.min.css" type="text/css" />
    <link href='https://fonts.googleapis.com/css?family=PT+Serif' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
</head>

<body>
    <!-- Static navbar -->
    <nav class="navbar navbar-default navbar-static-top">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand navbar-brand-small tex" href="home.php" data-expr="f">f</a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="user nav navbar-nav navbar-right">
          <li>
            <span><?php echo $userRow['USER_NAME']; ?></span>
            <img alt="Albert" class="albert" src="img/albert.png" width="43" height="43"/>
            <a href="logout.php?logout">
              <span class="glyphicon glyphicon-log-out"/>
            </a>
          </li>
        </ul>
      </div><!--/.nav-collapse -->
    </nav>

    <div class="container">
      <div class="well">
          <h1><?php echo $formulaRow['FORM_NAME']; ?></h1>
          <div class="category"><?php echo $formulaRow['CATEGORYNAME']; ?></div>
          <div class="formula tex" data-expr="<?php echo $formulaRow['FORM_FORMULA']; ?>"></div>
          <div class="caption">
            added by <?php echo $formulaRow['USERNAME']; ?>
            on <?php echo date('m/d/Y', strtotime($formulaRow['FORM_DATE']) );?>
          </div>
      </div>
      <div class="formula-description"><?php echo $formulaRow['FORM_DESC']; ?></div>
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
      $(document).ready(function() {
        startup();
      });
    </script>
</body>
</html>

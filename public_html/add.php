<?php
session_start();
include_once 'dbconnect.php';

if(!isset($_SESSION['user']))
{
 header("Location: index.php");
}
$res=mysql_query("SELECT * FROM USER WHERE USER_ID=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);

if(isset($_POST['add-formula']))
{	
 $uid = $_SESSION['user'];
 $name = mysql_real_escape_string($_POST['name']);
 $formula = mysql_real_escape_string($_POST['formula']);
 $desc = mysql_real_escape_string($_POST['description']);
 $cat_selected = mysql_real_escape_string($_POST['category']);
 if($cat_selected == 'Math'){
	 $catid = 1;
 }
 else {
	 $catid = 2;
 } 
 $formula_lowercase = strtolower($formula);
 $formula_lowercase_replace = str_replace(" ", "", $formula_lowercase);
 $count = mysql_query("SELECT COUNT(*) AS total FROM FORMULA WHERE REPLACE(LOWER(FORM_FORMULA), ' ', '') = '$formula_lowercase_replace' ");
 $data=mysql_fetch_assoc($count);
 
if ($data['total'] > 0)
{
?> 
         <script>alert('formula already added');</script> 
         <?php 
}
else
{
	 if(mysql_query("INSERT INTO FORMULA(FORM_NAME,FORM_DESC,FORM_FORMULA,USER_ID,CAT_ID) VALUES('$name','$desc','$formula','$uid','$catid')")) 
 	{ 
 	  header("Location: /home.php"); 
 	} 
 	 else 
 	{ 
 	  ?> 
 	        <script>alert('error while adding formula...');</script> 
 	        <?php 
 	} 
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Add | Formulas</title>

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
      <form class="form form-add" method="post">
        <h2>Add a Formula</h2>
        <input type="text" name="name" class="form-control" placeholder="name" required autofocus>
        <input type="text" name="formula" class="form-control" placeholder="formula" required>

        <div class="dropdown">
          <button class="btn btn-default dropdown-toggle" type="button" id="categoryDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            category
            <span class="caret"></span>
          </button>
          <input type="hidden" name="category" id="category" value="Math">
          <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
            <li>
              <a href="#" onclick="mathSelected()">math
                <span id="mathCheckmark" class="pull-right glyphicon glyphicon-ok" aria-hidden="true"></span>
              </a>
            </li>
            <li>
              <a href="#" onclick="physicsSelected()">physics
                <span id="physicsCheckmark" class="pull-right hidden glyphicon glyphicon-ok" aria-hidden="true"></span>
              </a>
            </li>
          </ul>
        </div>

        <textarea class="form-control" name="description" placeholder="Enter a detailed description of the formula here…" required></textarea>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="add-formula">Add</button>
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
      $(document).ready(function() {
        startup();
      });
      var mathSelected = function() {
        $('#category').val('Math');
        $('#mathCheckmark').removeClass('hidden');
        $('#physicsCheckmark').addClass('hidden');
      };
      var physicsSelected = function() {
        $('#category').val('Physics')
        $('#mathCheckmark').addClass('hidden');
        $('#physicsCheckmark').removeClass('hidden');
      }
    </script>
</body>
</html>

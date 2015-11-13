<?php
session_start();
include_once 'dbconnect.php';

if(!isset($_SESSION['user']))
{
 header("Location: index.php");
}
$res=mysql_query("SELECT * FROM USER WHERE USER_ID=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);

if(isset($_POST['add-new']))
{
	header("Location: add.php");
}
if(isset($_POST['math'])){
	$result = mysql_query("SELECT *, USER.USER_NAME AS USERNAME, 
							CATEGORY.CAT_NAME AS CATEGORYNAME FROM FORMULA INNER JOIN USER ON USER.USER_ID=FORMULA.USER_ID 
							INNER JOIN CATEGORY ON FORMULA.CAT_ID=CATEGORY.CAT_ID WHERE FORMULA.CAT_ID=1");
}
else if(isset($_POST['physics'])){
	$result = mysql_query("SELECT *, USER.USER_NAME AS USERNAME, 
							CATEGORY.CAT_NAME AS CATEGORYNAME FROM FORMULA INNER JOIN USER ON USER.USER_ID=FORMULA.USER_ID 
							INNER JOIN CATEGORY ON FORMULA.CAT_ID=CATEGORY.CAT_ID WHERE FORMULA.CAT_ID=2");
}
else{
	$result = mysql_query("SELECT *, USER.USER_NAME AS USERNAME, 
							CATEGORY.CAT_NAME AS CATEGORYNAME FROM FORMULA INNER JOIN USER ON FORMULA.USER_ID = USER.USER_ID 
							INNER JOIN CATEGORY ON FORMULA.CAT_ID = CATEGORY.CAT_ID");
}

$count_math = mysql_query("SELECT COUNT(CAT_ID) AS MATHROWS FROM FORMULA WHERE CAT_ID = 1");
$count_physics = mysql_query("SELECT COUNT(CAT_ID) AS MATHROWS FROM FORMULA WHERE CAT_ID = 2");
$count_all = mysql_query("SELECT COUNT(*) AS ALLROWS FROM FORMULA");

if(isset($_POST['delete'])){	
	$delete_id = $_POST['delete'];
	$result = mysql_query("DELETE FROM FORMULA WHERE FORM_ID='$delete_id'");
	
	$result = mysql_query("SELECT *, USER.USER_NAME AS USERNAME, 
							CATEGORY.CAT_NAME AS CATEGORYNAME FROM FORMULA INNER JOIN USER ON FORMULA.USER_ID = USER.USER_ID 
							INNER JOIN CATEGORY ON FORMULA.CAT_ID = CATEGORY.CAT_ID");
							
	$count_math = mysql_query("SELECT COUNT(CAT_ID) AS MATHROWS FROM FORMULA WHERE CAT_ID = 1");
	$count_physics = mysql_query("SELECT COUNT(CAT_ID) AS MATHROWS FROM FORMULA WHERE CAT_ID = 2");
	$count_all = mysql_query("SELECT COUNT(*) AS ALLROWS FROM FORMULA");
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
	<title>Formulas</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<link rel="stylesheet" href="css/home.css" type="text/css" />
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
        <a class="navbar-brand navbar-brand-small tex" href="home.php" data-expr="f(ormulas)">f(ormulas)</a>
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

    <div class="input-group">
      <div class="input-group-btn">
        <button type="button" id="allButton" class="btn btn-default
          <?php if(!isset($_POST['math']) && !isset($_POST['physics'])) { echo 'active'; }?>">
          <span>All (<?php echo mysql_result($count_all,0) ?>)</span>
        </button>
        <button type="button" id="mathButton" class="btn btn-default
          <?php if(isset($_POST['math'])) { echo 'active'; }?>">
          <span>Math (<?php echo mysql_result($count_math,0) ?>)</span>
        </button>
        <button type="button" id="physicsButton" class="btn btn-default
          <?php if(isset($_POST['physics'])) { echo 'active'; }?>">
          <span>Physics (<?php echo mysql_result($count_physics,0) ?>)</span>
        </button>
      </div>
    </div>

    <div class="container">
      <table class="table-striped">
        <thead>
          <tr>
            <th>Name</th>
            <th>Formula</th>
            <th>Category</th>
            <th>
              <form method="post">
                <button class="btn btn-default add-your-own-button" type="submit" name="add-new">Add Your Own! +</button>
              </form>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = mysql_fetch_array($result)) : ?>
          <tr>
            <td><a href='details.php?FORM_ID=<?php echo $row['FORM_ID']; ?>' class="row-text"><?php echo $row['FORM_NAME']; ?></a></td>
            <td><div class="row-text tex" data-expr="<?php echo $row['FORM_FORMULA']; ?>"></div></td>
            <td><div class="row-text"><?php echo $row['CATEGORYNAME']; ?></div></td>
            <td>
              <form method="post">
                  <button class="btn btn-link" type="submit" name="delete" value="<?php echo $row['FORM_ID']; ?>">
                    <span class="glyphicon glyphicon-remove"/>
                  </button>
              </form>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
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
        $('#allButton').click(function() {
          var form = document.createElement('form');
          form.method = 'post';
          var input = document.createElement('input');
          input.type = 'hidden';
          input.name = 'all';
          input.value = '';
          form.appendChild(input);
          document.body.appendChild(form);
          form.submit();
          return false;
        });
        $('#mathButton').click(function() {
          var form = document.createElement('form');
          form.method = 'post';
          var input = document.createElement('input');
          input.type = 'hidden';
          input.name = 'math';
          input.value = '';
          form.appendChild(input);
          document.body.appendChild(form);
          form.submit();
          return false;
        });
        $('#physicsButton').click(function() {
          var form = document.createElement('form');
          form.method = 'post';
          var input = document.createElement('input');
          input.type = 'hidden';
          input.name = 'physics';
          input.value = '';
          form.appendChild(input);
          document.body.appendChild(form);
          form.submit();
          return false;
        });
      });
    </script>
</body>
</html>

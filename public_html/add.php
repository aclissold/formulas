<?php
session_start();
include_once 'dbconnect.php';

if(!isset($_SESSION['user']))
{
 header("Location: index.php");
}

if(isset($_POST['addFormula']))
{
 $uid = $_SESSION['user'];
 $name = mysql_real_escape_string($_POST['name']);
 $formula = mysql_real_escape_string($_POST['formula']);
 $desc = mysql_real_escape_string($_POST['description']);
 $cat_selected = mysql_real_escape_string($_POST['category']);
 if($cat_selected = 'Math'){
	 $catid = 1;
 }
 else {
	 $catid = 2;
 }
 
 if(mysql_query("INSERT INTO FORMULA(FORM_NAME,FORM_DESC,FORM_FORMULA,FORM_DATE,USER_ID,CAT_ID) VALUES('$name','$desc','$formula',now(),'$uid','$catid')"))
 {
  ?>
        <script>alert('successfully added ');</script>
        <?php
 }
 else
 {
  ?>
        <script>alert('error while adding formula...');</script>
        <?php
 }
}

$res=mysql_query("SELECT * FROM USER WHERE USER_ID=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Formulas</title>
	<link rel="stylesheet" href="style.css" type="text/css" />
	<script src="jquery-2.1.4.min.js"></script>
</head>

<body>
	<div id="header">
		<div id="left">
			<label>Formulas</label>
		</div>
		<div id="right">
			<div id="content">
				Welcome, <?php echo $userRow['USER_NAME']; ?>&nbsp;<a href="logout.php?logout">Sign Out</a>
			</div>
		</div>		
	</div>
	<div id="body">			
		<center>
			<div style="width: 80%; margin-top: 50px">
				<table style="width:100%" class="category-table">
					<tr style="background:#a5a5a5">
						<td style="color:#ffffff">
							<h2>Add New Formula</h2>
						</td>
					</tr>
				</table>
				<table style="width:100%"> 					
					<tr>
						<td>
						<form method="post">
							<h3 style="color:#a5a5a5; margin:5px 0 0 0">Name:</h3>
							<input type="text" name="name">
							<br>
							<h3 style="color:#a5a5a5; margin:5px 0 0 0">Formula:</h3>
							<input type="text" name="formula">
							<br>
							<h3 style="color:#a5a5a5; margin:5px 0 0 0">Category:</h3>
							<input class="radio-button" type="radio" id="math" name="category" value="Math" checked>
							Math
							<input class="radio-button" type="radio" name="category" value="Physics">
							Physics
							<h3 style="color:#a5a5a5; margin:5px 0 0 0">Description:</h3>
							<textarea class="description-textarea" name="description" ></textarea>	
							<br>							  
						</form>
						</td>
					</tr>
					<tr>
						<td class="cancel-button" <button type="button" id="cancelAdd">Cancel</button></td>	
						<td class="save-button" <button type="submit" name="addFormula" id="addFormula">Save</button></td>	
					</tr>
				</table>
			</div>
		</center>
	</div>
	<script>
        $(document).ready(function() {
            $('#cancelAdd').click(function(event){
               $('#main-body').load('home.php');
            });
        });
     </script>
</body>
</html>
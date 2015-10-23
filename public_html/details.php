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
	<div id="body" style="margin-bottom:100px">			
		<center>
			<div style="width: 80%; margin-top: 50px">
				<table style="width:100%" class="category-table">
					<tr style="background:#a5a5a5">
						<td style="color:#ffffff; width:80%">
							<h2><?php echo $formulaRow['FORM_NAME']; ?></h2>
						</td>
						<td style="color:#ffffff; width:20%">
							<h2 style="text-align:center;"><?php echo $formulaRow['CATEGORYNAME']; ?></h2>
						</td>
					</tr>
				</table>
				<table style="width:100%"> 					
					<tr>
						<td>
							<h1 style="color:#a5a5a5; text-align:center; font-size:60px; margin:100px 0 100px 0;"><?php echo $formulaRow['FORM_FORMULA']; ?></h1>
						</td>
					</tr>
					<tr>						
						<td>
							<h2 style="color:#a5a5a5; text-align:right;">
								Added by <?php echo $formulaRow['USERNAME']; ?> on <?php echo date('m-d-Y', strtotime($formulaRow['FORM_DATE']) );?>
							</h2>
						</td>
					</tr>
				</table>
				<table style="width:100%;">
					<tr>
						<td>
							<h3 style="color:#a5a5a5; text-align:center;" ><?php echo $formulaRow['FORM_DESC']; ?></h3>
						</td>
					</tr>
				</table>
				<table style="width:100%; padding:0px;">
					<tr>
						<td>
							<a href="/home.php"><button class="details-cancel-button" type="button" name="cancelAdd">Back</button></a>
						</td>
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
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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Formulas</title>
	<link rel="stylesheet" href="style.css" type="text/css" />
	<script src="jquery-2.1.4.min.js"></script>
</head>

<body id="main-body">
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
			<div id="formula-table" style="width: 80%; margin-top: 50px">
				<table style="width:100%" class="category-table">
					<tr style="width:100%">
						<form method="post">
							<td style="width:15%"><button class="category-button" onclick="changeColor()" type="submit" name="all">All (<?php echo mysql_result($count_all,0) ?>)</button></td>
						</form>
						<form method="post">
							<td style="width:15%"><button class="category-button" type="submit" name="math">Math (<?php echo mysql_result($count_math,0) ?>)</a></h2></td>
						</form>
						<form method="post">
							<td style="width:15%"><h2><button class="category-button" type="submit" name="physics">Physics (<?php echo mysql_result($count_physics,0) ?>)</a></h2></td>
						</form>
						<form method="post">
							<td><button class="add-new-button" type="submit" name="add-new">Add New</button></td>
						</form>
					</tr>
				</table>				
				<table >
					<tr style="background:#a5a5a5">
						<td style="color:#ffffff"><b>Name</b></td>
						<td style="color:#ffffff"><b>Description</b></td>
						<td style="color:#ffffff"><b>Formula</b></td>
						<td style="color:#ffffff"><b>Date</b></td>
						<td style="color:#ffffff"><b>User</b></td>
						<td style="color:#ffffff"><b>Category</b></td>
						<td style="color:#ffffff"><b></b></td>
					</tr>
					<?php while($row = mysql_fetch_array($result)) : ?>
					<tr>
						<td style="width:15%"><a href='details.php?FORM_ID=<?php echo $row['FORM_ID']; ?>'><?php echo $row['FORM_NAME']; ?></a></td>
						<td style="width:30%"><?php echo substr($row['FORM_DESC'],0,70).'...'; ?></td>
						<td style="width:20%"><?php echo $row['FORM_FORMULA']; ?></td>
						<td style="width:12%"><?php echo date('m-d-Y', strtotime($row['FORM_DATE']) ); ?></td>
						<td style="width:13%"><?php echo $row['USERNAME']; ?></td>
						<td style="width:10%"><?php echo $row['CATEGORYNAME']; ?></td>
						<?php
						if(13 == $_SESSION['user']) {
						?>
							<form method="post">
								<td><button class="delete-formula" type="submit" name="delete" value="<? echo $row['FORM_ID']; ?>" >Delete</button></td>
							</form>
						<?php 
						} 
						else if($row['USER_ID'] == $_SESSION['user']){
						?>
							<form method="post">
								<td><button class="delete-formula" type="submit" name="delete" value="<? echo $row['FORM_ID']; ?>" >Delete</button></td>
							</form>
						<?php
						}
						?>
					</tr>
					<?php endwhile; ?>
				</table>
			</div>
		</center>
	</div>
</body>
</html>
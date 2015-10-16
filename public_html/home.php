<?php
session_start();
include_once 'dbconnect.php';

if(!isset($_SESSION['user']))
{
 header("Location: index.php");
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
		<?php $result = mysql_query("SELECT *, USER.USER_NAME AS USERNAME, 
									CATEGORY.CAT_NAME AS CATEGORYNAME FROM FORMULA INNER JOIN USER ON FORMULA.USER_ID = USER.USER_ID 
									INNER JOIN CATEGORY ON FORMULA.CAT_ID = CATEGORY.CAT_ID"); ?>
		<?php $count_all = mysql_num_rows($result); ?>
		<?php $count_math = mysql_query("SELECT COUNT(CAT_ID) AS MATHROWS FROM FORMULA WHERE CAT_ID = 1"); ?>
		<?php $count_physics = mysql_query("SELECT COUNT(CAT_ID) AS MATHROWS FROM FORMULA WHERE CAT_ID = 2"); ?>
		
		<center>
			<div id="formula-table" style="width: 80%; margin-top: 100px">
				<table class="category-table">
					<tr>
						<td <h2 style="color:#a5a5a5; margin-bottom:10px">All (<?php echo $count_all ?>)</h2></td>
						<td <h2 style="color:#a5a5a5; margin-bottom:10px">Math (<?php echo mysql_result($count_math,0) ?>)</h2></td>
						<td <h2 style="color:#a5a5a5; margin-bottom:10px">Physics (<?php echo mysql_result($count_physics,0) ?>)</h2></td>
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
					</tr>
					<?php while($row = mysql_fetch_array($result)) : ?>
					<tr>
						<td style="width:10%"><?php echo $row['FORM_NAME']; ?></td>
						<td style="width:40%"><?php echo substr($row['FORM_DESC'],0,70).'...'; ?></td>
						<td style="width:20%"><?php echo $row['FORM_FORMULA']; ?></td>
						<td style="width:10%"><?php echo date('m-d-Y', strtotime($row['FORM_DATE']) ); ?></td>
						<td style="width:10%"><?php echo $row['USERNAME']; ?></td>
						<td style="width:10%"><?php echo $row['CATEGORYNAME']; ?></td>
					</tr>
					<?php endwhile; ?>
				</table>
			</div>
		</center>
	</div>
</body>
</html>
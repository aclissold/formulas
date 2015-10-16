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
				hi' <?php echo $userRow['USER_NAME']; ?>&nbsp;<a href="logout.php?logout">Sign Out</a>
			</div>
		</div>		
	</div>
	<div id="body">
		<?php $result = mysql_query("SELECT * FROM FORMULA"); ?>
		<center>
			<div id="formula-table" style="width: 80%; margin-top: 100px">
				<h2 style="color:#a5a5a5">All</h2>
				<table >
					<tr style="background:#a5a5a5">
						<td style="color:#ffffff"><b>Name</b></td>
						<td style="color:#ffffff"><b>Description</b></td>
						<td style="color:#ffffff"><b>Formula</b></td>
						<td style="color:#ffffff"><b>Date</b></td>
						<td style="color:#ffffff"><b>User Id</b></td>
						<td style="color:#ffffff"><b>Category Id</b></td>
					</tr>
					<?php while($row = mysql_fetch_array($result)) : ?>
					<tr>
						<td style="width:10%"><?php echo $row['FORM_NAME']; ?></td>
						<td style="width:40%"><?php echo substr($row['FORM_DESC'],0,70).'...'; ?></td>
						<td style="width:20%"><?php echo $row['FORM_FORMULA']; ?></td>
						<td style="width:10%"><?php echo date('m-d-Y', strtotime($row['FORM_DATE']) ); ?></td>
						<td style="width:10%"><?php echo $row['USER_ID']; ?></td>
						<td style="width:10%"><?php echo $row['CAT_ID']; ?></td>
					</tr>
					<?php endwhile; ?>
				</table>
			</div>
		</center>
	</div>
</body>
</html>
<?php
if(!mysql_connect("localhost","username","password"))
{
     die('oops connection problem ! --> '.mysql_error());
}
if(!mysql_select_db("databasename"))
{
     die('oops database selection problem ! --> '.mysql_error());
}
?>
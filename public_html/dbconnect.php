<?php
if(!mysql_connect("localhost","aaronmgiroux","oakland"))
{
     die('oops connection problem ! --> '.mysql_error());
}
if(!mysql_select_db("CSE345DATABASE"))
{
     die('oops database selection problem ! --> '.mysql_error());
}
?>
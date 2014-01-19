<?php
  //exit from managment (admin) page
  if(isset($_GET['logout']))
  {
	header('WWW-Authenticate:Basic realm="welcome to the admin system of online shop"'); 
	header('HTTP/1.0 401 Unauthorized'); 
	die("<H2>logout</h2>");
  }

 
  //http to login
  if ($_SERVER['PHP_AUTH_USER']==ADMIN_USER && $_SERVER['PHP_AUTH_PW']==ADMIN_PW)
  {
	; //login successfully
  } else {
    header('WWW-Authenticate:Basic realm="welcome to the admin system of online shop"'); 
    header('HTTP/1.0 401 Unauthorized'); 
    die("<H2>please input correct username and password!</h2>"); 
  }
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>online shop admin</title>
<style>
<!--
 /* Global Styles */
 body {background-color: #fff; font-size: 12px; margin: 0px;} 
 p {text-align: left;} 
 a {color: #336699;} 
 caption {font-size: 14px; font-weight: bold;}

 /* table format */
 TABLE.main {background: #999; border: 0px; font-size: 12px;} 
 TABLE.main TD {background-color: #FEFEFE; padding:2 5 5 2; height:20px;} 
 TABLE.main TH {background-color: #CCCCCC; padding-top: 4px; height: 22px;} 
 DIV.btnInsert {float: left; width:150px; border: #336699 solid 1px; padding: 5 0 5 0; background: #EFEFEF;} 
 DIV.submit {text-align: center; padding-top: 20px; height: 32px;} 
 DIV.error {text-align:left; background: #FFFFCC; border: #FF0000 solid 1px;} 
//-->
</style>
</head>
<body>
<br><center>
<div style="width:96%; text-align:center">
<!-- navigation bar -->
<h3 align=left>
 <a href="category.php">category management</a> |
 <a href="product.php">product management</a> |
 <a href="order.php">order management</a> |
 <a href="?logout">exit</a>
</h3>
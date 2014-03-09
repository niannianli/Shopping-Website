<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>online shop</title>
<style type="text/css">
 body { link=rgb(84,107,173) vlink=rgb(84,107,173) alink="red";}
 h2 { color:rgb(84,107,173) }
 li { margin-left: -1em; margin-right: -2em; color:rgb(84,107,173);}
 p { color: rgb(84,107,173); font-family: Tahoma, Helvetica, sans-serif;} 
 a {text-decoration:none; font-weight:bold; color:rgb(84,107,173);}
</style>
</head>
<body topmargin="0" leftmargin="0" buttommargin="0" rightmargin="0">
<table border="0" cellpadding="17" cellspacing="0" width="100%" height="100%">
  <tr>
  <td width="20%" bgcolor="#e7f0ff" valign="top">
  <!-- navigation bar on the right -->
	<img border=0 width=133 height=65 src="img/logo.gif">
	<!-- cart, show number of products -->
<?php
	//user identify
	$session_id = session_id();

	//query cart, number of products
	$sql = "SELECT SUM(number) FROM carts WHERE session_id='$session_id'";
	$result = mysql_query($sql);
	
	@$row = mysql_fetch_row($result);
     $number = intval($row[0]);	//number of products
?>
<!-- <b>cart has <a href="mycart.php"><font color=red><? echo $number ?></font></a> products</b> -->
<hr>
	<!-- cart end -->
<ul>
	<li><a href="index.php">homepage</a></li>
    <li><b>products list</b></li>
<ul>
<?php
	//list products catalog
	$sql = "SELECT * FROM categories ORDER BY category_name";
	$result = mysql_query($sql);
	if($result === FALSE) {
    die(mysql_error()); // TODO: better error handling
}
	while($row = mysql_fetch_array($result))
	{
		echo "<li><a href=\"list.php?catid=$row[category_id]\">";
		echo htmlspecialchars($row['category_name']);
		echo "</a></li>";
	}
?>
</ul>
      <li><a href="mycart.php">cart</a></li>
      <li><a href="checkout.php">checkout</a></li>
</ul>
  <!-- navigation bar on the right -->
　</td>
  <td width="80%" valign="top">
   	<!--begin para-->
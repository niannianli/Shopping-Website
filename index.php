<?php
  /*******************************/
  /*      file name:index.php      */
  /*      info:homepage       */
  /*******************************/
  include "config.inc.php";		//congigure
  include "header.inc.php";		//header
?>
<h2>homepage recommended</h2>
<?php
  
  //get products recommended in homepage
  $sql = "SELECT product_name, product_id, price, photo FROM products
  	    ORDER BY is_commend DESC, post_datetime DESC LIMIT 5";
  $result = mysql_query($sql);
?>
<!-- recommended begin -->
<table border="0" width="90%" cellpadding="4" cellspacing="1" bgcolor="#0066CC">
  <tr bgcolor="#e7f0ff">
  <?php
  	
	//output recommended products
  	while($data = mysql_fetch_array($result))
  	{
  		$product_id = $data['product_id'];							//product id
  		$product_name = htmlspecialchars($data['product_name']); 	//product_name
  		$photo = ($data['photo']) ? $data['photo']:'default.gif';	//image
  		$price = MoneyFormat($data['price']);						//price
  ?>
  <td align="center"><a href="show.php?product_id=<?php echo $product_id ?>" ?>
  	<img border=0 src="uploads/<?php echo $photo ?>" height=85 width=85>
  	<br><?php echo $product_name ?>
  	</a><br><font color="red">гд<?php echo $price ?></font>
  </td>
  <?php } ?>
  </tr>
</table>
<!-- recommended end -->

<h2>products list</h2>
<?php
  //get products catalog
  $sql = "SELECT * FROM categories ORDER BY category_name";
  $result = mysql_query($sql);

  //output products catalog
  while($row = mysql_fetch_array($result))
  {
?>
  <table border="0" width="100%" cellpadding="4" cellspacing="1" bgcolor="#0066CC">
    <tr bgcolor="#e7f0ff">
  	<th colspan="3" align="left">[*]
  	<?php
 
	//output products category_name with link
  	echo "<a href=\"list.php?catid=$row[category_id]\">";
  	echo htmlspecialchars($row['category_name']);
  	echo "</a>";
  	?></th>
    </tr>
<?php
 
	//get products info under this category
  	$sql2 = "SELECT product_name, product_id, price, is_commend FROM products
  		   WHERE category_id = '$row[category_id]'
  		   ORDER BY is_commend DESC, post_datetime DESC LIMIT 5";
  	$result2 = mysql_query($sql2);


	//output products info
  	while($row2 = mysql_fetch_array($result2))
  	{
?>
   <tr bgcolor="#FFFFFF">
  	<td width="5%"><?php echo $row2['product_id'] ?></td>
  	<td width="70%">
  	<?php if($row2['is_commend']){?>
  		<img src="img/star.gif" border=0 align="absmiddle">
  	<?php } ?>
	<a href="show.php?product_id=<?php echo $row2['product_id'] ?>">
		<?php echo htmlspecialchars($row2['product_name']) ?></a>
  	<a href="docart.php?product_id=<?php echo $row2['product_id'] ?>&action=addcart&number=1">
  		<img src="img/add.gif" border=0 align="absmiddle" height=15></a>
	</td>
	<td width="25%" align="right"><?php echo MoneyFormat($row2['price']) ?> $</td>
  </tr>
<?php
  	}//end 
  	$row2 = null;
?>
  	</table>
  	<br>
<?php
  }//end
  include "footer.inc.php";		//footer
?>
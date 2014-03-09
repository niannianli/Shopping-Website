<?php
  /************************************/
  /*      file name: show.php            */
  /*      information: product details   */
  /************************************/
  include "config.inc.php";		//configure file
  include "header.inc.php";		//header file

  $product_id = intval($_REQUEST['product_id']); 	//product id

  //get product data
  $result = mysql_query("SELECT p.*, c.* FROM products p
					JOIN categories c ON c.category_id = p.category_id
					WHERE p.product_id='$product_id'");
  $data = mysql_fetch_array($result);
?>
<form method="get" action="docart.php">
<h2>product detail</h2>
  <table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#0066CC">
    <tr>
      <th bgcolor="#e7f0ff" width="20%">product detail</th>
      <td bgcolor="#FFFFFF"><?php echo htmlspecialchars($data['category_name']) ?></td>
	</tr>
	<tr>
      <th bgcolor="#e7f0ff">product_name</th>
      <td bgcolor="#FFFFFF"><b><?php echo htmlspecialchars($data['product_name']) ?></b>
    			<?php if($data['is_commend']) echo "<font color=red>recommended!</font>" ?></td>
	</tr>
	<tr>
      <th bgcolor="#e7f0ff">product_image</th>
      <td bgcolor="#FFFFFF">
    	<?php if($data['photo']) { ?>
    		<img src="uploads/<?php echo $data['photo'] ?>" border="1" width="200"><br>
    	<?php } ?>
       </td>
	</tr>
	<tr>
      <th bgcolor="#e7f0ff">price</th>
      <td bgcolor="#FFFFFF">
      	<font color=red><?php echo MoneyFormat($data['price']) ?></font> $
		<input type="hidden" name="action" value="addcart">
		<input type="hidden" name="product_id" value="<?php echo $product_id ?>">	
		<input name="number" value="1" type="text" size=4 maxlength="2">
		<input type="submit" value="submit">&nbsp;<input type="image" src="img/buyit.gif" alt="order">
	  </td>
	</tr>
	<tr>
      <th bgcolor="#e7f0ff">detail</th>
      <td bgcolor="#FFFFFF"><?php echo nl2br(htmlspecialchars($data['detail'])) ?></td>
    </tr>
  </table>
</form>
<?php
  include "footer.inc.php";		//footer
?>
<?php
  /**********************************/
  /*      file name£ºmycart.php		*/
  /*      infor£ºcart detail     */
  /**********************************/
  include "config.inc.php";		//congif file
  include "header.inc.php";		//header file

  $session_id = session_id();  //user id
?>
<form action="upcart.php" method="post">
  <h2>cart</h2>
  <table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#0066CC">
    <tr bgcolor="#e7f0ff">
      <th>image</th>
      <th>product_name</th>
      <th>price</th>
      <th>number</th>
      <th>amount</th>
      <th>action</th>
    </tr>
    <?php
	//get detail record in cart
	$sql = "SELECT s.*, s.number*p.price AS amount, 
			p.product_id, p.product_name, p.price, p.photo FROM products p
		  JOIN carts s ON s.product_id=p.product_id
		  WHERE session_id='$session_id'
		  ORDER BY p.product_name DESC";
	$result = mysql_query($sql);
	@$numrows = mysql_num_rows($result);

	//any product in cart?
	if($numrows>0)
	{
		$total_price = 0; 
		
		//output shopping list
		while($data = mysql_fetch_array($result))
		{
			$id = $data['product_id']; 				//product ID
			$name = $data['product_name']; 			//product name
			$price = $data['price']; 				//price
			$number = $data['number']; 				//number
			$amount = $data['amount']; 				//amount
			$photo = ($data['photo']) 
				? $data['photo'] : 'default.gif'; 	//image

			$total_price +=$amount; 		 		//total_price
  ?>
    <tr align="center">
      <td bgcolor="#FFFFFF">
		<img src="uploads/<?php echo $photo ?>" width=100 height=50 border="0">
      </td>
      <td bgcolor="#FFFFFF">
		<a href="show.php?product_id=<?php echo $id ?>">
				<b><?php echo htmlspecialchars($name) ?></b></a> 
      </td>
      <td bgcolor="#FFFFFF"><?php echo MoneyFormat($price) ?> Ôª</td>
      <td bgcolor="#FFFFFF">
		<input type="text" name="p_<?php echo $id ?>" 
				value="<?php echo $number ?>" size=4 maxlength=3>
      </td>
      <td bgcolor="#FFFFFF"><?php echo MoneyFormat($amount) ?> Ôª</td>
      <td bgcolor="#FFFFFF">
		<input name="delete" type="button" value="cancel" onClick="if(confirm('sure to cancel this product?'))
		 location.href='docart.php?action=editcart&product_id=<?php echo $id ?>&number=0'">
      </td>
    </tr>
    <?php
		}
  ?>
    <!-- show total price-->
    <tr bgcolor="#e7f0ff">
      <td colspan="4" align="right"><strong>total_price</strong></td>
      <td colspan="2"><strong><?php echo MoneyFormat($total_price) ?> $</strong></td>
    </tr>
    <?php
  	}else{
	  ?>
	    <tr>
	      <td align="center" colspan="6" bgcolor="#FFFFFF">no product in cart</td>
	    </tr>
    <?
	}
  ?>
  </table>
  <p align="center">
    <input type="submit" name="update_cart" value="update cart">
    &nbsp;
    <input type="button" name="check_out" value="go to check out" onClick="location.href='checkout.php'">
  </p>
</form>
<?php
  include "footer.inc.php";		//footer
?>
<?php
  /*******************************/
  /*    filename:checkout2.php    */
  /*    infor:place order      */
  /*******************************/
  include "config.inc.php";		//configure
  include "header.inc.php";		//header file

  $session_id = session_id();				//usder id

  $order_id	= time();						//order_id
  $user_name	= $_POST['user_name'];		//user name
  $email		= $_POST['email'];			//email
  $postcode	= $_POST['postcode'];			//postcode
  $tel_no		= $_POST['tel_no'];			//tel_no
  $content 	= $_POST['content'];			//notes
  $address	= $_POST['address1'] . $_POST['address2']; 	//address
?>
<h2>order information</h2>
<h3>order_id£º<font color=red>M<?php echo $order_id ?></font></h3>
<table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#0066CC">
  <tr bgcolor="#e7f0ff">
    <th>product_name</th>
    <th>price</th>
    <th>number</th>
    <th>amount</th>
  </tr>
  <?php
	//get records in the cart
	$sql = "SELECT s.*, s.number*p.price AS amount, 
				p.product_id, p.product_name, p.price, p.photo FROM products p
			JOIN carts s ON s.product_id=p.product_id
			WHERE session_id='$session_id'
			ORDER BY p.product_name DESC";
	$result = mysql_query($sql);
	$numrows = mysql_num_rows($result);

	//product exits?
	if($numrows>0)
	{
		$total_price = 0;
	
		//output data
		while($data = mysql_fetch_array($result))
		{
			$id = $data['product_id'];				//product id
			$name = $data['product_name'];			//product name
			$price = $data['price'];				//price
			$number = $data['number'];				//number
			$amount = $data['amount'];				//amount
			$photo = ($data['photo']) 
				? $data['photo'] : 'default.gif';	//image
			$total_price +=$amount;					//total price
  ?>
  <tr align="center" bgcolor="#FFFFFF">
    <td><a href="show.php?product_id=<?php echo $id ?>"> 
		<b><?php echo htmlspecialchars($name) ?></b></a></td>
    <td><?php echo MoneyFormat($price) ?> $</td>
    <td><?php echo $number ?></td>
    <td><?php echo MoneyFormat($amount) ?> $</td>
  </tr>
  <?php
		}//endwhile
  ?>
  <tr bgcolor="#e7f0ff">
    <td colspan="3" align="right"><strong>total_price</strong></td>
    <td><strong><?php echo MoneyFormat($total_price) ?> $</strong></td>
  </tr>
  <?php
  	}else{
	  ?>
		<tr>
		  <td align="center" colspan="4" bgcolor="#FFFFFF">no product in cart</td>
		</tr>
	  <?
	}
  ?>
</table>
<?php
  //insert order to database
  if($total_price)
  {
	$sql = "INSERT INTO orders 
			(order_id, session_id, total_price, user_name, email, address, postcode, tel_no, content)
		  VALUES ('$order_id', '$session_id', '$total_price', '$user_name', 
			'$email', '$address' , '$postcode', '$tel_no', '$content');";
	
	mysql_query($sql);
  }

  //get again session_id;
  session_regenerate_id();
  session_write_close();
  $new_sessionid = session_id();

  include "footer.inc.php";		//footer
?>
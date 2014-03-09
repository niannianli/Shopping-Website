<?php
  /**************************************/
  /*    filename: admin/order_show.php    */
  /*    infor: order list              */
  /**************************************/
 include "../config.inc.php";	//config file
 // include "config.inc.php";	//configure file
  include "header.inc.php";	//admin header file

  $order_id = intval($_GET['order_id']);

  //get session_id
  $sql = "SELECT * FROM orders WHERE order_id='$order_id'";
  $result = mysql_query($sql);
  $order = mysql_fetch_array($result);
  $session_id	= $order['session_id'];

	//get cart infor
	$sql = "SELECT s.*, s.number*p.price AS amount, 
				p.product_id, p.product_name, p.price, p.photo FROM products p
		  JOIN carts s ON s.product_id=p.product_id
		  WHERE session_id='$session_id'
		  ORDER BY p.product_name DESC";
	$result = mysql_query($sql);

	//amount of shopping
	$numrows = mysql_num_rows($result);
?>
<table width="100%" class="main" cellspacing="1">
  <caption>
  order detail
  </caption>
  <tr>
    <th>product_name</th>
    <th>price</th>
    <th>number</th>
    <th>amount</th>
  </tr>
  <?php
	if($numrows>0)
	{
		$total_price = 0;
		while($data = mysql_fetch_array($result))
		{
			$id = $data['product_id'];			//product ID
			$name = $data['product_name'];	//product name
			$price = $data['price'];			//price
			$number = $data['number'];		//number
			$amount = $data['amount'];		//amount
			$photo = ($data['photo']) ? $data['photo'] : 'default.gif';

			$total_price +=$amount;
  ?>
  <tr align="center">
    <td><a href="../show.php?product_id=<?php echo $id ?>" target="_blank"> <b><?php echo htmlspecialchars($name) ?></b></a></td>
    <td><?php echo MoneyFormat($price) ?> $</td>
    <td><?php echo $number ?></td>
    <td><?php echo MoneyFormat($amount) ?> $</td>
  </tr>
  <?php
		}//endwhile
  ?>
  <tr>
    <td colspan="3" align="right"><strong>total_price</strong></td>
    <td><strong><?php echo MoneyFormat($total_price) ?> $</strong></td>
  </tr>
  <?php
  	}else{
	  ?>
  		<tr>
			<td align="center" colspan="4">no product</td>
		</tr>
  	  <?php
	}
  ?>
</table>
<p><hr></p>
<table border="0" class="main" cellspacing="1" width="60%">
  <caption>
  client infor
  </caption>
  <tr>
    <th align="right">user_name</th>
    <td><?php echo htmlspecialchars($order["user_name"]) ?></td>
  </tr>
  <tr>
    <th align="right">emal</th>
    <td><?php echo htmlspecialchars($order["email"]) ?></td>
  </tr>
  <tr>
    <th align="right">address</th>
    <td><?php echo htmlspecialchars($order["address"]) ?></td>
  </tr>
  <tr>
    <th align="right">postcode</th>
    <td><?php echo htmlspecialchars($order["postcode"]) ?></td>
  </tr>
  <tr>
    <th align="right">tel_no</th>
    <td><?php echo htmlspecialchars($order["tel_no"]) ?></td>
  </tr>
  <tr>
    <th align="right">notes</th>
    <td><?php echo nl2br(htmlspecialchars($order["content"])) ?></td>
  </tr>
</table>
<p>
</body>
</html>
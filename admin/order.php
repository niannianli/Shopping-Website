<?php
  /*********************************/
  /*    filename: admin/order.php    */
  /*    infor: order list        */
  /*********************************/
 include "../config.inc.php";	//config file
  //include "config.inc.php";	//configure file
  include "header.inc.php";		//admin header

  $each_page = EACH_PAGE;				//the biggest number of orders to show in this page
  $offset = intval($_GET['offset']);	//offset
?>
<br>
<table width="100%" class="main" cellspacing="1">
  <caption>order admin</caption>
  <tr>
    <th>order id</th>
    <th>order user</th>
    <th>total_price</th>
    <th>date</th>
    <th width="20%">detail</th>
  </tr>
  <?php
	//total number of orders
	$sql = "SELECT Count(*) FROM orders";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);
	$total = $row[0];

	//$offset
	if($offset<0)
		$offset = 0;
	elseif($offset > $total)
		$offset = $total;

	//order list
	$sql = "SELECT total_price, order_id, user_name FROM orders 
		  ORDER BY order_id DESC LIMIT $offset, $each_page";
	$result = mysql_query($sql);
	$numrows = mysql_num_rows($result);

	if($numrows>0)
	{
		//output data
		while($data = mysql_fetch_array($result))
		{
			$order_id = $data['order_id'];
			$user_name = $data['user_name'];
			$total_price = $data['total_price'];
  ?>
  <tr align="center">
    <td>M<?php echo $order_id ?></td>
    <td><?php echo htmlspecialchars($user_name) ?></td>
    <td><?php echo MoneyFormat($total_price) ?> $</td>
    <td><?php echo date("Y-m-d H:i", $order_id) ?></td>
    <td><input name="update" type="button" value="detail"
		 onclick="location.href='order_show.php?order_id=<?php echo $order_id ?>'" />
    </td>
  </tr>
  <?php
		}//endwhile 
  	}else{
	  ?>
  		<tr>
			<td align="center" colspan="4">no product</td>
		</tr>
  	  <?php
	}
  ?>
</table>
<p>total<font color=red><b><?php echo $total ?></b></font> recordes &nbsp;<b>
<?php
  //prepare for a single related page
  $last_offset = $offset - $each_page;
  if($last_offset<0)
  {
	?>previous<?php
  }else{
	?><a href="?offset=<?php echo $last_offset ?>&catid=<?php echo $category_id ?>">previous</a><?
  }
  echo " &nbsp; ";

  $next_offset = $offset + $each_page;
  if($next_offset>=$total)
  {
	?>next<?
  }else{
	?><a href="?offset=<?php echo $next_offset ?>&catid=<?php echo $category_id ?>">next</a><?
  }
?>
  </b></p>
</body>
</html>
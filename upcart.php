<?php
  /**************************************/
  /*    file name£ºupcart.php              */
  /*    infor£ºupdate all products in cart   */
  /**************************************/
  require_once 'config.inc.php';	//configure file

  $session_id = session_id();		//tell user by id

  //update all records
  if($_POST['update_cart'])
  {

	//update every record in cart
	foreach($_POST as $key=>$number)
	{
	  //separate from $ key, get product id
	  list($null, $product_id) = split("_",$key);
	  
	  //update cart
	  //if $number>0, update product number
	  //or, delete the product
	  if($number>0)
	  {
		$sql = "UPDATE carts SET number=$number
				WHERE session_id='$session_id' AND product_id='$product_id'";
	  }
	  else
	  {
		$sql = "DELETE FROM carts
				WHERE session_id='$session_id' AND product_id='$product_id'";
	  }
	  @$result = mysql_query($sql);
	}
  }

  //empty cart
  elseif($_POST['clear_cart'])
  {
	//delete all records in cart
	$sql = "DELETE FROM carts WHERE session_id='$session_id'";
	@$result = mysql_query($sql);
  }

  //go to cart page
  header("Location: mycart.php");
  exit();
?>
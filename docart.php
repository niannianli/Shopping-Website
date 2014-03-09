<?php
  /**************************************/
  /*    file name: docart.php			    */
  /*    info: update product in cart    */
  /**************************************/
  require_once 'config.inc.php';	//configure

  $session_id = session_id();					//user session_id
  $product_id = intval($_GET['product_id']);	//product_id
  $number = intval($_GET['number']);			//number of buying products
  $action = $_GET['action'];					//action


  //get product record
  $sql = "SELECT number FROM carts 
		WHERE session_id='$session_id' and product_id='$product_id'";
  $result = mysql_query($sql);
  //$row = mysql_fetch_row($result);
@$row = mysql_fetch_row($result);
  if($row)
  {
	$old_number = intval($row[0]);	//original number of products
	$have_product = true;			//product in cart
  }else{
	$old_number = 0;
	$have_product = false;			//product inot in cart
 }

 //add cart
 if($action == 'addcart') 
 {
	$new_number = $old_number + $number;

	if($new_number>0) 
	{
		if($have_product) 
		{
		
			//product exist, update 	$new_number
			$sql = "UPDATE carts SET number=$new_number
					WHERE session_id='$session_id' AND product_id='$product_id'";	
		}
		else
		{
			
			//product not exist, insert to $new_number
			$sql = "INSERT INTO carts (session_id, product_id, number)
					VALUES('$session_id', '$product_id', '$new_number')";
		}
	}
	else
	{
		
		//number<=0, delete product
		$sql = "DELETE FROM carts
				WHERE session_id='$session_id' AND product_id='$product_id'";
	}
	$result = mysql_query($sql);
  }

  /* update cart */
  elseif($action == 'editcart') {
	if($number>0)
	{
		
		//if >0, update $number
		$sql = "UPDATE carts SET number=$number
				WHERE session_id='$session_id' AND product_id='$product_id'";	
	}
	else
	{
		
		//if not >0, delete the product
		$sql = "DELETE FROM carts
				WHERE session_id='$session_id' AND product_id='$product_id'";
	}
	$result = mysql_query($sql);
  }

  //go to cart page
  header("Location: mycart.php");
  exit();
?>
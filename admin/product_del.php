<?php
  /***************************************/
  /*    filename: admin/product_del.php    */
  /*    infor: delete product            */
  /***************************************/
 include "../config.inc.php";		//configure file
 // include "config.inc.php";	//configure file
  include "header.inc.php";			//admin header file

  $product_id = $_GET['product_id'];	//product id

  //get image
  $sql = "SELECT photo FROM products WHERE product_id='$product_id'";
  $result = mysql_query($sql);
  $row  = mysql_fetch_row($result);	
  $photo = $row[0];

  //delete record
  $sql = "DELETE FROM products WHERE product_id='$product_id'";
  $result = mysql_query($sql);

  if(mysql_affected_rows($db)>0)
  {
	//delete image
	@unlink(UPLOAD_PATH.$photo);
	$error_msg = "product contents deleted";
  }else{
	$error_msg = "fail to delete product contents";
  }

  ExitMessage($error_msg);
?>
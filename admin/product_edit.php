<?php
  /******************************************/
  /*	  file name: admin/product_edit.php	*/
  /*	  infor: edit product		    */
  /******************************************/
  include "../config.inc.php";	//config file
  // include "config.inc.php";	//configure file
  include "header.inc.php";		//admin header file

  $product_id = intval($_REQUEST['product_id']);	//product id

  if($_POST['submit'])
  {
	$error_msg = array();
	if(empty($_POST['category_id'])){
		$error_msg[] = "please select product category";
	}

	if(empty($_POST['product_name'])){
		$error_msg[] = "please input product name";
	}
	
	if(empty($_POST['price'])){
		$error_msg[] = "please input price";
	}elseif(!is_numeric($_POST['price'])){
		$error_msg[] = "price must be numbers";	
	}

	if($_FILES['photo']['size']>0 && $_FILES['photo']['name'])
	{
		if(!($_FILES['photo']['type']=='image/gif' || $_FILES['photo']['type']=='image/pjpeg'))
		{
			$error_msg[] = "images must be .gif or .jpeg";
		}
		else
		{
			list($tmp,$file_ext) = explode("/",$_FILES['photo']['type']);
			$photo_name = mt_rand()."_".time().".".$file_ext;
			if(!move_uploaded_file($_FILES['photo']['tmp_name'], UPLOAD_PATH.$photo_name))
			{
				$error_msg[] = "fail to save image";
			}
		}
	}
	else
	{
		$photo_name = $_POST['old_photo'];
	}
	$photo = $photo_name;

	if(empty($_POST['detail']))
	{
		$error_msg[] = "input details";
	}

	$has_error = isset($error_msg[0]);		//set sign to tell true or false
	if(!$has_error)
	{
		//insert data to database
		$sql = "UPDATE products	SET
				category_id='".$_POST['category_id']."',
				product_name='".$_POST['product_name']."',
				price='".$_POST['price']."',
				detail='".$_POST['detail']."',
				is_commend='".$_POST['is_commend']."',
				photo='$photo_name'
			   WHERE product_id='$product_id'";
		$result = mysql_query($sql);
		
		
		//how many records are updated
		if(mysql_affected_rows($db)>=0)
		{
			ExitMessage("product contents modified", "product.php?catid={$_POST[category_id]}");
		}else{
			ExitMessage("fail to modify product contents");
		}
	}
  }else{
	//get product record
	$result = mysql_query("SELECT * FROM products WHERE product_id='$product_id'");
	$data = mysql_fetch_array($result);
	$_POST = $data;
	$photo = $data['photo'];
	$product_id = $data['product_id'];
  }

  
  //one error, output hint infor
  if($has_error)
  {
	showErrorBox($error_msg);
  }
?>
<form method="post" action="product_edit.php" enctype="multipart/form-data">
  <input type="hidden" name="product_id" value="<?php echo $product_id ?>">
  <table width="100%" class="main" cellspacing="1">
    <caption>edit product</caption>
    <tr>
      <th>product category<font color="red">(*)</font></th>
      <td><select name="category_id">
          <option value="0">select product category</option>
          <?php echo optionCategories($_POST['category_id']) ?>
        </select>
	 </td>
    </tr>
    <tr>
      <th>product_name<font color="red">(*)</font></th>
      <td><input name="product_name" value="<?php echo html2text($_POST['product_name']) ?>"
	  		type="text" size="35" maxlength="20">
	 </td>
    </tr>
    <tr>
      <th>price<font color="red">(*)</font></th>
      <td><input name="price" value="<?php echo html2text($_POST['price']) ?>"
	  		type="text" size="12" maxlength="20">
        $</td>
    </tr>
    <tr>
      <th>products recommended</th>
      <td><input name="is_commend" type="checkbox" value="1" 
				<?php if($_POST['is_commend']) echo "checked" ?>>
	 </td>
    </tr>
    <tr>
      <th>product_image</th>
      <td><?php if($photo) { ?>
        <img src="../uploads/<?php echo $photo ?>" border="1" width="100" height="80"><br>
        <input type="hidden" name="old_photo" value="<?php echo $photo ?>">
        <?php } ?>
        <input name="photo" type="file" size="50"></td>
    </tr>
    <tr>
      <th>detail<font color="red">(*)</font></th>
      <td><textarea name="detail" rows="10" cols="50">
		<?php echo html2text($_POST['detail']) ?></textarea></td>
    </tr>
  </table>
  <div class="submit">
    <input name="submit" type="submit" id="submit" value=" edit ">
    <input name="return" type="button" value=" back " onClick="location.href='product.php'">
  </div>
</form>
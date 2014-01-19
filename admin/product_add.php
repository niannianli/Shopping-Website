<?php
  /***************************************/
  /*    file name£ºadmin/product_add.php    */
  /*    infor£ºadd product               */
  /***************************************/
  include "../config.inc.php";	//configue file
  include "header.inc.php";		//admin header

  if($_POST['submit'])
  {
	$error_msg = array();
	if(empty($_POST['category_id'])){
		$error_msg[] = "please select category";
	}
	if(empty($_POST['product_name'])){
		$error_msg[] = "please input product name";
	}
	if(empty($_POST['price'])){
		$error_msg[] = "please input product price";
	}elseif(!is_numeric($_POST['price'])){
		$error_msg[] = "product price must be numbers";	
	}

	if($_FILES['photo']['size']>0 && $_FILES['photo']['name'])
	{
		if(!($_FILES['photo']['type']=='image/gif' || $_FILES['photo']['type']=='image/pjpeg'))
		{
			$error_msg[] = "product images must in .gif or .jpeg";
		}else{
			list($tmp,$file_ext) = explode("/",$_FILES['photo']['type']);
			$photo_name = mt_rand()."_".time().".".$file_ext;
			if(!move_uploaded_file($_FILES['photo']['tmp_name'], UPLOAD_PATH.$photo_name))
			{
				$error_msg[] = "fail to save product image";
			}
		}
	}

	if(empty($_POST['detail']))
	{
		$error_msg[] = "please input details for the product";
	}

	//set a sign to tell true or false
	$has_error = isset($error_msg[0]); 
	if(!$has_error)
	{
		//insert data to database
		$sql = "INSERT INTO products(category_id , product_name, price, detail, is_commend,
						 photo, post_datetime)
			    VALUES('".$_POST['category_id']."',
					   '".$_POST['product_name']."',
					   '".$_POST['price']."',
					   '".$_POST['detail']."',
					   '".intval($_POST['is_commend'])."',
					   '$photo_name', NOW())";
		$result = mysql_query($sql);
	
		//how much records are inserted
		if(mysql_affected_rows($db))
		{
			ExitMessage("products content added", "product.php?catid={$_POST[category_id]}");
		}else{
			ExitMessage("fail to add products content");
		}
	}
  }

  //one error, output hint infor
  if($has_error)
  { 
	showErrorBox($error_msg);
  }

  //get product id
  if(!isset($_POST['category_id']))
  {
	$_POST['category_id'] = $_GET['catid'];
  }
?>
<form method="post" action="product_add.php" enctype="multipart/form-data">
  <table width="100%" class="main" cellspacing="1">
    <caption>
   add  new product
    </caption>
    <tr>
      <th>product_category<font color="red">(*)</font></th>
      <td><select name="category_id">
          <option value="0">select product category</option>
          <?php echo optionCategories($_POST['category_id']) ?>
        </select></td>
    </tr>
    <tr>
      <th>product <font color="red">(*)</font></th>
      <td><input name="product_name" value="<?php echo html2text($_POST['product_name']) ?>"
	  		type="text" size="35" maxlength="20"></td>
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
				<?php if($_POST['is_commend']) echo "checked" ?>></td>
    </tr>
    <tr>
      <th>product image</th>
      <td><input name="photo" type="file" size="50" /></td>
    </tr>
    <tr>
      <th>details<font color="red">(*)</font></th>
      <td><textarea name="detail" rows="10" cols="50">
		<?php echo html2text($_POST['detail']) ?></textarea></td>
    </tr>
    <tr>
      <th>&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
  </table>
  <div class="submit">
    <input name="submit" type="submit" id="submit" value=" create new ">
    <input name="return" type="button" value=" back " onClick="location.href='catalog.php'">
  </div>
</form>

</body>
</html>
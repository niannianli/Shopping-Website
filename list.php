<?php
  /********************************/
  /*	  file name: list.php	      */
  /*	  infor: category list  */
  /********************************/
  include "config.inc.php";		//configure
  include "header.inc.php";		//header

  $each_page = EACH_PAGE;		  			//maximum records in one page
  $offset = intval($_GET['offset']);		//offset
  $category_id = intval($_GET['catid']);	//category id
?>
<h2>products list</h2>
select product category
<select name="catid" onChange="location='?catid='+this.options[this.selectedIndex].value">
 <option value="0">select product category</option>
<?php echo OptionCategories($category_id) ?>
</select>
<br><br>
<table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#0066CC">
  <tr bgcolor="#e7f0ff">
	<th>image</th>
	<th>product_name</th>
	<th>price</th>
	<th>action</th>
  </tr>
  <?php
  //total records
	
	$sql = "SELECT Count(*) FROM products WHERE category_id='$category_id'";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);
	$total = $row[0];	 //total number of products

	//$offset
	if($offset<0)			$offset = 0;
	elseif($offset > $total)	$offset = $total;

	
	//get products list
	$sql = "SELECT product_id, product_name, photo, price FROM products 
		  WHERE category_id='$category_id'
		  ORDER BY post_datetime DESC LIMIT $offset, $each_page";
	$result = mysql_query($sql);
	$numrows = mysql_num_rows($result);

	//number of records
	if($numrows>0)
	{
		
		//products list
		while($data = mysql_fetch_array($result))
		{
			$id = $data['product_id']; 				//product id
			$name = $data['product_name']; 			//product name
			$price = MoneyFormat($data['price']); 	//price
			$photo = ($data['photo']) 
				? $data['photo'] : 'default.gif'; 	//image
  ?>
  <tr align="center" bgcolor="#FFFFFF">
	<td><img src="uploads/<?php echo $photo ?>" width=85></td>
	<td><a href="show.php?product_id=<?php echo $id ?>">
			<b><?php echo htmlspecialchars($name) ?></b></a></td>
	<td><?php echo $price ?> $</td>
	<td><input name="update" type="button" value="buy now"
		 onclick="location.href='docart.php?action=addcart&product_id=<?php echo $id ?>&number=1'">
	</td>
  </tr>
  <?php
		}//endwhile
  	}else{
	  ?><tr bgcolor="#FFFFFF">
		<td colspan="4" align="center">no product in this category</td>
		</tr>
	   <?
	}
  ?>
</table>

<p>total <font color=red><b><?php echo $total ?></b></font> records&nbsp;<b>
<?php
  
  //output previous page
  $last_offset = $offset - $each_page;
  if($last_offset<0)
  {
	?>previous<?
  }else{
	?><a href="?offset=<?php echo $last_offset ?>&catid=<?php echo $category_id ?>">previous</a><?
  }

  echo " &nbsp; ";


  //output next page
  $next_offset = $offset + $each_page;
  if($next_offset>=$total)
  {
	?>next<?
  }else{
	?><a href="?offset=<?php echo $next_offset ?>&catid=<?php echo $category_id ?>">next</a><?
  }
?>
</b>
</p>
<?php
  include "footer.inc.php";		//footer
?>
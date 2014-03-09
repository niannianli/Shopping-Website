<?php
  /***********************************/
  /*    file name: admin/product.php    */
  /*    infor: add product list       */
  /***********************************/
  include "../config.inc.php";	//configure file
 // include "config.inc.php";	//configure file
  include "header.inc.php";	//admin header file

  $each_page = EACH_PAGE;			//records in every page
  $offset = intval($_GET['offset']);			//offset
  $category_id = intval($_GET['catid']);		//product_category
?>
<div class="btnInsert"> 
  <a href="product_add.php?catid=<?php echo $category_id ?>">add new product</a> 
</div>
select product category
<select name="catid" onChange="location='?catid='+this.options[this.selectedIndex].value">
  <option value="0">select product category</option>
  <?php echo optionCategories($category_id) ?>
</select>
<br>
<br>
<table width="100%" class="main" cellspacing="1">
  <caption>products admin</caption>
  <tr>
    <th>ID</th>
    <th>product_name</th>
    <th>price</th>
    <th>action</th>
  </tr>
  <?php
	//records total
	$sql = "SELECT Count(*) FROM products WHERE category_id='$category_id'";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);
	$total = $row[0];

	//$offset
	if($offset<0)			$offset = 0;
	elseif($offset > $total)	$offset = $total;

	$result = mysql_query($sql);

	
	//inquery record
	$sql = "SELECT product_id, product_name, price FROM products 
		  WHERE category_id='$category_id' ORDER BY post_datetime DESC
		  LIMIT $offset, $each_page";
	$result = mysql_query($sql);
	$numrows = mysql_num_rows($result);

	if($numrows>0)
	{
		
		//output data
		while($data = mysql_fetch_array($result))
		{
			$id = $data['product_id'];
			$name = $data['product_name'];
			$price = $data['price'];
  ?>
  <tr align="center">
    <td><?php echo $id ?></td>
    <td>
	<a href="product_edit.php?product_id=<?php echo $id ?>">
		 <?php echo htmlspecialchars($name) ?></a>
    </td>
    <td><?php echo MoneyFormat($price) ?> $</td>
    <td><input name="update" type="button" value="edit"
		 onclick="location.href='product_edit.php?product_id=<?php echo $id ?>'">
	 &nbsp;
      <input name="delete" type="button" value="delete" onClick="if(confirm('are you sure to delete this product?'))
		 location.href='product_del.php?product_id=<?php echo $id ?>'">
	</td>
  </tr>
  <?php
		}//endwhile
  	}else{
  		?>
		  <tr>
		    <td align="center" colspan="4">no product in this category</td>
		  </tr>
		<?
	}
  ?>
</table>
<p>total <font color=red><b><?php echo $total ?></b></font> records &nbsp;<b>
<?php
  //prepare for a single related page
  $last_offset = $offset - $each_page;
  if($last_offset<0){
	?>previous<?
  }else{
	?><a href="?offset=<?php echo $last_offset ?>&catid=<?php echo $category_id ?>">previous</a><?
  }

  echo " &nbsp; ";

  $next_offset = $offset + $each_page;		
  if($next_offset>=$total)
  {
	?>next<?
  }else{
	?><a href="?offset=<?php echo $next_offset ?>&catid=<?php echo $category_id ?>">next</a> <?
  }
?>
  </b></p>
</body>
</html>
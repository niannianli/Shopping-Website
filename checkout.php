<?php
  /*************************************/
  /*    file name:checkout.php           */
  /*    infor:client infor fill page  */
  /*************************************/
  include "config.inc.php";		//configure file
  include "header.inc.php";		//header file

  $session_id = session_id();	//user id


  //get cart infor
  $sql = "SELECT s.*, s.number*p.price AS amount, 
		p.product_id, p.product_name, p.price, p.photo FROM products p
		JOIN carts s ON s.product_id=p.product_id
		WHERE session_id='$session_id'
		ORDER BY p.product_name DESC";
  @$result = mysql_query($sql);


  //number of records
  @$numrows = mysql_num_rows($result);

  
  //no record, back to cart page
  if(!$numrows)
  {
	header("Location: mycart.php");
	exit();
  }
?>
<script language="JavaScript" type="text/javascript">
<!--
  function checkit ( form )
  {
	if (form.user_name.value =='') {	alert('user name must be provided'); return false;}
	else if (form.email.value =='') { alert('email must be provided');	 return false;}
	else if (form.address1.value =='') { alert('address must be provide'); return false;}
	else if (form.tel_no.value =='') {alert('tel_no must be provided'); return false;}
	return true;
  }
//-->
</script>

<form name="" action="checkout2.php" method="POST" onSubmit="return checkit(this)">
  <h2>personal information</h2>
  <table border="0" cellpadding="4" cellspacing="1" bgcolor="#0066CC">
    <tr>
      <th align="right" bgcolor="#e7f0ff">user name</th>
      <td bgcolor="#FFFFFF">
		<input name="user_name" type="text" id="user_name" size="40" maxlength="20">
	 </td>
    </tr>
    <tr>
      <th align="right" bgcolor="#e7f0ff">email</th>
      <td bgcolor="#FFFFFF"><input name="email" type="text" size="40" maxlength="40"></td>
    </tr>
    <tr>
      <th align="right" bgcolor="#e7f0ff">address to deliver to</th>
      <td bgcolor="#FFFFFF"><input type="text" name="address1" size="40"></td>
    </tr>
    <tr>
      <th align="right" bgcolor="#e7f0ff">address2</th>
      <td bgcolor="#FFFFFF"><input type="text" name="address2" size="40"></td>
    </tr>
    <tr>
      <th align="right" bgcolor="#e7f0ff">postcode</th>
      <td bgcolor="#FFFFFF"><input name="postcode" type="text" id="postcode" maxlength="6"></td>
    </tr>
    <tr>
      <th align="right" bgcolor="#e7f0ff">tel_no</th>
      <td bgcolor="#FFFFFF"><input name="tel_no" type="text" id="tel_no" maxlength="20"></td>
    </tr>
    <tr>
      <th align="right" bgcolor="#e7f0ff">notes</th>
      <td bgcolor="#FFFFFF"><textarea name="content" cols="40" rows="5"></textarea></td>
    </tr>
  </table>
  <p>must fill user information to get the products you ordered.</p>
  <p>
    <input type="submit" value=" place order ">
  </p>
</form>
<h2>cart</h2>
<table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#0066CC">
  <tr bgcolor="#e7f0ff">
    <th>product_name</th>
    <th>price</th>
    <th>number</th>
    <th>amount</th>
  </tr>
  <?php
	if($numrows>0) {
		$total_price = 0;
	
		//output
		while($data = mysql_fetch_array($result))
		{
			$id = $data['product_id'];					//product_id
			$name = $data['product_name'];				//product_name
			$price = $data['price'];					//price
			$number = $data['number'];					//number
			$amount = $data['amount'];					//amount
			$photo = ($data['photo']) 
					? $data['photo'] : 'default.gif';	//image
			$total_price +=$amount;						//total_price
  ?>
  <tr align="center" bgcolor="#FFFFFF">
    <td><a href="show.php?product_id=<?php echo $id ?>">
			 <b><?php echo htmlspecialchars($name) ?></b></a>
    </td>
    <td><?php echo MoneyFormat($price) ?> $</td>
    <td><?php echo $number ?></td>
    <td><?php echo MoneyFormat($amount) ?> $</td>
  </tr>
  <?php
		}//endwhile
  ?>
  <tr bgcolor="#e7f0ff">
    <td colspan="3" align="right"><strong>total price</strong></td>
    <td><strong><?php echo MoneyFormat($total_price) ?> $</strong></td>
  </tr>
  <?php
  	}else{
	  ?>
	  <tr>
	    <td align="center" colspan="4" bgcolor="#FFFFFF">in product in cart</td>
	  </tr>
  <?
	}
  ?>
</table>
<?php
  include "footer.inc.php";		//footer
?>
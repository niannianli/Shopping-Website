<?php
	/**********************/
	/*    system parameter setting    */
	/**********************/

	//database
	define('DB_USER',		 "root");		//user name
	define('DB_PASSWORD',	 "lilian");		//password
	define('DB_HOST',		 "localhost");	//localhost
	define('DB_NAME',		 "php_shop");	//database name

	//administration
	define('ADMIN_USER',	"admin");
	define('ADMIN_PW',		"admin");

	
	//records in every page
	define('EACH_PAGE',	 5);

	//file upload path
	define('UPLOAD_PATH',dirname(__FILE__)."/uploads/");

	/**********************/
	/*    public function setting    */
	/**********************/

	//function: show error infor, back page, end programm
	//input: error infor, link
	//output: error info
	function ExitMessage($message, $url='')
	{
		echo '<p class="message">'. $message. '<br>';
		if($url){
		    	echo '<a href="'.$url.'">back</a>';
		}else{
			echo '<a href="#" onClick="window.history.go(-1);">back</a>';
		}
		echo '</p>';
		exit;
	}


	//function: admin, show error
	//input: error info array
	//output: error info
	function ShowErrorBox($error)
	{
		if(!is_array($error)){
			$error = array($error);
		}
		$error_msg = '<ul>';
		foreach($error as $err){
			$error_msg .= "<li>$err</li>";
		}
		$error_msg .= '</ul>';
		echo '<div class="error">' .$error_msg. '</div>';
	}

	
	//function: show category list
	//input: error info, link
	//output:char, string
	function OptionCategories($selected_id=0)
	{
		global $db;
		$sql = "SELECT * FROM categories ORDER BY category_name";
		$result=mysql_query($sql);
		while ($row=mysql_fetch_array($result))
		{
		  $category_id=$row["category_id"];
		  $category_name=htmlspecialchars($row["category_name"]);

		  if($selected_id == $category_id)
		  {
			echo '<option value="'.$category_id.'" selected>'.$category_name.'</option>';
		  }else{
			echo '<option value="'.$category_id.'">'.$category_name.'</option>';
		  }
		}
	}

	
	//html
	//input: html
	//output: string
	function Html2Text($html)
	{
		return htmlspecialchars(stripslashes($html));
	}

	
	//char
	//price
	//, string
	function MoneyFormat($price)
	{
		return number_format($price, 2, '.', ',');
	}

	/********************/
	/*    initial program   */
	/********************/

	//start SESSION
	@session_start();

	//connect database
	$db = mysql_pconnect(DB_HOST, DB_USER, DB_PASSWORD);
	if (!$db) 
	{
	   die('<b>fail to connect database.</b>');
	   exit;
	}
	//select database
	mysql_select_db (DB_NAME);
?>
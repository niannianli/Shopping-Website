<?php
  /*****************************************/
  /*    filename£ºadmin/category_edit.php    */
  /*    comment£ºproducts category management page          */
  /*****************************************/
  include "../config.inc.php";	//config file
  include "header.inc.php";		//header file for management

  $action = $_POST['action'];					//action
  $category_name = $_POST['category_name'];		//category_name
  $category_id = $_POST['category_id'];			//category_id

  
  //add category_name
  if($action == 'addcat')
  {
  	if(empty($category_name)) {
  		ExitMessage("input category name£¡");
  	}

	//category_name same?
  	$sql = "SELECT * FROM categories WHERE category_name='$category_name'";
  	$result = mysql_query($sql);

  	if(mysql_num_rows($result)>0)
	{
  		
		//category_name exist, print error infor
  		ExitMessage("category name exist, please choose another name£¡");
  	}
	else
	{
		//category name not exist, add new category
  		$sql = "INSERT INTO categories (category_name) VALUES('$category_name')";
  		$result = mysql_query($sql);
  		ExitMessage("new category added£¡", "category.php");
  	}
  }


  //modify category name
  elseif($action == 'rencat')
  {
  	
	//not choose category to modify
  	if(empty($category_id)) {
  		ExitMessage("please choose the category to modify£¡");
  	}	
  
	//not input new category name
  	elseif(empty($category_name))	{
  		ExitMessage("please input new category name £¡");
  	}

  	//new category nama exists?
  	$sql = "SELECT * FROM categories 
  			WHERE category_name='$category_name' AND category_id<>'$category_id'";
  	$result = mysql_query($sql);
  	
  	if(mysql_num_rows($result) >0){
  		
		//category name exists, print error infor
  		ExitMessage("category name already exists, please choose another name£¡");
  	}
	else
	{
  	
		//category name not exist, modify category name
  		$sql = "UPDATE categories SET category_name='$category_name'
  				WHERE category_id='$category_id'";
  		$result = mysql_query($sql);
  		ExitMessage("category name modified£¡", "category.php");
  	}
  }

  //delete category
  elseif($action == 'delcat') {
  	
	//not choose category to modify
  	if(empty($category_id)) {
  		ExitMessage("please choose the category to modify£¡");
  	}	

  
	//is there product in this category?
  	$sql = "SELECT * FROM products WHERE category_id='$category_id'";
  	$result = mysql_query($sql);

  	if(mysql_num_rows($result) >0) 
	{
		
		//there is product in this category, cannot delete
   		ExitMessage("there is product in this category, cannot delete£¡");
  	}
	else
	{
  		
		//delete category name
  		$sql = "DELETE FROM categories WHERE category_id='$category_id'";
  		$result = mysql_query($sql);
   		ExitMessage("category deleted£¡", "category.php");
  	}
  } 
  else
  {
  	ExitMessage("system parameters error£¡");
  }
?>
</html>
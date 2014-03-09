<?php
  /************************************/
  /*    filename: admin/category.php    */
  /*    comment: category manamgement page       */
  /************************************/
 include "../config.inc.php";	//config file
  //include "config.inc.php";	//configure file
  include "header.inc.php";		//management page header file
?>
<!-- create category -->
<form action="category_edit.php" method="post">
  <table width="100%" class="main" cellspacing="1">
    <caption>
    create category
    </caption>
    <input type="hidden" name="action" value="addcat">
    <tr>
      <th width="20%"><input type="submit" value="create category" name="submit1">
        </td>
      <td width="80%"><input size="30" name="category_name"></td>
    </tr>
  </table>
</form>

<!-- modify category -->
<form action="category_edit.php" method="post">
  <table width="100%" class="main" cellspacing="1">
    <caption>
modify category 
    </caption>
    <input type="hidden" name="action" value="rencat">
    <tr>
      <th width="20%"><input type="submit" value="modify category " name="submit2"></th>
      <td width="80%"><select size="1" name="category_id">
          <option value="0">-=choose category=-</option>
          <?php echo OptionCategories() ?>
        </select>
        new name£º
        <input name="category_name" size="20">
      </td>
    </tr>
  </table>
</form>

<!-- delete category-->
<form action="category_edit.php" method="post">
  <table width="100%" class="main" cellspacing="1">
    <caption>
    delete category
    </caption>
    <input type="hidden" name="action" value="delcat">
    <tr>
      <th width="20%"><input type="submit" value="delete category" name="submit3">
        </td>
      <td width="80%"><select size="1" name="category_id">
          <option value="0">-=choose category=-</option>
          <?php echo OptionCategories() ?>
        </select></td>
    </tr>
  </table>
</form>

</body>
</html>
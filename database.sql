/**************************/
/*    categories    */
/*       */
/**************************/ 
CREATE TABLE `categories` 
(
  `category_id` INT NOT NULL AUTO_INCREMENT,
  `category_name` VARCHAR(15) NOT NULL,
  PRIMARY KEY  (`category_id`),
  UNIQUE KEY `category_name` (`category_name`)
) TYPE=MyISAM;


/**************************/ 
/*	products	  */
/*     */
/**************************/
CREATE TABLE `products`
(
  `product_id` INT(10) NOT NULL AUTO_INCREMENT,
  `category_id` MEDIUMINT(8) NOT NULL,
  `product_name` VARCHAR(50) NOT NULL,
  `price` DOUBLE NOT NULL,
  `detail` TEXT NOT NULL,
  `is_commend` TINYINT(1) NOT NULL DEFAULT '0',
  `photo` VARCHAR(255) NOT NULL,
  `post_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (`product_id`),
  KEY `category_id` (`category_id`)
) TYPE=MyISAM;


/**************************/ 
/*   carts		  */
/*        */
/**************************/
CREATE TABLE `carts`
(
  `cart_id` INT(10) NOT NULL auto_increment,
  `session_id` VARCHAR(32) NOT NULL,
  `product_id` INT(10) NOT NULL,
  `number` INT(10) NOT NULL,
  PRIMARY KEY  (`cart_id`),
  KEY `session_id` (`session_id`,`product_id`)
) TYPE=MyISAM;


/**************************/ 
/*    orders        */
/*      */
/**************************/
CREATE TABLE `orders`
(
  `order_id` INT(10) NOT NULL,
  `session_id` VARCHAR(32) NOT NULL,
  `user_name` VARCHAR(40),
  `email` VARCHAR(40) NOT NULL,
  `address` VARCHAR(200) DEFAULT NULL,
  `total_price` DOUBLE NOT NULL,
  `postcode` VARCHAR(10) NOT NULL,
  `tel_no` VARCHAR(20) NOT NULL,
  `content` TEXT NOT NULL,
  PRIMARY KEY  (`order_id`),
  KEY `session_id` (`session_id`)
) TYPE=MyISAM;

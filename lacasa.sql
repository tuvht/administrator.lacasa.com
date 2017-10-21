--
-- Table structure for table `category`
--
DROP TABLE IF EXISTS `category`;

CREATE TABLE IF NOT EXISTS `category` (
  `id`          INT(11)      NOT NULL AUTO_INCREMENT,
  `name`        VARCHAR(255) NOT NULL,
  `description` TEXT         NOT NULL,
  `image`       VARCHAR(255) DEFAULT NULL,
  `status`      TINYINT(4)   NOT NULL,
  `parent`      INT(11)      NOT NULL,  
  PRIMARY KEY (`id`),
  INDEX `idx_status` (`status` ASC)
) 
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'LACASA Category';

--
-- Table structure for table `customer`
--
DROP TABLE IF EXISTS `customer`;

CREATE TABLE IF NOT EXISTS `customer` (
  `id`     INT(11)      NOT NULL AUTO_INCREMENT,
  `name`   VARCHAR(255) NOT NULL,
  `phone`  VARCHAR(20)  NOT NULL,
  `email`  VARCHAR(255) DEFAULT NULL,
  `status` TINYINT(4)   NOT NULL,
  `type`   INT(11)      NOT NULL,  
  PRIMARY KEY (`id`),
  INDEX `idx_status` (`status` ASC)
) 
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'LACASA Customer';

--
-- Table structure for table `customer_type`
--
DROP TABLE IF EXISTS `customer_type`;

CREATE TABLE IF NOT EXISTS `customer_type` (
  `id`          INT(11)      NOT NULL AUTO_INCREMENT,
  `title`       VARCHAR(255) NOT NULL,
  `description` TEXT         NOT NULL,
  `status`      TINYINT(4)   NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_status` (`status` ASC)
) 
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'LACASA Customer Type';

--
-- Dumping data for table `customer_type`
--
LOCK TABLES `customer_type` WRITE;
INSERT INTO `customer_type` VALUES ('', 'Quản lý', '', 1);
INSERT INTO `customer_type` VALUES ('', 'Đại lý', '', 1);
INSERT INTO `customer_type` VALUES ('', 'Người tiêu dùng', '', 1);
UNLOCK TABLES;


--
-- Table structure for table `orders`
--
DROP TABLE IF EXISTS `orders`;

CREATE TABLE IF NOT EXISTS `orders` (
  `id`           INT(11)       NOT NULL AUTO_INCREMENT,
  `order_number` VARCHAR(255)  NOT NULL,
  `customer_id`  INT(11)       NOT NULL,
  `user_info_id` INT(11)       NOT NULL,
  `subtotal`     DECIMAL(15,2) NOT NULL,
  `total`        DECIMAL(15,2) NOT NULL,
  `discount`     DECIMAL(15,2) NOT NULL,
  `tax`          DECIMAL(15,2) NOT NULL,
  `created_date` DATETIME      NOT NULL,
  `status`       TINYINT(4)    NOT NULL,
  `encr_key`     VARCHAR(255)  NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_status` (`status` ASC)
) 
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'LACASA Orders';

--
-- Table structure for table `order_item`
--
DROP TABLE IF EXISTS `order_item`;

CREATE TABLE IF NOT EXISTS `order_item` (
  `id`            INT(11)       NOT NULL AUTO_INCREMENT,
  `order_id`      INT(11)       NOT NULL,
  `product_id`    INT(11)       NOT NULL,
  `product_sku`   VARCHAR(255)  NOT NULL,
  `product_name`  VARCHAR(255)  NOT NULL,
  `product_price` DECIMAL(15,2) NOT NULL,
  `quantity`      INT(11)       NOT NULL,
  `final_price`   DECIMAL(15,2) NOT NULL,
  PRIMARY KEY (`id`)
) 
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'LACASA Order Items';

--
-- Table structure for table `order_user_info`
--
DROP TABLE IF EXISTS `order_user_info`;

CREATE TABLE IF NOT EXISTS `order_user_info` (
  `id`       INT(11)      NOT NULL AUTO_INCREMENT,
  `order_id` INT(11)      NOT NULL,
  `name`     VARCHAR(255) NOT NULL,
  `email`    VARCHAR(255) NOT NULL,
  `phone`    VARCHAR(20)  NOT NULL,
  `address`  VARCHAR(255) NOT NULL,
  `type`     TINYINT(4)   NOT NULL,
  PRIMARY KEY (`id`)
) 
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'LACASA Order User Info';

--
-- Table structure for table `order_status`
--
DROP TABLE IF EXISTS `order_status`;

CREATE TABLE IF NOT EXISTS`order_status` (
  `id`          INT(11)      NOT NULL AUTO_INCREMENT,
  `title`       VARCHAR(255) NOT NULL,
  `description` TEXT         NOT NULL,
  `status`      TINYINT(4)   NOT NULL,
  PRIMARY KEY (`id`)
) 
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'LACASA Order Status';

--
-- Table structure for table `product`
--
DROP TABLE IF EXISTS `product`;

CREATE TABLE IF NOT EXISTS `product` (
  `id`           INT(11)       NOT NULL AUTO_INCREMENT,
  `sku`          VARCHAR(255)  NOT NULL,
  `name`         VARCHAR(255)  NOT NULL,
  `description`  TEXT          NOT NULL,
  `price`        DECIMAL(15,2) NOT NULL,
  `status`       TINYINT(4)    NOT NULL,
  `created_date` DATETIME      NOT NULL,
  `metakey`      VARCHAR(255)  NOT NULL,
  `metadesc`     VARCHAR(255)  NOT NULL,
  PRIMARY KEY (`id`)
) 
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'LACASA Products';

--
-- Table structure for table `product_image`
--

DROP TABLE IF EXISTS `product_image`;

CREATE TABLE IF NOT EXISTS `product_image` (
  `id`          INT(11)       NOT NULL AUTO_INCREMENT,
  `product_id`  INT(11)       NOT NULL,
  `name`        VARCHAR(255)  NOT NULL,
  `path`        VARCHAR(255)  NOT NULL,
  `description` TEXT          NOT NULL,
  `extension`   VARCHAR(10)   NOT NULL,
  `default`     TINYINT(4)    NOT NULL,
  PRIMARY KEY (`id`)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'LACASA Product Images';

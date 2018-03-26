/*
SQLyog Ultimate v11.27 (32 bit)
MySQL - 5.7.11-log : Database - gangerp
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`gangerp` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `gangerp`;

/*Table structure for table `article_tag` */

DROP TABLE IF EXISTS `article_tag`;

CREATE TABLE `article_tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `articles` */

DROP TABLE IF EXISTS `articles`;

CREATE TABLE `articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('PUBLISHED','DRAFT') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'PUBLISHED',
  `date` date NOT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `bids` */

DROP TABLE IF EXISTS `bids`;

CREATE TABLE `bids` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pid` int(11) NOT NULL COMMENT '项目id',
  `uid` int(11) DEFAULT NULL,
  `contact_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `s_province` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `s_city` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `s_county` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `add` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `brands` text COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) DEFAULT '0' COMMENT '0批次 1统一价 2分品牌',
  `mtype` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '计量方式',
  `amount` bigint(20) DEFAULT NULL,
  `batch_amount` bigint(20) DEFAULT NULL,
  `settlement` text COLLATE utf8_unicode_ci,
  `paytype` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quote_request` text COLLATE utf8_unicode_ci,
  `deposit` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deposit_type` int(11) DEFAULT NULL,
  `deposit_account` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deposit_bank_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tender_deadline` datetime DEFAULT NULL,
  `deposit_return` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tender_price` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tender_add` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tender_open_sale` datetime DEFAULT NULL,
  `bid_deadline` datetime DEFAULT NULL,
  `bod` datetime DEFAULT NULL COMMENT '开标时间',
  `delivery_day` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quote_list` text COLLATE utf8_unicode_ci,
  `remark` text COLLATE utf8_unicode_ci,
  `companys` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `whowin` int(11) DEFAULT NULL,
  `stage` int(11) DEFAULT NULL COMMENT '2投标 3二次 4开标 5结束',
  `qtype` smallint(6) DEFAULT NULL COMMENT '报价类型',
  `up_down` tinyint(4) DEFAULT NULL,
  `want_price` text COLLATE utf8_unicode_ci,
  `sup_down` text COLLATE utf8_unicode_ci,
  `corrections` text COLLATE utf8_unicode_ci COMMENT '更正公告',
  `reason` text COLLATE utf8_unicode_ci COMMENT '废标原因',
  `status` tinyint(4) DEFAULT '0',
  `remove_text` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `moderated_at` timestamp NULL DEFAULT NULL,
  `moderated_by` int(11) DEFAULT NULL,
  `review_agree` tinyint(4) DEFAULT '0',
  `review_reason` text COLLATE utf8_unicode_ci,
  `decision_agree` tinyint(4) DEFAULT '0',
  `decision_reason` text COLLATE utf8_unicode_ci,
  `bid_to` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_company` int(11) DEFAULT NULL COMMENT '发起投标用户所在公司',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT '0',
  `lft` int(10) unsigned DEFAULT NULL,
  `rgt` int(10) unsigned DEFAULT NULL,
  `depth` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `company` */

DROP TABLE IF EXISTS `company`;

CREATE TABLE `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL,
  `name` char(255) NOT NULL,
  `province` char(255) NOT NULL,
  `city` char(255) NOT NULL,
  `county` char(255) NOT NULL,
  `address` char(255) NOT NULL,
  `company_contacts` varchar(50) DEFAULT NULL,
  `company_type` varchar(255) NOT NULL COMMENT '企业类型:(1)招标方(2)投标方',
  `company_attr` varchar(255) NOT NULL COMMENT '企业性质:(1)国有企业(2)集体企业(3)独资企业(4)合资企业(5)民营企业',
  `is_listed` tinyint(255) NOT NULL COMMENT '是否上市:(1)是(2)否',
  `company_number` varchar(50) NOT NULL,
  `company_file_path` varchar(255) NOT NULL,
  `company_boss` varchar(255) NOT NULL,
  `company_tel` varchar(255) NOT NULL,
  `idcard_number` varchar(255) NOT NULL,
  `is_review` tinyint(1) DEFAULT '0' COMMENT '是否已审核',
  `register_money` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

/*Table structure for table `dara_payment_kind` */

DROP TABLE IF EXISTS `dara_payment_kind`;

CREATE TABLE `dara_payment_kind` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Table structure for table `data_brand_details` */

DROP TABLE IF EXISTS `data_brand_details`;

CREATE TABLE `data_brand_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brands` varchar(50) DEFAULT NULL,
  `context` text COMMENT '基本资料',
  `cate_spec` text COMMENT '生产规格',
  `cate_style` varchar(255) DEFAULT NULL COMMENT '钢牌/钢标样式',
  `weight_standard` varchar(255) DEFAULT NULL COMMENT '理计重量标准',
  `transport_way` varchar(50) DEFAULT NULL COMMENT '承运方式',
  `steel_certificate` text COMMENT '钢厂三证',
  `quality_certificate` varchar(255) DEFAULT NULL COMMENT '质量认证书',
  `supplier` text COMMENT '广东区域供应商',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `data_brand_resource` */

DROP TABLE IF EXISTS `data_brand_resource`;

CREATE TABLE `data_brand_resource` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(255) NOT NULL,
  `mean_of_months` text NOT NULL,
  `mean_of_one_month` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;

/*Table structure for table `data_history_record` */

DROP TABLE IF EXISTS `data_history_record`;

CREATE TABLE `data_history_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `target_table` varchar(255) NOT NULL,
  `target_id` text NOT NULL,
  `target_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=926 DEFAULT CHARSET=utf8;

/*Table structure for table `data_market_datas` */

DROP TABLE IF EXISTS `data_market_datas`;

CREATE TABLE `data_market_datas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price_queue` varchar(255) NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=533 DEFAULT CHARSET=utf8;

/*Table structure for table `data_market_datas_child` */

DROP TABLE IF EXISTS `data_market_datas_child`;

CREATE TABLE `data_market_datas_child` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `cate_spec` varchar(255) NOT NULL,
  `material` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `times` int(32) DEFAULT NULL,
  `inventory` varchar(255) NOT NULL,
  `price_source` varchar(255) NOT NULL,
  `warehouse` varchar(255) NOT NULL,
  `transport` varchar(255) NOT NULL,
  `payment_kind` varchar(255) NOT NULL,
  `product_status` varchar(255) DEFAULT NULL,
  `writer_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=149259 DEFAULT CHARSET=utf8;

/*Table structure for table `data_market_price_rule` */

DROP TABLE IF EXISTS `data_market_price_rule`;

CREATE TABLE `data_market_price_rule` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `steel_products_id` int(11) NOT NULL COMMENT '钢铁规格外建',
  `is_active` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否开单',
  `active_type` tinyint(4) DEFAULT NULL COMMENT '取价规则',
  `supplier_id` int(11) NOT NULL COMMENT '供应商ID',
  `float_type` tinyint(4) NOT NULL COMMENT '上下浮  ',
  `float_price` varchar(255) NOT NULL COMMENT '浮动价格',
  `customize_float_type` tinyint(4) DEFAULT '1' COMMENT '上下浮',
  `customize_float_price` int(11) DEFAULT '10' COMMENT '浮动价格',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=632 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `data_market_rule` */

DROP TABLE IF EXISTS `data_market_rule`;

CREATE TABLE `data_market_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_id` int(11) NOT NULL,
  `active_rule` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `data_notice_price` */

DROP TABLE IF EXISTS `data_notice_price`;

CREATE TABLE `data_notice_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(255) NOT NULL,
  `cate_spec` varchar(255) NOT NULL,
  `material` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `transport_type` int(1) NOT NULL COMMENT '1为物流承运, 2为钢厂直送',
  `maxNumber` int(11) NOT NULL,
  `minNumber` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=608 DEFAULT CHARSET=utf8;

/*Table structure for table `data_order_bussiness_info` */

DROP TABLE IF EXISTS `data_order_bussiness_info`;

CREATE TABLE `data_order_bussiness_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `buyer_id` int(11) DEFAULT NULL,
  `buyer_name` varchar(50) DEFAULT NULL,
  `buyer_fax` varchar(20) DEFAULT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `seller_name` varchar(50) DEFAULT NULL,
  `seller_fax` varchar(20) DEFAULT NULL,
  `date_create` varchar(32) DEFAULT NULL,
  `date_handle` varchar(32) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `data_order_logistics_info` */

DROP TABLE IF EXISTS `data_order_logistics_info`;

CREATE TABLE `data_order_logistics_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `plate_number` varchar(50) DEFAULT NULL,
  `driver` varchar(50) DEFAULT NULL,
  `driver_tel` varchar(20) DEFAULT NULL,
  `driver_idcard_num` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Table structure for table `data_price_source` */

DROP TABLE IF EXISTS `data_price_source`;

CREATE TABLE `data_price_source` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `short_name` varchar(16) DEFAULT NULL,
  `company_type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8;

/*Table structure for table `data_project` */

DROP TABLE IF EXISTS `data_project`;

CREATE TABLE `data_project` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `project_info_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8;

/*Table structure for table `data_project_info` */

DROP TABLE IF EXISTS `data_project_info`;

CREATE TABLE `data_project_info` (
  `project_info_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `province` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '广东省',
  `city` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `area` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `addr` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `brands` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `receivers` text COLLATE utf8_unicode_ci,
  `handlers` text COLLATE utf8_unicode_ci NOT NULL,
  `settlement` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`project_info_id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `data_project_settlement` */

DROP TABLE IF EXISTS `data_project_settlement`;

CREATE TABLE `data_project_settlement` (
  `settlement_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_info_id` int(11) DEFAULT NULL,
  `type` int(4) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL COMMENT '品牌',
  `specification` varchar(255) DEFAULT NULL COMMENT '规格',
  `reference` varchar(255) DEFAULT NULL COMMENT '参照的价格(网价,现货等等)',
  `count_number` varchar(255) DEFAULT NULL COMMENT '计算的值',
  `freight` varchar(255) DEFAULT NULL COMMENT '运费',
  `cost_freight` varchar(255) DEFAULT NULL COMMENT 'cost运费',
  `ponderation` varchar(255) DEFAULT NULL COMMENT '过磅费',
  `crane` varchar(255) DEFAULT NULL COMMENT '吊机费',
  `funds_rate` varchar(255) DEFAULT NULL COMMENT '资金费率',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`settlement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2473 DEFAULT CHARSET=utf8;

/*Table structure for table `data_project_with_user` */

DROP TABLE IF EXISTS `data_project_with_user`;

CREATE TABLE `data_project_with_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

/*Table structure for table `data_transport` */

DROP TABLE IF EXISTS `data_transport`;

CREATE TABLE `data_transport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL COMMENT '1为物流承运, 2为钢厂直送',
  `transport_price` varchar(255) NOT NULL,
  `transport_count` varchar(255) NOT NULL,
  `transport_car_price` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL DEFAULT '全部规格',
  `origin_city` varchar(255) DEFAULT NULL,
  `origin_area` varchar(255) DEFAULT NULL,
  `origin_address` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `remarks` varchar(512) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2314 DEFAULT CHARSET=utf8;

/*Table structure for table `data_user_car_info` */

DROP TABLE IF EXISTS `data_user_car_info`;

CREATE TABLE `data_user_car_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_source` varchar(255) DEFAULT NULL,
  `plate_number` varchar(30) NOT NULL,
  `driver` varchar(30) NOT NULL,
  `driver_tel` varchar(30) NOT NULL,
  `driver_idcard_num` varchar(30) NOT NULL,
  `user_id` int(11) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `data_user_orders` */

DROP TABLE IF EXISTS `data_user_orders`;

CREATE TABLE `data_user_orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_type` int(2) NOT NULL DEFAULT '0',
  `price_type` int(2) DEFAULT NULL,
  `user_id` int(10) NOT NULL DEFAULT '-1',
  `seller_id` int(10) NOT NULL DEFAULT '-1',
  `order_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_id` int(10) DEFAULT NULL,
  `transport_function` int(2) DEFAULT NULL,
  `status` int(10) NOT NULL,
  `send_for_purchar` int(2) NOT NULL DEFAULT '0',
  `count_total` int(10) DEFAULT NULL,
  `all_total` int(20) NOT NULL,
  `receiver` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `receiver_tel` varchar(22) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_of_receipt` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `place_of_receipt` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `received_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `data_user_orders_detail` */

DROP TABLE IF EXISTS `data_user_orders_detail`;

CREATE TABLE `data_user_orders_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `menu` varchar(6) DEFAULT NULL,
  `market_price_id` varchar(11) DEFAULT NULL,
  `brand` varchar(20) DEFAULT NULL,
  `cate_spec` varchar(20) DEFAULT NULL,
  `size` varchar(20) DEFAULT NULL,
  `material` varchar(20) DEFAULT NULL,
  `warehouse` varchar(20) DEFAULT NULL,
  `cost_freight` int(11) DEFAULT NULL,
  `freight` int(11) DEFAULT NULL,
  `unit_price` int(10) DEFAULT NULL,
  `price` int(10) DEFAULT NULL,
  `out_warehouse_amount` double DEFAULT NULL,
  `received_amount` double DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `total` int(20) DEFAULT NULL,
  `remark` varchar(50) DEFAULT NULL,
  `plate_num` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=214 DEFAULT CHARSET=utf8;

/*Table structure for table `data_user_record` */

DROP TABLE IF EXISTS `data_user_record`;

CREATE TABLE `data_user_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `table` varchar(255) DEFAULT NULL,
  `data_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74634 DEFAULT CHARSET=utf8;

/*Table structure for table `data_warehouse` */

DROP TABLE IF EXISTS `data_warehouse`;

CREATE TABLE `data_warehouse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `warehouse_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

/*Table structure for table `data_web_price` */

DROP TABLE IF EXISTS `data_web_price`;

CREATE TABLE `data_web_price` (
  `product` varchar(20) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `material` varchar(20) DEFAULT NULL,
  `brands` varchar(20) DEFAULT NULL,
  `web_price` varchar(20) DEFAULT NULL,
  `price_change` varchar(20) DEFAULT NULL,
  `source_states` varchar(40) DEFAULT NULL,
  `file_name` int(40) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `file_name_index` (`file_name`)
) ENGINE=InnoDB AUTO_INCREMENT=1079761 DEFAULT CHARSET=utf8;

/*Table structure for table `data_web_price_date` */

DROP TABLE IF EXISTS `data_web_price_date`;

CREATE TABLE `data_web_price_date` (
  `date` int(30) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `date` (`date`)
) ENGINE=InnoDB AUTO_INCREMENT=6024 DEFAULT CHARSET=utf8;

/*Table structure for table `items` */

DROP TABLE IF EXISTS `items`;

CREATE TABLE `items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `languages` */

DROP TABLE IF EXISTS `languages`;

CREATE TABLE `languages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `app_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `flag` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `abbr` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `script` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `native` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `default` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `laravel_sms` */

DROP TABLE IF EXISTS `laravel_sms`;

CREATE TABLE `laravel_sms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `to` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `temp_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `data` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `voice_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fail_times` mediumint(9) NOT NULL DEFAULT '0',
  `last_fail_time` int(10) unsigned NOT NULL DEFAULT '0',
  `sent_time` int(10) unsigned NOT NULL DEFAULT '0',
  `result_info` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `menu_items` */

DROP TABLE IF EXISTS `menu_items`;

CREATE TABLE `menu_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `page_id` int(10) unsigned DEFAULT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `lft` int(10) unsigned DEFAULT NULL,
  `rgt` int(10) unsigned DEFAULT NULL,
  `depth` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `message` */

DROP TABLE IF EXISTS `message`;

CREATE TABLE `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL COMMENT '标题',
  `from_uid` int(11) DEFAULT NULL COMMENT '发自',
  `to_uid` int(11) DEFAULT NULL COMMENT '发送至',
  `content` varchar(500) DEFAULT NULL COMMENT '内容',
  `is_read` tinyint(1) DEFAULT '0' COMMENT '0未读 1已读',
  `send_at` timestamp NULL DEFAULT NULL COMMENT '发送时间',
  `created_at` varchar(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `notifications` */

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notifiable_id` int(10) unsigned NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_id_notifiable_type_index` (`notifiable_id`,`notifiable_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `pages` */

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `extras` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `permission_roles` */

DROP TABLE IF EXISTS `permission_roles`;

CREATE TABLE `permission_roles` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_roles_role_id_foreign` (`role_id`),
  CONSTRAINT `permission_roles_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `permission_users` */

DROP TABLE IF EXISTS `permission_users`;

CREATE TABLE `permission_users` (
  `user_id` int(10) unsigned NOT NULL,
  `permission_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`permission_id`),
  KEY `permission_users_permission_id_foreign` (`permission_id`),
  CONSTRAINT `permission_users_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `project` */

DROP TABLE IF EXISTS `project`;

CREATE TABLE `project` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `province` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `area` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `add` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `brands` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `m_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `c_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` bigint(20) DEFAULT NULL,
  `settlement` text COLLATE utf8_unicode_ci NOT NULL,
  `paytype` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `quote_request` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quote_list` */

DROP TABLE IF EXISTS `quote_list`;

CREATE TABLE `quote_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bid` int(11) NOT NULL,
  `cname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cname_cid` int(11) NOT NULL,
  `size` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `size_cid` int(11) NOT NULL,
  `material` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `material_cid` int(11) NOT NULL,
  `amount` mediumint(9) NOT NULL DEFAULT '0',
  `mark` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `type` int(11) NOT NULL DEFAULT '0',
  `brand_id` int(11) NOT NULL,
  `bname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `base_type` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quote_prices` */

DROP TABLE IF EXISTS `quote_prices`;

CREATE TABLE `quote_prices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bid` int(11) NOT NULL,
  `who` int(11) NOT NULL,
  `pid` int(11) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `price` double(8,2) DEFAULT NULL,
  `want_price` double(8,2) DEFAULT NULL,
  `second_price` double(8,2) DEFAULT NULL,
  `s_price` double DEFAULT NULL,
  `d_price` double DEFAULT NULL,
  `m_price` double DEFAULT NULL,
  `u_price` double DEFAULT NULL,
  `t_price` double DEFAULT NULL,
  `sup_down` tinyint(4) DEFAULT NULL,
  `net_price` double(8,2) DEFAULT NULL,
  `up_down` int(11) DEFAULT NULL,
  `up_price` double(8,2) DEFAULT NULL,
  `base_type` int(11) DEFAULT NULL,
  `cname` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `cname_cid` int(11) DEFAULT NULL,
  `size` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `size_cid` int(11) DEFAULT NULL,
  `material` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `material_cid` int(11) DEFAULT NULL,
  `amount` mediumint(9) DEFAULT '0',
  `mark` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `type` int(11) DEFAULT '0',
  `qtype` smallint(6) DEFAULT NULL,
  `bname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `review_agree` tinyint(4) DEFAULT '0',
  `decision_agree` tinyint(4) DEFAULT '0',
  `review_reason` text COLLATE utf8_unicode_ci,
  `decision_reason` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `register_phone` */

DROP TABLE IF EXISTS `register_phone`;

CREATE TABLE `register_phone` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` int(11) NOT NULL,
  `deadline` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `revisions` */

DROP TABLE IF EXISTS `revisions`;

CREATE TABLE `revisions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `revisionable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `revisionable_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `old_value` text COLLATE utf8_unicode_ci,
  `new_value` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `revisions_revisionable_id_revisionable_type_index` (`revisionable_id`,`revisionable_type`)
) ENGINE=InnoDB AUTO_INCREMENT=246 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `role_users` */

DROP TABLE IF EXISTS `role_users`;

CREATE TABLE `role_users` (
  `role_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`user_id`),
  KEY `role_users_user_id_foreign` (`user_id`),
  CONSTRAINT `role_users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `settings` */

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `field` text COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `steel_brands` */

DROP TABLE IF EXISTS `steel_brands`;

CREATE TABLE `steel_brands` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `factory_id` int(10) DEFAULT NULL,
  `svids` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `steel_brands_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `steel_factorys` */

DROP TABLE IF EXISTS `steel_factorys`;

CREATE TABLE `steel_factorys` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `abbreviation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `steel_factorys_full_name_unique` (`full_name`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `steel_products` */

DROP TABLE IF EXISTS `steel_products`;

CREATE TABLE `steel_products` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `bid` int(11) unsigned NOT NULL,
  `steel_code` varchar(50) NOT NULL,
  `brand` varchar(50) DEFAULT NULL COMMENT '品牌',
  `cate_spec` varchar(50) DEFAULT NULL COMMENT '品名',
  `size` varchar(20) DEFAULT NULL COMMENT '规格',
  `material` varchar(50) DEFAULT NULL COMMENT '材质',
  `spec` mediumtext,
  `spec_key` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `brand` (`brand`)
) ENGINE=InnoDB AUTO_INCREMENT=1085 DEFAULT CHARSET=utf8;

/*Table structure for table `steel_products_spec` */

DROP TABLE IF EXISTS `steel_products_spec`;

CREATE TABLE `steel_products_spec` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `value` mediumtext NOT NULL,
  `note` varchar(255) DEFAULT 'NULL',
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Table structure for table `steel_products_spec_value` */

DROP TABLE IF EXISTS `steel_products_spec_value`;

CREATE TABLE `steel_products_spec_value` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `spec_id` bigint(20) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `sort` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

/*Table structure for table `tags` */

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tags_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `user_info` */

DROP TABLE IF EXISTS `user_info`;

CREATE TABLE `user_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` varchar(255) NOT NULL,
  `company` char(255) NOT NULL,
  `province` char(255) NOT NULL,
  `city` char(255) NOT NULL,
  `county` char(255) NOT NULL,
  `address` char(255) NOT NULL,
  `company_type` varchar(255) NOT NULL COMMENT '企业类型:(1)招标方(2)投标方',
  `company_attr` varchar(255) NOT NULL COMMENT '企业性质:(1)国有企业(2)集体企业(3)独资企业(4)合资企业(5)民营企业',
  `is_listed` tinyint(255) NOT NULL COMMENT '是否上市:(1)是(2)否',
  `company_number` int(11) NOT NULL,
  `company_file_path` varchar(255) NOT NULL,
  `company_boss` varchar(255) NOT NULL,
  `company_tel` varchar(255) NOT NULL,
  `idcard_number` varchar(255) NOT NULL,
  `is_review` tinyint(1) DEFAULT '0' COMMENT '是否已审核',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

/*Table structure for table `user_info_accounts` */

DROP TABLE IF EXISTS `user_info_accounts`;

CREATE TABLE `user_info_accounts` (
  `id` int(1) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(255) NOT NULL,
  `post` int(255) NOT NULL COMMENT '职务:(1)收货员(2)采购员(3)采购经理',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;

/*Table structure for table `user_quote` */

DROP TABLE IF EXISTS `user_quote`;

CREATE TABLE `user_quote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `second_quote` tinyint(1) DEFAULT '0',
  `second_price_post` tinyint(4) DEFAULT '0',
  `bidfile` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `qstatus` tinyint(4) DEFAULT '0',
  `quote` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_parent` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(13) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_id` int(10) DEFAULT NULL,
  `session_id` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobile` (`mobile`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

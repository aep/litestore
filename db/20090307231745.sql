create table `address_book` 
(
    `address_book_id`       integer primary key auto_increment,
    `customers_id`          integer references `customers`(`customers_id`),
    `entry_gender`          char not null,
    `entry_company`         text default null,
    `entry_firstname`       text not null,
    `entry_lastname`        text not null,
    `entry_street_address`  text not null,
    `entry_suburb`          text default null,
    `entry_postcode`        text not null,
    `entry_city`            text not null,
    `entry_state`           text default null,
    `entry_country_id`      integer not null default '0',
    `entry_zone_id`         integer not null default '0',
    `address_date_added`    datetime default '0000-00-00 00:00:00',
    `address_last_modified` datetime default '0000-00-00 00:00:00'
);


insert into `address_book` values (1,1,'','<<RSTI_COMPANY_NAME>>','<<RSTI_OWNER_FIRST_NAME>>','<<RSTI_OWNER_LAST_NAME>>','<<RSTI_OWNER_STREET>>','','<<RSTI_OWNER_POSTCODE>>','<<RSTI_OWNER_CITY>>','',81,94,'0000-00-00 00:00:00','2008-05-15 13:08:17');


create table `address_format` 
(
    `address_format_id` integer primary key auto_increment,
    `address_format`    text NOT NULL,
    `address_summary`   text NOT NULL
);

insert into `address_format` values (1,'$firstname $lastname$cr$streets$cr$city, $postcode$cr$statecomma$country','$city / $country');
insert into `address_format` values (2,'$firstname $lastname$cr$streets$cr$city, $state    $postcode$cr$country','$city, $state / $country');
insert into `address_format` values (3,'$firstname $lastname$cr$streets$cr$city$cr$postcode - $statecomma$country','$state / $country');
insert into `address_format` values (4,'$firstname $lastname$cr$streets$cr$city ($postcode)$cr$country','$postcode / $country');
insert into `address_format` values (5,'$firstname $lastname$cr$streets$cr$postcode $city$cr$country','$city / $country');


create table `admin_access` 
(
    `customers_id`      integer primary key references `customers`(`customers_id`),
    `configuration`     integer NOT NULL default '0',
    `modules`           integer NOT NULL default '0',
    `countries`         integer NOT NULL default '0',
    `currencies`        integer NOT NULL default '0',
    `zones`             integer NOT NULL default '0',
    `geo_zones`         integer NOT NULL default '0',
    `tax_classes`       integer NOT NULL default '0',
    `tax_rates`         integer NOT NULL default '0',
    `accounting`        integer NOT NULL default '0',
    `backup`            integer NOT NULL default '0',
    `cache`             integer NOT NULL default '0',
    `server_info`       integer NOT NULL default '0',
    `whos_online`       integer NOT NULL default '0',
    `languages`         integer NOT NULL default '0',
    `define_language`   integer NOT NULL default '0',
    `orders_status`     integer NOT NULL default '0',
    `shipping_status`   integer NOT NULL default '0',
    `module_export`     integer NOT NULL default '0',
    `customers`         integer NOT NULL default '0',
    `create_account`    integer NOT NULL default '0',
    `customers_status`  integer NOT NULL default '0',
    `orders`            integer NOT NULL default '0',
    `campaigns`         integer NOT NULL default '0',
    `print_packingslip` integer NOT NULL default '0',
    `print_order`       integer NOT NULL default '0',
    `popup_memo`        integer NOT NULL default '0',
    `coupon_admin`      integer NOT NULL default '0',
    `listcategories`    integer NOT NULL default '0',
    `gv_queue`          integer NOT NULL default '0',
    `gv_mail`           integer NOT NULL default '0',
    `gv_sent`           integer NOT NULL default '0',
    `validproducts`     integer NOT NULL default '0',
    `validcategories`   integer NOT NULL default '0',
    `mail`              integer NOT NULL default '0',
    `categories`        integer NOT NULL default '0',
    `new_attributes`    integer NOT NULL default '0',
    `products_attributes` integer NOT NULL default '0',
    `manufacturers`     integer NOT NULL default '0',
    `reviews`           integer NOT NULL default '0',
    `specials`          integer NOT NULL default '0',
    `stats_products_expected` integer NOT NULL default '0',
    `stats_products_viewed` integer NOT NULL default '0',
    `stats_products_purchased` integer NOT NULL default '0',
    `stats_customers`   integer NOT NULL default '0',
    `stats_sales_report` integer NOT NULL default '0',
    `stats_campaigns`   integer NOT NULL default '0',
    `banner_manager`    integer NOT NULL default '0',
    `banner_statistics` integer NOT NULL default '0',
    `module_newsletter` integer NOT NULL default '0',
    `start`             integer NOT NULL default '0',
    `content_manager`   integer NOT NULL default '0',
    `content_preview`   integer NOT NULL default '0',
    `credits`           integer NOT NULL default '0',
    `blacklist`         integer NOT NULL default '0',
    `orders_edit`       integer NOT NULL default '0',
    `popup_image`       integer NOT NULL default '0',
    `export`            integer NOT NULL default '0',
    `csv_backend`       integer NOT NULL default '0',
    `products_vpe`      integer NOT NULL default '0',
    `cross_sell_groups` integer NOT NULL default '0',
    `stats_unsold_carts` integer NOT NULL default '0',
    `fck_wrapper`       integer NOT NULL default '0',
    `filemanager`       integer NOT NULL default '0',
    `adsense`           integer NOT NULL default '0',
    `adwords`           integer NOT NULL default '0',
    `style`             integer NOT NULL default '0',
    `metatags`          integer NOT NULL default '0'
);

insert into `admin_access` values 
(
         '1',1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1
);


create table `banktransfer` 
(
    `orders_id`               integer primary key references `orders` (`orders_id`),
    `banktransfer_owner`      text default NULL,
    `banktransfer_number`     text default NULL,
    `banktransfer_bankname`   text default NULL,
    `banktransfer_blz`        text default NULL,
    `banktransfer_status`     integer default NULL,
    `banktransfer_prz`        char    default NULL,
    `banktransfer_fax`        char    default NULL
);


create table `banners` 
(
    `banners_id`            integer primary key  auto_increment,
    `banners_title`         text NOT NULL,
    `banners_url`           text NOT NULL,
    `banners_image`         text NOT NULL,
    `banners_group`         text NOT NULL,
    `banners_html_text`     text,
    `expires_impressions`   integer default '0',
    `expires_date`          datetime default NULL,
    `date_scheduled`        datetime default NULL,
    `date_added`            datetime NOT NULL,
    `date_status_change`    datetime default NULL,
    `status`                integer NOT NULL default '1'
);


create table `banners_history` 
(
    `banners_history_id`   integer primary key  auto_increment,
    `banners_id`           integer references `banners` (`banners_id`),
    `banners_shown`        integer NOT NULL default '0',
    `banners_clicked`      integer NOT NULL default '0',
    `banners_history_date` datetime NOT NULL
);


create table `campaigns` 
(
	`campaigns_id`      integer primary key  auto_increment,
	`campaigns_name`    varchar(1000) NOT NULL default '' unique,
	`campaigns_refID`   text default NULL,
	`campaigns_leads`   integer NOT NULL default '0',
	`date_added`        datetime default NULL,
	`last_modified`     datetime default NULL
);


create table `campaigns_ip` 
(
    `user_ip`   text  NOT NULL,
    `time`      datetime NOT NULL,
    `campaign`  text  NOT NULL
);


create table `card_blacklist` 
(
    `blacklist_id`          integer primary key  auto_increment,
    `blacklist_card_number` text  NOT NULL default '',
    `date_added`            datetime default NULL,
    `last_modified`         datetime default NULL
);


create table `categories` 
(
    `categories_id`         integer primary key  auto_increment,
    `categories_image`      text default NULL,
    `categories_teaser`     text default '',
    `parent_id`             integer NOT NULL default '0' references `categories`(`categories_id`),
    `categories_status`     integer NOT NULL default '1',
    `categories_template`   text default NULL,
    `listing_template`      text default NULL,
    `sort_order`            integer NOT NULL default '0',
    `products_sorting`      text default NULL,
    `products_sorting2`     text default NULL,
    `date_added`            datetime default NULL,
    `last_modified`         datetime default NULL,
    `categories_key`        text default '',
    `ibc_devices`           text default NULL
);


create table `categories_description` 
(
    `categories_id`                 integer NOT NULL default '0' references `categories`(`categories_id`),
    `languages_id`                  integer NOT NULL default '1' references `languages` (`language_id`),
    `categories_name`               text NOT NULL default '',
    `categories_heading_title`      text NOT NULL default '',
    `categories_description`        text NOT NULL,
    `categories_meta_title`         text NOT NULL default '',
    `categories_meta_description`   text NOT NULL default '',
    `categories_meta_keywords`      text NOT NULL default '',
    primary key (`categories_id`,`languages_id`)
);

create table `configuration` 
(
    `configuration_id`          integer primary key  auto_increment,
    `configuration_key`         text NOT NULL,
    `configuration_value`       text NOT NULL,
    `configuration_group_id`    integer  NOT NULL,
    `sort_order`                integer default NULL,
    `last_modified`             datetime default NULL,
    `date_added`                datetime NOT NULL,
    `use_function`              text default NULL,
    `set_function`              text default NULL
);

insert into `configuration` 
    select           1,'STORE_NAME','<<RSTI_STORE_NAME>>',1,1,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 2,'STORE_OWNER','<<RSTI_STORE_NAME>>',1,2,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 3,'STORE_OWNER_EMAIL_ADDRESS','<<RSTI_OWNER_MAIL>>',1,3,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 4,'EMAIL_FROM','<<RSTI_STORE_MAIL>>',1,4,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 5,'STORE_COUNTRY','81',1,6,NULL,'0000-00-00 00:00:00','xtc_get_country_name','xtc_cfg_pull_down_country_list('
    union all select 6,'STORE_ZONE','94',1,7,NULL,'0000-00-00 00:00:00','xtc_cfg_get_zone_name','xtc_cfg_pull_down_zone_list('
    union all select 7,'EXPECTED_PRODUCTS_SORT','desc',1,8,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''asc'', ''desc''),'
    union all select 8,'EXPECTED_PRODUCTS_FIELD','date_expected',1,9,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''products_name'', ''date_expected''),'
    union all select 9,'USE_DEFAULT_LANGUAGE_CURRENCY','false',1,10,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 10,'SEARCH_ENGINE_FRIENDLY_URLS','false',2147483647,12,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 11,'DISPLAY_CART','false',1,13,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 12,'ADVANCED_SEARCH_DEFAULT_OPERATOR','and',1,15,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''and'', ''or''),'
    union all select 13,'STORE_NAME_ADDRESS','Test',1,16,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_textarea('
    union all select 14,'SHOW_COUNTS','false',1,17,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 15,'DEFAULT_CUSTOMERS_STATUS_ID_ADMIN','0',1,20,NULL,'0000-00-00 00:00:00','xtc_get_customers_status_name','xtc_cfg_pull_down_customers_status_list('
    union all select 16,'DEFAULT_CUSTOMERS_STATUS_ID_GUEST','1',1,21,NULL,'0000-00-00 00:00:00','xtc_get_customers_status_name','xtc_cfg_pull_down_customers_status_list('
    union all select 17,'DEFAULT_CUSTOMERS_STATUS_ID','2',1,23,NULL,'0000-00-00 00:00:00','xtc_get_customers_status_name','xtc_cfg_pull_down_customers_status_list('
    union all select 18,'ALLOW_ADD_TO_CART','false',1,24,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 19,'CURRENT_TEMPLATE','restore',666,26,NULL,'0000-00-00 00:00:00',NULL,''
    union all select 20,'PRICE_IS_BRUTTO','false',1,27,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 21,'PRICE_PRECISION','4',1,28,NULL,'0000-00-00 00:00:00',NULL,''
    union all select 22,'CC_KEYCHAIN','64854354354',1,29,NULL,'0000-00-00 00:00:00',NULL,''
    union all select 23,'ENTRY_FIRST_NAME_MIN_LENGTH','2',2,1,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 24,'ENTRY_LAST_NAME_MIN_LENGTH','2',2,2,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 25,'ENTRY_DOB_MIN_LENGTH','10',2,3,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 26,'ENTRY_EMAIL_ADDRESS_MIN_LENGTH','6',2,4,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 27,'ENTRY_STREET_ADDRESS_MIN_LENGTH','5',2,5,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 28,'ENTRY_COMPANY_MIN_LENGTH','2',2,6,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 29,'ENTRY_POSTCODE_MIN_LENGTH','4',2,7,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 30,'ENTRY_CITY_MIN_LENGTH','3',2,8,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 31,'ENTRY_STATE_MIN_LENGTH','2',2,9,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 32,'ENTRY_TELEPHONE_MIN_LENGTH','3',2,10,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 33,'ENTRY_PASSWORD_MIN_LENGTH','5',2,11,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 34,'CC_OWNER_MIN_LENGTH','3',2,12,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 35,'CC_NUMBER_MIN_LENGTH','10',2,13,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 36,'REVIEW_TEXT_MIN_LENGTH','50',2,14,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 37,'MIN_DISPLAY_BESTSELLERS','1',2,15,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 38,'MIN_DISPLAY_ALSO_PURCHASED','1',2,16,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 39,'MAX_ADDRESS_BOOK_ENTRIES','5',3,1,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 40,'MAX_DISPLAY_SEARCH_RESULTS','48',3,2,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 41,'MAX_DISPLAY_PAGE_LINKS','5',3,3,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 42,'MAX_DISPLAY_SPECIAL_PRODUCTS','9',3,4,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 43,'MAX_DISPLAY_NEW_PRODUCTS','9',3,5,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 44,'MAX_DISPLAY_UPCOMING_PRODUCTS','10',3,6,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 45,'MAX_DISPLAY_MANUFACTURERS_IN_A_LIST','0',3,7,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 46,'MAX_MANUFACTURERS_LIST','1',3,7,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 47,'MAX_DISPLAY_MANUFACTURER_NAME_LEN','15',3,8,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 48,'MAX_DISPLAY_NEW_REVIEWS','6',3,9,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 49,'MAX_RANDOM_SELECT_REVIEWS','10',3,10,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 50,'MAX_RANDOM_SELECT_NEW','10',3,11,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 51,'MAX_RANDOM_SELECT_SPECIALS','10',3,12,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 52,'MAX_DISPLAY_CATEGORIES_PER_ROW','3',3,13,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 53,'MAX_DISPLAY_PRODUCTS_NEW','10',3,14,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 54,'MAX_DISPLAY_BESTSELLERS','10',3,15,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 55,'MAX_DISPLAY_ALSO_PURCHASED','6',3,16,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 56,'MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX','6',3,17,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 57,'MAX_DISPLAY_ORDER_HISTORY','10',3,18,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 58,'PRODUCT_REVIEWS_VIEW','5',3,19,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 59,'MAX_PRODUCTS_QTY','1000',3,21,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,NULL
    union all select 60,'MAX_DISPLAY_NEW_PRODUCTS_DAYS','30',3,22,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,NULL
    union all select 61,'CONFIG_CALCULATE_IMAGE_SIZE','true',4,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 62,'IMAGE_QUALITY','80',4,2,'2003-12-15 12:10:45','0000-00-00 00:00:00',NULL,NULL
    union all select 63,'PRODUCT_IMAGE_THUMBNAIL_WIDTH','80',4,7,'2003-12-15 12:10:45','0000-00-00 00:00:00',NULL,NULL
    union all select 64,'PRODUCT_IMAGE_THUMBNAIL_HEIGHT','80',4,8,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 65,'PRODUCT_IMAGE_INFO_WIDTH','160',4,9,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 66,'PRODUCT_IMAGE_INFO_HEIGHT','160',4,10,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 67,'PRODUCT_IMAGE_POPUP_WIDTH','350',4,11,'2003-12-15 12:11:00','0000-00-00 00:00:00',NULL,NULL
    union all select 68,'PRODUCT_IMAGE_POPUP_HEIGHT','350',4,12,'2003-12-15 12:11:09','0000-00-00 00:00:00',NULL,NULL
    union all select 69,'PRODUCT_IMAGE_THUMBNAIL_BEVEL','',4,13,'2003-12-15 13:14:39','0000-00-00 00:00:00','',''
    union all select 70,'PRODUCT_IMAGE_THUMBNAIL_GREYSCALE','',4,14,'2003-12-15 13:13:37','0000-00-00 00:00:00',NULL,NULL
    union all select 71,'PRODUCT_IMAGE_THUMBNAIL_ELLIPSE','',4,15,'2003-12-15 13:14:57','0000-00-00 00:00:00',NULL,NULL
    union all select 72,'PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES','',4,16,'2003-12-15 13:19:45','0000-00-00 00:00:00',NULL,NULL
    union all select 73,'PRODUCT_IMAGE_THUMBNAIL_MERGE','',4,17,'2003-12-15 12:01:43','0000-00-00 00:00:00',NULL,NULL
    union all select 74,'PRODUCT_IMAGE_THUMBNAIL_FRAME','',4,18,'2003-12-15 13:19:37','0000-00-00 00:00:00',NULL,NULL
    union all select 75,'PRODUCT_IMAGE_THUMBNAIL_DROP_SHADDOW','',4,19,'2003-12-15 13:15:14','0000-00-00 00:00:00',NULL,NULL
    union all select 76,'PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR','',4,20,'2003-12-15 12:02:19','0000-00-00 00:00:00',NULL,NULL
    union all select 77,'PRODUCT_IMAGE_INFO_BEVEL','',4,21,'2003-12-15 13:42:09','0000-00-00 00:00:00',NULL,NULL
    union all select 78,'PRODUCT_IMAGE_INFO_GREYSCALE','',4,22,'2003-12-15 13:18:00','0000-00-00 00:00:00',NULL,NULL
    union all select 79,'PRODUCT_IMAGE_INFO_ELLIPSE','',4,23,'2003-12-15 13:41:53','0000-00-00 00:00:00',NULL,NULL
    union all select 80,'PRODUCT_IMAGE_INFO_ROUND_EDGES','',4,24,'2003-12-15 13:21:55','0000-00-00 00:00:00',NULL,NULL
    union all select 81,'PRODUCT_IMAGE_INFO_MERGE','',4,25,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 82,'PRODUCT_IMAGE_INFO_FRAME','',4,26,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 83,'PRODUCT_IMAGE_INFO_DROP_SHADDOW','',4,27,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 84,'PRODUCT_IMAGE_INFO_MOTION_BLUR','',4,28,'2003-12-15 13:21:18','0000-00-00 00:00:00',NULL,NULL
    union all select 85,'PRODUCT_IMAGE_POPUP_BEVEL','',4,29,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 86,'PRODUCT_IMAGE_POPUP_GREYSCALE','',4,30,'2003-12-15 13:22:58','0000-00-00 00:00:00',NULL,NULL
    union all select 87,'PRODUCT_IMAGE_POPUP_ELLIPSE','',4,31,'2003-12-15 13:22:51','0000-00-00 00:00:00',NULL,NULL
    union all select 88,'PRODUCT_IMAGE_POPUP_ROUND_EDGES','',4,32,'2003-12-15 13:23:17','0000-00-00 00:00:00',NULL,NULL
    union all select 89,'PRODUCT_IMAGE_POPUP_MERGE','',4,33,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 90,'PRODUCT_IMAGE_POPUP_FRAME','',4,34,'2003-12-15 13:22:43','0000-00-00 00:00:00',NULL,NULL
    union all select 91,'PRODUCT_IMAGE_POPUP_DROP_SHADDOW','',4,35,'2003-12-15 13:22:26','0000-00-00 00:00:00',NULL,NULL
    union all select 92,'PRODUCT_IMAGE_POPUP_MOTION_BLUR','',4,36,'2003-12-15 13:22:32','0000-00-00 00:00:00',NULL,NULL
    union all select 93,'MO_PICS','0',2147483647,3,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,NULL
    union all select 94,'IMAGE_MANIPULATOR','image_manipulator_GD2.php',4,3,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''image_manipulator_GD2.php'', ''image_manipulator_GD1.php''),'
    union all select 95,'ACCOUNT_GENDER','true',5,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 96,'ACCOUNT_DOB','true',5,2,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 97,'ACCOUNT_COMPANY','true',5,3,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 98,'ACCOUNT_SUBURB','false',5,4,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 99,'ACCOUNT_STATE','true',5,5,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 100,'ACCOUNT_OPTIONS','account',1000000017,6,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''account'', ''guest'', ''both''),'
    union all select 101,'DELETE_GUEST_ACCOUNT','true',1000000017,7,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 102,'MODULE_PAYMENT_INSTALLED','banktransfer.php;cod.php',6,0,'2008-05-15 14:28:06','0000-00-00 00:00:00',NULL,NULL
    union all select 103,'MODULE_ORDER_TOTAL_INSTALLED','ot_subtotal.php;ot_discount.php;ot_shipping.php;ot_subtotal_no_tax.php;ot_tax.php;ot_total.php',6,0,'2008-02-12 14:49:24','0000-00-00 00:00:00',NULL,NULL
    union all select 104,'MODULE_SHIPPING_INSTALLED','dp.php;selfpickup.php',6,0,'2008-05-15 16:29:07','0000-00-00 00:00:00',NULL,NULL
    union all select 105,'DEFAULT_CURRENCY','EUR',6,0,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 106,'DEFAULT_LANGUAGE','de',6,0,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 107,'DEFAULT_ORDERS_STATUS_ID','1',6,0,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 108,'DEFAULT_PRODUCTS_VPE_ID','1',6,0,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 109,'DEFAULT_SHIPPING_STATUS_ID','1',6,0,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 110,'MODULE_ORDER_TOTAL_SHIPPING_STATUS','true',6,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 111,'MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER','30',6,2,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 112,'MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING','false',6,3,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 113,'MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER','50',6,4,NULL,'0000-00-00 00:00:00','currencies->format',NULL
    union all select 114,'MODULE_ORDER_TOTAL_SHIPPING_DESTINATION','national',6,5,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''national'', ''international'', ''both''),'
    union all select 115,'MODULE_ORDER_TOTAL_SUBTOTAL_STATUS','true',6,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 116,'MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER','10',6,2,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 117,'MODULE_ORDER_TOTAL_TAX_STATUS','true',6,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 118,'MODULE_ORDER_TOTAL_TAX_SORT_ORDER','50',6,2,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 119,'MODULE_ORDER_TOTAL_TOTAL_STATUS','true',6,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 120,'MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER','99',6,2,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 121,'MODULE_ORDER_TOTAL_DISCOUNT_STATUS','true',6,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 122,'MODULE_ORDER_TOTAL_DISCOUNT_SORT_ORDER','20',6,2,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 123,'MODULE_ORDER_TOTAL_SUBTOTAL_NO_TAX_STATUS','true',6,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 124,'MODULE_ORDER_TOTAL_SUBTOTAL_NO_TAX_SORT_ORDER','40',6,2,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 125,'SHIPPING_ORIGIN_COUNTRY','81',7,1,NULL,'0000-00-00 00:00:00','xtc_get_country_name','xtc_cfg_pull_down_country_list('
    union all select 126,'SHIPPING_ORIGIN_ZIP','99817',7,2,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 127,'SHIPPING_MAX_WEIGHT','30',7,3,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 128,'SHIPPING_BOX_WEIGHT','3',7,4,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 129,'SHIPPING_BOX_PADDING','10',7,5,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 130,'SHOW_SHIPPING','true',7,6,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 131,'SHIPPING_INFOS','1',7,5,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 132,'PRODUCT_LIST_FILTER','1',8,1,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 133,'STOCK_CHECK','false',9,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 134,'ATTRIBUTE_STOCK_CHECK','true',9,2,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 135,'STOCK_LIMITED','false',9,3,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 136,'STOCK_ALLOW_CHECKOUT','true',9,4,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 137,'STOCK_MARK_PRODUCT_OUT_OF_STOCK','***',9,5,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 138,'STOCK_REORDER_LEVEL','5',9,6,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 139,'STORE_PAGE_PARSE_TIME','false',10,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 140,'STORE_PAGE_PARSE_TIME_LOG','/var/log/www/tep/page_parse_time.log',10,2,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 141,'STORE_PARSE_DATE_TIME_FORMAT','%d/%m/%Y %H:%M:%S',10,3,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 142,'DISPLAY_PAGE_PARSE_TIME','true',10,4,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 143,'STORE_DB_TRANSACTIONS','false',10,5,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 144,'USE_CACHE','false',11,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 145,'DIR_FS_CACHE','cache',11,2,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 146,'CACHE_LIFETIME','3600',11,3,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 147,'CACHE_CHECK','true',11,4,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 148,'DB_CACHE','false',11,5,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 149,'DB_CACHE_EXPIRE','3600',11,6,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 150,'EMAIL_TRANSPORT','sendmail',12,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''sendmail'', ''smtp'', ''mail''),'
    union all select 151,'SENDMAIL_PATH','/usr/sbin/sendmail',12,2,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 152,'SMTP_MAIN_SERVER','',12,3,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 153,'SMTP_Backup_Server','',12,4,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 154,'SMTP_PORT','',12,5,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 155,'SMTP_USERNAME','',12,6,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 156,'SMTP_PASSWORD','',12,7,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 157,'SMTP_AUTH','true',12,8,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 158,'EMAIL_LINEFEED','LF',12,9,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''LF'', ''CRLF''),'
    union all select 159,'EMAIL_USE_HTML','true',12,10,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 160,'ENTRY_EMAIL_ADDRESS_CHECK','false',12,11,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 161,'SEND_EMAILS','true',12,12,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 162,'CONTACT_US_EMAIL_ADDRESS','<<RSTI_OWNER_MAIL>>',12,20,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 163,'CONTACT_US_NAME','<<RSTI_OWNER_MAIL>>',12,21,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 164,'CONTACT_US_REPLY_ADDRESS','<<RSTI_OWNER_MAIL>>',12,22,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 165,'CONTACT_US_REPLY_ADDRESS_NAME','<<RSTI_OWNER_MAIL>>',12,23,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 166,'CONTACT_US_EMAIL_SUBJECT','<<RSTI_OWNER_MAIL>>',12,24,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 167,'CONTACT_US_FORWARDING_STRING','<<RSTI_OWNER_MAIL>>',12,25,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 168,'EMAIL_SUPPORT_ADDRESS','<<RSTI_OWNER_MAIL>>',12,26,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 169,'EMAIL_SUPPORT_NAME','<<RSTI_OWNER_MAIL>>',12,27,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 170,'EMAIL_SUPPORT_REPLY_ADDRESS','<<RSTI_OWNER_MAIL>>',12,28,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 171,'EMAIL_SUPPORT_REPLY_ADDRESS_NAME','<<RSTI_OWNER_MAIL>>',12,29,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 172,'EMAIL_SUPPORT_SUBJECT','<<RSTI_OWNER_MAIL>>',12,30,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 173,'EMAIL_SUPPORT_FORWARDING_STRING','<<RSTI_OWNER_MAIL>>',12,31,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 174,'EMAIL_BILLING_ADDRESS','<<RSTI_OWNER_MAIL>>',12,32,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 175,'EMAIL_BILLING_NAME','<<RSTI_OWNER_MAIL>>',12,33,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 176,'EMAIL_BILLING_REPLY_ADDRESS','<<RSTI_OWNER_MAIL>>',12,34,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 177,'EMAIL_BILLING_REPLY_ADDRESS_NAME','<<RSTI_OWNER_MAIL>>',12,35,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 178,'EMAIL_BILLING_SUBJECT','<<RSTI_OWNER_MAIL>>',12,36,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 179,'EMAIL_BILLING_FORWARDING_STRING','<<RSTI_OWNER_MAIL>>',12,37,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 180,'EMAIL_BILLING_SUBJECT_ORDER','Ihre Onlinebestellung Nr:{$nr} vom {$date}',12,38,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 181,'DOWNLOAD_ENABLED','false',13,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 182,'DOWNLOAD_BY_REDIRECT','false',13,2,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 183,'DOWNLOAD_UNALLOWED_PAYMENT','banktransfer,cod,invoice,moneyorder',13,5,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 184,'DOWNLOAD_MIN_ORDERS_STATUS','1',13,5,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 185,'GZIP_COMPRESSION','false',14,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 186,'GZIP_LEVEL','5',14,2,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 187,'SESSION_WRITE_DIRECTORY','/tmp',15,1,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 188,'SESSION_FORCE_COOKIE_USE','False',15,2,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''True'', ''False''),'
    union all select 189,'SESSION_CHECK_SSL_SESSION_ID','False',15,3,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''True'', ''False''),'
    union all select 190,'SESSION_CHECK_USER_AGENT','False',15,4,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''True'', ''False''),'
    union all select 191,'SESSION_CHECK_IP_ADDRESS','False',15,5,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''True'', ''False''),'
    union all select 192,'SESSION_RECREATE','False',15,7,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''True'', ''False''),'
    union all select 193,'META_MIN_KEYWORD_LENGTH','6',16,2,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 194,'META_KEYWORDS_NUMBER','20',16,3,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 195,'META_AUTHOR','<<RSTI_COMPANY_NAME>>',16,4,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 196,'META_PUBLISHER','litestore.de',16,5,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 197,'META_COMPANY','<<RSTI_COMPANY_NAME>>',16,6,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 198,'META_TOPIC','shopping',16,7,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 199,'META_REPLY_TO','',16,8,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 200,'META_REVISIT_AFTER','1',16,9,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 201,'META_ROBOTS','index,follow',16,10,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 202,'META_DESCRIPTION','<<RSTI_COMPANY_NAME>>',16,11,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 203,'META_KEYWORDS','<<RSTI_COMPANY_NAME>>',16,12,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 204,'CHECK_CLIENT_AGENT','false',16,13,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 205,'USE_WYSIWYG','true',1000000017,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 206,'ACTIVATE_GIFT_SYSTEM','false',1000000017,2,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 207,'SECURITY_CODE_LENGTH','10',1000000017,3,NULL,'2003-12-05 05:01:41',NULL,NULL
    union all select 208,'NEW_SIGNUP_GIFT_VOUCHER_AMOUNT','0',1000000017,4,NULL,'2003-12-05 05:01:41',NULL,NULL
    union all select 209,'NEW_SIGNUP_DISCOUNT_COUPON','',1000000017,5,NULL,'2003-12-05 05:01:41',NULL,NULL
    union all select 210,'ACTIVATE_SHIPPING_STATUS','true',17,6,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 211,'DISPLAY_CONDITIONS_ON_CHECKOUT','true',17,7,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 212,'SHOW_IP_LOG','false',17,8,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 213,'GROUP_CHECK','false',17,9,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 214,'ACTIVATE_NAVIGATOR','false',17,10,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 215,'QUICKLINK_ACTIVATED','true',17,11,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 216,'ACTIVATE_REVERSE_CROSS_SELLING','true',17,12,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 217,'DISPLAY_REVOCATION_ON_CHECKOUT','true',17,13,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 218,'REVOCATION_ID','',17,14,NULL,'2003-12-05 05:01:41',NULL,NULL
    union all select 219,'ACCOUNT_COMPANY_VAT_CHECK','true',18,4,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 220,'STORE_OWNER_VAT_ID','',18,3,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,NULL
    union all select 221,'DEFAULT_CUSTOMERS_VAT_STATUS_ID','1',18,23,'0000-00-00 00:00:00','0000-00-00 00:00:00','xtc_get_customers_status_name','xtc_cfg_pull_down_customers_status_list('
    union all select 222,'ACCOUNT_COMPANY_VAT_LIVE_CHECK','true',18,4,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 223,'ACCOUNT_COMPANY_VAT_GROUP','true',18,4,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 224,'ACCOUNT_VAT_BLOCK_ERROR','true',18,4,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 225,'DEFAULT_CUSTOMERS_VAT_STATUS_ID_LOCAL','3',18,24,NULL,'0000-00-00 00:00:00','xtc_get_customers_status_name','xtc_cfg_pull_down_customers_status_list('
    union all select 226,'GOOGLE_CONVERSION_ID','',19,2,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 227,'GOOGLE_LANG','de',19,3,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 229,'CSV_TEXTSIGN','\"',20,1,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 230,'CSV_SEPERATOR','    ',20,2,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 231,'COMPRESS_EXPORT','false',20,3,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 232,'AFTERBUY_PARTNERID','',21,2,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 233,'AFTERBUY_PARTNERPASS','',21,3,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 234,'AFTERBUY_USERID','',21,4,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 235,'AFTERBUY_ORDERSTATUS','1',21,5,NULL,'0000-00-00 00:00:00','xtc_get_order_status_name','xtc_cfg_pull_down_order_statuses('
    union all select 236,'AFTERBUY_ACTIVATED','false',21,6,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 237,'SEARCH_IN_DESC','true',22,2,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 238,'SEARCH_IN_ATTR','true',22,3,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 239,'TRACKING_ECONDA_ACTIVE','false',23,1,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),'
    union all select 240,'TRACKING_ECONDA_ID','',23,2,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 241,'MODULE_EXPORT_INSTALLED','golem.php;image_processing.php',6,0,'2008-04-28 15:44:27','2008-01-20 16:40:06',NULL,NULL
    union all select 242,'MODULE_IMAGE_PROCESS_STATUS','True',6,1,NULL,'2008-01-24 14:10:12',NULL,'xtc_cfg_select_option(array(''True'', ''False''), '
    union all select 243,'MODULE_PAYMENT_MONEYORDER_STATUS','True',6,1,NULL,'2008-02-13 16:25:20',NULL,'xtc_cfg_select_option(array(''True'', ''False''), '
    union all select 244,'MODULE_PAYMENT_MONEYORDER_ALLOWED','',6,0,NULL,'2008-02-13 16:25:20',NULL,NULL
    union all select 245,'MODULE_PAYMENT_MONEYORDER_PAYTO','Der Gesamtbetrag und die Bankverbindung wird Ihnen in der AuftragsbestÃƒÂ¤tigung mitgeteilt.',6,1,NULL,'2008-02-13 16:25:20',NULL,NULL
    union all select 246,'MODULE_PAYMENT_MONEYORDER_SORT_ORDER','10',6,0,NULL,'2008-02-13 16:25:20',NULL,NULL
    union all select 247,'MODULE_PAYMENT_MONEYORDER_ZONE','0',6,2,NULL,'2008-02-13 16:25:20','xtc_get_zone_class_title','xtc_cfg_pull_down_zone_classes('
    union all select 248,'MODULE_PAYMENT_MONEYORDER_ORDER_STATUS_ID','1',6,0,NULL,'2008-02-13 16:25:20','xtc_get_order_status_name','xtc_cfg_pull_down_order_statuses('
    union all select 335,'MODULE_PAYMENT_BANKTRANSFER_ORDER_STATUS_ID','0',6,0,NULL,'2008-04-03 14:01:33','xtc_get_order_status_name','xtc_cfg_pull_down_order_statuses('
    union all select 334,'MODULE_PAYMENT_BANKTRANSFER_SORT_ORDER','0',6,0,NULL,'2008-04-03 14:01:33',NULL,NULL
    union all select 333,'MODULE_PAYMENT_BANKTRANSFER_ALLOWED','',6,0,NULL,'2008-04-03 14:01:33',NULL,NULL
    union all select 332,'MODULE_PAYMENT_BANKTRANSFER_ZONE','0',6,2,NULL,'2008-04-03 14:01:33','xtc_get_zone_class_title','xtc_cfg_pull_down_zone_classes('
    union all select 331,'MODULE_PAYMENT_BANKTRANSFER_STATUS','True',6,1,NULL,'2008-04-03 14:01:33',NULL,'xtc_cfg_select_option(array(''True'', ''False''), '
    union all select 255,'MODULE_SHIPPING_DP_STATUS','True',6,0,NULL,'2008-04-03 13:31:21',NULL,'xtc_cfg_select_option(array(''True'', ''False''), '
    union all select 256,'MODULE_SHIPPING_DP_HANDLING','0',6,0,NULL,'2008-04-03 13:31:21',NULL,NULL
    union all select 257,'MODULE_SHIPPING_DP_TAX_CLASS','0',6,0,NULL,'2008-04-03 13:31:21','xtc_get_tax_class_title','xtc_cfg_pull_down_tax_classes('
    union all select 258,'MODULE_SHIPPING_DP_ZONE','0',6,0,NULL,'2008-04-03 13:31:21','xtc_get_zone_class_title','xtc_cfg_pull_down_zone_classes('
    union all select 259,'MODULE_SHIPPING_DP_SORT_ORDER','0',6,0,NULL,'2008-04-03 13:31:21',NULL,NULL
    union all select 260,'MODULE_SHIPPING_DP_ALLOWED','',6,0,NULL,'2008-04-03 13:31:21',NULL,NULL
    union all select 261,'MODULE_SHIPPING_DP_COUNTRIES_1','AD,AT,BE,CZ,DK,FO,FI,FR,GR,GL,IE,IT,LI,LU,MC,NL,PL,PT,SM,SK,SE,CH,VA,GB,SP',6,0,NULL,'2008-04-03 13:31:21',NULL,NULL
    union all select 262,'MODULE_SHIPPING_DP_COST_1','5:16.50,10:20.50,20:28.50',6,0,NULL,'2008-04-03 13:31:21',NULL,NULL
    union all select 263,'MODULE_SHIPPING_DP_COUNTRIES_2','AL,AM,AZ,BY,BA,BG,HR,CY,GE,GI,HU,IS,KZ,LT,MK,MT,MD,NO,SI,UA,TR,YU,RU,RO,LV,EE',6,0,NULL,'2008-04-03 13:31:21',NULL,NULL
    union all select 264,'MODULE_SHIPPING_DP_COST_2','5:25.00,10:35.00,20:45.00',6,0,NULL,'2008-04-03 13:31:21',NULL,NULL
    union all select 265,'MODULE_SHIPPING_DP_COUNTRIES_3','DZ,BH,CA,EG,IR,IQ,IL,JO,KW,LB,LY,OM,SA,SY,US,AE,YE,MA,QA,TN,PM',6,0,NULL,'2008-04-03 13:31:21',NULL,NULL
    union all select 266,'MODULE_SHIPPING_DP_COST_3','5:29.00,10:39.00,20:59.00',6,0,NULL,'2008-04-03 13:31:21',NULL,NULL
    union all select 267,'MODULE_SHIPPING_DP_COUNTRIES_4','AF,AS,AO,AI,AG,AR,AW,AU,BS,BD,BB,BZ,BJ,BM,BT,BO,BW,BR,IO,BN,BF,BI,KH,CM,CV,KY,CF,TD,CL,CN,CC,CO,KM,CG,CR,CI,CU,DM,DO,EC,SV,ER,ET,FK,FJ,GF,PF,GA,GM,GH,GD,GP,GT,GN,GW,GY,HT,HN,HK,IN,ID,JM,JP,KE,KI,KG,KP,KR,LA,LS',6,0,NULL,'2008-04-03 13:31:21',NULL,NULL
    union all select 268,'MODULE_SHIPPING_DP_COST_4','5:35.00,10:50.00,20:80.00',6,0,NULL,'2008-04-03 13:31:21',NULL,NULL
    union all select 269,'MODULE_SHIPPING_DP_COUNTRIES_5','MO,MG,MW,MY,MV,ML,MQ,MR,MU,MX,MN,MS,MZ,MM,NA,NR,NP,AN,NC,NZ,NI,NE,NG,PK,PA,PG,PY,PE,PH,PN,RE,KN,LC,VC,SN,SC,SL,SO,LK,SR,SZ,ZA,SG,TG,TH,TZ,TT,TO,TM,TV,VN,WF,VE,UG,UZ,UY,ST,SH,SD,TW,GQ,LR,DJ,CG,RW,ZM,ZW',6,0,NULL,'2008-04-03 13:31:21',NULL,NULL
    union all select 270,'MODULE_SHIPPING_DP_COST_5','5:35.00,10:50.00,20:80.00',6,0,NULL,'2008-04-03 13:31:21',NULL,NULL
    union all select 271,'MODULE_SHIPPING_DP_COUNTRIES_6','DE',6,0,NULL,'2008-04-03 13:31:21',NULL,NULL
    union all select 272,'MODULE_SHIPPING_DP_COST_6','5:6.70,10:9.70,20:13.00',6,0,NULL,'2008-04-03 13:31:21',NULL,NULL
    union all select 354,'MODULE_SHIPPING_SELFPICKUP_ALLOWED','',6,0,NULL,'2008-05-15 11:59:57',NULL,NULL
    union all select 355,'MODULE_SHIPPING_SELFPICKUP_SORT_ORDER','0',6,4,NULL,'2008-05-15 11:59:57',NULL,NULL
    union all select 353,'MODULE_SHIPPING_SELFPICKUP_STATUS','True',6,7,NULL,'2008-05-15 11:59:57',NULL,'xtc_cfg_select_option(array(''True'', ''False''), '
    union all select 348,'CURRENT_BACKGROUND','gruenes1.jpg',666,NULL,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 349,'CURRENT_LOGO','meinonlineshop.de.png',666,NULL,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 350,'ADSENSE_PUBID','pub-5799004657015467',667,NULL,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 351,'ADSENSE_SLOT','9815371424',667,NULL,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 352,'ADSENSE_ACTIVE','on',667,NULL,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 347,'CURRENT_CSS','rot.css',666,NULL,NULL,'0000-00-00 00:00:00',NULL,NULL
    union all select 345,'MODULE_GOLEM_FILE','golem.xml',6,1,NULL,'2008-04-28 15:44:26',NULL,''
    union all select 346,'MODULE_GOLEM_STATUS','True',6,1,NULL,'2008-04-28 15:44:26',NULL,'xtc_cfg_select_option(array(''True'', ''False''), '
    union all select 343,'MODULE_PAYMENT_COD_SORT_ORDER','0',6,0,NULL,'2008-04-03 14:01:36',NULL,NULL
    union all select 344,'MODULE_PAYMENT_COD_ORDER_STATUS_ID','0',6,0,NULL,'2008-04-03 14:01:36','xtc_get_order_status_name','xtc_cfg_pull_down_order_statuses('
    union all select 341,'MODULE_PAYMENT_COD_ALLOWED','',6,0,NULL,'2008-04-03 14:01:36',NULL,NULL
    union all select 342,'MODULE_PAYMENT_COD_ZONE','0',6,2,NULL,'2008-04-03 14:01:36','xtc_get_zone_class_title','xtc_cfg_pull_down_zone_classes('
    union all select 338,'MODULE_PAYMENT_BANKTRANSFER_URL_NOTE','fax.html',6,0,NULL,'2008-04-03 14:01:33',NULL,NULL
    union all select 339,'MODULE_PAYMENT_BANKTRANSFER_MIN_ORDER','0',6,0,NULL,'2008-04-03 14:01:33',NULL,NULL
    union all select 340,'MODULE_PAYMENT_COD_STATUS','True',6,1,NULL,'2008-04-03 14:01:36',NULL,'xtc_cfg_select_option(array(''True'', ''False''), '
    union all select 336,'MODULE_PAYMENT_BANKTRANSFER_FAX_CONFIRMATION','false',6,2,NULL,'2008-04-03 14:01:33',NULL,'xtc_cfg_select_option(array(''true'', ''false''), '
    union all select 337,'MODULE_PAYMENT_BANKTRANSFER_DATABASE_BLZ','false',6,0,NULL,'2008-04-03 14:01:33',NULL,'xtc_cfg_select_option(array(''true'', ''false''), '
    union all select 1021,'GOOGLE_CONVERSION_REGISTER','',76,3,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_textarea('
    union all select 1022,'GOOGLE_CONVERSION_BUY','',76,2,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_textarea('
    union all select 228,'GOOGLE_CONVERSION','false',76,0,NULL,'0000-00-00 00:00:00',NULL,'xtc_cfg_select_option(array(''true'', ''false''),';


create table `configuration_group` 
(
    `configuration_group_id`            integer primary key  auto_increment,
    `configuration_group_title`         text NOT NULL,
    `configuration_group_description`   text NOT NULL,
    `sort_order`                        integer default NULL,
    `visible`                           integer default '1'
);

insert into `configuration_group` values (1,'My Store','General information about my store',1,1);
insert into `configuration_group` values (2,'Minimum values','The minimum values for functions / data',2,1);
insert into `configuration_group` values (3,'Maximum values','The maximum values for functions / data',3,1);
insert into `configuration_group` values (4,'Images','Image parameters',4,1);
insert into `configuration_group` values (5,'Customer Details','Customer account configuration',5,1);
insert into `configuration_group` values (6,'Module Options','Hidden from configuration',6,0);
insert into `configuration_group` values (7,'Shipping/Packaging','Shipping options available at my store',7,1);
insert into `configuration_group` values (8,'Product Listing','Product Listing    configuration options',8,1);
insert into `configuration_group` values (9,'Stock','Stock configuration options',9,1);
insert into `configuration_group` values (10,'Logging','Logging configuration options',10,1);
insert into `configuration_group` values (11,'Cache','Caching configuration options',11,1);
insert into `configuration_group` values (12,'E-Mail Options','General setting for E-Mail transport and HTML E-Mails',12,1);
insert into `configuration_group` values (13,'Download','Downloadable products options',13,1);
insert into `configuration_group` values (14,'GZip Compression','GZip compression options',14,1);
insert into `configuration_group` values (15,'Sessions','Session options',15,1);
insert into `configuration_group` values (16,'Meta-Tags/Search engines','Meta-tags/Search engines',16,1);
insert into `configuration_group` values (18,'Vat ID','Vat ID',18,1);
insert into `configuration_group` values (19,'Google Conversion','Google Conversion-Tracking',19,1);
insert into `configuration_group` values (20,'Import/Export','Import/Export',20,1);
insert into `configuration_group` values (21,'Afterbuy','Afterbuy.de',21,1);
insert into `configuration_group` values (22,'Search Options','Additional Options for search function',22,1);

create table `content_manager` 
(
    `content_id`        integer primary key  auto_increment,
    `categories_id`     integer  NOT NULL default '0',
    `parent_id`         integer  NOT NULL default '0' references `content_manager` (`content_id`),
    `group_ids`         text,
    `languages_id`      integer  NOT NULL default '0' references `languages` (`language_id`),
    `content_title`     text NOT NULL,
    `content_heading`   text NOT NULL,
    `content_text`      text NOT NULL,
    `sort_order`        integer NOT NULL default '0',
    `file_flag`         integer NOT NULL default '0',
    `content_file`      text NOT NULL default '',
    `content_status`    integer NOT NULL default '0',
    `content_group`     integer  NOT NULL,
    `content_delete`    integer NOT NULL default '1'
);

insert into `content_manager` values (6,0,0,'',2,'Liefer- und Versandkosten','Liefer- und Versandkosten','',0,1,'versandkosten.html',1,1,0);
insert into `content_manager` values (7,0,0,'',2,'Privatsphäre und Datenschutz','Privatsphäre und Datenschutz','',0,1,'agb.html',0,2,0);
insert into `content_manager` values (8,0,0,'',2,'AGB''s','Allgemeine Gesch&auml;ftsbedingungen','',0,1,'agb.html',1,3,0);
insert into `content_manager` values (9,0,0,'',2,'Impressum','Impressum','',0,1,'impressum.html',1,4,0);
insert into `content_manager` values (10,0,0,'',2,'Index','','Willkommen',0,1,'',0,5,0);


create table `counter` 
(
    `startdate` char default NULL,
    `counter`   integer default NULL
);

create table `counter_history` 
(
    `month`     char default NULL,
    `counter`   integer default NULL
);


create table `countries` 
(
    `countries_id` integer primary key  auto_increment,
    `countries_name` text NOT NULL,
    `countries_iso_code_2` text NOT NULL,
    `countries_iso_code_3` text NOT NULL,
    `address_format_id` integer  NOT NULL,
    `status` integer default '1'
);

insert into `countries` values (1,'Afghanistan','AF','AFG',1,1);
insert into `countries` values (2,'Albania','AL','ALB',1,1);
insert into `countries` values (3,'Algeria','DZ','DZA',1,1);
insert into `countries` values (4,'American Samoa','AS','ASM',1,1);
insert into `countries` values (5,'Andorra','AD','AND',1,1);
insert into `countries` values (6,'Angola','AO','AGO',1,1);
insert into `countries` values (7,'Anguilla','AI','AIA',1,1);
insert into `countries` values (8,'Antarctica','AQ','ATA',1,1);
insert into `countries` values (9,'Antigua and Barbuda','AG','ATG',1,1);
insert into `countries` values (10,'Argentina','AR','ARG',1,1);
insert into `countries` values (11,'Armenia','AM','ARM',1,1);
insert into `countries` values (12,'Aruba','AW','ABW',1,1);
insert into `countries` values (13,'Australia','AU','AUS',1,1);
insert into `countries` values (14,'Austria','AT','AUT',5,1);
insert into `countries` values (15,'Azerbaijan','AZ','AZE',1,1);
insert into `countries` values (16,'Bahamas','BS','BHS',1,1);
insert into `countries` values (17,'Bahrain','BH','BHR',1,1);
insert into `countries` values (18,'Bangladesh','BD','BGD',1,1);
insert into `countries` values (19,'Barbados','BB','BRB',1,1);
insert into `countries` values (20,'Belarus','BY','BLR',1,1);
insert into `countries` values (21,'Belgium','BE','BEL',1,1);
insert into `countries` values (22,'Belize','BZ','BLZ',1,1);
insert into `countries` values (23,'Benin','BJ','BEN',1,1);
insert into `countries` values (24,'Bermuda','BM','BMU',1,1);
insert into `countries` values (25,'Bhutan','BT','BTN',1,1);
insert into `countries` values (26,'Bolivia','BO','BOL',1,1);
insert into `countries` values (27,'Bosnia and Herzegowina','BA','BIH',1,1);
insert into `countries` values (28,'Botswana','BW','BWA',1,1);
insert into `countries` values (29,'Bouvet Island','BV','BVT',1,1);
insert into `countries` values (30,'Brazil','BR','BRA',1,1);
insert into `countries` values (31,'British Indian Ocean Territory','IO','IOT',1,1);
insert into `countries` values (32,'Brunei Darussalam','BN','BRN',1,1);
insert into `countries` values (33,'Bulgaria','BG','BGR',1,1);
insert into `countries` values (34,'Burkina Faso','BF','BFA',1,1);
insert into `countries` values (35,'Burundi','BI','BDI',1,1);
insert into `countries` values (36,'Cambodia','KH','KHM',1,1);
insert into `countries` values (37,'Cameroon','CM','CMR',1,1);
insert into `countries` values (38,'Canada','CA','CAN',1,1);
insert into `countries` values (39,'Cape Verde','CV','CPV',1,1);
insert into `countries` values (40,'Cayman Islands','KY','CYM',1,1);
insert into `countries` values (41,'Central African Republic','CF','CAF',1,1);
insert into `countries` values (42,'Chad','TD','TCD',1,1);
insert into `countries` values (43,'Chile','CL','CHL',1,1);
insert into `countries` values (44,'China','CN','CHN',1,1);
insert into `countries` values (45,'Christmas Island','CX','CXR',1,1);
insert into `countries` values (46,'Cocos (Keeling) Islands','CC','CCK',1,1);
insert into `countries` values (47,'Colombia','CO','COL',1,1);
insert into `countries` values (48,'Comoros','KM','COM',1,1);
insert into `countries` values (49,'Congo','CG','COG',1,1);
insert into `countries` values (50,'Cook Islands','CK','COK',1,1);
insert into `countries` values (51,'Costa Rica','CR','CRI',1,1);
insert into `countries` values (52,'Cote D''Ivoire','CI','CIV',1,1);
insert into `countries` values (53,'Croatia','HR','HRV',1,1);
insert into `countries` values (54,'Cuba','CU','CUB',1,1);
insert into `countries` values (55,'Cyprus','CY','CYP',1,1);
insert into `countries` values (56,'Czech Republic','CZ','CZE',1,1);
insert into `countries` values (57,'Denmark','DK','DNK',1,1);
insert into `countries` values (58,'Djibouti','DJ','DJI',1,1);
insert into `countries` values (59,'Dominica','DM','DMA',1,1);
insert into `countries` values (60,'Dominican Republic','DO','DOM',1,1);
insert into `countries` values (61,'East Timor','TP','TMP',1,1);
insert into `countries` values (62,'Ecuador','EC','ECU',1,1);
insert into `countries` values (63,'Egypt','EG','EGY',1,1);
insert into `countries` values (64,'El Salvador','SV','SLV',1,1);
insert into `countries` values (65,'Equatorial Guinea','GQ','GNQ',1,1);
insert into `countries` values (66,'Eritrea','ER','ERI',1,1);
insert into `countries` values (67,'Estonia','EE','EST',1,1);
insert into `countries` values (68,'Ethiopia','ET','ETH',1,1);
insert into `countries` values (69,'Falkland Islands (Malvinas)','FK','FLK',1,1);
insert into `countries` values (70,'Faroe Islands','FO','FRO',1,1);
insert into `countries` values (71,'Fiji','FJ','FJI',1,1);
insert into `countries` values (72,'Finland','FI','FIN',1,1);
insert into `countries` values (73,'France','FR','FRA',1,1);
insert into `countries` values (74,'France, Metropolitan','FX','FXX',1,1);
insert into `countries` values (75,'French Guiana','GF','GUF',1,1);
insert into `countries` values (76,'French Polynesia','PF','PYF',1,1);
insert into `countries` values (77,'French Southern Territories','TF','ATF',1,1);
insert into `countries` values (78,'Gabon','GA','GAB',1,1);
insert into `countries` values (79,'Gambia','GM','GMB',1,1);
insert into `countries` values (80,'Georgia','GE','GEO',1,1);
insert into `countries` values (81,'Germany','DE','DEU',5,1);
insert into `countries` values (82,'Ghana','GH','GHA',1,1);
insert into `countries` values (83,'Gibraltar','GI','GIB',1,1);
insert into `countries` values (84,'Greece','GR','GRC',1,1);
insert into `countries` values (85,'Greenland','GL','GRL',1,1);
insert into `countries` values (86,'Grenada','GD','GRD',1,1);
insert into `countries` values (87,'Guadeloupe','GP','GLP',1,1);
insert into `countries` values (88,'Guam','GU','GUM',1,1);
insert into `countries` values (89,'Guatemala','GT','GTM',1,1);
insert into `countries` values (90,'Guinea','GN','GIN',1,1);
insert into `countries` values (91,'Guinea-bissau','GW','GNB',1,1);
insert into `countries` values (92,'Guyana','GY','GUY',1,1);
insert into `countries` values (93,'Haiti','HT','HTI',1,1);
insert into `countries` values (94,'Heard and Mc Donald Islands','HM','HMD',1,1);
insert into `countries` values (95,'Honduras','HN','HND',1,1);
insert into `countries` values (96,'Hong Kong','HK','HKG',1,1);
insert into `countries` values (97,'Hungary','HU','HUN',1,1);
insert into `countries` values (98,'Iceland','IS','ISL',1,1);
insert into `countries` values (99,'India','IN','IND',1,1);
insert into `countries` values (100,'Indonesia','ID','IDN',1,1);
insert into `countries` values (101,'Iran (Islamic Republic of)','IR','IRN',1,1);
insert into `countries` values (102,'Iraq','IQ','IRQ',1,1);
insert into `countries` values (103,'Ireland','IE','IRL',1,1);
insert into `countries` values (104,'Israel','IL','ISR',1,1);
insert into `countries` values (105,'Italy','IT','ITA',1,1);
insert into `countries` values (106,'Jamaica','JM','JAM',1,1);
insert into `countries` values (107,'Japan','JP','JPN',1,1);
insert into `countries` values (108,'Jordan','JO','JOR',1,1);
insert into `countries` values (109,'Kazakhstan','KZ','KAZ',1,1);
insert into `countries` values (110,'Kenya','KE','KEN',1,1);
insert into `countries` values (111,'Kiribati','KI','KIR',1,1);
insert into `countries` values (112,'Korea, Democratic People''s Republic of','KP','PRK',1,1);
insert into `countries` values (113,'Korea, Republic of','KR','KOR',1,1);
insert into `countries` values (114,'Kuwait','KW','KWT',1,1);
insert into `countries` values (115,'Kyrgyzstan','KG','KGZ',1,1);
insert into `countries` values (116,'Lao People''s Democratic Republic','LA','LAO',1,1);
insert into `countries` values (117,'Latvia','LV','LVA',1,1);
insert into `countries` values (118,'Lebanon','LB','LBN',1,1);
insert into `countries` values (119,'Lesotho','LS','LSO',1,1);
insert into `countries` values (120,'Liberia','LR','LBR',1,1);
insert into `countries` values (121,'Libyan Arab Jamahiriya','LY','LBY',1,1);
insert into `countries` values (122,'Liechtenstein','LI','LIE',1,1);
insert into `countries` values (123,'Lithuania','LT','LTU',1,1);
insert into `countries` values (124,'Luxembourg','LU','LUX',1,1);
insert into `countries` values (125,'Macau','MO','MAC',1,1);
insert into `countries` values (126,'Macedonia, The Former Yugoslav Republic of','MK','MKD',1,1);
insert into `countries` values (127,'Madagascar','MG','MDG',1,1);
insert into `countries` values (128,'Malawi','MW','MWI',1,1);
insert into `countries` values (129,'Malaysia','MY','MYS',1,1);
insert into `countries` values (130,'Maldives','MV','MDV',1,1);
insert into `countries` values (131,'Mali','ML','MLI',1,1);
insert into `countries` values (132,'Malta','MT','MLT',1,1);
insert into `countries` values (133,'Marshall Islands','MH','MHL',1,1);
insert into `countries` values (134,'Martinique','MQ','MTQ',1,1);
insert into `countries` values (135,'Mauritania','MR','MRT',1,1);
insert into `countries` values (136,'Mauritius','MU','MUS',1,1);
insert into `countries` values (137,'Mayotte','YT','MYT',1,1);
insert into `countries` values (138,'Mexico','MX','MEX',1,1);
insert into `countries` values (139,'Micronesia, Federated States of','FM','FSM',1,1);
insert into `countries` values (140,'Moldova, Republic of','MD','MDA',1,1);
insert into `countries` values (141,'Monaco','MC','MCO',1,1);
insert into `countries` values (142,'Mongolia','MN','MNG',1,1);
insert into `countries` values (143,'Montserrat','MS','MSR',1,1);
insert into `countries` values (144,'Morocco','MA','MAR',1,1);
insert into `countries` values (145,'Mozambique','MZ','MOZ',1,1);
insert into `countries` values (146,'Myanmar','MM','MMR',1,1);
insert into `countries` values (147,'Namibia','NA','NAM',1,1);
insert into `countries` values (148,'Nauru','NR','NRU',1,1);
insert into `countries` values (149,'Nepal','NP','NPL',1,1);
insert into `countries` values (150,'Netherlands','NL','NLD',1,1);
insert into `countries` values (151,'Netherlands Antilles','AN','ANT',1,1);
insert into `countries` values (152,'New Caledonia','NC','NCL',1,1);
insert into `countries` values (153,'New Zealand','NZ','NZL',1,1);
insert into `countries` values (154,'Nicaragua','NI','NIC',1,1);
insert into `countries` values (155,'Niger','NE','NER',1,1);
insert into `countries` values (156,'Nigeria','NG','NGA',1,1);
insert into `countries` values (157,'Niue','NU','NIU',1,1);
insert into `countries` values (158,'Norfolk Island','NF','NFK',1,1);
insert into `countries` values (159,'Northern Mariana Islands','MP','MNP',1,1);
insert into `countries` values (160,'Norway','NO','NOR',1,1);
insert into `countries` values (161,'Oman','OM','OMN',1,1);
insert into `countries` values (162,'Pakistan','PK','PAK',1,1);
insert into `countries` values (163,'Palau','PW','PLW',1,1);
insert into `countries` values (164,'Panama','PA','PAN',1,1);
insert into `countries` values (165,'Papua New Guinea','PG','PNG',1,1);
insert into `countries` values (166,'Paraguay','PY','PRY',1,1);
insert into `countries` values (167,'Peru','PE','PER',1,1);
insert into `countries` values (168,'Philippines','PH','PHL',1,1);
insert into `countries` values (169,'Pitcairn','PN','PCN',1,1);
insert into `countries` values (170,'Poland','PL','POL',1,1);
insert into `countries` values (171,'Portugal','PT','PRT',1,1);
insert into `countries` values (172,'Puerto Rico','PR','PRI',1,1);
insert into `countries` values (173,'Qatar','QA','QAT',1,1);
insert into `countries` values (174,'Reunion','RE','REU',1,1);
insert into `countries` values (175,'Romania','RO','ROM',1,1);
insert into `countries` values (176,'Russian Federation','RU','RUS',1,1);
insert into `countries` values (177,'Rwanda','RW','RWA',1,1);
insert into `countries` values (178,'Saint Kitts and Nevis','KN','KNA',1,1);
insert into `countries` values (179,'Saint Lucia','LC','LCA',1,1);
insert into `countries` values (180,'Saint Vincent and the Grenadines','VC','VCT',1,1);
insert into `countries` values (181,'Samoa','WS','WSM',1,1);
insert into `countries` values (182,'San Marino','SM','SMR',1,1);
insert into `countries` values (183,'Sao Tome and Principe','ST','STP',1,1);
insert into `countries` values (184,'Saudi Arabia','SA','SAU',1,1);
insert into `countries` values (185,'Senegal','SN','SEN',1,1);
insert into `countries` values (186,'Seychelles','SC','SYC',1,1);
insert into `countries` values (187,'Sierra Leone','SL','SLE',1,1);
insert into `countries` values (188,'Singapore','SG','SGP',4,1);
insert into `countries` values (189,'Slovakia (Slovak Republic)','SK','SVK',1,1);
insert into `countries` values (190,'Slovenia','SI','SVN',1,1);
insert into `countries` values (191,'Solomon Islands','SB','SLB',1,1);
insert into `countries` values (192,'Somalia','SO','SOM',1,1);
insert into `countries` values (193,'South Africa','ZA','ZAF',1,1);
insert into `countries` values (194,'South Georgia and the South Sandwich Islands','GS','SGS',1,1);
insert into `countries` values (195,'Spain','ES','ESP',3,1);
insert into `countries` values (196,'Sri Lanka','LK','LKA',1,1);
insert into `countries` values (197,'St. Helena','SH','SHN',1,1);
insert into `countries` values (198,'St. Pierre and Miquelon','PM','SPM',1,1);
insert into `countries` values (199,'Sudan','SD','SDN',1,1);
insert into `countries` values (200,'Suriname','SR','SUR',1,1);
insert into `countries` values (201,'Svalbard and Jan Mayen Islands','SJ','SJM',1,1);
insert into `countries` values (202,'Swaziland','SZ','SWZ',1,1);
insert into `countries` values (203,'Sweden','SE','SWE',1,1);
insert into `countries` values (204,'Switzerland','CH','CHE',1,1);
insert into `countries` values (205,'Syrian Arab Republic','SY','SYR',1,1);
insert into `countries` values (206,'Taiwan','TW','TWN',1,1);
insert into `countries` values (207,'Tajikistan','TJ','TJK',1,1);
insert into `countries` values (208,'Tanzania, United Republic of','TZ','TZA',1,1);
insert into `countries` values (209,'Thailand','TH','THA',1,1);
insert into `countries` values (210,'Togo','TG','TGO',1,1);
insert into `countries` values (211,'Tokelau','TK','TKL',1,1);
insert into `countries` values (212,'Tonga','TO','TON',1,1);
insert into `countries` values (213,'Trinidad and Tobago','TT','TTO',1,1);
insert into `countries` values (214,'Tunisia','TN','TUN',1,1);
insert into `countries` values (215,'Turkey','TR','TUR',1,1);
insert into `countries` values (216,'Turkmenistan','TM','TKM',1,1);
insert into `countries` values (217,'Turks and Caicos Islands','TC','TCA',1,1);
insert into `countries` values (218,'Tuvalu','TV','TUV',1,1);
insert into `countries` values (219,'Uganda','UG','UGA',1,1);
insert into `countries` values (220,'Ukraine','UA','UKR',1,1);
insert into `countries` values (221,'United Arab Emirates','AE','ARE',1,1);
insert into `countries` values (222,'United Kingdom','GB','GBR',1,1);
insert into `countries` values (223,'United States','US','USA',2,1);
insert into `countries` values (224,'United States Minor Outlying Islands','UM','UMI',1,1);
insert into `countries` values (225,'Uruguay','UY','URY',1,1);
insert into `countries` values (226,'Uzbekistan','UZ','UZB',1,1);
insert into `countries` values (227,'Vanuatu','VU','VUT',1,1);
insert into `countries` values (228,'Vatican City State (Holy See)','VA','VAT',1,1);
insert into `countries` values (229,'Venezuela','VE','VEN',1,1);
insert into `countries` values (230,'Viet Nam','VN','VNM',1,1);
insert into `countries` values (231,'Virgin Islands (British)','VG','VGB',1,1);
insert into `countries` values (232,'Virgin Islands (U.S.)','VI','VIR',1,1);
insert into `countries` values (233,'Wallis and Futuna Islands','WF','WLF',1,1);
insert into `countries` values (234,'Western Sahara','EH','ESH',1,1);
insert into `countries` values (235,'Yemen','YE','YEM',1,1);
insert into `countries` values (236,'Yugoslavia','YU','YUG',1,1);
insert into `countries` values (237,'Zaire','ZR','ZAR',1,1);
insert into `countries` values (238,'Zambia','ZM','ZMB',1,1);
insert into `countries` values (239,'Zimbabwe','ZW','ZWE',1,1);


create table `currencies` 
(
    `currencies_id`     integer primary key  auto_increment,
    `title`             text  NOT NULL,
    `code`              text NOT NULL,
    `symbol_left`       text default NULL,
    `symbol_right`      text default NULL,
    `decimal_point`     char default NULL,
    `thousands_point`   char default NULL,
    `decimal_places`    char default NULL,
    `value`             real default NULL,
    `last_updated`      datetime default NULL
);

insert into `currencies` values (1,'Euro','EUR','','EUR',',','.','2',1.00000000,'2008-01-20 11:05:21');


create table `customers` 
(
    `customers_id`                  integer  primary key  auto_increment,
    `customers_cid`                 varchar(1000)  default NULL unique,
    `customers_vat_id`              text  default NULL,
    `customers_vat_id_status`       integer  NOT NULL default '0',
    `customers_warning`             text  default NULL,
    `customers_status`              integer  NOT NULL default '1' references `customers_status`(`customers_status_id`),
    `customers_gender`              char     NOT NULL,
    `customers_firstname`           text  NOT NULL,
    `customers_lastname`            text  NOT NULL,
    `customers_dob`                 datetime NOT NULL default '0000-00-00 00:00:00',
    `customers_email_address`       text NOT NULL,
    `customers_default_address_id`  integer  NOT NULL,
    `customers_telephone`           text  NOT NULL,
    `customers_fax`                 text  default NULL,
    `customers_password`            text NOT NULL,
    `customers_newsletter`          char default NULL,
    `customers_newsletter_mode`     char NOT NULL default '0',
    `member_flag`                   char NOT NULL default '0',
    `delete_user`                   char NOT NULL default '1',
    `account_type`                  integer NOT NULL default '0',
    `password_request_key`          text  NOT NULL,
    `payment_unallowed`             text NOT NULL,
    `shipping_unallowed`            text NOT NULL,
    `refferers_id`                  integer NOT NULL default '0',
    `customers_date_added`          datetime default '0000-00-00 00:00:00',
    `customers_last_modified`       datetime default '0000-00-00 00:00:00'
);

insert into `customers` values (1,'admin','',0,NULL,0,'m','<<RSTI_OWNER_FIRST_NAME>>','<<RSTI_OWNER_LAST_NAME>>','2987-01-26 00:00:00','<<RSTI_OWNER_MAIL>>',1,'000','','21232f297a57a5a743894a0e4a801fc3','1','0','0','0',0,'','','',0,'0000-00-00 00:00:00','2008-05-15 13:08:17');



create table `customers_basket` 
(
    `customers_basket_id`           integer  primary key  auto_increment,
    `customers_id`                  integer references `customers` (`customers_id`),
    `products_id`                   text NOT NULL,
    `customers_basket_quantity`     integer NOT NULL,
    `final_price`                   real NOT NULL,
    `customers_basket_date_added`   char default NULL
);


create table `customers_basket_attributes` 
(
    `customers_basket_attributes_id`    integer  primary key  auto_increment,
    `customers_id`                      integer  NOT NULL references `customers` (`customers_id`),
    `products_id`                       text NOT NULL,
    `products_options_id`               integer    NOT NULL,
    `products_options_value_id`         integer  NOT NULL
);


create table `customers_info` 
(
    `customers_info_id`                         integer  primary key,
    `customers_info_date_of_last_logon`         datetime default NULL,
    `customers_info_number_of_logons`           integer default NULL,
    `customers_info_date_account_created`       datetime default NULL,
    `customers_info_date_account_last_modified` datetime default NULL,
    `global_product_notifications`              integer default '0'
);



create table `customers_ip` 
(
    `customers_ip_id`       integer  primary key  auto_increment,
    `customers_id`          integer  NOT NULL default '0' references `customers` (`customers_id`),
    `customers_ip`          text  NOT NULL default '',
    `customers_ip_date`     datetime NOT NULL default '0000-00-00 00:00:00',
    `customers_host`        text NOT NULL default '',
    `customers_advertiser`  text default NULL,
    `customers_referer_url` text default NULL
);


create table `customers_memo` 
(
    `memo_id`       integer  primary key  auto_increment,
    `customers_id`  integer  NOT NULL default '0',
    `memo_date`     date NOT NULL default '0000-00-00',
    `memo_title`    text NOT NULL,
    `memo_text`     text NOT NULL,
    `poster_id`     integer  NOT NULL default '0'
);


create table `customers_status` 
(
    `customers_status_id`               integer  NOT NULL default '0',
    `languages_id`                      integer  NOT NULL default '1'  references `languages` (`language_id`),
    `customers_status_name`             text  NOT NULL default '',
    `customers_status_public`           integer NOT NULL default '1',
    `customers_status_min_order`        integer default NULL,
    `customers_status_max_order`        integer default NULL,
    `customers_status_image`            text default NULL,
    `customers_status_discount`         real default '0.00',
    `customers_status_ot_discount_flag` char NOT NULL default '0',
    `customers_status_ot_discount`      real default '0.00',
    `customers_status_graduated_prices` varchar(1000) NOT NULL default '0',
    `customers_status_show_price`       integer NOT NULL default '1',
    `customers_status_show_price_tax`   integer NOT NULL default '1',
    `customers_status_add_tax_ot`       integer NOT NULL default '0',
    `customers_status_payment_unallowed` text NOT NULL default '',
    `customers_status_shipping_unallowed` text NOT NULL default '',
    `customers_status_discount_attributes` integer NOT NULL default '0',
    `customers_fsk18`                   integer NOT NULL default '1',
    `customers_fsk18_display`           integer NOT NULL default '1',
    `customers_status_write_reviews`    integer NOT NULL default '1',
    `customers_status_read_reviews`     integer NOT NULL default '1',
    primary key (`customers_status_id`,`languages_id`)
);

insert into `customers_status` values (0,2,'Admin',1,0,0,'admin_status.gif','0.00','0','0.00','0',1,1,0,'','',0,0,0,0,0);
insert into `customers_status` values (1,2,'Gast',1,0,0,'guest_status.gif','0.00','0','0.00','0',1,1,0,'','',0,1,0,0,0);
insert into `customers_status` values (2,2,'Neuer Kunde',1,0,0,'customer_status.gif','0.00','0','0.00','0',1,1,0,'','',0,1,1,0,1);
insert into `customers_status` values (3,2,'Kunde, Vorkasse',1,0,0,'merchant_status.gif','0.00','0','0.00','0',1,1,0,'invoice','',0,1,1,0,0);
insert into `customers_status` values (4,2,'Kunde, Rechnung',1,0,0,NULL,'0.00','0','0.00','0',1,1,0,'','',0,0,0,0,0);


create table `customers_status_history` 
(
    `customers_status_history_id`   integer primary key  auto_increment,
    `customers_id`                  integer  NOT NULL default '0' references `customers` (`customers_id`),
    `new_value`                     integer NOT NULL default '0',
    `old_value`                     integer default NULL,
    `date_added`                    datetime NOT NULL default '0000-00-00 00:00:00',
    `customer_notified`             integer default '0'
);


create table `geo_zones` 
(
    `geo_zone_id`           integer primary key  auto_increment,
    `geo_zone_name`         text  NOT NULL,
    `geo_zone_description`  text NOT NULL,
    `last_modified`         datetime default NULL,
    `date_added`            datetime NOT NULL
);

insert into `geo_zones` values (6,'Steuerzone EU-Ausland','','0000-00-00 00:00:00','2008-01-20 11:12:18');
insert into `geo_zones` values (5,'Steuerzone EU','Steuerzone fü die EU','0000-00-00 00:00:00','2008-01-20 11:12:18');
insert into `geo_zones` values (7,'Steuerzone B2B','',NULL,'2008-01-20 11:12:18');


create table `languages` 
(
    `languages_id`      integer  primary key auto_increment,
    `name`              text  NOT NULL default '',
    `code`              varchar(1000)  NOT NULL default '' unique,
    `image`             text  default NULL,
    `directory`         text  default NULL,
    `sort_order`        integer  default NULL,
    `language_charset`  text NOT NULL
);

insert into `languages` values (2,'Deutsch','de','icon.gif','german',1,'UTF-8');


create table `manufacturers` 
(
    `manufacturers_id`      integer  primary key auto_increment,
    `manufacturers_name`    varchar(1000)  NOT NULL default '' unique,
    `manufacturers_image`   text default NULL,
    `date_added`            datetime default NULL,
    `last_modified`         datetime default NULL
);



create table `manufacturers_info` 
(
    `manufacturers_id`               integer  NOT NULL references `manufacturers` (`manufacturers_id`),
    `languages_id`                   integer  NOT NULL references `languages` (`languages_id`),
    `manufacturers_meta_title`       text NOT NULL,
    `manufacturers_meta_description` text NOT NULL,
    `manufacturers_meta_keywords`    text NOT NULL,
    `manufacturers_url`              text NOT NULL,
    `url_clicked`                    integer NOT NULL default '0',
    `date_last_click`                datetime default NULL,
    primary key (`manufacturers_id`,`languages_id`)
);


create table `module_newsletter` 
(
    `newsletter_id` integer  primary key auto_increment,
    `title`         text NOT NULL,
    `bc`            text NOT NULL,
    `cc`            text NOT NULL,
    `date`          datetime default NULL,
    `status`        integer NOT NULL default '0',
    `body`          text NOT NULL
);


create table `newsletter_recipients` 
(
    `mail_id`                 integer  primary key auto_increment,
    `customers_email_address` text NOT NULL default '',
    `customers_id`            integer  NOT NULL default '0',
    `customers_status`        integer NOT NULL default '0',
    `customers_firstname`     text  NOT NULL default '',
    `customers_lastname`      text  NOT NULL default '',
    `mail_status`             integer NOT NULL default '0',
    `mail_key`                text  NOT NULL default '',
    `date_added`              datetime NOT NULL default '0000-00-00 00:00:00'
);


create table `newsletters` 
(
  `newsletters_id`          integer  primary key auto_increment,
  `title`                   text NOT NULL,
  `content`                 text NOT NULL,
  `module`                  text NOT NULL,
  `date_added`              datetime NOT NULL,
  `date_sent`               datetime default NULL,
  `status`                  integer default NULL,
  `locked`                  integer default '0'
);


create table `newsletters_history` 
(
    `news_hist_id` integer  primary key,
    `news_hist_cs` integer  NOT NULL default '0',
    `news_hist_cs_date_sent` date default NULL
);

create table `orders` 
(
    `orders_id`                     integer primary key auto_increment,
    `customers_id`                  integer NOT NULL references `customers` (`customers_id`),
    `customers_cid`                 text default NULL,
    `customers_vat_id`              text default NULL,
    `customers_status`              integer default NULL,
    `customers_status_name`         text NOT NULL,
    `customers_status_image`        text default NULL,
    `customers_status_discount`     real    default NULL,
    `customers_name`                text NOT NULL,
    `customers_firstname`           text NOT NULL,
    `customers_lastname`            text NOT NULL,
    `customers_company`             text default NULL,
    `customers_street_address`      text NOT NULL,
    `customers_suburb`              text default NULL,
    `customers_city`                text NOT NULL,
    `customers_postcode`            text NOT NULL,
    `customers_state`               text default NULL,
    `customers_country`             text NOT NULL,
    `customers_telephone`           text NOT NULL,
    `customers_email_address`       text NOT NULL,
    `customers_address_format_id`   integer NOT NULL,
    `delivery_name`                 text NOT NULL,
    `delivery_firstname`            text NOT NULL,
    `delivery_lastname`             text NOT NULL,
    `delivery_company`              text default NULL,
    `delivery_street_address`       text NOT NULL,
    `delivery_suburb`               text default NULL,
    `delivery_city`                 text NOT NULL,
    `delivery_postcode`             text NOT NULL,
    `delivery_state`                text default NULL,
    `delivery_country`              text NOT NULL,
    `delivery_country_iso_code_2`   text NOT NULL,
    `delivery_address_format_id`    integer NOT NULL,
    `billing_name`                  text NOT NULL,
    `billing_firstname`             text NOT NULL,
    `billing_lastname`              text NOT NULL,
    `billing_company`               text default NULL,
    `billing_street_address`        text NOT NULL,
    `billing_suburb`                text default NULL,
    `billing_city`                  text NOT NULL,
    `billing_postcode`              text NOT NULL,
    `billing_state`                 text default NULL,
    `billing_country`               text NOT NULL,
    `billing_country_iso_code_2`    text NOT NULL,
    `billing_address_format_id`     integer NOT NULL,
    `payment_method`                text NOT NULL,
    `cc_type`                       text default NULL,
    `cc_owner`                      text default NULL,
    `cc_number`                     text default NULL,
    `cc_expires`                    text default NULL,
    `cc_start`                      text default NULL,
    `cc_issue`                      text default NULL,
    `cc_cvv`                        text default NULL,
    `comments`                      text default NULL,
    `last_modified`                 datetime default NULL,
    `date_purchased`                datetime default NULL,
    `orders_status`                 integer NOT NULL,
    `orders_date_finished`          datetime default NULL,
    `currency`                      text default NULL,
    `currency_value`                real default NULL,
    `account_type`                  integer NOT NULL default '0',
    `payment_class`                 text NOT NULL,
    `shipping_method`               text NOT NULL,
    `shipping_class`                text NOT NULL,
    `customers_ip`                  text NOT NULL,
    `language`                      text NOT NULL,
    `afterbuy_success`              integer NOT NULL default '0',
    `afterbuy_id`                   int NOT NULL default '0',
    `refferers_id`                  text NOT NULL,
    `conversion_type`               integer NOT NULL default '0',
    `orders_ident_key`              text default NULL
);

create table `orders_products` 
(
    `orders_products_id`        integer primary key auto_increment,
    `orders_id`                 integer  NOT NULL references `orders` (`orders_id`),
    `products_id`               integer  NOT NULL,
    `products_model`            text default NULL,
    `products_name`             text NOT NULL,
    `products_price`            real NOT NULL,
    `products_discount_made`    real default NULL,
    `products_shipping_time`    text default NULL,
    `final_price`               real NOT NULL,
    `products_tax`              real NOT NULL,
    `products_quantity`         integer NOT NULL,
    `allow_tax`                 integer NOT NULL
);


create table `orders_products_attributes` 
(
    `orders_products_attributes_id` integer primary key auto_increment,
    `orders_id`                     integer NOT NULL references `orders` (`orders_id`),
    `orders_products_id`            integer NOT NULL references `orders_products` (`orders_products_id`),
    `products_options`              text NOT NULL,
    `products_options_values`       text NOT NULL,
    `options_values_price`          real NOT NULL,
    `price_prefix`                  char NOT NULL
);


create table `orders_products_download` 
(
    `orders_products_download_id`   integer primary key auto_increment,
    `orders_id`                     integer  NOT NULL default '0' references `orders` (`orders_id`),
    `orders_products_id`            integer  NOT NULL default '0',
    `orders_products_filename`      text NOT NULL default '',
    `download_maxdays`              integer NOT NULL default '0',
    `download_count`                integer NOT NULL default '0'
);


create table `orders_recalculate` 
(
    `orders_recalculate_id` integer primary key auto_increment,
    `orders_id`             integer  NOT NULL default '0',
    `n_price`               real NOT NULL default '0.0000',
    `b_price`               real NOT NULL default '0.0000',
    `tax`                   real NOT NULL default '0.0000',
    `tax_rate`              real NOT NULL default '0.0000',
    `class`                 text  NOT NULL default ''
);


create table `orders_status` 
(
    `orders_status_id`      integer  NOT NULL default '0',
    `languages_id`          integer  NOT NULL default '1' references `languages`(`languages_id`),
    `orders_status_name`    text  NOT NULL default '',
    primary key  (`orders_status_id`,`languages_id`)
);

insert into `orders_status` values (1,2,'Offen');
insert into `orders_status` values (2,2,'In Bearbeitung');
insert into `orders_status` values (3,2,'Versendet');
insert into `orders_status` values (4,2,'warten auf Zahlungseingang');
insert into `orders_status` values (5,2,'Bestellung storniert');


create table `orders_status_history` 
(
    `orders_status_history_id`  integer  primary key auto_increment,
    `orders_id`                 integer  NOT NULL references `orders` (`orders_id`),
    `orders_status_id`          integer  NOT NULL references `orders_status` (`orders_status_id`),
    `date_added`                datetime NOT NULL,
    `customer_notified`         integer  default '0',
    `comments`                  text
);


create table `orders_total` 
(
    `orders_total_id`   integer primary key auto_increment,
    `orders_id`         integer  NOT NULL,
    `title`             text NOT NULL,
    `text`              text NOT NULL,
    `value`             real NOT NULL,
    `class`             text  NOT NULL,
    `sort_order`        integer  NOT NULL
);


create table `payment_moneybookers` 
(
    `mb_TRID`    varchar(1000) primary key NOT NULL,
    `mb_ERRNO`   integer  unsigned NOT NULL default '0',
    `mb_ERRTXT`  text NOT NULL default '',
    `mb_DATE`    datetime NOT NULL default '0000-00-00 00:00:00',
    `mb_MBTID`   integer unsigned NOT NULL default '0',
    `mb_STATUS`  integer NOT NULL default '0',
    `mb_ORDERID` integer  unsigned NOT NULL default '0'
);


create table `payment_moneybookers_countries` 
(
    `osc_cID`   integer   primary key NOT NULL,
    `mb_cID`    text NOT NULL default ''
);

insert into `payment_moneybookers_countries` values (2,'ALB');
insert into `payment_moneybookers_countries` values (3,'ALG');
insert into `payment_moneybookers_countries` values (4,'AME');
insert into `payment_moneybookers_countries` values (5,'AND');
insert into `payment_moneybookers_countries` values (6,'AGL');
insert into `payment_moneybookers_countries` values (7,'ANG');
insert into `payment_moneybookers_countries` values (9,'ANT');
insert into `payment_moneybookers_countries` values (10,'ARG');
insert into `payment_moneybookers_countries` values (11,'ARM');
insert into `payment_moneybookers_countries` values (12,'ARU');
insert into `payment_moneybookers_countries` values (13,'AUS');
insert into `payment_moneybookers_countries` values (14,'AUT');
insert into `payment_moneybookers_countries` values (15,'AZE');
insert into `payment_moneybookers_countries` values (16,'BMS');
insert into `payment_moneybookers_countries` values (17,'BAH');
insert into `payment_moneybookers_countries` values (18,'BAN');
insert into `payment_moneybookers_countries` values (19,'BAR');
insert into `payment_moneybookers_countries` values (20,'BLR');
insert into `payment_moneybookers_countries` values (21,'BGM');
insert into `payment_moneybookers_countries` values (22,'BEL');
insert into `payment_moneybookers_countries` values (23,'BEN');
insert into `payment_moneybookers_countries` values (24,'BER');
insert into `payment_moneybookers_countries` values (26,'BOL');
insert into `payment_moneybookers_countries` values (27,'BOS');
insert into `payment_moneybookers_countries` values (28,'BOT');
insert into `payment_moneybookers_countries` values (30,'BRA');
insert into `payment_moneybookers_countries` values (32,'BRU');
insert into `payment_moneybookers_countries` values (33,'BUL');
insert into `payment_moneybookers_countries` values (34,'BKF');
insert into `payment_moneybookers_countries` values (35,'BUR');
insert into `payment_moneybookers_countries` values (36,'CAM');
insert into `payment_moneybookers_countries` values (37,'CMR');
insert into `payment_moneybookers_countries` values (38,'CAN');
insert into `payment_moneybookers_countries` values (39,'CAP');
insert into `payment_moneybookers_countries` values (40,'CAY');
insert into `payment_moneybookers_countries` values (41,'CEN');
insert into `payment_moneybookers_countries` values (42,'CHA');
insert into `payment_moneybookers_countries` values (43,'CHL');
insert into `payment_moneybookers_countries` values (44,'CHN');
insert into `payment_moneybookers_countries` values (47,'COL');
insert into `payment_moneybookers_countries` values (49,'CON');
insert into `payment_moneybookers_countries` values (51,'COS');
insert into `payment_moneybookers_countries` values (52,'COT');
insert into `payment_moneybookers_countries` values (53,'CRO');
insert into `payment_moneybookers_countries` values (54,'CUB');
insert into `payment_moneybookers_countries` values (55,'CYP');
insert into `payment_moneybookers_countries` values (56,'CZE');
insert into `payment_moneybookers_countries` values (57,'DEN');
insert into `payment_moneybookers_countries` values (58,'DJI');
insert into `payment_moneybookers_countries` values (59,'DOM');
insert into `payment_moneybookers_countries` values (60,'DRP');
insert into `payment_moneybookers_countries` values (62,'ECU');
insert into `payment_moneybookers_countries` values (64,'EL_');
insert into `payment_moneybookers_countries` values (65,'EQU');
insert into `payment_moneybookers_countries` values (66,'ERI');
insert into `payment_moneybookers_countries` values (67,'EST');
insert into `payment_moneybookers_countries` values (68,'ETH');
insert into `payment_moneybookers_countries` values (70,'FAR');
insert into `payment_moneybookers_countries` values (71,'FIJ');
insert into `payment_moneybookers_countries` values (72,'FIN');
insert into `payment_moneybookers_countries` values (73,'FRA');
insert into `payment_moneybookers_countries` values (75,'FRE');
insert into `payment_moneybookers_countries` values (78,'GAB');
insert into `payment_moneybookers_countries` values (79,'GAM');
insert into `payment_moneybookers_countries` values (80,'GEO');
insert into `payment_moneybookers_countries` values (81,'GER');
insert into `payment_moneybookers_countries` values (82,'GHA');
insert into `payment_moneybookers_countries` values (83,'GIB');
insert into `payment_moneybookers_countries` values (84,'GRC');
insert into `payment_moneybookers_countries` values (85,'GRL');
insert into `payment_moneybookers_countries` values (87,'GDL');
insert into `payment_moneybookers_countries` values (88,'GUM');
insert into `payment_moneybookers_countries` values (89,'GUA');
insert into `payment_moneybookers_countries` values (90,'GUI');
insert into `payment_moneybookers_countries` values (91,'GBS');
insert into `payment_moneybookers_countries` values (92,'GUY');
insert into `payment_moneybookers_countries` values (93,'HAI');
insert into `payment_moneybookers_countries` values (95,'HON');
insert into `payment_moneybookers_countries` values (96,'HKG');
insert into `payment_moneybookers_countries` values (97,'HUN');
insert into `payment_moneybookers_countries` values (98,'ICE');
insert into `payment_moneybookers_countries` values (99,'IND');
insert into `payment_moneybookers_countries` values (101,'IRN');
insert into `payment_moneybookers_countries` values (102,'IRA');
insert into `payment_moneybookers_countries` values (103,'IRE');
insert into `payment_moneybookers_countries` values (104,'ISR');
insert into `payment_moneybookers_countries` values (105,'ITA');
insert into `payment_moneybookers_countries` values (106,'JAM');
insert into `payment_moneybookers_countries` values (107,'JAP');
insert into `payment_moneybookers_countries` values (108,'JOR');
insert into `payment_moneybookers_countries` values (109,'KAZ');
insert into `payment_moneybookers_countries` values (110,'KEN');
insert into `payment_moneybookers_countries` values (112,'SKO');
insert into `payment_moneybookers_countries` values (113,'KOR');
insert into `payment_moneybookers_countries` values (114,'KUW');
insert into `payment_moneybookers_countries` values (115,'KYR');
insert into `payment_moneybookers_countries` values (116,'LAO');
insert into `payment_moneybookers_countries` values (117,'LAT');
insert into `payment_moneybookers_countries` values (141,'MCO');
insert into `payment_moneybookers_countries` values (119,'LES');
insert into `payment_moneybookers_countries` values (120,'LIB');
insert into `payment_moneybookers_countries` values (121,'LBY');
insert into `payment_moneybookers_countries` values (122,'LIE');
insert into `payment_moneybookers_countries` values (123,'LIT');
insert into `payment_moneybookers_countries` values (124,'LUX');
insert into `payment_moneybookers_countries` values (125,'MAC');
insert into `payment_moneybookers_countries` values (126,'F.Y');
insert into `payment_moneybookers_countries` values (127,'MAD');
insert into `payment_moneybookers_countries` values (128,'MLW');
insert into `payment_moneybookers_countries` values (129,'MLS');
insert into `payment_moneybookers_countries` values (130,'MAL');
insert into `payment_moneybookers_countries` values (131,'MLI');
insert into `payment_moneybookers_countries` values (132,'MLT');
insert into `payment_moneybookers_countries` values (134,'MAR');
insert into `payment_moneybookers_countries` values (135,'MRT');
insert into `payment_moneybookers_countries` values (136,'MAU');
insert into `payment_moneybookers_countries` values (138,'MEX');
insert into `payment_moneybookers_countries` values (140,'MOL');
insert into `payment_moneybookers_countries` values (142,'MON');
insert into `payment_moneybookers_countries` values (143,'MTT');
insert into `payment_moneybookers_countries` values (144,'MOR');
insert into `payment_moneybookers_countries` values (145,'MOZ');
insert into `payment_moneybookers_countries` values (76,'PYF');
insert into `payment_moneybookers_countries` values (147,'NAM');
insert into `payment_moneybookers_countries` values (149,'NEP');
insert into `payment_moneybookers_countries` values (150,'NED');
insert into `payment_moneybookers_countries` values (151,'NET');
insert into `payment_moneybookers_countries` values (152,'CDN');
insert into `payment_moneybookers_countries` values (153,'NEW');
insert into `payment_moneybookers_countries` values (154,'NIC');
insert into `payment_moneybookers_countries` values (155,'NIG');
insert into `payment_moneybookers_countries` values (69,'FLK');
insert into `payment_moneybookers_countries` values (160,'NWY');
insert into `payment_moneybookers_countries` values (161,'OMA');
insert into `payment_moneybookers_countries` values (162,'PAK');
insert into `payment_moneybookers_countries` values (164,'PAN');
insert into `payment_moneybookers_countries` values (165,'PAP');
insert into `payment_moneybookers_countries` values (166,'PAR');
insert into `payment_moneybookers_countries` values (167,'PER');
insert into `payment_moneybookers_countries` values (168,'PHI');
insert into `payment_moneybookers_countries` values (170,'POL');
insert into `payment_moneybookers_countries` values (171,'POR');
insert into `payment_moneybookers_countries` values (172,'PUE');
insert into `payment_moneybookers_countries` values (173,'QAT');
insert into `payment_moneybookers_countries` values (175,'ROM');
insert into `payment_moneybookers_countries` values (176,'RUS');
insert into `payment_moneybookers_countries` values (177,'RWA');
insert into `payment_moneybookers_countries` values (178,'SKN');
insert into `payment_moneybookers_countries` values (179,'SLU');
insert into `payment_moneybookers_countries` values (180,'ST.');
insert into `payment_moneybookers_countries` values (181,'WES');
insert into `payment_moneybookers_countries` values (182,'SAN');
insert into `payment_moneybookers_countries` values (183,'SAO');
insert into `payment_moneybookers_countries` values (184,'SAU');
insert into `payment_moneybookers_countries` values (185,'SEN');
insert into `payment_moneybookers_countries` values (186,'SEY');
insert into `payment_moneybookers_countries` values (187,'SIE');
insert into `payment_moneybookers_countries` values (188,'SIN');
insert into `payment_moneybookers_countries` values (189,'SLO');
insert into `payment_moneybookers_countries` values (190,'SLV');
insert into `payment_moneybookers_countries` values (191,'SOL');
insert into `payment_moneybookers_countries` values (192,'SOM');
insert into `payment_moneybookers_countries` values (193,'SOU');
insert into `payment_moneybookers_countries` values (195,'SPA');
insert into `payment_moneybookers_countries` values (196,'SRI');
insert into `payment_moneybookers_countries` values (199,'SUD');
insert into `payment_moneybookers_countries` values (200,'SUR');
insert into `payment_moneybookers_countries` values (202,'SWA');
insert into `payment_moneybookers_countries` values (203,'SWE');
insert into `payment_moneybookers_countries` values (204,'SWI');
insert into `payment_moneybookers_countries` values (205,'SYR');
insert into `payment_moneybookers_countries` values (206,'TWN');
insert into `payment_moneybookers_countries` values (207,'TAJ');
insert into `payment_moneybookers_countries` values (208,'TAN');
insert into `payment_moneybookers_countries` values (209,'THA');
insert into `payment_moneybookers_countries` values (210,'TOG');
insert into `payment_moneybookers_countries` values (212,'TON');
insert into `payment_moneybookers_countries` values (213,'TRI');
insert into `payment_moneybookers_countries` values (214,'TUN');
insert into `payment_moneybookers_countries` values (215,'TUR');
insert into `payment_moneybookers_countries` values (216,'TKM');
insert into `payment_moneybookers_countries` values (217,'TCI');
insert into `payment_moneybookers_countries` values (219,'UGA');
insert into `payment_moneybookers_countries` values (231,'BRI');
insert into `payment_moneybookers_countries` values (221,'UAE');
insert into `payment_moneybookers_countries` values (222,'GBR');
insert into `payment_moneybookers_countries` values (223,'UNI');
insert into `payment_moneybookers_countries` values (225,'URU');
insert into `payment_moneybookers_countries` values (226,'UZB');
insert into `payment_moneybookers_countries` values (227,'VAN');
insert into `payment_moneybookers_countries` values (229,'VEN');
insert into `payment_moneybookers_countries` values (230,'VIE');
insert into `payment_moneybookers_countries` values (232,'US_');
insert into `payment_moneybookers_countries` values (235,'YEM');
insert into `payment_moneybookers_countries` values (236,'YUG');
insert into `payment_moneybookers_countries` values (238,'ZAM');
insert into `payment_moneybookers_countries` values (239,'ZIM');


create table `payment_moneybookers_currencies` 
(
    `mb_currID`     varchar(1000) primary key NOT NULL,
    `mb_currName`   text NOT NULL default ''
);

insert into `payment_moneybookers_currencies` values ('AUD','Australian Dollar');
insert into `payment_moneybookers_currencies` values ('BGN','Bulgarian Lev');
insert into `payment_moneybookers_currencies` values ('CAD','Canadian Dollar');
insert into `payment_moneybookers_currencies` values ('CHF','Swiss Franc');
insert into `payment_moneybookers_currencies` values ('CZK','Czech Koruna');
insert into `payment_moneybookers_currencies` values ('DKK','Danish Krone');
insert into `payment_moneybookers_currencies` values ('EEK','Estonian Koruna');
insert into `payment_moneybookers_currencies` values ('EUR','Euro');
insert into `payment_moneybookers_currencies` values ('GBP','Pound Sterling');
insert into `payment_moneybookers_currencies` values ('HKD','Hong Kong Dollar');
insert into `payment_moneybookers_currencies` values ('HUF','Forint');
insert into `payment_moneybookers_currencies` values ('ILS','Shekel');
insert into `payment_moneybookers_currencies` values ('ISK','Iceland Krona');
insert into `payment_moneybookers_currencies` values ('JPY','Yen');
insert into `payment_moneybookers_currencies` values ('KRW','South-Korean Won');
insert into `payment_moneybookers_currencies` values ('LVL','Latvian Lat');
insert into `payment_moneybookers_currencies` values ('MYR','Malaysian Ringgit');
insert into `payment_moneybookers_currencies` values ('NOK','Norwegian Krone');
insert into `payment_moneybookers_currencies` values ('NZD','New Zealand Dollar');
insert into `payment_moneybookers_currencies` values ('PLN','Zloty');
insert into `payment_moneybookers_currencies` values ('SEK','Swedish Krona');
insert into `payment_moneybookers_currencies` values ('SGD','Singapore Dollar');
insert into `payment_moneybookers_currencies` values ('SKK','Slovak Koruna');
insert into `payment_moneybookers_currencies` values ('THB','Baht');
insert into `payment_moneybookers_currencies` values ('TWD','New Taiwan Dollar');
insert into `payment_moneybookers_currencies` values ('USD','US Dollar');
insert into `payment_moneybookers_currencies` values ('ZAR','South-African Rand');

create table `payment_qenta` 
(
    `q_TRID`        varchar(1000)  primary key NOT NULL,
    `q_DATE`        datetime NOT NULL default '0000-00-00 00:00:00',
    `q_QTID`        integer unsigned NOT NULL default '0',
    `q_ORDERDESC`   text NOT NULL default '',
    `q_STATUS`      integer NOT NULL default '0',
    `q_ORDERID`     integer  unsigned NOT NULL default '0'
);


create table `products` 
(
    `products_id`               integer primary key auto_increment,
    `products_ean`              text default NULL,
    `products_quantity`         integer NOT NULL default '0',
    `products_shippingtime`     integer NOT NULL default '0',
    `products_model`            varchar(1000) default NULL unique,
    `products_sort`             integer NOT NULL default '0',
    `products_price`            real NOT NULL default '0.0000',
    `products_discount_allowed` real NOT NULL default '0.00',
    `products_date_added`       datetime NOT NULL default '0000-00-00 00:00:00',
    `products_last_modified`    datetime default NULL,
    `products_date_available`   datetime default NULL,
    `products_weight`           real NOT NULL default '0.00',
    `products_status`           integer NOT NULL default '0',
    `products_tax_class_id`     integer  NOT NULL default '0',
    `product_template`          text default NULL,
    `options_template`          text default NULL,
    `manufacturers_id`          integer  default NULL,
    `products_ordered`          integer  NOT NULL default '0',
    `products_fsk18`            integer NOT NULL default '0',
    `products_vpe_id`           integer  NOT NULL default '0' references `products_vpe` (`products_vpe_id`),
    `products_vpe_status`       integer NOT NULL default '0',
    `products_vpe_value`        real NOT NULL default '0.0000',
    `products_startpage`        integer NOT NULL default '0',
    `products_startpage_sort`   integer NOT NULL default '0',
    `products_trading_unit`     integer NOT NULL default '1',
    `ibc_supplies`              text default NULL
);


create table `products_attributes` 
(
    `products_attributes_id`    integer primary key auto_increment,
    `products_id`               integer  NOT NULL,
    `options_id`                integer  NOT NULL,
    `options_values_id`         integer  NOT NULL,
    `options_values_price`      real NOT NULL,
    `price_prefix`              char NOT NULL,
    `attributes_model`          text default NULL,
    `attributes_stock`          integer default NULL,
    `options_values_weight`     real NOT NULL,
    `weight_prefix`             char NOT NULL,
    `sortorder`                 integer  default NULL
);



create table `products_attributes_download` 
(
    `products_attributes_id`        integer primary key NOT NULL references `products_attributes` (`products_attributes_id`) ,
    `products_attributes_filename`  text NOT NULL default '',
    `products_attributes_maxdays`   integer default '0',
    `products_attributes_maxcount`  integer default '0'
);


create table `products_content` 
(
    `content_id`    integer  primary key auto_increment,
    `products_id`   integer  NOT NULL default '0' references `products` (`products_id`),
    `group_ids`     text,
    `content_name`  text  NOT NULL default '',
    `content_file`  text NOT NULL,
    `content_link`  text NOT NULL,
    `languages_id`  integer  NOT NULL default '0' references  `languages` (`languages_id`),
    `content_read`  integer  NOT NULL default '0',
    `file_comment`  text NOT NULL
);


create table `products_description` 
(
    `products_id`                integer NOT NULL references `products` (`products_id`),
    `languages_id`               integer  NOT NULL default '1' references `languages` (`languages_id`),
    `products_name`              text NOT NULL,
    `products_description`       text,
    `products_short_description` text,
    `products_keywords`          text default NULL,
    `products_meta_title`        text NOT NULL,
    `products_meta_description`  text NOT NULL,
    `products_meta_keywords`     text NOT NULL,
    `products_url`               text default NULL,
    `products_viewed`            integer,
    `products_trading_unit_name` text NOT NULL,
    primary key (`products_id`,`languages_id`)
);


create table `products_graduated_prices` 
(
    `products_id`   integer  NOT NULL primary key references `products` (`products_id`),
    `quantity`      integer  NOT NULL,
    `unitprice`     real NOT NULL
);


create table `products_images` 
(
    `image_nr`      integer primary key auto_increment,
    `products_id`   integer NOT NULL references `products` (`products_id`),
    `url_small`     text NOT NULL,
    `url_middle`    text,
    `url_big`       text,
    unique  (`image_nr`,`products_id`)
);


create table `products_notifications` 
(
    `products_id`   integer  NOT NULL  references `products` (`products_id`),
    `customers_id`  integer  NOT NULL  references `customers` (`customers_id`),
    `date_added`    datetime NOT NULL,
    primary key  (`products_id`,`customers_id`)
);


create table `products_options` 
(
    `products_options_id`   integer  NOT NULL default '0',
    `languages_id`          integer  NOT NULL default '1' references `languages` (`languages_id`),
    `products_options_name` text  NOT NULL default '',
    primary key (`products_options_id`,`languages_id`)
);


create table `products_options_values` 
(
    `products_options_values_id` integer  NOT NULL default '0',
    `languages_id` integer  NOT NULL default '1'  references `languages` (`languages_id`),
    `products_options_values_name` text NOT NULL default '',
    primary key  (`products_options_values_id`,`languages_id`)
);


create table `products_options_values_to_products_options` 
(
    `products_options_values_to_products_options_id`    integer primary key auto_increment,
    `products_options_id`                               integer  NOT NULL references `products_options` (`products_options_id`) ,
    `products_options_values_id`                        integer  NOT NULL references `products_options_values` (`products_options_values_id`)
);


create table `products_to_categories` 
(
    `products_id`   integer  NOT NULL references `products` (`products_id`) ,
    `categories_id` integer  NOT NULL references `categories` (`categories_id`),
    primary key  (`products_id`,`categories_id`)
);


create table `products_vpe` 
(
    `products_vpe_id` integer NOT NULL,
    `languages_id` integer  NOT NULL default '0' references `languages` (`languages_id`),
    `products_vpe_name` varchar(900)  NOT NULL default '',
    unique (`products_vpe_id`,`languages_id`),
    unique (`products_vpe_name`,`languages_id`)
); 

insert into `products_vpe` values (1,1,'kg');
insert into `products_vpe` values (1,2,'kg');



create table `products_xsell` 
(
    `ID`                            integer primary key auto_increment,
    `products_id`                   integer unsigned NOT NULL default '1' references `products` (`products_id` ) ,
    `products_xsell_grp_name_id`    integer unsigned NOT NULL default '1',
    `xsell_id`                      integer unsigned NOT NULL default '1',
    `sort_order`                    integer unsigned NOT NULL default '1'
);



create table `products_xsell_grp_name` 
(
    `products_xsell_grp_name_id`    integer NOT NULL,
    `xsell_sort_order`              integer NOT NULL default '0',
    `language_id`                   integer NOT NULL default '0',
    `groupname`                     text NOT NULL default ''
);


create table `reviews` 
(
    `reviews_id`        integer  primary key auto_increment,
    `products_id`       integer  NOT NULL references `products` (`products_id`),
    `customers_id`      integer  default NULL references `customers` (`customers_id`),
    `customers_name`    text  NOT NULL,
    `reviews_rating`    integer  default NULL,
    `date_added`        datetime default NULL,
    `last_modified`     datetime default NULL,
    `reviews_read`      integer  NOT NULL default '0'
);


create table `reviews_description` 
(
    `reviews_id`    integer  NOT NULL references `reviews` (`reviews_id`),
    `languages_id`  integer  NOT NULL references `languages` (`languages_id`),
    `reviews_text`  text NOT NULL,
    primary key  (`reviews_id`,`languages_id`)
);


create table `sessions` 
(
    `sesskey`   varchar(1000)  primary key NOT NULL,
    `expiry`    integer  unsigned NOT NULL,
    `value`     text NOT NULL
);


create table `shipping_status` 
(
    `shipping_status_id`    integer  NOT NULL default '0',
    `languages_id`          integer  NOT NULL default '1' references `languages`(`languages_id`) ,
    `shipping_status_name`  varchar(900)  NOT NULL default '',
    `shipping_status_image` timestamp NOT NULL default CURRENT_TIMESTAMP,
    primary key  (`shipping_status_id`,`languages_id`),
    UNIQUE (`shipping_status_name`,`languages_id`)
);

insert into `shipping_status` values (1,1,'3-4 Days','');
insert into `shipping_status` values (1,2,'Sofort lieferbar!','');
insert into `shipping_status` values (2,1,'1 Week','');
insert into `shipping_status` values (2,2,'demn&auml;chst lieferbar','');


create table `specials` 
(
    `specials_id`                   integer primary key auto_increment,
    `products_id`                   integer  NOT NULL references `products` (`products_id`),
    `specials_quantity`             integer NOT NULL,
    `specials_new_products_price`   real NOT NULL,
    `specials_date_added`           datetime default NULL,
    `specials_last_modified`        datetime default NULL,
    `expires_date`                  datetime default NULL,
    `date_status_change`            datetime default NULL,
    `status`                        integer NOT NULL default '1'
);


create table `tax_class` 
(
    `tax_class_id`          integer primary key auto_increment,
    `tax_class_title`       text  NOT NULL,
    `tax_class_description` text NOT NULL,
    `last_modified`         datetime default NULL,
    `date_added`            datetime NOT NULL
);

insert into `tax_class` values (1,'Standardsatz','','0000-00-00 00:00:00','2008-01-20 11:12:18');
insert into `tax_class` values (2,'ermäßigter Steuersatz','',NULL,'2008-01-20 11:12:18');


create table `tax_rates` 
(
    `tax_rates_id`  integer  primary key auto_increment,
    `tax_zone_id`   integer  NOT NULL,
    `tax_class_id`  integer  NOT NULL references `tax_class` (`tax_class_id`),
    `tax_priority`  integer default '1',
    `tax_rate`      real NOT NULL,
    `tax_description` text NOT NULL,
    `last_modified` datetime default NULL,
    `date_added`    datetime NOT NULL
);

insert into `tax_rates` values (1,5,1,1,'19.0000','UST 19%','2008-01-20 17:02:35','0000-00-00 00:00:00');
insert into `tax_rates` values (2,5,2,1,'7.0000','UST 7%','0000-00-00 00:00:00','0000-00-00 00:00:00');
insert into `tax_rates` values (3,6,1,1,'0.0000','EU-AUS-UST 0%','0000-00-00 00:00:00','0000-00-00 00:00:00');
insert into `tax_rates` values (4,6,2,1,'0.0000','EU-AUS-UST 0%','0000-00-00 00:00:00','0000-00-00 00:00:00');


create table `whos_online` 
(
    `customer_id`       integer  default NULL,
    `full_name`         text NOT NULL,
    `session_id`        text NOT NULL,
    `ip_address`        text  NOT NULL,
    `time_entry`        text(14) NOT NULL,
    `time_last_click`   text(14) NOT NULL,
    `last_page_url`     text NOT NULL
);


create table `zones` 
(
    `zone_id`           integer primary key auto_increment,
    `zone_country_id`   integer  NOT NULL,
    `zone_code`         text  NOT NULL,
    `zone_name`         text  NOT NULL
);

insert into `zones` values (1,223,'AL','Alabama');
insert into `zones` values (2,223,'AK','Alaska');
insert into `zones` values (3,223,'AS','American Samoa');
insert into `zones` values (4,223,'AZ','Arizona');
insert into `zones` values (5,223,'AR','Arkansas');
insert into `zones` values (6,223,'AF','Armed Forces Africa');
insert into `zones` values (7,223,'AA','Armed Forces Americas');
insert into `zones` values (8,223,'AC','Armed Forces Canada');
insert into `zones` values (9,223,'AE','Armed Forces Europe');
insert into `zones` values (10,223,'AM','Armed Forces Middle East');
insert into `zones` values (11,223,'AP','Armed Forces Pacific');
insert into `zones` values (12,223,'CA','California');
insert into `zones` values (13,223,'CO','Colorado');
insert into `zones` values (14,223,'CT','Connecticut');
insert into `zones` values (15,223,'DE','Delaware');
insert into `zones` values (16,223,'DC','District of Columbia');
insert into `zones` values (17,223,'FM','Federated States Of Micronesia');
insert into `zones` values (18,223,'FL','Florida');
insert into `zones` values (19,223,'GA','Georgia');
insert into `zones` values (20,223,'GU','Guam');
insert into `zones` values (21,223,'HI','Hawaii');
insert into `zones` values (22,223,'ID','Idaho');
insert into `zones` values (23,223,'IL','Illinois');
insert into `zones` values (24,223,'IN','Indiana');
insert into `zones` values (25,223,'IA','Iowa');
insert into `zones` values (26,223,'KS','Kansas');
insert into `zones` values (27,223,'KY','Kentucky');
insert into `zones` values (28,223,'LA','Louisiana');
insert into `zones` values (29,223,'ME','Maine');
insert into `zones` values (30,223,'MH','Marshall Islands');
insert into `zones` values (31,223,'MD','Maryland');
insert into `zones` values (32,223,'MA','Massachusetts');
insert into `zones` values (33,223,'MI','Michigan');
insert into `zones` values (34,223,'MN','Minnesota');
insert into `zones` values (35,223,'MS','Mississippi');
insert into `zones` values (36,223,'MO','Missouri');
insert into `zones` values (37,223,'MT','Montana');
insert into `zones` values (38,223,'NE','Nebraska');
insert into `zones` values (39,223,'NV','Nevada');
insert into `zones` values (40,223,'NH','New Hampshire');
insert into `zones` values (41,223,'NJ','New Jersey');
insert into `zones` values (42,223,'NM','New Mexico');
insert into `zones` values (43,223,'NY','New York');
insert into `zones` values (44,223,'NC','North Carolina');
insert into `zones` values (45,223,'ND','North Dakota');
insert into `zones` values (46,223,'MP','Northern Mariana Islands');
insert into `zones` values (47,223,'OH','Ohio');
insert into `zones` values (48,223,'OK','Oklahoma');
insert into `zones` values (49,223,'OR','Oregon');
insert into `zones` values (50,223,'PW','Palau');
insert into `zones` values (51,223,'PA','Pennsylvania');
insert into `zones` values (52,223,'PR','Puerto Rico');
insert into `zones` values (53,223,'RI','Rhode Island');
insert into `zones` values (54,223,'SC','South Carolina');
insert into `zones` values (55,223,'SD','South Dakota');
insert into `zones` values (56,223,'TN','Tennessee');
insert into `zones` values (57,223,'TX','Texas');
insert into `zones` values (58,223,'UT','Utah');
insert into `zones` values (59,223,'VT','Vermont');
insert into `zones` values (60,223,'VI','Virgin Islands');
insert into `zones` values (61,223,'VA','Virginia');
insert into `zones` values (62,223,'WA','Washington');
insert into `zones` values (63,223,'WV','West Virginia');
insert into `zones` values (64,223,'WI','Wisconsin');
insert into `zones` values (65,223,'WY','Wyoming');
insert into `zones` values (66,38,'AB','Alberta');
insert into `zones` values (67,38,'BC','British Columbia');
insert into `zones` values (68,38,'MB','Manitoba');
insert into `zones` values (69,38,'NF','Newfoundland');
insert into `zones` values (70,38,'NB','New Brunswick');
insert into `zones` values (71,38,'NS','Nova Scotia');
insert into `zones` values (72,38,'NT','Northwest Territories');
insert into `zones` values (73,38,'NU','Nunavut');
insert into `zones` values (74,38,'ON','Ontario');
insert into `zones` values (75,38,'PE','Prince Edward Island');
insert into `zones` values (76,38,'QC','Quebec');
insert into `zones` values (77,38,'SK','Saskatchewan');
insert into `zones` values (78,38,'YT','Yukon Territory');
insert into `zones` values (79,81,'NDS','Niedersachsen');
insert into `zones` values (80,81,'BAW','Baden-WÃ¼rttemberg');
insert into `zones` values (81,81,'BAY','Bayern');
insert into `zones` values (82,81,'BER','Berlin');
insert into `zones` values (83,81,'BRG','Brandenburg');
insert into `zones` values (84,81,'BRE','Bremen');
insert into `zones` values (85,81,'HAM','Hamburg');
insert into `zones` values (86,81,'HES','Hessen');
insert into `zones` values (87,81,'MEC','Mecklenburg-Vorpommern');
insert into `zones` values (88,81,'NRW','Nordrhein-Westfalen');
insert into `zones` values (89,81,'RHE','Rheinland-Pfalz');
insert into `zones` values (90,81,'SAR','Saarland');
insert into `zones` values (91,81,'SAS','Sachsen');
insert into `zones` values (92,81,'SAC','Sachsen-Anhalt');
insert into `zones` values (93,81,'SCN','Schleswig-Holstein');
insert into `zones` values (94,81,'THE','ThÃ¼ringen');
insert into `zones` values (95,14,'WI','Wien');
insert into `zones` values (96,14,'NO','NiederÃ¶sterreich');
insert into `zones` values (97,14,'OO','OberÃ¶sterreich');
insert into `zones` values (98,14,'SB','Salzburg');
insert into `zones` values (99,14,'KN','KÃ¤rnten');
insert into `zones` values (100,14,'ST','Steiermark');
insert into `zones` values (101,14,'TI','Tirol');
insert into `zones` values (102,14,'BL','Burgenland');
insert into `zones` values (103,14,'VB','Voralberg');
insert into `zones` values (104,204,'AG','Aargau');
insert into `zones` values (105,204,'AI','Appenzell Innerrhoden');
insert into `zones` values (106,204,'AR','Appenzell Ausserrhoden');
insert into `zones` values (107,204,'BE','Bern');
insert into `zones` values (108,204,'BL','Basel-Landschaft');
insert into `zones` values (109,204,'BS','Basel-Stadt');
insert into `zones` values (110,204,'FR','Freiburg');
insert into `zones` values (111,204,'GE','Genf');
insert into `zones` values (112,204,'GL','Glarus');
insert into `zones` values (113,204,'JU','GraubÃ¼nden');
insert into `zones` values (114,204,'JU','Jura');
insert into `zones` values (115,204,'LU','Luzern');
insert into `zones` values (116,204,'NE','Neuenburg');
insert into `zones` values (117,204,'NW','Nidwalden');
insert into `zones` values (118,204,'OW','Obwalden');
insert into `zones` values (119,204,'SG','St. Gallen');
insert into `zones` values (120,204,'SH','Schaffhausen');
insert into `zones` values (121,204,'SO','Solothurn');
insert into `zones` values (122,204,'SZ','Schwyz');
insert into `zones` values (123,204,'TG','Thurgau');
insert into `zones` values (124,204,'TI','Tessin');
insert into `zones` values (125,204,'UR','Uri');
insert into `zones` values (126,204,'VD','Waadt');
insert into `zones` values (127,204,'VS','Wallis');
insert into `zones` values (128,204,'ZG','Zug');
insert into `zones` values (129,204,'ZH','ZÃ¼rich');
insert into `zones` values (130,195,'A CoruÃ±a','A CoruÃ±a');
insert into `zones` values (131,195,'Alava','Alava');
insert into `zones` values (132,195,'Albacete','Albacete');
insert into `zones` values (133,195,'Alicante','Alicante');
insert into `zones` values (134,195,'Almeria','Almeria');
insert into `zones` values (135,195,'Asturias','Asturias');
insert into `zones` values (136,195,'Avila','Avila');
insert into `zones` values (137,195,'Badajoz','Badajoz');
insert into `zones` values (138,195,'Baleares','Baleares');
insert into `zones` values (139,195,'Barcelona','Barcelona');
insert into `zones` values (140,195,'Burgos','Burgos');
insert into `zones` values (141,195,'Caceres','Caceres');
insert into `zones` values (142,195,'Cadiz','Cadiz');
insert into `zones` values (143,195,'Cantabria','Cantabria');
insert into `zones` values (144,195,'Castellon','Castellon');
insert into `zones` values (145,195,'Ceuta','Ceuta');
insert into `zones` values (146,195,'Ciudad Real','Ciudad Real');
insert into `zones` values (147,195,'Cordoba','Cordoba');
insert into `zones` values (148,195,'Cuenca','Cuenca');
insert into `zones` values (149,195,'Girona','Girona');
insert into `zones` values (150,195,'Granada','Granada');
insert into `zones` values (151,195,'Guadalajara','Guadalajara');
insert into `zones` values (152,195,'Guipuzcoa','Guipuzcoa');
insert into `zones` values (153,195,'Huelva','Huelva');
insert into `zones` values (154,195,'Huesca','Huesca');
insert into `zones` values (155,195,'Jaen','Jaen');
insert into `zones` values (156,195,'La Rioja','La Rioja');
insert into `zones` values (157,195,'Las Palmas','Las Palmas');
insert into `zones` values (158,195,'Leon','Leon');
insert into `zones` values (159,195,'Lleida','Lleida');
insert into `zones` values (160,195,'Lugo','Lugo');
insert into `zones` values (161,195,'Madrid','Madrid');
insert into `zones` values (162,195,'Malaga','Malaga');
insert into `zones` values (163,195,'Melilla','Melilla');
insert into `zones` values (164,195,'Murcia','Murcia');
insert into `zones` values (165,195,'Navarra','Navarra');
insert into `zones` values (166,195,'Ourense','Ourense');
insert into `zones` values (167,195,'Palencia','Palencia');
insert into `zones` values (168,195,'Pontevedra','Pontevedra');
insert into `zones` values (169,195,'Salamanca','Salamanca');
insert into `zones` values (170,195,'Santa Cruz de Tenerife','Santa Cruz de Tenerife');
insert into `zones` values (171,195,'Segovia','Segovia');
insert into `zones` values (172,195,'Sevilla','Sevilla');
insert into `zones` values (173,195,'Soria','Soria');
insert into `zones` values (174,195,'Tarragona','Tarragona');
insert into `zones` values (175,195,'Teruel','Teruel');
insert into `zones` values (176,195,'Toledo','Toledo');
insert into `zones` values (177,195,'Valencia','Valencia');
insert into `zones` values (178,195,'Valladolid','Valladolid');
insert into `zones` values (179,195,'Vizcaya','Vizcaya');
insert into `zones` values (180,195,'Zamora','Zamora');
insert into `zones` values (181,195,'Zaragoza','Zaragoza');
insert into `zones` values (182,13,'NSW','New South Wales');
insert into `zones` values (183,13,'VIC','Victoria');
insert into `zones` values (184,13,'QLD','Queensland');
insert into `zones` values (185,13,'NT','Northern Territory');
insert into `zones` values (186,13,'WA','Western Australia');
insert into `zones` values (187,13,'SA','South Australia');
insert into `zones` values (188,13,'TAS','Tasmania');
insert into `zones` values (189,13,'ACT','Australian Capital Territory');
insert into `zones` values (190,153,'Northland','Northland');
insert into `zones` values (191,153,'Auckland','Auckland');
insert into `zones` values (192,153,'Waikato','Waikato');
insert into `zones` values (193,153,'Bay of Plenty','Bay of Plenty');
insert into `zones` values (194,153,'Gisborne','Gisborne');
insert into `zones` values (195,153,'Hawkes Bay','Hawkes Bay');
insert into `zones` values (196,153,'Taranaki','Taranaki');
insert into `zones` values (197,153,'Manawatu-Wanganui','Manawatu-Wanganui');
insert into `zones` values (198,153,'Wellington','Wellington');
insert into `zones` values (199,153,'West Coast','West Coast');
insert into `zones` values (200,153,'Canterbury','Canterbury');
insert into `zones` values (201,153,'Otago','Otago');
insert into `zones` values (202,153,'Southland','Southland');
insert into `zones` values (203,153,'Tasman','Tasman');
insert into `zones` values (204,153,'Nelson','Nelson');
insert into `zones` values (205,153,'Marlborough','Marlborough');
insert into `zones` values (206,30,'SP','SÃ£o Paulo');
insert into `zones` values (207,30,'RJ','Rio de Janeiro');
insert into `zones` values (208,30,'PE','Pernanbuco');
insert into `zones` values (209,30,'BA','Bahia');
insert into `zones` values (210,30,'AM','Amazonas');
insert into `zones` values (211,30,'MG','Minas Gerais');
insert into `zones` values (212,30,'ES','Espirito Santo');
insert into `zones` values (213,30,'RS','Rio Grande do Sul');
insert into `zones` values (214,30,'PR','ParanÃ¡');
insert into `zones` values (215,30,'SC','Santa Catarina');
insert into `zones` values (216,30,'RG','Rio Grande do Norte');
insert into `zones` values (217,30,'MS','Mato Grosso do Sul');
insert into `zones` values (218,30,'MT','Mato Grosso');
insert into `zones` values (219,30,'GO','Goias');
insert into `zones` values (220,30,'TO','Tocantins');
insert into `zones` values (221,30,'DF','Distrito Federal');
insert into `zones` values (222,30,'RO','Rondonia');
insert into `zones` values (223,30,'AC','Acre');
insert into `zones` values (224,30,'AP','Amapa');
insert into `zones` values (225,30,'RO','Roraima');
insert into `zones` values (226,30,'AL','Alagoas');
insert into `zones` values (227,30,'CE','CearÃ¡');
insert into `zones` values (228,30,'MA','MaranhÃ£o');
insert into `zones` values (229,30,'PA','ParÃ¡');
insert into `zones` values (230,30,'PB','ParaÃ­ba');
insert into `zones` values (231,30,'PI','PiauÃ­');
insert into `zones` values (232,30,'SE','Sergipe');
insert into `zones` values (233,43,'I','I RegiÃ³n de TarapacÃ¡');
insert into `zones` values (234,43,'II','II RegiÃ³n de Antofagasta');
insert into `zones` values (235,43,'III','III RegiÃ³n de Atacama');
insert into `zones` values (236,43,'IV','IV RegiÃ³n de Coquimbo');
insert into `zones` values (237,43,'V','V RegiÃ³n de ValaparaÃ­so');
insert into `zones` values (238,43,'RM','RegiÃ³n Metropolitana');
insert into `zones` values (239,43,'VI','VI RegiÃ³n de L. B. OÂ´higgins');
insert into `zones` values (240,43,'VII','VII RegiÃ³n del Maule');
insert into `zones` values (241,43,'VIII','VIII RegiÃ³n del BÃ­o BÃ­o');
insert into `zones` values (242,43,'IX','IX RegiÃ³n de la AraucanÃ­a');
insert into `zones` values (243,43,'X','X RegiÃ³n de los Lagos');
insert into `zones` values (244,43,'XI','XI RegiÃ³n de AysÃ©n');
insert into `zones` values (245,43,'XII','XII RegiÃ³n de Magallanes');
insert into `zones` values (246,47,'AMA','Amazonas');
insert into `zones` values (247,47,'ANT','Antioquia');
insert into `zones` values (248,47,'ARA','Arauca');
insert into `zones` values (249,47,'ATL','Atlantico');
insert into `zones` values (250,47,'BOL','Bolivar');
insert into `zones` values (251,47,'BOY','Boyaca');
insert into `zones` values (252,47,'CAL','Caldas');
insert into `zones` values (253,47,'CAQ','Caqueta');
insert into `zones` values (254,47,'CAS','Casanare');
insert into `zones` values (255,47,'CAU','Cauca');
insert into `zones` values (256,47,'CES','Cesar');
insert into `zones` values (257,47,'CHO','Choco');
insert into `zones` values (258,47,'COR','Cordoba');
insert into `zones` values (259,47,'CUN','Cundinamarca');
insert into `zones` values (260,47,'HUI','Huila');
insert into `zones` values (261,47,'GUA','Guainia');
insert into `zones` values (262,47,'GUA','Guajira');
insert into `zones` values (263,47,'GUV','Guaviare');
insert into `zones` values (264,47,'MAG','Magdalena');
insert into `zones` values (265,47,'MET','Meta');
insert into `zones` values (266,47,'NAR','Narino');
insert into `zones` values (267,47,'NDS','Norte de Santander');
insert into `zones` values (268,47,'PUT','Putumayo');
insert into `zones` values (269,47,'QUI','Quindio');
insert into `zones` values (270,47,'RIS','Risaralda');
insert into `zones` values (271,47,'SAI','San Andres Islas');
insert into `zones` values (272,47,'SAN','Santander');
insert into `zones` values (273,47,'SUC','Sucre');
insert into `zones` values (274,47,'TOL','Tolima');
insert into `zones` values (275,47,'VAL','Valle');
insert into `zones` values (276,47,'VAU','Vaupes');
insert into `zones` values (277,47,'VIC','Vichada');
insert into `zones` values (278,73,'Et','Etranger');
insert into `zones` values (279,73,'01','Ain');
insert into `zones` values (280,73,'02','Aisne');
insert into `zones` values (281,73,'03','Allier');
insert into `zones` values (282,73,'04','Alpes de Haute Provence');
insert into `zones` values (283,73,'05','Hautes-Alpes');
insert into `zones` values (284,73,'06','Alpes Maritimes');
insert into `zones` values (285,73,'07','Ard?che');
insert into `zones` values (286,73,'08','Ardennes');
insert into `zones` values (287,73,'09','Ari?ge');
insert into `zones` values (288,73,'10','Aube');
insert into `zones` values (289,73,'11','Aude');
insert into `zones` values (290,73,'12','Aveyron');
insert into `zones` values (291,73,'13','Bouches du RhÃƒÂ´ne');
insert into `zones` values (292,73,'14','Calvados');
insert into `zones` values (293,73,'15','Cantal');
insert into `zones` values (294,73,'16','Charente');
insert into `zones` values (295,73,'17','Charente Maritime');
insert into `zones` values (296,73,'18','Cher');
insert into `zones` values (297,73,'19','Corr?ze');
insert into `zones` values (298,73,'2A','Corse du Sud');
insert into `zones` values (299,73,'2B','Haute Corse');
insert into `zones` values (300,73,'21','Câ„¢te d''or');
insert into `zones` values (301,73,'22','Câ„¢tes d''Armor');
insert into `zones` values (302,73,'23','Creuse');
insert into `zones` values (303,73,'24','Dordogne');
insert into `zones` values (304,73,'25','Doubs');
insert into `zones` values (305,73,'26','Drâ„¢me');
insert into `zones` values (306,73,'27','Eure');
insert into `zones` values (307,73,'28','Eure et Loir');
insert into `zones` values (308,73,'29','Finist?re');
insert into `zones` values (309,73,'30','Gard');
insert into `zones` values (310,73,'31','Haute Garonne');
insert into `zones` values (311,73,'32','Gers');
insert into `zones` values (312,73,'33','Gironde');
insert into `zones` values (313,73,'34','HÅ½rault');
insert into `zones` values (314,73,'35','Ille et Vilaine');
insert into `zones` values (315,73,'36','Indre');
insert into `zones` values (316,73,'37','Indre et Loire');
insert into `zones` values (317,73,'38','Is?re');
insert into `zones` values (318,73,'39','Jura');
insert into `zones` values (319,73,'40','Landes');
insert into `zones` values (320,73,'41','Loir et Cher');
insert into `zones` values (321,73,'42','Loire');
insert into `zones` values (322,73,'43','Haute Loire');
insert into `zones` values (323,73,'44','Loire Atlantique');
insert into `zones` values (324,73,'45','Loiret');
insert into `zones` values (325,73,'46','Lot');
insert into `zones` values (326,73,'47','Lot et Garonne');
insert into `zones` values (327,73,'48','Loz?re');
insert into `zones` values (328,73,'49','Maine et Loire');
insert into `zones` values (329,73,'50','Manche');
insert into `zones` values (330,73,'51','Marne');
insert into `zones` values (331,73,'52','Haute Marne');
insert into `zones` values (332,73,'53','Mayenne');
insert into `zones` values (333,73,'54','Meurthe et Moselle');
insert into `zones` values (334,73,'55','Meuse');
insert into `zones` values (335,73,'56','Morbihan');
insert into `zones` values (336,73,'57','Moselle');
insert into `zones` values (337,73,'58','Ni?vre');
insert into `zones` values (338,73,'59','Nord');
insert into `zones` values (339,73,'60','Oise');
insert into `zones` values (340,73,'61','Orne');
insert into `zones` values (341,73,'62','Pas de Calais');
insert into `zones` values (342,73,'63','Puy de Dâ„¢me');
insert into `zones` values (343,73,'64','PyrÅ½nÅ½es Atlantiques');
insert into `zones` values (344,73,'65','Hautes PyrÅ½nÅ½es');
insert into `zones` values (345,73,'66','PyrÅ½nÅ½es Orientales');
insert into `zones` values (346,73,'67','Bas Rhin');
insert into `zones` values (347,73,'68','Haut Rhin');
insert into `zones` values (348,73,'69','Rhâ„¢ne');
insert into `zones` values (349,73,'70','Haute Saâ„¢ne');
insert into `zones` values (350,73,'71','Saâ„¢ne et Loire');
insert into `zones` values (351,73,'72','Sarthe');
insert into `zones` values (352,73,'73','Savoie');
insert into `zones` values (353,73,'74','Haute Savoie');
insert into `zones` values (354,73,'75','Paris');
insert into `zones` values (355,73,'76','Seine Maritime');
insert into `zones` values (356,73,'77','Seine et Marne');
insert into `zones` values (357,73,'78','Yvelines');
insert into `zones` values (358,73,'79','Deux S?vres');
insert into `zones` values (359,73,'80','Somme');
insert into `zones` values (360,73,'81','Tarn');
insert into `zones` values (361,73,'82','Tarn et Garonne');
insert into `zones` values (362,73,'83','Var');
insert into `zones` values (363,73,'84','Vaucluse');
insert into `zones` values (364,73,'85','VendÅ½e');
insert into `zones` values (365,73,'86','Vienne');
insert into `zones` values (366,73,'87','Haute Vienne');
insert into `zones` values (367,73,'88','Vosges');
insert into `zones` values (368,73,'89','Yonne');
insert into `zones` values (369,73,'90','Territoire de Belfort');
insert into `zones` values (370,73,'91','Essonne');
insert into `zones` values (371,73,'92','Hauts de Seine');
insert into `zones` values (372,73,'93','Seine St-Denis');
insert into `zones` values (373,73,'94','Val de Marne');
insert into `zones` values (374,73,'95','Val d''Oise');
insert into `zones` values (375,73,'971 (DOM)','Guadeloupe');
insert into `zones` values (376,73,'972 (DOM)','Martinique');
insert into `zones` values (377,73,'973 (DOM)','Guyane');
insert into `zones` values (378,73,'974 (DOM)','Saint Denis');
insert into `zones` values (379,73,'975 (DOM)','St-Pierre de Miquelon');
insert into `zones` values (380,73,'976 (TOM)','Mayotte');
insert into `zones` values (381,73,'984 (TOM)','Terres australes et Antartiques ');
insert into `zones` values (382,73,'985 (TOM)','Nouvelle CalÅ½donie');
insert into `zones` values (383,73,'986 (TOM)','Wallis et Futuna');
insert into `zones` values (384,73,'987 (TOM)','PolynÅ½sie fran?aise');
insert into `zones` values (385,99,'DL','Delhi');
insert into `zones` values (386,99,'MH','Maharashtra');
insert into `zones` values (387,99,'TN','Tamil Nadu');
insert into `zones` values (388,99,'KL','Kerala');
insert into `zones` values (389,99,'AP','Andhra Pradesh');
insert into `zones` values (390,99,'KA','Karnataka');
insert into `zones` values (391,99,'GA','Goa');
insert into `zones` values (392,99,'MP','Madhya Pradesh');
insert into `zones` values (393,99,'PY','Pondicherry');
insert into `zones` values (394,99,'GJ','Gujarat');
insert into `zones` values (395,99,'OR','Orrisa');
insert into `zones` values (396,99,'CA','Chhatisgarh');
insert into `zones` values (397,99,'JH','Jharkhand');
insert into `zones` values (398,99,'BR','Bihar');
insert into `zones` values (399,99,'WB','West Bengal');
insert into `zones` values (400,99,'UP','Uttar Pradesh');
insert into `zones` values (401,99,'RJ','Rajasthan');
insert into `zones` values (402,99,'PB','Punjab');
insert into `zones` values (403,99,'HR','Haryana');
insert into `zones` values (404,99,'CH','Chandigarh');
insert into `zones` values (405,99,'JK','Jammu & Kashmir');
insert into `zones` values (406,99,'HP','Himachal Pradesh');
insert into `zones` values (407,99,'UA','Uttaranchal');
insert into `zones` values (408,99,'LK','Lakshadweep');
insert into `zones` values (409,99,'AN','Andaman & Nicobar');
insert into `zones` values (410,99,'MG','Meghalaya');
insert into `zones` values (411,99,'AS','Assam');
insert into `zones` values (412,99,'DR','Dadra & Nagar Haveli');
insert into `zones` values (413,99,'DN','Daman & Diu');
insert into `zones` values (414,99,'SK','Sikkim');
insert into `zones` values (415,99,'TR','Tripura');
insert into `zones` values (416,99,'MZ','Mizoram');
insert into `zones` values (417,99,'MN','Manipur');
insert into `zones` values (418,99,'NL','Nagaland');
insert into `zones` values (419,99,'AR','Arunachal Pradesh');
insert into `zones` values (420,105,'AG','Agrigento');
insert into `zones` values (421,105,'AL','Alessandria');
insert into `zones` values (422,105,'AN','Ancona');
insert into `zones` values (423,105,'AO','Aosta');
insert into `zones` values (424,105,'AR','Arezzo');
insert into `zones` values (425,105,'AP','Ascoli Piceno');
insert into `zones` values (426,105,'AT','Asti');
insert into `zones` values (427,105,'AV','Avellino');
insert into `zones` values (428,105,'BA','Bari');
insert into `zones` values (429,105,'BL','Belluno');
insert into `zones` values (430,105,'BN','Benevento');
insert into `zones` values (431,105,'BG','Bergamo');
insert into `zones` values (432,105,'BI','Biella');
insert into `zones` values (433,105,'BO','Bologna');
insert into `zones` values (434,105,'BZ','Bolzano');
insert into `zones` values (435,105,'BS','Brescia');
insert into `zones` values (436,105,'BR','Brindisi');
insert into `zones` values (437,105,'CA','Cagliari');
insert into `zones` values (438,105,'CL','Caltanissetta');
insert into `zones` values (439,105,'CB','Campobasso');
insert into `zones` values (440,105,'CE','Caserta');
insert into `zones` values (441,105,'CT','Catania');
insert into `zones` values (442,105,'CZ','Catanzaro');
insert into `zones` values (443,105,'CH','Chieti');
insert into `zones` values (444,105,'CO','Como');
insert into `zones` values (445,105,'CS','Cosenza');
insert into `zones` values (446,105,'CR','Cremona');
insert into `zones` values (447,105,'KR','Crotone');
insert into `zones` values (448,105,'CN','Cuneo');
insert into `zones` values (449,105,'EN','Enna');
insert into `zones` values (450,105,'FE','Ferrara');
insert into `zones` values (451,105,'FI','Firenze');
insert into `zones` values (452,105,'FG','Foggia');
insert into `zones` values (453,105,'FO','ForlÃ¬');
insert into `zones` values (454,105,'FR','Frosinone');
insert into `zones` values (455,105,'GE','Genova');
insert into `zones` values (456,105,'GO','Gorizia');
insert into `zones` values (457,105,'GR','Grosseto');
insert into `zones` values (458,105,'IM','Imperia');
insert into `zones` values (459,105,'IS','Isernia');
insert into `zones` values (460,105,'AQ','Aquila');
insert into `zones` values (461,105,'SP','La Spezia');
insert into `zones` values (462,105,'LT','Latina');
insert into `zones` values (463,105,'LE','Lecce');
insert into `zones` values (464,105,'LC','Lecco');
insert into `zones` values (465,105,'LI','Livorno');
insert into `zones` values (466,105,'LO','Lodi');
insert into `zones` values (467,105,'LU','Lucca');
insert into `zones` values (468,105,'MC','Macerata');
insert into `zones` values (469,105,'MN','Mantova');
insert into `zones` values (470,105,'MS','Massa-Carrara');
insert into `zones` values (471,105,'MT','Matera');
insert into `zones` values (472,105,'ME','Messina');
insert into `zones` values (473,105,'MI','Milano');
insert into `zones` values (474,105,'MO','Modena');
insert into `zones` values (475,105,'NA','Napoli');
insert into `zones` values (476,105,'NO','Novara');
insert into `zones` values (477,105,'NU','Nuoro');
insert into `zones` values (478,105,'OR','Oristano');
insert into `zones` values (479,105,'PD','Padova');
insert into `zones` values (480,105,'PA','Palermo');
insert into `zones` values (481,105,'PR','Parma');
insert into `zones` values (482,105,'PG','Perugia');
insert into `zones` values (483,105,'PV','Pavia');
insert into `zones` values (484,105,'PS','Pesaro e Urbino');
insert into `zones` values (485,105,'PE','Pescara');
insert into `zones` values (486,105,'PC','Piacenza');
insert into `zones` values (487,105,'PI','Pisa');
insert into `zones` values (488,105,'PT','Pistoia');
insert into `zones` values (489,105,'PN','Pordenone');
insert into `zones` values (490,105,'PZ','Potenza');
insert into `zones` values (491,105,'PO','Prato');
insert into `zones` values (492,105,'RG','Ragusa');
insert into `zones` values (493,105,'RA','Ravenna');
insert into `zones` values (494,105,'RC','Reggio di Calabria');
insert into `zones` values (495,105,'RE','Reggio Emilia');
insert into `zones` values (496,105,'RI','Rieti');
insert into `zones` values (497,105,'RN','Rimini');
insert into `zones` values (498,105,'RM','Roma');
insert into `zones` values (499,105,'RO','Rovigo');
insert into `zones` values (500,105,'SA','Salerno');
insert into `zones` values (501,105,'SS','Sassari');
insert into `zones` values (502,105,'SV','Savona');
insert into `zones` values (503,105,'SI','Siena');
insert into `zones` values (504,105,'SR','Siracusa');
insert into `zones` values (505,105,'SO','Sondrio');
insert into `zones` values (506,105,'TA','Taranto');
insert into `zones` values (507,105,'TE','Teramo');
insert into `zones` values (508,105,'TR','Terni');
insert into `zones` values (509,105,'TO','Torino');
insert into `zones` values (510,105,'TP','Trapani');
insert into `zones` values (511,105,'TN','Trento');
insert into `zones` values (512,105,'TV','Treviso');
insert into `zones` values (513,105,'TS','Trieste');
insert into `zones` values (514,105,'UD','Udine');
insert into `zones` values (515,105,'VA','Varese');
insert into `zones` values (516,105,'VE','Venezia');
insert into `zones` values (517,105,'VB','Verbania');
insert into `zones` values (518,105,'VC','Vercelli');
insert into `zones` values (519,105,'VR','Verona');
insert into `zones` values (520,105,'VV','Vibo Valentia');
insert into `zones` values (521,105,'VI','Vicenza');
insert into `zones` values (522,105,'VT','Viterbo');
insert into `zones` values (523,107,'Niigata','Niigata');
insert into `zones` values (524,107,'Toyama','Toyama');
insert into `zones` values (525,107,'Ishikawa','Ishikawa');
insert into `zones` values (526,107,'Fukui','Fukui');
insert into `zones` values (527,107,'Yamanashi','Yamanashi');
insert into `zones` values (528,107,'Nagano','Nagano');
insert into `zones` values (529,107,'Gifu','Gifu');
insert into `zones` values (530,107,'Shizuoka','Shizuoka');
insert into `zones` values (531,107,'Aichi','Aichi');
insert into `zones` values (532,107,'Mie','Mie');
insert into `zones` values (533,107,'Shiga','Shiga');
insert into `zones` values (534,107,'Kyoto','Kyoto');
insert into `zones` values (535,107,'Osaka','Osaka');
insert into `zones` values (536,107,'Hyogo','Hyogo');
insert into `zones` values (537,107,'Nara','Nara');
insert into `zones` values (538,107,'Wakayama','Wakayama');
insert into `zones` values (539,107,'Tottori','Tottori');
insert into `zones` values (540,107,'Shimane','Shimane');
insert into `zones` values (541,107,'Okayama','Okayama');
insert into `zones` values (542,107,'Hiroshima','Hiroshima');
insert into `zones` values (543,107,'Yamaguchi','Yamaguchi');
insert into `zones` values (544,107,'Tokushima','Tokushima');
insert into `zones` values (545,107,'Kagawa','Kagawa');
insert into `zones` values (546,107,'Ehime','Ehime');
insert into `zones` values (547,107,'Kochi','Kochi');
insert into `zones` values (548,107,'Fukuoka','Fukuoka');
insert into `zones` values (549,107,'Saga','Saga');
insert into `zones` values (550,107,'Nagasaki','Nagasaki');
insert into `zones` values (551,107,'Kumamoto','Kumamoto');
insert into `zones` values (552,107,'Oita','Oita');
insert into `zones` values (553,107,'Miyazaki','Miyazaki');
insert into `zones` values (554,107,'Kagoshima','Kagoshima');
insert into `zones` values (555,129,'JOH','Johor');
insert into `zones` values (556,129,'KDH','Kedah');
insert into `zones` values (557,129,'KEL','Kelantan');
insert into `zones` values (558,129,'KL','Kuala Lumpur');
insert into `zones` values (559,129,'MEL','Melaka');
insert into `zones` values (560,129,'NS','Negeri Sembilan');
insert into `zones` values (561,129,'PAH','Pahang');
insert into `zones` values (562,129,'PRK','Perak');
insert into `zones` values (563,129,'PER','Perlis');
insert into `zones` values (564,129,'PP','Pulau Pinang');
insert into `zones` values (565,129,'SAB','Sabah');
insert into `zones` values (566,129,'SWK','Sarawak');
insert into `zones` values (567,129,'SEL','Selangor');
insert into `zones` values (568,129,'TER','Terengganu');
insert into `zones` values (569,129,'LAB','W.P.Labuan');
insert into `zones` values (570,138,'AGS','Aguascalientes');
insert into `zones` values (571,138,'BC','Baja California');
insert into `zones` values (572,138,'BCS','Baja California Sur');
insert into `zones` values (573,138,'CAM','Campeche');
insert into `zones` values (574,138,'COA','Coahuila');
insert into `zones` values (575,138,'COL','Colima');
insert into `zones` values (576,138,'CHI','Chiapas');
insert into `zones` values (577,138,'CHIH','Chihuahua');
insert into `zones` values (578,138,'DF','Distrito Federal');
insert into `zones` values (579,138,'DGO','Durango');
insert into `zones` values (580,138,'MEX','Estado de Mexico');
insert into `zones` values (581,138,'GTO','Guanajuato');
insert into `zones` values (582,138,'GRO','Guerrero');
insert into `zones` values (583,138,'HGO','Hidalgo');
insert into `zones` values (584,138,'JAL','Jalisco');
insert into `zones` values (585,138,'MCH','Michoacan');
insert into `zones` values (586,138,'MOR','Morelos');
insert into `zones` values (587,138,'NAY','Nayarit');
insert into `zones` values (588,138,'NL','Nuevo Leon');
insert into `zones` values (589,138,'OAX','Oaxaca');
insert into `zones` values (590,138,'PUE','Puebla');
insert into `zones` values (591,138,'QRO','Queretaro');
insert into `zones` values (592,138,'QR','Quintana Roo');
insert into `zones` values (593,138,'SLP','San Luis Potosi');
insert into `zones` values (594,138,'SIN','Sinaloa');
insert into `zones` values (595,138,'SON','Sonora');
insert into `zones` values (596,138,'TAB','Tabasco');
insert into `zones` values (597,138,'TMPS','Tamaulipas');
insert into `zones` values (598,138,'TLAX','Tlaxcala');
insert into `zones` values (599,138,'VER','Veracruz');
insert into `zones` values (600,138,'YUC','Yucatan');
insert into `zones` values (601,138,'ZAC','Zacatecas');
insert into `zones` values (602,160,'OSL','Oslo');
insert into `zones` values (603,160,'AKE','Akershus');
insert into `zones` values (604,160,'AUA','Aust-Agder');
insert into `zones` values (605,160,'BUS','Buskerud');
insert into `zones` values (606,160,'FIN','Finnmark');
insert into `zones` values (607,160,'HED','Hedmark');
insert into `zones` values (608,160,'HOR','Hordaland');
insert into `zones` values (609,160,'MOR','MÃ¸re og Romsdal');
insert into `zones` values (610,160,'NOR','Nordland');
insert into `zones` values (611,160,'NTR','Nord-TrÃ¸ndelag');
insert into `zones` values (612,160,'OPP','Oppland');
insert into `zones` values (613,160,'ROG','Rogaland');
insert into `zones` values (614,160,'SOF','Sogn og Fjordane');
insert into `zones` values (615,160,'STR','SÃ¸r-TrÃ¸ndelag');
insert into `zones` values (616,160,'TEL','Telemark');
insert into `zones` values (617,160,'TRO','Troms');
insert into `zones` values (618,160,'VEA','Vest-Agder');
insert into `zones` values (619,160,'OST','Ã˜stfold');
insert into `zones` values (620,160,'SVA','Svalbard');
insert into `zones` values (621,99,'KHI','Karachi');
insert into `zones` values (622,99,'LH','Lahore');
insert into `zones` values (623,99,'ISB','Islamabad');
insert into `zones` values (624,99,'QUE','Quetta');
insert into `zones` values (625,99,'PSH','Peshawar');
insert into `zones` values (626,99,'GUJ','Gujrat');
insert into `zones` values (627,99,'SAH','Sahiwal');
insert into `zones` values (628,99,'FSB','Faisalabad');
insert into `zones` values (629,99,'RIP','Rawal Pindi');
insert into `zones` values (630,175,'AB','Alba');
insert into `zones` values (631,175,'AR','Arad');
insert into `zones` values (632,175,'AG','Arges');
insert into `zones` values (633,175,'BC','Bacau');
insert into `zones` values (634,175,'BH','Bihor');
insert into `zones` values (635,175,'BN','Bistrita-Nasaud');
insert into `zones` values (636,175,'BT','Botosani');
insert into `zones` values (637,175,'BV','Brasov');
insert into `zones` values (638,175,'BR','Braila');
insert into `zones` values (639,175,'B','Bucuresti');
insert into `zones` values (640,175,'BZ','Buzau');
insert into `zones` values (641,175,'CS','Caras-Severin');
insert into `zones` values (642,175,'CL','Calarasi');
insert into `zones` values (643,175,'CJ','Cluj');
insert into `zones` values (644,175,'CT','Constanta');
insert into `zones` values (645,175,'CV','Covasna');
insert into `zones` values (646,175,'DB','Dimbovita');
insert into `zones` values (647,175,'DJ','Dolj');
insert into `zones` values (648,175,'GL','Galati');
insert into `zones` values (649,175,'GR','Giurgiu');
insert into `zones` values (650,175,'GJ','Gorj');
insert into `zones` values (651,175,'HR','Harghita');
insert into `zones` values (652,175,'HD','Hunedoara');
insert into `zones` values (653,175,'IL','Ialomita');
insert into `zones` values (654,175,'IS','Iasi');
insert into `zones` values (655,175,'IF','Ilfov');
insert into `zones` values (656,175,'MM','Maramures');
insert into `zones` values (657,175,'MH','Mehedint');
insert into `zones` values (658,175,'MS','Mures');
insert into `zones` values (659,175,'NT','Neamt');
insert into `zones` values (660,175,'OT','Olt');
insert into `zones` values (661,175,'PH','Prahova');
insert into `zones` values (662,175,'SM','Satu-Mare');
insert into `zones` values (663,175,'SJ','Salaj');
insert into `zones` values (664,175,'SB','Sibiu');
insert into `zones` values (665,175,'SV','Suceava');
insert into `zones` values (666,175,'TR','Teleorman');
insert into `zones` values (667,175,'TM','Timis');
insert into `zones` values (668,175,'TL','Tulcea');
insert into `zones` values (669,175,'VS','Vaslui');
insert into `zones` values (670,175,'VL','Valcea');
insert into `zones` values (671,175,'VN','Vrancea');
insert into `zones` values (672,193,'WP','Western Cape');
insert into `zones` values (673,193,'GP','Gauteng');
insert into `zones` values (674,193,'KZN','Kwazulu-Natal');
insert into `zones` values (675,193,'NC','Northern-Cape');
insert into `zones` values (676,193,'EC','Eastern-Cape');
insert into `zones` values (677,193,'MP','Mpumalanga');
insert into `zones` values (678,193,'NW','North-West');
insert into `zones` values (679,193,'FS','Free State');
insert into `zones` values (680,193,'NP','Northern Province');
insert into `zones` values (681,215,'ADANA','ADANA');
insert into `zones` values (682,215,'ADIYAMAN','ADIYAMAN');
insert into `zones` values (683,215,'AFYON','AFYON');
insert into `zones` values (684,215,'AGRI','AGRI');
insert into `zones` values (685,215,'AMASYA','AMASYA');
insert into `zones` values (686,215,'ANKARA','ANKARA');
insert into `zones` values (687,215,'ANTALYA','ANTALYA');
insert into `zones` values (688,215,'ARTVIN','ARTVIN');
insert into `zones` values (689,215,'AYDIN','AYDIN');
insert into `zones` values (690,215,'BALIKESIR','BALIKESIR');
insert into `zones` values (691,215,'BILECIK','BILECIK');
insert into `zones` values (692,215,'BINGÃ–L','BINGÃ–L');
insert into `zones` values (693,215,'BITLIS','BITLIS');
insert into `zones` values (694,215,'BOLU','BOLU');
insert into `zones` values (695,215,'BURDUR','BURDUR');
insert into `zones` values (696,215,'BURSA','BURSA');
insert into `zones` values (697,215,'Ã‡ANAKKALE','Ã‡ANAKKALE');
insert into `zones` values (698,215,'Ã‡ANKIRI','Ã‡ANKIRI');
insert into `zones` values (699,215,'Ã‡ORUM','Ã‡ORUM');
insert into `zones` values (700,215,'DENIZLI','DENIZLI');
insert into `zones` values (701,215,'DIYARBAKIR','DIYARBAKIR');
insert into `zones` values (702,215,'EDIRNE','EDIRNE');
insert into `zones` values (703,215,'ELAZIG','ELAZIG');
insert into `zones` values (704,215,'ERZINCAN','ERZINCAN');
insert into `zones` values (705,215,'ERZURUM','ERZURUM');
insert into `zones` values (706,215,'ESKISEHIR','ESKISEHIR');
insert into `zones` values (707,215,'GAZIANTEP','GAZIANTEP');
insert into `zones` values (708,215,'GIRESUN','GIRESUN');
insert into `zones` values (709,215,'GÃœMÃœSHANE','GÃœMÃœSHANE');
insert into `zones` values (710,215,'HAKKARI','HAKKARI');
insert into `zones` values (711,215,'HATAY','HATAY');
insert into `zones` values (712,215,'ISPARTA','ISPARTA');
insert into `zones` values (713,215,'IÃ‡EL','IÃ‡EL');
insert into `zones` values (714,215,'ISTANBUL','ISTANBUL');
insert into `zones` values (715,215,'IZMIR','IZMIR');
insert into `zones` values (716,215,'KARS','KARS');
insert into `zones` values (717,215,'KASTAMONU','KASTAMONU');
insert into `zones` values (718,215,'KAYSERI','KAYSERI');
insert into `zones` values (719,215,'KIRKLARELI','KIRKLARELI');
insert into `zones` values (720,215,'KIRSEHIR','KIRSEHIR');
insert into `zones` values (721,215,'KOCAELI','KOCAELI');
insert into `zones` values (722,215,'KONYA','KONYA');
insert into `zones` values (723,215,'KÃœTAHYA','KÃœTAHYA');
insert into `zones` values (724,215,'MALATYA','MALATYA');
insert into `zones` values (725,215,'MANISA','MANISA');
insert into `zones` values (726,215,'KAHRAMANMARAS','KAHRAMANMARAS');
insert into `zones` values (727,215,'MARDIN','MARDIN');
insert into `zones` values (728,215,'MUGLA','MUGLA');
insert into `zones` values (729,215,'MUS','MUS');
insert into `zones` values (730,215,'NEVSEHIR','NEVSEHIR');
insert into `zones` values (731,215,'NIGDE','NIGDE');
insert into `zones` values (732,215,'ORDU','ORDU');
insert into `zones` values (733,215,'RIZE','RIZE');
insert into `zones` values (734,215,'SAKARYA','SAKARYA');
insert into `zones` values (735,215,'SAMSUN','SAMSUN');
insert into `zones` values (736,215,'SIIRT','SIIRT');
insert into `zones` values (737,215,'SINOP','SINOP');
insert into `zones` values (738,215,'SIVAS','SIVAS');
insert into `zones` values (739,215,'TEKIRDAG','TEKIRDAG');
insert into `zones` values (740,215,'TOKAT','TOKAT');
insert into `zones` values (741,215,'TRABZON','TRABZON');
insert into `zones` values (742,215,'TUNCELI','TUNCELI');
insert into `zones` values (743,215,'SANLIURFA','SANLIURFA');
insert into `zones` values (744,215,'USAK','USAK');
insert into `zones` values (745,215,'VAN','VAN');
insert into `zones` values (746,215,'YOZGAT','YOZGAT');
insert into `zones` values (747,215,'ZONGULDAK','ZONGULDAK');
insert into `zones` values (748,215,'AKSARAY','AKSARAY');
insert into `zones` values (749,215,'BAYBURT','BAYBURT');
insert into `zones` values (750,215,'KARAMAN','KARAMAN');
insert into `zones` values (751,215,'KIRIKKALE','KIRIKKALE');
insert into `zones` values (752,215,'BATMAN','BATMAN');
insert into `zones` values (753,215,'SIRNAK','SIRNAK');
insert into `zones` values (754,215,'BARTIN','BARTIN');
insert into `zones` values (755,215,'ARDAHAN','ARDAHAN');
insert into `zones` values (756,215,'IGDIR','IGDIR');
insert into `zones` values (757,215,'YALOVA','YALOVA');
insert into `zones` values (758,215,'KARABÃœK','KARABÃœK');
insert into `zones` values (759,215,'KILIS','KILIS');
insert into `zones` values (760,215,'OSMANIYE','OSMANIYE');
insert into `zones` values (761,215,'DÃœZCE','DÃœZCE');
insert into `zones` values (762,229,'AM','Amazonas');
insert into `zones` values (763,229,'AN','AnzoÃ¡tegui');
insert into `zones` values (764,229,'AR','Aragua');
insert into `zones` values (765,229,'AP','Apure');
insert into `zones` values (766,229,'BA','Barinas');
insert into `zones` values (767,229,'BO','BolÃ­var');
insert into `zones` values (768,229,'CA','Carabobo');
insert into `zones` values (769,229,'CO','Cojedes');
insert into `zones` values (770,229,'DA','Delta Amacuro');
insert into `zones` values (771,229,'DC','Distrito Capital');
insert into `zones` values (772,229,'FA','FalcÃ³n');
insert into `zones` values (773,229,'GA','GuÃ¡rico');
insert into `zones` values (774,229,'GU','Guayana');
insert into `zones` values (775,229,'LA','Lara');
insert into `zones` values (776,229,'ME','MÃ©rida');
insert into `zones` values (777,229,'MI','Miranda');
insert into `zones` values (778,229,'MO','Monagas');
insert into `zones` values (779,229,'NE','Nueva Esparta');
insert into `zones` values (780,229,'PO','Portuguesa');
insert into `zones` values (781,229,'SU','Sucre');
insert into `zones` values (782,229,'TA','TÃ¡chira');
insert into `zones` values (783,229,'TU','Trujillo');
insert into `zones` values (784,229,'VA','Vargas');
insert into `zones` values (785,229,'YA','Yaracuy');
insert into `zones` values (786,229,'ZU','Zulia');
insert into `zones` values (787,222,'AVON','Avon');
insert into `zones` values (788,222,'BEDS','Bedfordshire');
insert into `zones` values (789,222,'BERK','Berkshire');
insert into `zones` values (790,222,'BIRM','Birmingham');
insert into `zones` values (791,222,'BORD','Borders');
insert into `zones` values (792,222,'BUCK','Buckinghamshire');
insert into `zones` values (793,222,'CAMB','Cambridgeshire');
insert into `zones` values (794,222,'CENT','Central');
insert into `zones` values (795,222,'CHES','Cheshire');
insert into `zones` values (796,222,'CLEV','Cleveland');
insert into `zones` values (797,222,'CLWY','Clwyd');
insert into `zones` values (798,222,'CORN','Cornwall');
insert into `zones` values (799,222,'CUMB','Cumbria');
insert into `zones` values (800,222,'DERB','Derbyshire');
insert into `zones` values (801,222,'DEVO','Devon');
insert into `zones` values (802,222,'DORS','Dorset');
insert into `zones` values (803,222,'DUMF','Dumfries & Galloway');
insert into `zones` values (804,222,'DURH','Durham');
insert into `zones` values (805,222,'DYFE','Dyfed');
insert into `zones` values (806,222,'ESUS','East Sussex');
insert into `zones` values (807,222,'ESSE','Essex');
insert into `zones` values (808,222,'FIFE','Fife');
insert into `zones` values (809,222,'GLAM','Glamorgan');
insert into `zones` values (810,222,'GLOU','Gloucestershire');
insert into `zones` values (811,222,'GRAM','Grampian');
insert into `zones` values (812,222,'GWEN','Gwent');
insert into `zones` values (813,222,'GWYN','Gwynedd');
insert into `zones` values (814,222,'HAMP','Hampshire');
insert into `zones` values (815,222,'HERE','Hereford & Worcester');
insert into `zones` values (816,222,'HERT','Hertfordshire');
insert into `zones` values (817,222,'HUMB','Humberside');
insert into `zones` values (818,222,'KENT','Kent');
insert into `zones` values (819,222,'LANC','Lancashire');
insert into `zones` values (820,222,'LEIC','Leicestershire');
insert into `zones` values (821,222,'LINC','Lincolnshire');
insert into `zones` values (822,222,'LOND','London');
insert into `zones` values (823,222,'LOTH','Lothian');
insert into `zones` values (824,222,'MANC','Manchester');
insert into `zones` values (825,222,'MERS','Merseyside');
insert into `zones` values (826,222,'NORF','Norfolk');
insert into `zones` values (827,222,'NYOR','North Yorkshire');
insert into `zones` values (828,222,'NWHI','North west Highlands');
insert into `zones` values (829,222,'NHAM','Northamptonshire');
insert into `zones` values (830,222,'NUMB','Northumberland');
insert into `zones` values (831,222,'NOTT','Nottinghamshire');
insert into `zones` values (832,222,'OXFO','Oxfordshire');
insert into `zones` values (833,222,'POWY','Powys');
insert into `zones` values (834,222,'SHRO','Shropshire');
insert into `zones` values (835,222,'SOME','Somerset');
insert into `zones` values (836,222,'SYOR','South Yorkshire');
insert into `zones` values (837,222,'STAF','Staffordshire');
insert into `zones` values (838,222,'STRA','Strathclyde');
insert into `zones` values (839,222,'SUFF','Suffolk');
insert into `zones` values (840,222,'SURR','Surrey');
insert into `zones` values (841,222,'WSUS','West Sussex');
insert into `zones` values (842,222,'TAYS','Tayside');
insert into `zones` values (843,222,'TYWE','Tyne & Wear');
insert into `zones` values (844,222,'WARW','Warwickshire');
insert into `zones` values (845,222,'WISL','West Isles');
insert into `zones` values (846,222,'WYOR','West Yorkshire');
insert into `zones` values (847,222,'WILT','Wiltshire');


create table `zones_to_geo_zones` 
(
      `association_id`  integer primary key auto_increment,
      `zone_country_id` integer  NOT NULL,
      `zone_id`         integer  default NULL,
      `geo_zone_id`     integer  default NULL,
      `last_modified`   datetime default NULL,
      `date_added`  datetime NOT NULL
);

insert into `zones_to_geo_zones` values (14,14,0,5,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (21,21,0,5,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (55,55,0,5,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (56,56,0,5,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (57,57,0,5,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (67,67,0,5,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (72,72,0,5,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (73,73,0,5,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (81,81,NULL,5,'2008-05-02 15:39:31','2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (84,84,0,5,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (97,97,0,5,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (103,103,0,5,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (105,105,0,5,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (117,117,0,5,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (123,123,0,5,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (124,124,0,5,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (132,132,0,5,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (150,150,0,5,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (170,170,0,5,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (171,171,0,5,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (189,189,0,5,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (190,190,0,5,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (195,195,0,5,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (203,203,0,5,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (222,222,0,5,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (1,1,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (2,2,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (3,3,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (4,4,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (5,5,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (6,6,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (7,7,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (8,8,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (9,9,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (10,10,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (11,11,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (12,12,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (13,13,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (15,15,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (16,16,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (17,17,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (18,18,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (19,19,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (20,20,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (22,22,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (23,23,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (24,24,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (25,25,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (26,26,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (27,27,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (28,28,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (29,29,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (30,30,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (31,31,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (32,32,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (33,33,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (34,34,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (35,35,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (36,36,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (37,37,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (38,38,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (39,39,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (40,40,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (41,41,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (42,42,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (43,43,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (44,44,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (45,45,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (46,46,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (47,47,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (48,48,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (49,49,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (50,50,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (51,51,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (52,52,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (53,53,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (54,54,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (58,58,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (59,59,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (60,60,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (61,61,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (62,62,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (63,63,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (64,64,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (65,65,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (66,66,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (68,68,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (69,69,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (70,70,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (71,71,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (74,74,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (75,75,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (76,76,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (77,77,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (78,78,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (79,79,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (80,80,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (82,82,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (83,83,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (85,85,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (86,86,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (87,87,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (88,88,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (89,89,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (90,90,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (91,91,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (92,92,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (93,93,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (94,94,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (95,95,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (96,96,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (98,98,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (99,99,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (100,100,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (101,101,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (102,102,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (104,104,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (106,106,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (107,107,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (108,108,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (109,109,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (110,110,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (111,111,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (112,112,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (113,113,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (114,114,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (115,115,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (116,116,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (118,118,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (119,119,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (120,120,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (121,121,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (122,122,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (125,125,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (126,126,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (127,127,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (128,128,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (129,129,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (130,130,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (131,131,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (133,133,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (134,134,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (135,135,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (136,136,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (137,137,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (138,138,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (139,139,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (140,140,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (141,141,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (142,142,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (143,143,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (144,144,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (145,145,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (146,146,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (147,147,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (148,148,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (149,149,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (151,151,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (152,152,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (153,153,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (154,154,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (155,155,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (156,156,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (157,157,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (158,158,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (159,159,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (160,160,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (161,161,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (162,162,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (163,163,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (164,164,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (165,165,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (166,166,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (167,167,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (168,168,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (169,169,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (172,172,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (173,173,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (174,174,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (175,175,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (176,176,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (177,177,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (178,178,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (179,179,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (180,180,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (181,181,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (182,182,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (183,183,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (184,184,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (185,185,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (186,186,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (187,187,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (188,188,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (191,191,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (192,192,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (193,193,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (194,194,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (196,196,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (197,197,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (198,198,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (199,199,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (200,200,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (201,201,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (202,202,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (204,204,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (205,205,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (206,206,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (207,207,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (208,208,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (209,209,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (210,210,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (211,211,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (212,212,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (213,213,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (214,214,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (215,215,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (216,216,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (217,217,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (218,218,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (219,219,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (220,220,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (221,221,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (223,223,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (224,224,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (225,225,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (226,226,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (227,227,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (228,228,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (229,229,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (230,230,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (231,231,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (232,232,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (233,233,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (234,234,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (235,235,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (236,236,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (237,237,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (238,238,0,6,NULL,'2008-01-20 11:12:18');
insert into `zones_to_geo_zones` values (239,239,0,6,NULL,'2008-01-20 11:12:18');



create table `system_meta`
(
    `db_version`    text NOT NULL
);


insert into  `system_meta` values ('0');

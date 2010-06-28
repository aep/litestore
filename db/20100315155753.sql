alter table prices drop key customers_status_id;
alter table prices drop column customers_status_id;


alter table prices add column price_group_id int unique;
alter table prices add column show_old_price decimal(15,4);
alter table prices drop index `price_group_id`;
alter table prices add unique (products_id,price_group_id,quantity);

CREATE TABLE `customers_status_price_group` (
  `customers_status_id` int(11) NOT NULL DEFAULT '0',
  `price_group_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`customers_status_id`,`price_group_id`)
);


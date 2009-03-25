alter table categories  drop ibc_devices;
alter table categories  drop products_sorting;
alter table categories  drop products_sorting2;
alter table categories  drop listing_template;
alter table categories  drop categories_template;
alter table categories add `products_sorting` integer;
alter table categories add `products_sorting_key` text;


update  categories  set categories_id=1276123 where categories_id=1;
update  categories_description  set categories_id=1276123 where categories_id=1;
update  categories  set parent_id=1276123 where parent_id=1;
update  categories  set parent_id=1 where parent_id=0;
insert into categories values (1,'','',0,1,0,0,0,'root',0,'p.products_sort');
insert into categories_description values (1,2,'Katalog','','','','','');




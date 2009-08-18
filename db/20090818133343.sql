insert into content (name,uuid,parent,data) values ('Sidebar','com.asgaartech.asphyx.preset',1,'Sidebar');
set @tllid= LAST_INSERT_ID();
insert into content (name,uuid,parent,`order`) values ('AdminBox','com.handelsweise.litestore.sidebar.adminbox',(select @tllid),1); 
insert into content (name,uuid,parent,`order`) values ('CatalogBox','com.handelsweise.litestore.sidebar.catalog',(select @tllid),2); 
insert into content (name,uuid,parent,`order`) values ('ContentBox','com.handelsweise.litestore.sidebar.content',(select @tllid),3); 

set @tllid = (select id from content where name='Banner' and data='Banner');
insert into content (name,uuid,parent) values ('Adsense','com.handelsweise.litestore.gadget.adsense',(select @tllid));

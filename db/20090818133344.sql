set @tllid= (select id from content where uuid='com.asgaartech.asphyx.preset' and data='Sidebar');
insert into content (name,uuid,parent,`order`) values ('SearchBox','com.handelsweise.litestore.sidebar.search',(select @tllid),1); 

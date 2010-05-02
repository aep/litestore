insert into content (name,uuid,parent,data) values ('Root','com.asgaartech.asphyx.preset',1,'Root');
set @tllid= LAST_INSERT_ID();
insert into content (name,uuid,parent,data) values ('Frontpage','com.handelsweise.litestore.uriselect',(select @tllid),'^/$');
set @tllid= LAST_INSERT_ID();
set @fpid=(select id from content where uuid='com.asgaartech.asphyx.preset' and name='Frontpage');
update content set parent=(select @tllid) where parent=(select @fpid);
delete from content where id=(select @fpid);
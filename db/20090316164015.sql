create table `content`
(
    `id` integer primary key auto_increment,
    `parent` integer,
    `uuid` text, 
    `name` text,
    `data` blob,
    `order` integer
);

insert into `content`  values (1,null,'{0ab256ea-0000-4000-9827-6556fa1eb9e8}','Domain','Domain',0);  

insert into `content`  values (2,1,'{0ab256ea-0000-4000-9827-6556fa1eb9e8}','Contentbox','Contentbox',0);
    insert into `content`  values (3,2,'{0ab256ea-0000-4000-9827-6556fa1eb9e8}','Agb','Agb',0);
        insert into `content`  values (4,3,'{c21ced16-0000-4000-92c1-69d94afb4933}','Agb','Agb',0);
    insert into `content`  values (5,2,'{c21ced16-0000-4000-92c1-69d94afb4933}','Impressum','Impressum',0);

insert into `content`  values (6,1,'{0ab256ea-0000-4000-9827-6556fa1eb9e8}','Frontpage','Frontpage',0);
    insert into `content`  values (7,6,'{c21ced16-0000-4000-92c1-69d94afb4933}','Frontpage','Willkommen',0);

insert into `content`  values (8,1,'{0ab256ea-0000-4000-9827-6556fa1eb9e8}','Wellcome','Wellcome',0);
    insert into `content`  values (9,8,'{c21ced16-0000-4000-92c1-69d94afb4933}','Wellcome','Willkommen',0);

insert into `content`  values (10,1,'{0ab256ea-0000-4000-9827-6556fa1eb9e8}','Logout','Logout',0);
    insert into `content`  values (11,10,'{c21ced16-0000-4000-92c1-69d94afb4933}','Logout','Sie wurden nun erfolgreich abgemeldet. Auf Wiedersehen!',0);



drop table `content_manager`;

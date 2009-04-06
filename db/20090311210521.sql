create table `prices`
(
    `prices_id`             integer primary key auto_increment,
    `customers_status_id`   integer references `customers_status` (`customers_status_id`),
    `products_id`           integer not null references `products` (`products_id`),
    `quantity`              integer,
    `price`                 float
);


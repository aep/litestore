menus.customers={text:'Kunden',iconCls:'icon_customers',menu:new Ext.menu.Menu()};
menus.customers.menu.add(
        {
            text: 'Kunden',
            handler: function() {module_iframe('Kunden','/admin/customers.php');}
        },
        {
            text: 'Kundengruppen',
            handler: function() {module_iframe('Kundengruppen','/admin/customers_status.php');}
        },
        {
            text: 'Bestellungen',
            handler: function() {module_iframe('Bestellungen','/admin/orders.php');}
        },
        {
            text: 'Kreditkarten sperren',
            handler: function() {module_iframe('Gesperrte Kreditkarten','/admin/blacklist.php');}
        }
);


appInitState.on("loadMenus",function () {

    menus.customers = new Ext.menu.Menu();
    mainmenu.add({text:'Kunden',iconCls:'icon_customers',menu:menus.customers});
    menus.customers.add(
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
});

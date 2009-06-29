menus.conf={text:'Einstellungen',iconCls:'icon_settings',menu:new Ext.menu.Menu()};

menus.conf.menu.add(
        {
            text: 'Minimum Werte',
            handler: function() {module_js('/admin/configuration2.php?gID=2');}
        },
        {
            text: 'Maximum Werte',
            handler: function() {module_js('/admin/configuration2.php?gID=3');}
        },
        {
            text: 'Kunden Details',
            handler: function() {module_iframe('Kunden Details','/admin/configuration.php?gID=5');}
        },
        {
            text: 'Versand Optionen',
            handler: function() {module_iframe('Versand Optionen','/admin/configuration.php?gID=7');}
        },
        {
            text: 'EMail Optionen',
            handler: function() {module_iframe('EMail Optionen','/admin/configuration.php?gID=12');}
        },
        {
            text: 'Zusatzmodule',
            handler: function() {module_iframe('Zusatzmodule','/admin/configuration.php?gID=17');}
        },
        {
            text: 'UST ID',
            handler: function() {module_iframe('UST ID','/admin/configuration.php?gID=18');}
        },
        {
            text: 'Such-Optionen',
            handler: function() {module_iframe('Such-Optionen','/admin/configuration.php?gID=22');}
        },
        {
            text: 'Bestellstatus',
            handler: function() {module_iframe('Bestellstatus','/admin/orders_status.php');}
        },
        {
            text: 'Lieferstatus',
            handler: function() {module_iframe('Lieferstatus','/admin/shipping_status.php');}
        },
        {
            text: 'Verpackungseinheit',
            handler: function() {module_iframe('Verpackungseinheit','/admin/products_vpe.php');}
        }
    );



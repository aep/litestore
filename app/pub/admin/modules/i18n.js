menus.i18n={text:'Lokalisation',iconCls:'icon_i18n',menu:new Ext.menu.Menu()};
menus.i18n.menu.add(
    {
        text: 'Land',
        handler: function() {module_iframe('Land','/admin/countries.php');}
    },
    {
        text: 'Währungen',
        handler: function() {module_iframe('Währungen','/admin/currencies.php');}
    },
    {
        text: 'Bundesländer',
        handler: function() {module_iframe('Bundesländer','/admin/zones.php');}
    },
    {
        text: 'Steuerzonen',
        handler: function() {module_iframe('Steuerzonen','/admin/geo_zones.php');}
    },
    {
        text: 'Steuerklassen',
        handler: function() {module_iframe('Steuerklassen','/admin/tax_classes.php');}
    },
    {
        text: 'Steuersätze',
        handler: function() {module_iframe('Steuersätze','/admin/tax_rates.php');}
    }
);


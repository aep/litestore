
appInitState.on("loadMenus",function () {

    menus.modules = new Ext.menu.Menu();
    menus.conf.add({text:'Module',icon:'/admin/images/icons/modules.png',menu:menus.modules});
    menus.modules.add(
        {
            text: 'Zahlungsoptionen',
            handler: function() {module_iframe('Zahlungsoptionen','/admin/modules.php?set=payment');}
        },
        {
            text: 'Versandart',
            handler: function() {module_iframe('Versandart','/admin/modules.php?set=shipping');}
        },
        {
            text: 'Zusammenfassung',
            handler: function() {module_iframe('Zusammenfassung','/admin/modules.php?set=ordertotal');}
        }
    );
});


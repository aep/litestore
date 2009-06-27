
appInitState.on("loadMenus",function () {

    menus.importexport = new Ext.menu.Menu();
    mainmenu.add({text:'Import/Export',iconCls:'icon_importexport',menu:menus.importexport});
    menus.importexport.add(
        {
            text: 'Export',
            handler: function() {module_iframe('Export','/admin/export.php');}
        },
        {
            text: 'Import',
            handler: function() {module_iframe('Import','/admin/csv_backend.php');}
        }


    );
});


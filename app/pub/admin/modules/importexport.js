menus.importexport = {text:'Import/Export',iconCls:'icon_importexport',menu:new Ext.menu.Menu()};
menus.importexport.menu.add(
    {
        text: 'Export',
        handler: function() {module_iframe('Export','/admin/export.php');}
    }
);


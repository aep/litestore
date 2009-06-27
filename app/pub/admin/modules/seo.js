
appInitState.on("loadMenus",function () {

    menus.seo = new Ext.menu.Menu();
    mainmenu.add({text:'SEO-Tools',iconCls:'icon_seo',menu:menus.seo});
    menus.seo.add(
        {
            text: 'Meta-Tags/Suchmaschinen',
            handler: function() {module_iframe('Meta-Tags/Suchmaschinen','/admin/metatags.php');}
        },
        {
            text: 'Google Adsense',
            handler: function() {module_iframe('Google Adsense','/admin/adsense.php');}
        }
    );
});

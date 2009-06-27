menus.seo = {text:'SEO-Tools',iconCls:'icon_seo',menu:new Ext.menu.Menu()};
menus.seo.menu.add(
    {
        text: 'Meta-Tags/Suchmaschinen',
        handler: function() {module_iframe('Meta-Tags/Suchmaschinen','/admin/metatags.php');}
    },
    {
        text: 'Google Adsense',
        handler: function() {module_iframe('Google Adsense','/admin/adsense.php');}
    }
);

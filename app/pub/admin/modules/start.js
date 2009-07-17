menus.start={text:'Übersicht',iconCls:'icon_start',handler: function() {module_start();} };

function module_start()
{
    document.title = 'Litemin';
    module=new Object();

    module.blabla=new  Ext.Panel({
        title:'News',
        cls: 'module_start_panel',
        collapsible:  true,
        html: '<img src="/admin/images/asphyx_teaser.png" />'
    });

    module.panel=new  Ext.Panel({
        cls: 'desktop',
        border: false,  
//        autoScroll:  true,
        items:[
            module.blabla
            ]
    });
    mainpanel.remove(0);
    mainpanel.add(module.panel);
    mainpanel.getLayout().setActiveItem(0);
    mainpanel.doLayout();


}





menus.start={text:'Übersicht',iconCls:'icon_start',handler: function() {module_start();} };

function module_start()
{
    document.title = 'Litemin';
    module=new Object();

    module.news=new  Ext.Panel({
        title:'News',
        collapsible:  true,
        cls: 'module_start_panel',
        html: '<img src="http://www.party-san.de/myspace/myspace_psoa.jpg">'
    });

    module.welcome=new  Ext.Panel({
        title:'Willkommen',
        collapsible:  true,
        html: '<div style="margin:10px;"><h4>HI, kennen Sie schon..</h4></div>',
        cls: 'module_start_panel'
    });
    module.accessstats=new  Ext.Panel({
        title:'Werbung',
        cls: 'module_start_panel',
        collapsible:  true,
        html: '<img src="http://www.evocation.se/img/flyer_wod09_big.jpg">'
    });
    module.didyouknow=new  Ext.Panel({
        title:'Wussten Sie schon...',
        cls: 'module_start_panel',
        collapsible:  true,
        html: '<div style="margin:10px;">dass Katzen im dunkeln nicht leuchten?</div>'
    });
    module.blabla=new  Ext.Panel({
        title:'Gugug',
        cls: 'module_start_panel',
        collapsible:  true,
        html: '<div style="margin:10px;">Jemand(hust) sollte hier<br> sinnvollen Content basteln. <br>Oder ich machs halt wieder weg. <br>War nur so ne Idee..</div>'
    });

    module.panel=new  Ext.Panel({
        cls: 'desktop',
        border: false,  
//        autoScroll:  true,
        items:[
            module.accessstats,
            new Ext.Panel({
                border:false,
                cls:'module_start_panel x-panel-groupwrap',
                items:[module.didyouknow,module.welcome,module.blabla],
                layout:'table',
                layoutConfig: {columns: 1}
            }),
            module.news
            ]
    });
    mainpanel.remove(0);
    mainpanel.add(module.panel);
    mainpanel.getLayout().setActiveItem(0);
    mainpanel.doLayout();


}





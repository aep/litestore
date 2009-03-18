var mainpanel;



Ext.onReady(function()
{
    mainpanel = new Ext.Panel({
        autoScroll  :  'true',
	    region:'center',
	    deferredRender:false,
        activeTab:0,
        layout: 'card',
    });

    var actionAbout = new Ext.Panel({
        collapsed: true,
        frame         : true,
        title         : 'Start',
        collapsible   : true,
        contentEl     : 'actionAbout',
        titleCollapse : true
    });

    var actionCustomers = new Ext.Panel({
        collapsed: true,
        frame         : true,
        title         : 'Kundenstamm',
        collapsible   : true,
        contentEl     : 'actionCustomers',
        titleCollapse : true
    });


    var actionCatalog = new Ext.Panel({
        collapsed: true,
        frame         : true,
        title         : 'Artikelstamm',
        collapsible   : true,
        contentEl     : 'actionCatalog',
        titleCollapse : true
    });


    var actionModules = new Ext.Panel({
        collapsed: true,
        frame         : true,
        title         : 'Module',
        collapsible   : true,
        contentEl     : 'actionModules',
        titleCollapse : true
    });


    var actionStats = new Ext.Panel({
        collapsed: true,
        frame         : true,
        title         : 'Statistiken',
        collapsible   : true,
        contentEl     : 'actionStats',
        titleCollapse : true
    });

    var actionTools = new Ext.Panel({
        collapsed: true,
        frame         : true,
        title         : 'Tools',
        collapsible   : true,
        contentEl     : 'actionTools',
        titleCollapse : true
    });

    var actionLocalisation = new Ext.Panel({
        collapsed: true,
        frame         : true,
        title         : 'L&auml;ndereinstellungen',
        collapsible   : true,
        contentEl     : 'actionLocalisation',
        titleCollapse : true
    });

    var actionSeoTools = new Ext.Panel({
        collapsed     : true,
        frame         : true,
        title         : 'SEO Tools',
        collapsible   : true,
        contentEl     : 'actionSeoTools',
        titleCollapse : true
    });


    var actionSettings = new Ext.Panel({
        collapsed: true,
        frame         : true,
        title         : 'Einstellungen',
        collapsible   : true,
        contentEl     : 'actionSettings',
        titleCollapse : true
    });



     var actionPanel = new Ext.Panel({
        autoScroll  :  'true',
        id:'action-panel',
        region:'west',
        split:true,
        collapsible: true,
        collapseMode: 'mini',
        width: 200,
        minWidth: 150,
        border: false,
        baseCls:'x-plain',
        items: [actionAbout,actionCustomers,actionCatalog,actionStats,actionSeoTools,actionTools,actionLocalisation,actionModules,actionSettings]
    });



    // Configure viewport
    viewport = new Ext.Viewport({
           layout:'border',
           items:[actionPanel,mainpanel]});

    module_html('Willkommen','/admin/start.php');
});





function module_iframe(tit,uri)
{
    
    var panel = new Ext.Panel({
        title:tit, 
        html : '<iframe src="'+uri+'" width="100%" height="100%" marginheight="0" marginwidth="0" frameborder="0"/>'
    });

    mainpanel.remove(0);
    mainpanel.add(panel);
    mainpanel.getLayout().setActiveItem(0);
    mainpanel.doLayout();    
}





function module_js(uri)
{
    new Ajax.Request(uri,
    {
        evalJS: false,
        method: 'get',
        onSuccess: function(transport) 
        {   
            eval(transport.responseText);
        },
        onFailure: function(transport)
        {
            alert("failure");
        }
    });
}



function module_html(tit,uri)
{
    new Ajax.Request(uri,
    {
        method: 'get',
        onSuccess: function(transport) 
        {   

            var panel = new Ext.Panel({
                title   :tit, 
                html    :transport.responseText
            });

            mainpanel.remove(0);
            mainpanel.add(panel);
            mainpanel.getLayout().setActiveItem(0);
            mainpanel.doLayout();

            var sl=transport.responseText.extractScripts();
            for(var i = 0;i < sl.length;i++)
            {
                eval(sl[i]);
            }



        },
        onFailure: function(transport)
        {
            alert("failure");
        }
    });
}



function logout()
{
    new Ajax.Request('/logout',
    {
        onSuccess: function(transport)         
        {
            window.close();
            location.reload();
        },
        onFailure: function(transport)
        {
            alert("failure");
        }
    });

}



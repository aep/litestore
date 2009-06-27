
appInitState.on("loadMenus",function () {
    menus.seo.add(
        {
            text: 'Redirect',
            handler: function() {module_seo_notfound();}
        }
    );
});


function module_seo_notfound()
{
    var confstore = new Ext.data.Store
    ({
        proxy: new Ext.data.HttpProxy
        ({
            method: 'post',
            url: '/admin/db.php',
            jsonData : Ext.util.JSON.encode
            ({
                model:"configuration",
                action:"fetch",
                keys: ['SEO_NOTFOUNDPAGE']
            })
        }),
        reader: new Ext.data.JsonReader({},['SEO_NOTFOUNDPAGE']),
        remoteSort: false,
        autoLoad: false
    });
    confstore.on('loadexception',function(thisr,options,response,error)
    {
        Ext.Msg.alert('confstore', error);
    });


    var kk_SEO_NOTFOUNDPAGE = new Ext.form.TextField
    ({ 
        id: 'SEO_NOTFOUNDPAGE',
        fieldLabel: ' Url Weiterleitung bei nicht gefundener Seite:'
    });

    var form = new Ext.form.FormPanel
    ({
        title: 'SEO Redirect',
        labelWidth: 400,
        frame:  true,
        defaultType: 'textfield',
        autoScroll: true,
        disabled:true,
        items: 
        [ 
            kk_SEO_NOTFOUNDPAGE
        ], 
        buttons: 
        [
            {
                text: 'Speichern',
                handler: function() 
                {       
                    Ext.Ajax.request
                    ({
                        method:     'POST',
                        url:        '/admin/db.php',
                        jsonData:   Ext.util.JSON.encode
                        ({
                            model:  "configuration",
                            action: "save",
                            keys:   form.getForm().getValues(),
                        }),
                        success: function ( result, request )
                        {
                            confstore.load();
                        },
                        failure: function ( result, request )
                        {
                            Ext.Msg.alert('Speichern fehlgeschlagen.', 'Beim Speichern Ihrer Daten ist ein Fehler aufgetreten. Bitte versuchen Sie es in einigen Minuten noch einmal. Sollte das Problem weiterhin bestehen kontaktieren Sie den Support. ');
                        }
                    });
                    form.disable();
                }
            }
        ]
    });
 

    mainpanel.remove(0);
    mainpanel.add(form);
    mainpanel.getLayout().setActiveItem(0);
    mainpanel.doLayout();



    confstore.on('load', function() 
    {
        var cobj=confstore.getAt(0).data;
        kk_SEO_NOTFOUNDPAGE.setValue(cobj.SEO_NOTFOUNDPAGE);
        form.enable();
    });
	confstore.load();
}





function module_seo_conversion()
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
                keys: ['GOOGLE_CONVERSION','GOOGLE_CONVERSION_BUY','GOOGLE_CONVERSION_REGISTER']
            })
        }),
        reader: new Ext.data.JsonReader({},['GOOGLE_CONVERSION','GOOGLE_CONVERSION_BUY','GOOGLE_CONVERSION_REGISTER']),
        remoteSort: false,
        autoLoad: false
    });


      
    var kk_GOOGLE_CONVERSION = new Ext.form.Checkbox
    ({ 
        id: 'GOOGLE_CONVERSION',
        fieldLabel: 'Aufzeichnen von Conversions-Keywords bei Bestellungen'
    });

    var kk_GOOGLE_CONVERSION_BUY = new Ext.form.TextArea
    ({ 
        width:'90%',
        height:200,
        id: 'GOOGLE_CONVERSION_BUY ',
        fieldLabel: 'der von Google zur Verfügung gestellte Code, zum Zählen der Bestellungen'
    });

    var kk_GOOGLE_CONVERSION_REGISTER = new Ext.form.TextArea
    ({ 
        width:'90%',
        height:200,
        id: 'GOOGLE_CONVERSION_REGISTER ',
        fieldLabel: 'der von Google zur Verfügung gestellte Code, zum Zählen der Neuanmeldungen'
    });
      
    var form = new Ext.form.FormPanel
    ({
        title: 'Conversion Tracking',
        labelWidth: 400,
        width: '100%',
        frame:  true,
        defaultType: 'textfield',
        autoScroll: true,
        disabled:true,
        region:'center',
        items: 
        [ 
            kk_GOOGLE_CONVERSION,
            kk_GOOGLE_CONVERSION_BUY,
            kk_GOOGLE_CONVERSION_REGISTER
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
        kk_GOOGLE_CONVERSION.setValue(cobj.GOOGLE_CONVERSION);
        kk_GOOGLE_CONVERSION_REGISTER.setValue(cobj.GOOGLE_CONVERSION_REGISTER);
        kk_GOOGLE_CONVERSION_BUY.setValue(cobj.GOOGLE_CONVERSION_BUY);
        form.enable();
    });

    confstore.load();

 
}




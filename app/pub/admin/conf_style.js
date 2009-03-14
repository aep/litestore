function module_conf_style()
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
                keys: ['CURRENT_TEMPLATE','CURRENT_BACKGROUND','CURRENT_LOGO','CURRENT_CSS']
            })
        }),
        reader: new Ext.data.JsonReader({},['CURRENT_TEMPLATE','CURRENT_BACKGROUND','CURRENT_LOGO','CURRENT_CSS']),
        remoteSort: false,
        autoLoad: false
    });


    var templatestore = new Ext.data.Store
    ({
        proxy: new Ext.data.HttpProxy
        ({
            method:'post',
            url: '/admin/db.php',
            jsonData : Ext.util.JSON.encode
            ({
                model:"templates",
                action: "fetch"
            })
        }),
        reader: new Ext.data.JsonReader
        ({
            root: 'result',
            fields: [{name: 'id'},{name: 'name'}]
        }),
        autoLoad: false

    });

    var templatecombo= new Ext.form.ComboBox
    ({
        id: 'CURRENT_TEMPLATE_c',
        hiddenName: 'CURRENT_TEMPLATE',
        fieldLabel: 'Templateset',
        store: templatestore,
        triggerAction : 'all',
        valueField: 'id',
        displayField: 'name',
        typeAhead: true,

    });


    var cssstore = new Ext.data.Store
    ({
        proxy: new Ext.data.HttpProxy
        ({
            method:'post',
            url: '/admin/db.php',
            jsonData : Ext.util.JSON.encode
            ({
                model:"template_css",
                action: "fetch"
            })
        }),
        reader: new Ext.data.JsonReader
        ({
            root: 'result',
            fields: [{name: 'id'},{name: 'name'}]
        }),
        autoLoad: false

    });

    var csscombo= new Ext.form.ComboBox
    ({
        id: 'CURRENT_CSS_c',
        hiddenName: 'CURRENT_CSS',
        fieldLabel: 'CSS Variante',
        store: cssstore,
        triggerAction : 'all',
        valueField: 'id',
        displayField: 'name',
        typeAhead: true,

    });
          
    function reasign_css_combo()
    {
        cssstore.proxy= new Ext.data.HttpProxy
        ({
            method:'post',
            url: '/admin/db.php',
            jsonData : Ext.util.JSON.encode
            ({
                model:"template_css",
                action: "fetch",
                template:templatecombo.getValue()
            }),
        });


        cssstore.on('load',function()
        {
            if(cssstore.find('id',csscombo.getValue())<0)
                csscombo.clearValue();
        });

        cssstore.load();
        csscombo.lastQuery = null;
    }

    templatecombo.on('change', function(combo){reasign_css_combo(false)});






    var bgstore = new Ext.data.Store
    ({
        proxy: new Ext.data.HttpProxy
        ({
            method:'post',
            url: '/admin/db.php',
            jsonData : Ext.util.JSON.encode
            ({
                model:"template_background",
                action: "fetch"
            })
        }),
        reader: new Ext.data.JsonReader
        ({
            root: 'result',
            fields: [{name: 'id'},{name: 'name'}]
        }),
        autoLoad: false

    });

    var bgcombo= new Ext.form.ComboBox
    ({
        id: 'CURRENT_BACKGROUND_c',
        hiddenName: 'CURRENT_BACKGROUND',
        fieldLabel: 'Hintergrundbild',
        store: bgstore,
        triggerAction : 'all',
        valueField: 'id',
        displayField: 'name',
        typeAhead: true,

    });
          
    function reasign_bg_combo()
    {
        bgstore.proxy= new Ext.data.HttpProxy
        ({
            method:'post',
            url: '/admin/db.php',
            jsonData : Ext.util.JSON.encode
            ({
                model:"template_background",
                action: "fetch",
                template:templatecombo.getValue()
            }),
        });


        bgstore.on('load',function()
        {
            if(bgstore.find('id',bgcombo.getValue())<0)
                bgcombo.clearValue();
        });

        bgstore.load();
        bgcombo.lastQuery = null;
    }

    templatecombo.on('change', function(combo){reasign_bg_combo(false)});





    var logostore = new Ext.data.Store
    ({
        proxy: new Ext.data.HttpProxy
        ({
            method:'post',
            url: '/admin/db.php',
            jsonData : Ext.util.JSON.encode
            ({
                model:  "logo",
                action: "fetch"
            })
        }),
        reader: new Ext.data.JsonReader
        ({
            root: 'result',
            fields: [{name: 'id'},{name: 'name'}]
        }),
        autoLoad: false

    });

    var logocombo= new Ext.form.ComboBox
    ({
        id: 'CURRENT_LOGO_c',
        hiddenName: 'CURRENT_LOGO',
        fieldLabel: 'Logo',
        store: logostore,
        triggerAction : 'all',
        valueField: 'id',
        displayField: 'name',
        typeAhead: true,

    });


      
    var form = new Ext.form.FormPanel
    ({
        title: 'Mein Style',
        labelWidth: 400,
        frame:  true,
        defaultType: 'textfield',
        autoScroll: true,
        disabled:true,
        items: 
        [ 
            templatecombo,csscombo,bgcombo,logocombo
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



    function confstyle_init()
    {
        templatestore.on('load',function(){confstore.load();});
        confstore.on('load', function() 
        {
            var cobj=confstore.getAt(0).data;
            templatecombo.setValue(cobj.CURRENT_TEMPLATE);

            logostore.on('load',function()
            {
                logocombo.setValue(confstore.getAt(0).data.CURRENT_LOGO);
            });
            logostore.load();

            reasign_css_combo();
            cssstore.on('load',function()
            {
                csscombo.setValue(confstore.getAt(0).data.CURRENT_CSS);
            });
            reasign_bg_combo();
            bgstore.on('load',function()
            {
                bgcombo.setValue(confstore.getAt(0).data.CURRENT_BACKGROUND);
                form.enable();
            });
        });

        templatestore.load();
    }

    confstyle_init();



 
}




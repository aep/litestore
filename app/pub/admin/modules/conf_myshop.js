menus.conf.menu.add({
    text: 'Mein Shop',
    handler: function() {busyRef();module_conf_myshop.defer(500);}
});


function module_conf_myshop()
{
    document.title="Litemin - Mein Shop";

        var keys= 
        [
            'STORE_NAME',
            'STORE_OWNER',
            'STORE_OWNER_EMAIL_ADDRESS',
            'EMAIL_FROM',
            'STORE_COUNTRY',
            'STORE_ZONE',
            'EXPECTED_PRODUCTS_SORT',
            'EXPECTED_PRODUCTS_FIELD',
            'USE_DEFAULT_LANGUAGE_CURRENCY',
            'ADVANCED_SEARCH_DEFAULT_OPERATOR',
            'STORE_NAME_ADDRESS',
            'SHOW_COUNTS', 
            'DEFAULT_CUSTOMERS_STATUS_ID_GUEST',
            'DEFAULT_CUSTOMERS_STATUS_ID',
            'ALLOW_ADD_TO_CART',
            'PRICE_IS_BRUTTO',
            'PRICE_PRECISION',
            'CHECK_STOCK_QUANTITY'
        ];

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
                    keys: keys

                })
            }),
            reader: new Ext.data.JsonReader({},keys),
            remoteSort: false,
            autoLoad: false
        });
        confstore.on('loadexception',function(thisr,options,response,error)
        {
            throw 'confstore '+error;
        });


        var kk_STORE_NAME = new Ext.form.TextField
        ({ 
            id: 'STORE_NAME',
            fieldLabel: 'Name des Shops'
        });

        var kk_STORE_OWNER = new Ext.form.TextField
        ({ 
            id: 'STORE_OWNER',
            fieldLabel: 'Inhaber'
        });

        var kk_STORE_OWNER_EMAIL_ADDRESS = new Ext.form.TextField
        ({ 
            id: 'STORE_OWNER_EMAIL_ADDRESS',
            fieldLabel: 'EMail Adresse.'
        });

        var kk_EMAIL_FROM = new Ext.form.TextField
        ({ 
            id: 'EMAIL_FROM',
            fieldLabel: 'EMail Absender.'
        });
            

        var countrystore = new Ext.data.Store
        ({
            proxy: new Ext.data.HttpProxy
            ({
                method:'post',
                url: '/admin/db.php',
                jsonData : Ext.util.JSON.encode
                ({
                    model:"countries",
                    action: "fetch"
                })
            }),
            reader: new Ext.data.JsonReader
            ({
                root: 'result',
                fields: [{name: 'countries_id'},{name: 'countries_name'}]
            }),
            autoLoad: false

        });
        countrystore.on('loadexception',function(thisr,options,response,error)
        {
            throw 'countrystore' + error;
        });

          
        var kk_STORE_COUNTRY = new Ext.form.ComboBox
        ({
            id: 'STORE_COUNTRY_c',
            hiddenName: 'STORE_COUNTRY',
            fieldLabel: 'Land',
            store: countrystore,
            triggerAction : 'all',
            valueField: 'countries_id',
            displayField: 'countries_name',
            readOnly:true
        });


        var zonestore = new Ext.data.Store
        ({
            proxy: new Ext.data.HttpProxy
            ({
                method:'post',
                url: '/admin/db.php',
                jsonData : Ext.util.JSON.encode
                ({
                    model:"zones",
                    action:'fetch'
                }),
            }),
            reader: new Ext.data.JsonReader
            ({
                root: 'result',
                fields: [{name: 'zone_id'},{name: 'zone_name'}]
            }),
            autoLoad: false

        });
        zonestore.on('loadexception',function(thisr,options,response,error)
        {
           throw 'zonestore' +error;
        });

        var kk_STORE_ZONE = new Ext.form.ComboBox
        ({ 
            id: 'STORE_ZONE_c',
            hiddenName: 'STORE_ZONE',        
            fieldLabel: 'Region',
            store:  zonestore,
            triggerAction : 'all',
            displayField: 'zone_name',
            valueField: 'zone_id',
            autoLoad: false,
            valueNotFoundText:'<Region gehört nicht zum Land>',
            readOnly:true
        });
                   

        function reasign_zone_combo()
        {
            zonestore.proxy= new Ext.data.HttpProxy
            ({
                method:'post',
                url: '/admin/db.php',
                jsonData : Ext.util.JSON.encode
                ({
                    model:"zones",
                    action:'fetch',
                    zone_country_id:kk_STORE_COUNTRY.getValue()
                }),
            });

            zonestore.on('load',function()
            {
                if(zonestore.find('zones_id',kk_STORE_ZONE.getValue())<0)
                    kk_STORE_ZONE.clearValue();
            });
            busyRef();
            zonestore.load();
            kk_STORE_ZONE.lastQuery = null; // force a requery next time combo2 is used.
        }

        kk_STORE_COUNTRY.on('change', function(combo){reasign_zone_combo()});



        var kk_CHECK_STOCK_QUANTITY = new Ext.form.Checkbox
        ({ 
            id: 'CHECK_STOCK_QUANTITY',
            fieldLabel: 'Lagermenge beachten.'
        });


        var kk_EXPECTED_PRODUCTS_SORT = new Ext.form.ComboBox
        ({ 
            id: 'EXPECTED_PRODUCTS_SORT',
            fieldLabel: 'Anzeigereihenfolge für Artikelank&uuml;ndigungen',
            store:  [['asc','aufsteigend'],['desc','absteigend']],
            triggerAction : 'all'
        });

        var kk_EXPECTED_PRODUCTS_FIELD = new Ext.form.ComboBox
        ({ 
            id: 'EXPECTED_PRODUCTS_FIELD',
            fieldLabel: 'Feld, nach welchem Artikelankündigungen sortiert werden',
            store:  ['products_name','date_expected'],
            triggerAction : 'all'
        });

         
        var kk_USE_DEFAULT_LANGUAGE_CURRENCY = new Ext.form.Checkbox
        ({ 
            id: 'USE_DEFAULT_LANGUAGE_CURRENCY',
            fieldLabel: 'Auf die Landesw&auml;hrung automatisch umstellen'
        });

        var kk_ADVANCED_SEARCH_DEFAULT_OPERATOR = new Ext.form.ComboBox
        ({ 
            id: 'ADVANCED_SEARCH_DEFAULT_OPERATOR',
            fieldLabel: 'Standard Operator zum Verknüpfen von Suchwörtern',
            store:  ['and','or'],
            triggerAction : 'all'
        }); 

        var kk_STORE_NAME_ADDRESS = new Ext.form.TextArea
        ({
            id: 'STORE_NAME_ADDRESS', 
            fieldLabel: 'Geschäftsadresse und Telefonnummer etc',
            width: 400,
            height : 100
        });
                        
        var kk_SHOW_COUNTS = new Ext.form.Checkbox
        ({ 
            id: 'SHOW_COUNTS',
            fieldLabel: 'Artikelanzahl hinter Kategorienamen anzeigen'
        });





        var customergroupstore = new Ext.data.Store
        ({
            proxy: new Ext.data.HttpProxy
            ({
                method:'post',
                url: '/admin/db.php',
                jsonData : Ext.util.JSON.encode
                ({
                    model:"customers_status",
                    action:'fetch'
                }),
            }),
            reader: new Ext.data.JsonReader
            ({
                root: 'result',
                fields: [{name: 'customers_status_id'},{name: 'customers_status_name'}]
            }),
            autoLoad: true
        });
        customergroupstore.on('loadexception',function(thisr,options,response,error)
        {
            throw 'customergroupstore' + error;
        });




        var kk_DEFAULT_CUSTOMERS_STATUS_ID_GUEST = new Ext.form.ComboBox
        ({ 
            id: 'DEFAULT_CUSTOMERS_STATUS_ID_GUEST_cc',
            hiddenName: 'DEFAULT_CUSTOMERS_STATUS_ID_GUEST',
            fieldLabel: 'Kundengruppe für Gäste',
            store:  customergroupstore,
            triggerAction : 'all',
            forceSelection: true,
            displayField: 'customers_status_name',
            valueField: 'customers_status_id'


        });

        var kk_DEFAULT_CUSTOMERS_STATUS_ID = new Ext.form.ComboBox
        ({ 
            id: 'DEFAULT_CUSTOMERS_STATUS_ID_cc',
            hiddenName: 'DEFAULT_CUSTOMERS_STATUS_ID',
            fieldLabel: 'Kundengruppe für Neukunden',
            store:  customergroupstore,
            triggerAction : 'all',
            forceSelection: true,
            displayField: 'customers_status_name',
            valueField: 'customers_status_id'
        });

                        
        var kk_ALLOW_ADD_TO_CART = new Ext.form.Checkbox
        ({ 
            id: 'ALLOW_ADD_TO_CART',
            fieldLabel: 'Erlaube das Einfügen von Artikeln in den Warenkorb auch dann, wenn "Preise anzeigen" in der Kundengruppe auf "Nein" steht'
        });
                        
        var kk_PRICE_IS_BRUTTO = new Ext.form.Checkbox
        ({ 
            id: 'PRICE_IS_BRUTTO',
            fieldLabel: 'Ermögliche die Eingabe der Bruttopreise im Admin'
        });
                        
        var kk_PRICE_PRECISION = new Ext.form.TextField
        ({ 
            id: 'PRICE_PRECISION',
            fieldLabel: ' Brutto/Netto Dezimalstellen (Genauigkeit)'
        });
                    
        var form = new Ext.form.FormPanel
        ({  
            labelWidth: 400,
            frame:  true,
            defaultType: 'textfield',
            autoScroll: true,
            disabled:true,
            items: 
            [ 
                kk_STORE_NAME,
                kk_STORE_OWNER,
                kk_STORE_OWNER_EMAIL_ADDRESS,
                kk_EMAIL_FROM,
                kk_STORE_COUNTRY,
                kk_STORE_ZONE,
                kk_CHECK_STOCK_QUANTITY,
                kk_EXPECTED_PRODUCTS_SORT,
                kk_EXPECTED_PRODUCTS_FIELD,
                kk_USE_DEFAULT_LANGUAGE_CURRENCY,
                kk_ADVANCED_SEARCH_DEFAULT_OPERATOR,
                kk_STORE_NAME_ADDRESS,
                kk_SHOW_COUNTS,
                kk_DEFAULT_CUSTOMERS_STATUS_ID_GUEST,
                kk_DEFAULT_CUSTOMERS_STATUS_ID,
                kk_ALLOW_ADD_TO_CART,
                kk_PRICE_IS_BRUTTO,
                kk_PRICE_PRECISION
            ], 
            buttons: 
            [
                {
                    text: 'Speichern',
                    handler: function() 
                    {      

                        var vv=form.getForm().getValues();

                        if(kk_CHECK_STOCK_QUANTITY.getValue())
                            vv.CHECK_STOCK_QUANTITY=1;
                        else
                            vv.CHECK_STOCK_QUANTITY=0;
                        console.log(vv);
 
                        Ext.Ajax.request
                        ({
                            method:     'POST',
                            url:        '/admin/db.php',
                            jsonData:   Ext.util.JSON.encode
                            ({
                                model:  "configuration",
                                action: "save",
                                keys:   vv,
                            }),
                            success: function ( result, request )
                            {
                                busyRef();
                                confstore.load();
                            },
                            failure: function ( result, request )
                            {
                                throw "save failure";
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



        countrystore.on('load',function(){busyDeref();reasign_zone_combo();confstore.load();});
        customergroupstore.on('load',function(){busyDeref();countrystore.load();});

	    busyRef()
        customergroupstore.load();

        confstore.on('load', function() 
        {
            var cobj=confstore.getAt(0).data;
            kk_STORE_NAME.setValue(cobj.STORE_NAME);
            kk_STORE_OWNER.setValue(cobj.STORE_OWNER);
            kk_STORE_OWNER_EMAIL_ADDRESS.setValue(cobj.STORE_OWNER_EMAIL_ADDRESS);
            kk_EMAIL_FROM.setValue(cobj.EMAIL_FROM);
            kk_STORE_COUNTRY.setValue(cobj.STORE_COUNTRY);
            kk_STORE_ZONE.setValue(cobj.STORE_ZONE);
            kk_CHECK_STOCK_QUANTITY.setValue(cobj.CHECK_STOCK_QUANTITY);
            kk_EXPECTED_PRODUCTS_SORT.setValue(cobj.EXPECTED_PRODUCTS_SORT);
            kk_EXPECTED_PRODUCTS_FIELD.setValue(cobj.EXPECTED_PRODUCTS_FIELD);
            kk_USE_DEFAULT_LANGUAGE_CURRENCY.setValue(cobj.USE_DEFAULT_LANGUAGE_CURRENCY);
            kk_ADVANCED_SEARCH_DEFAULT_OPERATOR.setValue(cobj.ADVANCED_SEARCH_DEFAULT_OPERATOR);
            kk_STORE_NAME_ADDRESS.setValue(cobj.STORE_NAME_ADDRESS);
            kk_SHOW_COUNTS.setValue(cobj.SHOW_COUNTS);
            kk_DEFAULT_CUSTOMERS_STATUS_ID_GUEST.setValue(cobj.DEFAULT_CUSTOMERS_STATUS_ID_GUEST);
            kk_DEFAULT_CUSTOMERS_STATUS_ID.setValue(cobj.DEFAULT_CUSTOMERS_STATUS_ID);
            kk_ALLOW_ADD_TO_CART.setValue(cobj.ALLOW_ADD_TO_CART);
            kk_PRICE_IS_BRUTTO.setValue(cobj.PRICE_IS_BRUTTO);
            kk_PRICE_PRECISION.setValue(cobj.PRICE_PRECISION);


            reasign_zone_combo();
            zonestore.on('load',function()
            {
                busyDeref();
                kk_STORE_ZONE.setValue(confstore.getAt(0).data.STORE_ZONE);
                form.enable();     
                busyDeref();      
            });


        });

}




asphyxEditorFactory['com.handelsweise.litestore.product_image'] = 

function(plugin){
    plugin.editor = new Ext.form.FormPanel
    ({
        labelWidth: 200,
        defaultType: 'textfield',
        autoScroll: true,
        items: [ 
            { 
                id: 'url_small',
                fieldLabel: 'Addresse klein',
                width: '100%',
                value: plugin.node.data.url_small
            },
            { 
                id: 'url_middle',
                fieldLabel: 'Addresse mittel',
                width: '100%',
                value: plugin.node.data.url_middle
            },
            { 
                id: 'url_big',
                fieldLabel: 'Addresse gross',
                width: '100%',
                value: plugin.node.data.url_big
            }
        ]
    });

    plugin.save =  function(plugin){
        plugin.data=plugin.editor.getForm().getValues();
        plugin.data.products_id=plugin.node.data.products_id;
        plugin.data.image_nr=plugin.node.data.image_nr;
        plugin.node.data=plugin.data;
        rpcCommand({ command: 'asphyx',aclass: 'com.handelsweise.litestore.product_image', action : 'set', data: plugin.data }
        );
    };

};




/*
Kategorie Bild:
Kategorie Teaser: 	
Artikel-Sortierung: 	
Artikel-Sortierung: 	
*/



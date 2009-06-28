asphyxRegistry['com.handelsweise.litestore.product']={
    name: { 
        en:'Product',
        de:'Produkt'
    },
    construct: function(plugin){
        plugin.editor = new Ext.form.FormPanel
        ({
            labelWidth: 200,
            defaultType: 'textfield',
            autoScroll: true,
            items: [ 
                { 
                    id: 'name',
                    fieldLabel: 'Name',
                    width: '100%'
                },
                { 
                    id: 'short_description',
                    fieldLabel: 'Kurzbeschreibung',
                    width: '100%'
                },
                new Ext.form.HtmlEditor(
                { 
                    id: 'description',
                    fieldLabel: 'Beschreibung'
                }),
                { 
                    id: 'keywords',
                    fieldLabel: 'Suchbegriffe',
                    width: '100%'
                },
                { 
                    id: 'ean',
                    fieldLabel: 'EAN',
                    width: '100%'
                },
                { 
                    id: 'model',
                    fieldLabel: 'Artikel Nr.',
                    width: '100%'
                },
                { 
                    id: 'weight',
                    fieldLabel: 'Gewicht',
                    width: '100%'
                },
                new Ext.form.Checkbox(
                { 
                    id: 'status',
                    fieldLabel: 'Aktiv',
                }),
                { 
                    id: 'meta_title',
                    fieldLabel: 'Meta Title',
                    width: '100%'
                },
                { 
                    id: 'meta_description',
                    fieldLabel: 'Meta Description',
                    width: '100%'
                },
                { 
                    id: 'meta_keywords',
                    fieldLabel: 'Meta Keywords',
                    width: '100%'
                }
            ]
        });

        rpcCommand(
            {
                command: 'asphyx',
                aclass: 'com.handelsweise.litestore.product',
                action : 'get',
                products_id: plugin.node.data.products_id
            },
            function (value){
                for(prop in plugin.editor.items.map){
                    var field=plugin.editor.items.map[prop];
                    field.setValue(value[field.id]);
                }
            }
        );


        plugin.save =  function(plugin){
	        plugin.editor.items.map.description.syncValue();
            plugin.data=plugin.editor.getForm().getValues();
            plugin.data.id=plugin.node.data.products_id;
            plugin.node.setText(plugin.editor.items.map.name.getValue());
            rpcCommand({ command: 'asphyx',aclass: 'com.handelsweise.litestore.product', action : 'set', data: plugin.data });
        };

    },
    createNode:  function(node){
        if(node.aclass!="com.handelsweise.litestore.category"){
            return;
        }
        rpcCommand(
            {
                command: 'asphyx',
                aclass: 'com.handelsweise.litestore.product',
                action : 'create',
                parent: node.data.categories_id,
                name  : 'Neues Produkt'
            },
            function (value){
                var n=node.appendChild(node.attributes.loader.createNode(value));
                var p=n.getPath();
                var tree=n.getOwnerTree();
                n.ensureVisible(function(){tree.selectPath(p);});
            }
        );
    },
    removeNode:  function(node){
        rpcCommand(
            {
                command: 'asphyx',
                aclass: 'com.handelsweise.litestore.product',
                action : 'remove',
                product: node.data.products_id,
            },
            function (value){
                node.parentNode.select();
                node.remove();
            }
        );
    }
}




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
                new Ext.form.NumberField(
                { 
                    id: 'price',
                    fieldLabel: 'Preis',
                    width: '100%',
                    allowNegative:false,
//	                decimalSeparator: ','
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
                action : 'delete',
                product: node.data.products_id,
                category: node.parentNode.data.categories_id,
            },
            function (value){
                node.parentNode.select();
                node.remove();
            }
        );
    },
    canDrop:  function(e){
        var newParent=(e.point=='append')?e.target:e.target.parentNode;        
        return (newParent.aclass=='com.handelsweise.litestore.category');
    },
    drop: function (e){
        var newParent=(e.point=='append')?e.target:e.target.parentNode;

        if (e.dropNode.parentNode==newParent){
            rpcCommand(
                {
                    command: 'asphyx',
                    aclass: 'com.handelsweise.litestore.product',
                    action : 'move',
                    relative: e.point,
                    relativeTo: e.target.data.products_id,
                    parentOld: e.dropNode.parentNode.data.categories_id,
                    parentNew: newParent.data.categories_id,
                    product: e.dropNode.data.products_id
                },
                function (value){
                }
            );
            return true;
        }
        else{
            var ctx=new Ext.menu.Menu({
                items:[
                    {text:'Verlinken',handler:function(){
                        rpcCommand(
                            {
                                command: 'asphyx',
                                aclass: 'com.handelsweise.litestore.product',
                                action : 'link',
                                relative: e.point,
                                relativeTo: e.target.data.products_id,
                                parentOld: e.dropNode.parentNode.data.categories_id,
                                parentNew: newParent.data.categories_id,
                                product: e.dropNode.data.products_id
                            },
                            function (value){
                                newParent.reload();
                            }                        
                        );
                    }},
                    {text:'Verschieben',handler:function(){
                            rpcCommand(
                                {
                                    command: 'asphyx',
                                    aclass: 'com.handelsweise.litestore.product',
                                    action : 'move',
                                    relative: e.point,
                                    relativeTo: e.target.data.products_id,
                                    parentOld: e.dropNode.parentNode.data.categories_id,
                                    parentNew: newParent.data.categories_id,
                                    product: e.dropNode.data.products_id
                                },
                                function (value){
                                    e.dropNode.parentNode.removeChild(e.dropNode);
                                    newParent.reload();
                                }
                        );
                    }}
                ]
            });
            ctx.show(e.dropNode.ui.getAnchor());
            e.dropStatus=true;
            return false;

        }

    }
}




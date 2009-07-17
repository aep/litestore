asphyxPluginBuilder('com.handelsweise.litestore.category',
{
    name: { 
        en:'Category',
        de:'Kategorie'
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
                    id: 'heading_title',
                    fieldLabel: 'Überschrift',
                    width: '100%'
                },
                new Ext.form.HtmlEditor(
                { 
                    id: 'description',
                    fieldLabel: 'Beschreibung'
                }),
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
                },    
                new Ext.form.ComboBox({
                    fieldLabel: 'Produkte sortien nach',
                    id: 'products_sorting_keyCC',
                    hiddenName: 'products_sorting_key',
                    store: new Ext.data.SimpleStore({
                        fields: ['v','d'],
                        data :  [
                            ['Artikelnummer','p.products_model'],
                            ['Artikelname','pd.products_name'],
                            ['letzter Änderung','p.products_last_modified'],
                            ['angegebener Reihenfolge','p.products_sort']
                        ]
                    }),
                    displayField:'v',
                    valueField: 'd',
                    mode: 'local',
                    triggerAction: 'all',
                    emptyText:'Select a sorting key...',
                    selectOnFocus:true,
                    forceSelection: true
                }),    
                new Ext.form.ComboBox({
                    fieldLabel: 'Sortierrichtung',
                    id: 'products_sortingCC',
                    hiddenName: 'products_sorting',
                    store: new Ext.data.SimpleStore({
                        fields: ['v','d'],
                        data :  [
                            ['Aufsteigend','0'],
                            ['Absteigend','1']
                        ]
                    }),
                    displayField:'v',
                    valueField: 'd',
                    mode: 'local',
                    triggerAction: 'all',
                    selectOnFocus:true,
                    forceSelection: true
                })
            ]
        });

        rpcCommand(
            {
                command: 'asphyx',
                aclass: 'com.handelsweise.litestore.category',
                action : 'get',
                categories_id: plugin.node.data.categories_id
            },
            function (value){
                plugin.editor.items.map.name.setValue(value.name);
                plugin.editor.items.map.description.setValue(value.description);
                plugin.editor.items.map.heading_title.setValue(value.heading_title);
                plugin.editor.items.map.meta_title.setValue(value.meta_title);
                plugin.editor.items.map.meta_keywords.setValue(value.meta_keywords);
                plugin.editor.items.map.meta_description.setValue(value.meta_description);
                plugin.editor.items.map.status.setValue(value.status);
                plugin.editor.items.map.products_sorting_keyCC.setValue(value.products_sorting_key);
                plugin.editor.items.map.products_sortingCC.setValue(value.products_sorting);
            }
        );
    },
    save :  function(plugin){
        plugin.editor.items.map.description.syncValue();
        plugin.data=plugin.editor.getForm().getValues();
        plugin.data.id=plugin.node.data.categories_id;
        plugin.node.setText(plugin.editor.items.map.name.getValue());
        rpcCommand({ command: 'asphyx',aclass: 'com.handelsweise.litestore.category', action : 'set', data: plugin.data });
    },
    createNode:  function(node){
        if(node.aclass!="com.handelsweise.litestore.category"){
            return;
        }
        rpcCommand(
            {
                command: 'asphyx',
                aclass: 'com.handelsweise.litestore.category',
                action : 'create',
                parent: node.data.categories_id,
                name  : 'Neue Kategorie'
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
        if(node.data.categories_id<2){
            return false;
        }
        rpcCommand(
            {
                command: 'asphyx',
                aclass: 'com.handelsweise.litestore.category',
                action : 'delete',
                category: node.data.categories_id,
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

        rpcCommand(
            {
                command: 'asphyx',
                aclass: 'com.handelsweise.litestore.category',
                action : 'move',
                relative: e.point,
                relativeTo: e.target.data.categories_id,
                parentOld: e.dropNode.parentNode.data.categories_id,
                parentNew: newParent.data.categories_id,
                category: e.dropNode.data.categories_id
            },
            function (value){
//                newParent.reload();
            }
        );
        return true;
    },
    acceptedChildClasses: function (){
        return [
            'com.handelsweise.litestore.category',
            'com.handelsweise.litestore.product'
        ];
    }
});




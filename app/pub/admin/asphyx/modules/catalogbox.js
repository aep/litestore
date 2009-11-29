asphyxPluginBuilderExtend(
    'com.asgaartech.asphyx.folder','com.handelsweise.litestore.sidebar.catalog',
    {
        name:{
            en:'Catalog',
            de:'Katalog'
        },
        construct: function(plugin){
            plugin.editor = new Ext.form.FormPanel(
                {
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
                            id: 'data',
                            fieldLabel: 'Wurzelkategorie',
                            width: '100%'
                        }
                    ]
                });
            rpcCommand(
                {
                    command: 'asphyx',
                    aclass: plugin.node.aclass,
                    action : 'get',
                    data: plugin.node.data
                },
                function (value){
                    for(prop in plugin.editor.items.map){
                        var field=plugin.editor.items.map[prop];
                        field.setValue(value[field.id]);
                    }
                }
            );
        },
        createNode:  function(node){
            if(!node.data.id)
                return;
            rpcCommand(
                {
                    command: 'asphyx',
                    aclass: this.aclass,
                    action : 'create',
                    parent: node.data,
                    name  : this.name.de
                },
                function (value){
                    var n=node.appendChild(node.attributes.loader.createNode(value));
                    var p=n.getPath();
                    var tree=n.getOwnerTree();
                    n.ensureVisible(function(){tree.selectPath(p);});
                }
            );
        },
        acceptedChildClasses: function (){
            return [];
        }
    }
);




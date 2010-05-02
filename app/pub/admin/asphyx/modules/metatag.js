asphyxPluginBuilderExtend(
    'com.asgaartech.asphyx.folder','com.handelsweise.litestore.metatag',
    {
        name:{
            en:'Metatag',
            de:'Metatag'
        },
        construct: function(plugin){
            plugin.editor = new Ext.form.FormPanel(
                {
                    labelWidth: 200,
                    defaultType: 'textfield',
                    autoScroll: true,
                    items: [
                        new Ext.form.ComboBox({
                             fieldLabel: 'Name',
                             id: 'name',
                             store: new Ext.data.SimpleStore({
                                        fields: ['v','d'],
                                        data :  [
                                            ['keywords','keywords'],
                                            ['description','description'],
                                            ['title','title']
                                        ]
                                        }),
                             displayField:'v',
                             valueField: 'd',
                             mode: 'local',
                             triggerAction: 'all',
                             emptyText:'Select a key...',
                             selectOnFocus:true,
                             forceSelection: false
                        }),
                        { 
                            id: 'data',
                            fieldLabel: 'Value',
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
                    plugin.editor.items.map.name.setValue(value.name);
                    plugin.editor.items.map.data.setValue(value.data);
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
                    name  : 'description'
                },
                function (value){
                    var n=node.appendChild(node.attributes.loader.createNode(value));
                    var p=n.getPath();
                    var tree=n.getOwnerTree();
                    n.ensureVisible(function(){tree.selectPath(p);});
                }
            );
        }
    }
);


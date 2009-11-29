asphyxPluginBuilder('com.asgaartech.asphyx.folder',{
    cancopy:true,
    name: {
        en:'Folder',
        de:'Ordner'
    },
    construct: function(plugin){
        plugin.editor = new Ext.form.FormPanel({
            labelWidth: 200,
            defaultType: 'textfield',
            autoScroll: true,
            items: [
                {
                    id: 'name',
                    fieldLabel: 'Name',
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
    save : function(plugin){
        plugin.data=plugin.editor.getForm().getValues();
        plugin.data.id=plugin.node.data.id;
        plugin.node.setText(plugin.editor.items.map.name.getValue());
        rpcCommand({ command: 'asphyx',aclass: plugin.node.aclass, action : 'set', data: plugin.data });
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
        return [
            'com.asgaartech.asphyx.static',
            'com.asgaartech.asphyx.folder',
            'com.asgaartech.asphyx.conditional.datetime',
            'com.asgaartech.asphyx.conditional.customergroup',
            'com.asgaartech.asphyx.conditional.random',
            'com.asgaartech.asphyx.preset',
            'com.handelsweise.litestore.sidebar.blogs',
            'com.handelsweise.litestore.sidebar.adminbox',
            'com.handelsweise.litestore.sidebar.content',
            'com.handelsweise.litestore.sidebar.catalog'
        ];
    }
});




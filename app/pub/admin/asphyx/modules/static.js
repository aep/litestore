asphyxPluginBuilderExtend('com.asgaartech.asphyx.folder','com.asgaartech.asphyx.static',{
    name: { 
        en:'StaticContent',
        de:'StaticContent'
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
                },
                new Ext.form.HtmlEditor({ 
                    id: 'data',
                    fieldLabel: 'Html'
                })
            ]
        });

        rpcCommand(
            {
                command: 'asphyx',
                aclass: 'com.asgaartech.asphyx.static',
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
        plugin.editor.items.map.data.syncValue();
        plugin.data=plugin.editor.getForm().getValues();
        plugin.data.id=plugin.node.data.id;
        plugin.node.setText(plugin.editor.items.map.name.getValue());
        rpcCommand({ command: 'asphyx',aclass: plugin.node.aclass, action : 'set', data: plugin.data });
    }
});




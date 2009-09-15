asphyxPluginBuilderExtend('com.asgaartech.asphyx.folder','com.handelsweise.litestore.sidebar.blogs',{
    name: { 
        en:'Blogs',
        de:'Blogs'
    },
    construct: function(plugin){
        plugin.editor = new Ext.form.FormPanel({
            labelWidth: 200,
            defaultType: 'textfield',
            autoScroll: true,
            items: [ 
                { 
                    id: 'url',
                    fieldLabel: 'Feed Url',
                    width: '100%'
                },
            ]
        });

        rpcCommand(
            {
                command: 'asphyx',
                aclass: 'com.handelsweise.litestore.sidebar.blogs',
                action : 'get',
                data: plugin.node.data
            },
            function (value){
                    plugin.editor.items.map.url.setValue(value.data);
            }
        );
    },
    save : function(plugin){
        plugin.data=plugin.node.data;
        plugin.data.data=plugin.editor.items.map.url.getValue();

        rpcCommand({ command: 'asphyx',aclass: 'com.handelsweise.litestore.sidebar.blogs', action : 'set', data: plugin.data });
    }
});




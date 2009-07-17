asphyxPluginBuilderExtend('com.asgaartech.asphyx.folder','com.asgaartech.asphyx.conditional.customergroup',{
    name:{
        en:'Customergroup',
        de:'Kundengruppe'
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
                    fieldLabel: 'Name'
                }
            ]
        });

        plugin.store=new Ext.data.JsonStore({
                fields: ['cid','name'],
                data: []
        });

        plugin.sm = new Ext.grid.CheckboxSelectionModel();
        plugin.editor  = new Ext.grid.GridPanel({
            store: plugin.store,
            cm: new Ext.grid.ColumnModel({
                defaults: {
                    width: 120,
                    sortable: true
                },
                columns: [
                    plugin.sm,
                    {id:'id',header: "Group ID", dataIndex: 'cid'},
                    {header: "Name", dataIndex: 'name'},
                ]
            }),
            viewConfig: {
                forceFit:true
            },
            sm: plugin.sm,
            columnLines: true,
            iconCls:'icon-grid'
        });

        plugin.data=plugin.node.data;

        rpcCommand({
                command: 'asphyx',
                aclass: this.aclass,
                action : 'get',
                data: plugin.node.data
            },
            function (value){
                plugin.store.loadData(value.cgroups);
                var r=value.data.split(';');
                for(var i=0;i<r.length;i++){
                    plugin.sm.selectRow(plugin.store.find('cid',r[i]),true);
                }
            }
        );

    },
    save :  function(plugin){

        plugin.data.data='';

        var r=plugin.sm.getSelections();
        for( i in r){
            if(r[i].data){
	            if(plugin.data.data!='')
                    plugin.data.data+=';';
                plugin.data.data+=r[i].data.cid;
            }
        }

        plugin.data.name='Kundengruppen '+plugin.data.data;
        plugin.node.setText(plugin.data.name);

        rpcCommand({ command: 'asphyx',aclass: 'com.asgaartech.asphyx.conditional.datetime', action : 'set', data: plugin.data });
    },
});




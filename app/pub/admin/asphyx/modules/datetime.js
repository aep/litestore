asphyxPluginBuilderExtend('com.asgaartech.asphyx.folder','com.asgaartech.asphyx.conditional.datetime',{
    name:{
        en:'Timer',
        de:'Zeitsteuerung'
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
                },
                new Ext.form.Checkbox(
                { 
                    id: 'fromEnabled',
                    fieldLabel: 'min',
                    handler:  function(box,value){
                        plugin.editor.items.map.dateFrom.setDisabled(!value);
                        plugin.editor.items.map.timeFrom.setDisabled(!value);
                    }
                }),
                new Ext.form.DateField(
                { 
                    id: 'dateFrom',
                    fieldLabel: 'ab',
                    format: 'd.m.Y'
                }),
                new Ext.form.TimeField(
                { 
                    id: 'timeFrom',
                    fieldLabel: 'um',
                    format: 'H:i'
                }),
                new Ext.form.Checkbox(
                { 
                    id: 'toEnabled',
                    fieldLabel: 'max',
                    handler:  function(box,value){
                        plugin.editor.items.map.dateTo.setDisabled(!value);
                        plugin.editor.items.map.timeTo.setDisabled(!value);
                    }
                }),
                new Ext.form.DateField(
                { 
                    id: 'dateTo',
                    fieldLabel: 'bis',
                    format: 'd.m.Y'
                }),
                new Ext.form.TimeField(
                { 
                    id: 'timeTo',
                    fieldLabel: 'um',
                    format: 'H:i'
                })

            ]
        });


        plugin.editor.items.map.dateFrom.disable();
        plugin.editor.items.map.timeFrom.disable();
        plugin.editor.items.map.dateTo.disable();
        plugin.editor.items.map.timeTo.disable();

        plugin.data=plugin.node.data;

        rpcCommand(
            {
                command: 'asphyx',
                aclass: 'com.asgaartech.asphyx.conditional.datetime',
                action : 'get',
                data: plugin.node.data
            },
            function (value){
                plugin.editor.items.map.name.setValue(value.name);
                var a=value.data.split(';',2);
                if(a[0] && a[0]!=''){
                    plugin.editor.items.map.fromEnabled.setValue(true);
                    var d=new Date(a[0]);
                    plugin.editor.items.map.dateFrom.setValue(d);
                    plugin.editor.items.map.timeFrom.setValue(d.format('H:i'));
                }else{
                    plugin.editor.items.map.fromEnabled.setValue(false);
                }
                if(a[1] && a[1]!=''){
                    plugin.editor.items.map.toEnabled.setValue(true);
                    var d=new Date(a[1]);
                    plugin.editor.items.map.dateTo.setValue(d);
                    plugin.editor.items.map.timeTo.setValue(d.format('H:i'));
                }else{
                    plugin.editor.items.map.toEnabled.setValue(false);
                }
            }
        );
    },
    save :  function(plugin){

        plugin.data.name=plugin.editor.items.map.name.getValue();
        plugin.node.setText(plugin.editor.items.map.name.getValue());

        plugin.data.data='';

        if(plugin.editor.items.map.fromEnabled.getValue()){
            var d=plugin.editor.items.map.dateFrom.getValue().format('d.m.Y');;
            var t=plugin.editor.items.map.timeFrom.getValue();
            if(d=='')
                d='01.01.1971';
            if(t=='')
                t='00:00';
            plugin.data.data+= Date.parseDate(d+' '+t,'d.m.Y H:i').toUTCString();
        }
        plugin.data.data+=';';

        if(plugin.editor.items.map.toEnabled.getValue()){
            var d=plugin.editor.items.map.dateTo.getValue().format('d.m.Y');;
            var t=plugin.editor.items.map.timeTo.getValue();
            if(d=='')
                d='01.01.1971';
            if(t=='')
                t='00:00';
            plugin.data.data+= Date.parseDate(d+' '+t,'d.m.Y H:i').toUTCString();
        }

        rpcCommand({ command: 'asphyx',aclass: 'com.asgaartech.asphyx.conditional.datetime', action : 'set', data: plugin.data });
    },
});




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
            'com.asgaartech.asphyx.preset'
        ];
    }
});




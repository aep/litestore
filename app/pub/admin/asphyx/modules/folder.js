asphyxPluginBuilder('com.asgaartech.asphyx.folder',{
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
                name  : 'Neu'
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
        rpcCommand({
                command: 'asphyx',
                aclass: this.aclass,
                action : 'delete',
                data: node.data
            },
            function (value){
                node.parentNode.select();
                node.remove();
            }
        );
    },
    acceptedChildClasses: function (){
        return [
            'com.asgaartech.asphyx.static',
            'com.asgaartech.asphyx.folder',
            'com.asgaartech.asphyx.conditional.datetime',
            'com.asgaartech.asphyx.conditional.customergroup'
        ];
    },
    canDrop:  function(e){
        var newParent=(e.point=='append')?e.target:e.target.parentNode;        
        return ( newParent.aclass=='com.asgaartech.asphyx.folder' || 
                 newParent.aclass=='com.asgaartech.asphyx.preset' ||
                 newParent.aclass=='com.asgaartech.asphyx.conditional.datetime' ||
                 newParent.aclass=='com.asgaartech.asphyx.conditional.customergroup');
    },
    drop: function (e){
        var newParent=(e.point=='append')?e.target:e.target.parentNode;

        if (e.dropNode.parentNode==newParent){
            rpcCommand({
                    command: 'asphyx',
                    aclass: this.aclass,
                    action : 'move',
                    relative: e.point,
                    relativeTo: e.target.data,
                    parentOld: e.dropNode.parentNode.data,
                    parentNew: newParent.data,
                    subject: e.dropNode.data
                },
                function (value){
                }
            );
            return true;
        }
        else{
            var ctx=new Ext.menu.Menu({
                items:[
                    {text:'Verschieben',handler:function(){
                            rpcCommand(
                                {
                                    command: 'asphyx',
                                    aclass: this.aclass,
                                    action : 'move',
                                    relative: e.point,
                                    relativeTo: e.target.data,
                                    parentOld: e.dropNode.parentNode.data,
                                    parentNew: newParent.data,
                                    subject: e.dropNode.data
                                },
                                function (value){
                                    e.dropNode.parentNode.removeChild(e.dropNode);
                                    newParent.reload();
                                }
                        );
                    }},
                    {text:'Kopieren',handler:function(){
                            rpcCommand(
                                {
                                    command: 'asphyx',
                                    aclass: this.aclass,
                                    action : 'copy',
                                    relative: e.point,
                                    relativeTo: e.target.data,
                                    parentOld: e.dropNode.parentNode.data,
                                    parentNew: newParent.data,
                                    subject: e.dropNode.data
                                },
                                function (value){
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
});




var asphyxRegistry=new Object();


function nodeAllowedTo(node,cap){
    if(!node.caps)
        return true;

    if(cap=='write'){
        return (node.caps.write!==false);
    }
    else if(cap=='save'){
        return (node.caps.write!==false);
    }
    else if(cap=='move'){
        if(node.caps.move===undefined){
            return (node.caps.write!==false);            
        }
        else{
            return (node.caps.move);            
        }
    }
    else if(cap=='remove'){
        if(node.caps.remove===undefined){
            if(node.caps.move===undefined){
                return (node.caps.write!==false);            
            }
            else{
                return (node.caps.move);            
            }
        }
        else{
            return (node.caps.remove);            
        }
    }
    else if(cap=='read'){
        return (node.caps.read!==false);
    }
    return true;
}



var AbstractPlugin={
    canlink:false,
    cancopy:false,
    name : {
        en: 'Abstract'
    },
    construct : function(plugin){
        plugin.editor = new Ext.form.FormPanel({});
        plugin.editor.disable();
    },
    save : function (plugin){
        return false;
    },
    createNode:  function(node){
        return false;
    },
    removeNode:  function(node){
        return false;
    },
    acceptedChildClasses: function (){
        return [];
    },
    list: function (n,callback){
        rpcCommand({
                command: 'asphyx',
                aclass: this.aclass,
                action : 'list',         
                data : n.data
            },
            function (value){
                callback(value);
            }
        );
    },
    removeNodes:  function(nodes){
        var cmds=[];
        for(var i=0;i<nodes.length;i++){
            cmds.push({
                command: 'asphyx',
                aclass: nodes[i].aclass,
                action : 'delete',
                subject: nodes[i].data
            });
        }
        rpcCommands(cmds,function (value){
            nodes[0].parentNode.select();
            for(var i=0;i<nodes.length;i++){            
                nodes[i].remove();
            }
        });
    },
    drop: function (e){
        var that=this;
        var newParent=(e.point=='append')?e.target:e.target.parentNode;
        if (e.data.nodes[0].parentNode==newParent ||  (!this.canlink && !this.cancopy) ){
            var cmds=[];
            for(var i=0;i<e.data.nodes.length;i++){
                cmds.push({
                    command: 'asphyx',
                    aclass: e.data.nodes[i].aclass,
                    action : 'move',
                    relative: e.point,
                    relativeTo: e.target.data,
                    parentOld: e.data.nodes[i].parentNode.data,
                    parentNew: newParent.data,
                    subject: e.data.nodes[i].data
                });
            }
            rpcCommands(cmds,function (value){
            });
            return true;
        }
        else{

            var ctitems=[];

            ctitems.push({text:'Verschieben',handler:function(){
                var cmds=[];
                for(var i=0;i<e.data.nodes.length;i++){
                    cmds.push({
                        command: 'asphyx',
                        aclass: e.data.nodes[i].aclass,
                        action : 'move',
                        relative: e.point,
                        relativeTo: e.target.data,
                        parentOld: e.data.nodes[i].parentNode.data,
                        parentNew: newParent.data,
                        subject: e.data.nodes[i].data
                    });
                    e.data.nodes[i].parentNode.removeChild(e.data.nodes[i]);
                }

                rpcCommands(cmds,function (value){
                    newParent.reload();
                });
            }});
            if(this.cancopy==true){            
                ctitems.push({text:'Kopieren',handler:function(){
                    var cmds=[];
                    for(var i=0;i<e.data.nodes.length;i++){
                        cmds.push({
                            command: 'asphyx',
                            aclass: e.data.nodes[i].aclass,
                            action : 'copy',
                            relative: e.point,
                            relativeTo: e.target.data,
                            parentOld: e.data.nodes[i].parentNode.data,
                            parentNew: newParent.data,
                            subject: e.data.nodes[i].data
                        });
                    }
                    rpcCommands(cmds,function (value){
                        newParent.reload();
                    });
                }});
            }
            if(this.canlink==true){
                ctitems.push({text:'Verlinken',handler:function(){
                    var cmds=[];
                    for(var i=0;i<e.data.nodes.length;i++){
                        cmds.push({
                            command: 'asphyx',
                            aclass: e.data.nodes[i].aclass,
                            action : 'link',
                            relative: e.point,
                            relativeTo: e.target.data,
                            parentOld: e.data.nodes[i].parentNode.data,
                            parentNew: newParent.data,
                            subject: e.data.nodes[i].data
                        });
                    }
                    rpcCommands(cmds,function (value){
                        newParent.reload();
                    });
                }});
            }


            var ctx=new Ext.menu.Menu({
                items:ctitems
            });
            ctx.show(e.target.ui.getAnchor());
            e.dropStatus=true;
            return false;
        }
    }
}


function asphyxPluginBuilder(aclass,subc){
    var x=new Object();
    for(v in AbstractPlugin){
        x[v]=AbstractPlugin[v];
    }

    for(v in subc){
        x[v]=subc[v];
    }
    x.aclass=aclass;
    asphyxRegistry[aclass]=x;
}

function asphyxPluginBuilderExtend(superclass,aclass,subc){    
    var x=new Object();
    var s=asphyxRegistry[superclass];
    for(v in s){
        x[v]=s[v];
    }
    for(v in subc){
        x[v]=subc[v];
    }
    x.aclass=aclass;
    asphyxRegistry[aclass]=x;
}












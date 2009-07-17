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
    canDrop:  function(e){
        return false;
    },
    drop: function (e){
        return false;
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












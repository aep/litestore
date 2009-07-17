menus.catalog={text:'Unlimited',iconCls:'icon_asphyx',handler: function() {module_besatt();} };

function module_besatt()
{
    module=new Object();

    module.loader = new Ext.tree.TreeLoader
    ({
        dataUrl   :"null",
        createNode : function(attr){
            attr.cls=attr.aclass;
            attr.cls=attr.cls.replace(/\./g,'_');


            var node;
	        if(this.baseAttrs){
	            Ext.applyIf(attr, this.baseAttrs);
	        }
	        if(this.applyLoader !== false){
	            attr.loader = this;
	        }
	        if(typeof attr.uiProvider == 'string'){
	           attr.uiProvider = this.uiProviders[attr.uiProvider] || eval(attr.uiProvider);
	        }
	        if(attr.nodeType){
	            node= new Ext.tree.TreePanel.nodeTypes[attr.nodeType](attr);
	        }else{
	            node= attr.leaf ?
	                        new Ext.tree.TreeNode(attr) :
	                        new Ext.tree.AsyncTreeNode(attr);
	        }
            node.aclass=attr.aclass;
            node.data=attr.data;
            node.caps=attr.caps;

            

            return node;
        }

    });
    module.loader.on('loadexception',function(  This,  node,  response )
    {
        throw  'node '+node.id+' ("'+node.name+'") failed to load.';
    });
    module.loader.on("beforeload", function(loader, node) { 
        asphyxRegistry[node.aclass].list(node,function(nodes){
            for(var i=0;i<nodes.length;i++){
                node.appendChild(loader.createNode(nodes[i]));
            }
        });
        return false;
    });


    module.tree = new Ext.tree.TreePanel
    ({
        collapsible     : false,
        animCollapse    : false,
        border          : false,
        id              : "tree_besatt",
        autoScroll      : true,
        animate         : false,
        enableDD        : true,
        containerScroll : true,
        loader          : module.loader,
        root            : 
        {
            nodeType  : 'async',
            text      : 'Root',
            visible   : false,
            dragable  : false,
            id        : 'category_0',
            aclass    : 'root',
            data      : { categories_id: '0' },
            caps      : { move : false, write: false, read: true }
        },
        rootVisible     : false,
        region          : 'west',
        width           : 300,
        minWidth        : 150,
        split:  true

    });

    module.tree.getRootNode().expand();



    module.center = new Ext.Panel
    ({
        region: 'center',
        layout: 'card',
        border: false
    });


    module.tree.on('nodedragover',function(  e ){
        return asphyxRegistry[e.dropNode.aclass].canDrop(e);
    });


    module.tree.on('beforenodedrop',function(e){
        return asphyxRegistry[e.dropNode.aclass].drop(e);
    });
  
    module.tree.getSelectionModel().on('selectionchange',function(that,node)
    {
        if(!node){
            module.center.remove(0);
            module.toolbar.disable();
            return;
        }
        module.toolbar.enable();
        if(!asphyxRegistry[node.aclass]){
            throw ("unknown entity "+node.aclass);
        }

//        if(plugin) plugin.save(plugin);



        module.addmenu.removeAll();
        module.addbtn.disable();
        var l=asphyxRegistry[node.aclass].acceptedChildClasses();
	    for(var i=0;i<l.length;i++){
            if(!asphyxRegistry[l[i]])
                continue;
            module.addbtn.enable();
            var x=asphyxRegistry[l[i]].name.en;
            if(asphyxRegistry[l[i]].name.de){
                x=asphyxRegistry[l[i]].name.de;
            }
            var b=new Ext.menu.Item({text:x,handler:function(button){
                var sel=module.tree.getSelectionModel().getSelectedNode();
                if(!sel)
                    sel=module.tree.root;
                asphyxRegistry[button.aclass].createNode(sel);
            }});
            b.aclass=l[i];
            module.addmenu.add(b);
        }


        module.plugin=new Object();
        module.plugin.node=node;
        asphyxRegistry[node.aclass].construct(module.plugin);

        module.plugin.editor.region='center';


        if (!nodeAllowedTo(node,'write')){
            module.plugin.editor.disable();
        }

        if (nodeAllowedTo(node,'remove')){
            module.delbtn.enable();
        }
        else{
            module.delbtn.disable();
        }

        if (nodeAllowedTo(node,'save')){
            module.savebtn.enable();
        }
        else{
            module.savebtn.disable();
        }
   


        module.center.remove(0);
        module.center.add(module.plugin.editor);
        module.center.getLayout().setActiveItem(0);
        module.center.doLayout(); 
    });


    module.addmenu=new Ext.menu.Menu();
    module.addbtn=new Ext.Button({
        text: 'Neu', 
        iconCls:'icon_new',
        menuAlign:'bl-tl',
        menu:module.addmenu
    });
    module.delbtn=new Ext.Button({
        text: 'Löschen', 
        iconCls:'icon_remove', 
        handler: function(){
            var n =module.tree.getSelectionModel().getSelectedNode();
            Ext.Msg.confirm('Entfernen', 'Wirklich Knoten "'+n.text+'" mit allen Unterknoten Löschen?  (Kein Zurück!).',function(btn, text){
                if (btn == 'yes'){
                    asphyxRegistry[n.aclass].removeNode(n);
                }
            });
        }
    });
    module.savebtn=new Ext.Button({
        text: 'Speichern', 
        iconCls:'icon_save', 
        handler: function(){
            asphyxRegistry[module.plugin.node.aclass].save(module.plugin);
        }
    });

    module.toolbar =new Ext.Toolbar({
        region:'south',
        border: false,
        height: '20',
        disabled : true,
        items: [
            module.addbtn,
            module.delbtn,
            module.savebtn,
        '->'
        ]
    });

    module.panel  = new Ext.Panel
    ({
        layout: 'border',
        items: [module.toolbar,module.center,module.tree],
        border: false
    });





    document.title = 'Litemin - Catalog';


    mainpanel.remove(0);
    mainpanel.add(module.panel);
    mainpanel.getLayout().setActiveItem(0);
    mainpanel.doLayout();

}




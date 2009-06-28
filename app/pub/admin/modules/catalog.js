menus.catalog={text:'Artikel',iconCls:'icon_products',handler: function() {module_besatt();} };

function module_besatt()
{
    module=new Object();

    module.loader = new Ext.tree.TreeLoader
    ({
        dataUrl   :"/admin/besatt_ajax.php",
        baseParams:{command:'getChildren'},

        createNode : function(attr){
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
            node.removeRecursive=function(){
                console.log(this);
                var n=this.firstChild;
                while(n){
                    n.removeRecursive();
                    n=n.nextSibling;
                } 
                asphyxRegistry[node.aclass].removeNode(node);
            }
            return node;
        }

    });
    module.loader.on('loadexception',function(  This,  node,  response )
    {
        throw  'node '+node.id+' ("'+node.name+'") failed to load.';
    });
    module.loader.on("beforeload", function(treeLoader, node) {
        treeLoader.baseParams.aclass = node.aclass;
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
            text      : 'Products',
            visible   : false,
            dragable  : false,
            id        : 'category_0',
            aclass    : 'com.handelsweise.litestore.category',
            data      : { categories_id: '0' }
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


    module.tree.on('beforemovenode',function(  tree,  node,  oldParent,  newParent,  index )
    {
        new Ajax.Request('/admin/besatt_ajax.php',
        {
            evalJS: false,
            method: 'post',
            parameters :
            {
                model: 'itemcontext',
                action: 'move',
                node: node.id,
                parent: newParent.id,
                order: index
            },
            onSuccess: function(transport)
            {
                if(transport.responseText!='ok')
                {
                    Ext.Msg.alert('Asgaard Azrael', 'backend responded improperly during node move');
                }
            },
            onFailure: function(transport)
            {
                    Ext.Msg.alert('Asgaard Azrael', 'backend responded improperly during node move');
            }
        });
    });

    module.tree.getSelectionModel().on('selectionchange',function(that,node)
    {
        module.toolbar.enable();
        if(!asphyxRegistry[node.aclass]){
            throw ("unknown entity "+node.aclass);
        }

//        if(plugin) plugin.save(plugin);

   

        module.plugin=new Object();
        module.plugin.node=node;
        asphyxRegistry[node.aclass].construct(module.plugin);


        module.plugin.editor.region='center';


        module.center.remove(0);
        module.center.add(module.plugin.editor);
        module.center.getLayout().setActiveItem(0);
        module.center.doLayout(); 
    });


    module.addmenu=new Ext.menu.Menu();
	for( var e in asphyxRegistry){
        var x=asphyxRegistry[e].name.en;
        if(asphyxRegistry[e].name.de){
            x=asphyxRegistry[e].name.de;
        }
        var b=new Ext.menu.Item({text:x,handler:function(button){
            var sel=module.tree.getSelectionModel().getSelectedNode();
            if(!sel)
                sel=module.tree.root;
            asphyxRegistry[button.aclass].createNode(sel);
        }});
        b.aclass=e;
        module.addmenu.add(b);
    }


    module.toolbar =new Ext.Toolbar({
        region:'south',
        border: false,
        height: '20',
        disabled : true,
        items: [
        {
            text: 'Neu', 
            iconCls:'icon_new',
            menuAlign:'bl-tl',
            menu:module.addmenu
        },
        {
            text: 'Löschen', 
            iconCls:'icon_remove', 
            handler: function(){
                var n =module.tree.getSelectionModel().getSelectedNode();
                if((!n) || n.id=='category_0')
                    return;
                Ext.Msg.confirm('Entfernen', 'Wirklich Knoten "'+n.text+'" mit allen Unterknoten Löschen?  (Kein Zurück!).',function(btn, text){
                    if (btn == 'yes'){
                        n.removeRecursive();
                    }
                });
            }
        },
        {
            text: 'Speichern', 
            iconCls:'icon_save', 
            handler: function(){
                module.plugin.save(module.plugin);
            }
        },
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




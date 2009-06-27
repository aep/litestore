
appInitState.on("loadMenus",function () {


    mainmenu.add({text:'Content',iconCls:'icon_content',handler:function(){module_asphyx();}});
});

function module_asphyx()
{
    var asphyx_loader = new Ext.tree.TreeLoader
    ({
        dataUrl   :"/admin/asphyx_ajax.php",
        baseParams:{model:'tree'}
    });
    asphyx_loader.on('loadexception',function(  This,  node,  response )
    {
        Ext.Msg.alert('Asgaard asphyx', 'node '+node.id+' ("'+node.name+'") failed to load.');
    });

    var asphyx_tree = new Ext.tree.TreePanel
    ({
        collapsible     : false,
        animCollapse    : false,
        border          : false,
        id              : "tree_asphyx",
        autoScroll      : true,
        animate         : false,
        enableDD        : true,
        containerScroll : true,
        loader          : asphyx_loader,
        split           : true,
        root            : 
        {
            nodeType  : 'async',
            text      : 'domain',
            visible   : false,
            dragable  : false,
            id        : '1'
        }

    });

    asphyx_tree.getRootNode().expand();


    var detailstore= new Ext.data.Store
    ({
        proxy: new Ext.data.HttpProxy
        ({
            method: 'post',
            url: '/admin/asphyx_ajax.php',
            jsonData : Ext.util.JSON.encode

            ({
                model  : 'details',
                node    : 1
            })
        }),

        
        reader: new Ext.data.JsonReader
        ({
            root: 'result',
            fields: 
            [
                {name: 'key'},

                {name: 'value'}
            ]
        }),
        remoteSort: false,
        autoLoad: false
    });


    var asphyx_ctxmenu_add_static = new Ext.menu.Item({text:'StaticContent'});

    var asphyx_ctxmenu_add = new Ext.menu.Menu
    ({
        items:  [asphyx_ctxmenu_add_static]
    });

    
	asphyx_ctxmenu_add_static.on('click',function(){
    {
        Ext.Msg.prompt('Name', 'Name des neuen Content:', function(btn, text){
            if (btn == 'ok'){
                // process text value and close...

                new Ajax.Request('/admin/asphyx_ajax.php',
                {
                    evalJS: false,
                    method: 'post',
                    parameters :
                    {
                        model: 'itemcontext',
                        action: 'create',
                        type: '{c21ced16-0000-4000-92c1-69d94afb4933}',
                        nodename: text,
                        node: asphyx_tree.getSelectionModel().getSelectedNode().id
                    },
                    onSuccess: function(transport)
                    {
                        if(transport.responseText!='ok')
                        {
                            Ext.Msg.alert('Asgaard asphyx', 'backend responded improperly during node create');
                            return;
                        }
                            var p=asphyx_tree.getSelectionModel().getSelectedNode();
                            p.collapse();
                            asphyx_loader.load(p,function(){asphyx_tree.getSelectionModel().getSelectedNode().expand()});
                    },
                    onFailure: function(transport)
                    {
                        Ext.Msg.alert('Asgaard asphyx', 'backend responded improperly during node delete');
                    }
                });
            }
        });

    }

    })

    var asphyx_ctxmenu = new Ext.Toolbar
    ({
    });


    var asphyx_nodedetail = new Ext.grid.GridPanel
    ({
            store:  detailstore,
	        columns: 
            [
		        {header: 'Detail', width: '50%', sortable: true, dataIndex: 'key'},
		        {header: 'Value', width: '50%', sortable: true, dataIndex: 'value'},
	        ],
	        viewConfig: 
            {

	        },
	        autoHeight  : true,
            border      : false
    });








    detailstore.load();


    var asphyx_sidebar = new Ext.Panel
    ({
        id              : "sidebar_asphyx",
        region          : 'west',
        split           : true,
        width           : 200,
        minWidth        : 150,
        items           : [ asphyx_tree,asphyx_ctxmenu ,asphyx_nodedetail  ],
        border          : true,
        autoScroll      : true
    }); 


    var asphyx_center = new Ext.Panel
    ({
        region: 'center',
        layout: 'card',
        border: false
    });


    asphyx_tree.on('beforemovenode',function(  tree,  node,  oldParent,  newParent,  index )
    {
        new Ajax.Request('/admin/asphyx_ajax.php',
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
                    Ext.Msg.alert('Asgaard asphyx', 'backend responded improperly during node move');
                }
            },
            onFailure: function(transport)
            {
                    Ext.Msg.alert('Asgaard asphyx', 'backend responded improperly during node move');
            }
        });
    });

    asphyx_tree.on('click',function(node, e)
    {
        detailstore.proxy= new Ext.data.HttpProxy
        ({
            method: 'post',
            url: '/admin/asphyx_ajax.php',
            jsonData : Ext.util.JSON.encode
            ({
                model  : 'details',
                node    : node.id
            })
        });

        detailstore.load();

        asphyx_center.disable();
        new Ajax.Request('/admin/asphyx_ajax.php',
        {
            evalJS: false,
            method: 'post',
            parameters :
            {
                model: 'editor',
                node: node.id
            },
            onSuccess: function(transport)
            {   
                eval(transport.responseText);
                asphyx_center.enable();

                if(!asphyx_ctxmenu.hasitems)
                {
                    asphyx_ctxmenu.hasitems=true;
                    asphyx_ctxmenu.add
                    (
                        {
                            text:'Hinzufügen',
                            menu:asphyx_ctxmenu_add
                        },
                        {
                            text:'Entfernen',
                            handler: function()
                            {
                                Ext.Msg.confirm('Entfernen', 'Wirklich Knoten {} mit allen Unterknoten Löschen?  (Kein Zurück!).',function(btn, text)
                                {
                                    if (btn == 'yes')
                                    {
                                        new Ajax.Request('/admin/asphyx_ajax.php',
                                        {
                                            evalJS: false,
                                            method: 'post',
                                            parameters :
                                            {
                                                model: 'itemcontext',
                                                action: 'delete',
                                                node: asphyx_tree.getSelectionModel().getSelectedNode().id
                                            },
                                            onSuccess: function(transport)
                                            {
                                                if(transport.responseText!='ok')
                                                {
                                                    Ext.Msg.alert('Asgaard asphyx', 'backend responded improperly during node delete');
                                                    return;
                                                }
                                                var p=asphyx_tree.getSelectionModel().getSelectedNode().parentNode;
                                                asphyx_tree.getSelectionModel().getSelectedNode().remove();
                                                asphyx_tree.getSelectionModel().select(p);
                                            },
                                            onFailure: function(transport)
                                            {
                                                Ext.Msg.alert('Asgaard asphyx', 'backend responded improperly during node delete');
                                            }
                                        });

                                    }
                                });
                            }
                        }
                    );
                };




            },
            onFailure: function(transport)
            {
                Ext.Msg.alert('Asgaard asphyx', 'backend responded improperly during editor load');
            }
        });
   
    });






    var asphyx = new Ext.Panel
    ({
        layout: 'border',
        items: [asphyx_center,asphyx_sidebar],
        border: false
    });


    document.title = 'Litemin - Content';


    mainpanel.remove(0);
    mainpanel.add(asphyx);
    mainpanel.getLayout().setActiveItem(0);
    mainpanel.doLayout();

}




function module_besatt()
{
    var besatt_loader = new Ext.tree.TreeLoader
    ({
        dataUrl   :"/admin/besatt_ajax.php",
        baseParams:{model:'tree'}
    });
    besatt_loader.on('loadexception',function(  This,  node,  response )
    {
        Ext.Msg.alert('Asgaard Azrael', 'node '+node.id+' ("'+node.name+'") failed to load.');
    });

    var besatt_tree = new Ext.tree.TreePanel
    ({
        collapsible     : false,
        animCollapse    : false,
        border          : false,
        id              : "tree_besatt",
        autoScroll      : true,
        animate         : false,
        enableDD        : true,
        containerScroll : true,
        loader          : besatt_loader,
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

    besatt_tree.getRootNode().expand();


    var detailstore= new Ext.data.Store
    ({
        proxy: new Ext.data.HttpProxy
        ({
            method: 'post',
            url: '/admin/besatt_ajax.php',
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


    var besatt_ctxmenu_add_static = new Ext.menu.Item({text:'StaticContent'});

    var besatt_ctxmenu_add = new Ext.menu.Menu
    ({
        items:  [besatt_ctxmenu_add_static]
    });

    
	besatt_ctxmenu_add_static.on('click',function(){
    {
        Ext.Msg.prompt('Name', 'Name des neuen Kontens:', function(btn, text){
            if (btn == 'ok'){
                // process text value and close...

                new Ajax.Request('/admin/besatt_ajax.php',
                {
                    evalJS: false,
                    method: 'post',
                    parameters :
                    {
                        model: 'itemcontext',
                        action: 'create',
                        type: '{c21ced16-0000-4000-92c1-69d94afb4933}',
                        nodename: text,
                        node: besatt_tree.getSelectionModel().getSelectedNode().id
                    },
                    onSuccess: function(transport)
                    {
                        if(transport.responseText!='ok')
                        {
                            Ext.Msg.alert('Asgaard Azrael', 'backend responded improperly during node create');
                            return;
                        }
                            var p=besatt_tree.getSelectionModel().getSelectedNode();
                            p.collapse();
                            besatt_loader.load(p,function(){besatt_tree.getSelectionModel().getSelectedNode().expand()});
                    },
                    onFailure: function(transport)
                    {
                        Ext.Msg.alert('Asgaard Azrael', 'backend responded improperly during node delete');
                    }
                });
            }
        });

    }

    })

    var besatt_ctxmenu = new Ext.Toolbar
    ({
    });


    var besatt_nodedetail = new Ext.grid.GridPanel
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


    var besatt_sidebar = new Ext.Panel
    ({
        id              : "sidebar_besatt",
        region          : 'east',
        split           : true,
        width           : 200,
        minWidth        : 150,
        items           : [ besatt_tree,besatt_ctxmenu ,besatt_nodedetail  ],
        border          : true,
        autoScroll      : true
    }); 


    var besatt_center = new Ext.Panel
    ({
        region: 'center',
        layout: 'card',
        border: false
    });


    besatt_tree.on('beforemovenode',function(  tree,  node,  oldParent,  newParent,  index )
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

    besatt_tree.on('click',function(node, e)
    {
        detailstore.proxy= new Ext.data.HttpProxy
        ({
            method: 'post',
            url: '/admin/besatt_ajax.php',
            jsonData : Ext.util.JSON.encode
            ({
                model  : 'details',
                node    : node.id
            })
        });

        detailstore.load();

        besatt_center.disable();
        new Ajax.Request('/admin/besatt_ajax.php',
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
                besatt_center.enable();

                if(!besatt_ctxmenu.hasitems)
                {
                    besatt_ctxmenu.hasitems=true;
                    besatt_ctxmenu.add
                    (
                        {
                            text:'Hinzufügen',
                            menu:besatt_ctxmenu_add
                        },
                        {
                            text:'Entfernen',
                            handler: function()
                            {
                                Ext.Msg.confirm('Entfernen', 'Wirklich Knoten {} mit allen Unterknoten Löschen?  (Kein Zurück!).',function(btn, text)
                                {
                                    if (btn == 'yes')
                                    {
                                        new Ajax.Request('/admin/besatt_ajax.php',
                                        {
                                            evalJS: false,
                                            method: 'post',
                                            parameters :
                                            {
                                                model: 'itemcontext',
                                                action: 'delete',
                                                node: besatt_tree.getSelectionModel().getSelectedNode().id
                                            },
                                            onSuccess: function(transport)
                                            {
                                                if(transport.responseText!='ok')
                                                {
                                                    Ext.Msg.alert('Asgaard Azrael', 'backend responded improperly during node delete');
                                                    return;
                                                }
                                                var p=besatt_tree.getSelectionModel().getSelectedNode().parentNode;
                                                besatt_tree.getSelectionModel().getSelectedNode().remove();
                                                besatt_tree.getSelectionModel().select(p);
                                            },
                                            onFailure: function(transport)
                                            {
                                                Ext.Msg.alert('Asgaard Azrael', 'backend responded improperly during node delete');
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
                Ext.Msg.alert('Asgaard Azrael', 'backend responded improperly during editor load');
            }
        });
   
    });






    var besatt = new Ext.Panel
    ({
        title           : 'Asgaard Azrael',
        layout: 'border',
        items: [besatt_center,besatt_sidebar],
        border: false
    });



    mainpanel.remove(0);
    mainpanel.add(besatt);
    mainpanel.getLayout().setActiveItem(0);
    mainpanel.doLayout();

}




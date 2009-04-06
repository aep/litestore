function module_azrael()
{
 
    var azrael_loader = new Ext.tree.TreeLoader
    ({
        dataUrl   :"/admin/azrael_ajax.php",
        baseParams:{model:'tree'}
    });

    var azrael_tree = new Ext.tree.TreePanel
    ({
        collapsible     : false,
        animCollapse    : false,
        border          : false,
        id              : "tree_azrael",
        autoScroll      : true,
        animate         : false,
        enableDD        : true,
        containerScroll : true,
        loader          : azrael_loader,
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

    azrael_tree.getRootNode().expand();


    var detailstore= new Ext.data.Store
    ({
        proxy: new Ext.data.HttpProxy
        ({
            method: 'post',
            url: '/admin/azrael_ajax.php',
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



    var azrael_ctxmenu_add = new Ext.menu.Menu
    ({
        items: 
        [
                {text: 'Preset'},
                {text: 'Ordner'},
                {text: 'StaticContent'}
        ]
    });


    var azrael_ctxmenu = new Ext.Toolbar
    ({
    });


    var azrael_nodedetail = new Ext.grid.GridPanel
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


    var azrael_sidebar = new Ext.Panel
    ({
        id              : "sidebar_azrael",
        region          : 'east',
        split           : true,
        width           : 200,
        minWidth        : 150,
        items           : [ azrael_tree,azrael_ctxmenu ,azrael_nodedetail  ],
        border          : true,
        autoScroll      : true
    }); 


    var azrael_center = new Ext.Panel
    ({
        region: 'center',
        layout: 'card',
        border: false
    });


    azrael_tree.on('beforemovenode',function(  tree,  node,  oldParent,  newParent,  index )
    {
        new Ajax.Request('/admin/azrael_ajax.php',
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
                    throw 'unexpected response';
                }
            },
            onFailure: function(transport)
            {
                throw 'ajax request failed';
            }
        });
    });

    azrael_tree.on('click',function(node, e)
    {
        detailstore.proxy= new Ext.data.HttpProxy
        ({
            method: 'post',
            url: '/admin/azrael_ajax.php',
            jsonData : Ext.util.JSON.encode
            ({
                model  : 'details',
                node    : node.id
            })
        });

        detailstore.load();

        azrael_center.disable();
        new Ajax.Request('/admin/azrael_ajax.php',
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
                azrael_center.enable();

                if(!azrael_ctxmenu.hasitems)
                {
                    azrael_ctxmenu.hasitems=true;
                    azrael_ctxmenu.add
                    (
                        {
                            text:'Hinzufügen',
                            menu:azrael_ctxmenu_add
                        },
                        {
                            text:'Entfernen',
                            handler: function()
                            {
                                Ext.Msg.confirm('Entfernen', 'Wirklich Knoten {} mit allen Unterknoten Löschen?  (Kein Zurück!).',function(btn, text)
                                {
                                    if (btn == 'yes')
                                    {
                                        new Ajax.Request('/admin/azrael_ajax.php',
                                        {
                                            evalJS: false,
                                            method: 'post',
                                            parameters :
                                            {
                                                model: 'itemcontext',
                                                action: 'delete',
                                                node: azrael_tree.getSelectionModel().getSelectedNode().id
                                            },
                                            onSuccess: function(transport)
                                            {
                                                if(transport.responseText!='ok')
                                                {
                                                    throw 'unexpected response';
                                                }
                                                var p=azrael_tree.getSelectionModel().getSelectedNode().parentNode;
                                                azrael_tree.getSelectionModel().getSelectedNode().remove();
                                                azrael_tree.getSelectionModel().select(p);
                                            },
                                            onFailure: function(transport)
                                            {
                                                throw 'ajax request failed';
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
                alert("failure");
            }
        });
   
    });






    var azrael = new Ext.Panel
    ({
        title           : 'Asgaard Azrael',
        layout: 'border',
        items: [azrael_center,azrael_sidebar],
        border: false
    });



    mainpanel.remove(0);
    mainpanel.add(azrael);
    mainpanel.getLayout().setActiveItem(0);
    mainpanel.doLayout();




 
}




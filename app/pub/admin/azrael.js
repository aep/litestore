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
        width           : 150,
        minWidth        : 150,
        items           : [ azrael_tree,azrael_nodedetail  ],
        border          : true
    }); 


    var azrael_center = new Ext.Panel
    ({
        region: 'center',
        layout: 'card',
        border: false
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




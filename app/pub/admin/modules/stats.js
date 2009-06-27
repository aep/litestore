menus.stats ={text:'Statistik',iconCls:'icon_stats',menu: new Ext.menu.Menu()};
menus.stats.menu.add(
    {
        text: 'Besuchte Artikel',
        handler: function() {module_stats('products_viewed');}
    },
    {
        text: 'Verkaufte Artikel',
        handler: function() {module_stats('products_ordered');}
    },
    {
        text: 'Kunden-Bestellstatistik',
        handler: function() {module_stats('customer_orderstats');}
    },
    {
        text: 'Umsatzstatistik',
        handler: function() {module_iframe('Umsatzstatistik','/admin/stats_sales_report.php');}
    }
);


function module_stats(model)
{

	var statsReader; 
    var statsCols;
    var statsTitle;


    if(model=='products_viewed')
    {
        statsReader= new Ext.data.JsonReader
        ({
            root: 'result',
            fields: [{name: 'nr'},{name: 'name'},{name: 'viewed'}]
        });
        statsCols= 
        [
			{header: 'Nr.', width: '1%', sortable: true, dataIndex: 'nr'},
			{header: 'Artikel', width: 90, sortable: true, dataIndex: 'name'},
			{header: 'Besucht', width: 90, sortable: true, dataIndex: 'viewed'}
		];
        statsTitle='Besuchte Artikel';
    }
    else if(model=='products_ordered')
    {
        statsReader= new Ext.data.JsonReader
        ({
            root: 'result',
            fields: [{name: 'nr'},{name: 'name'},{name: 'ordered'}]
        });
        statsCols= 
        [
			{header: 'Nr.', width: '1%', sortable: true, dataIndex: 'nr'},
			{header: 'Artikel', width: 90, sortable: true, dataIndex: 'name'},
			{header: 'Verkauft', width: 90, sortable: true, dataIndex: 'ordered'}
		];
        statsTitle='Verkaufte Artikel';
    }
    else if(model=='customer_orderstats')
    {
        statsReader= new Ext.data.JsonReader
        ({
            root: 'result',
            fields: [{name: 'nr'},{name: 'name'},{name: 'sum'}]
        });
        statsCols= 
        [
			{header: 'Nr.', width: '1%', sortable: true, dataIndex: 'nr'},
			{header: 'Artikel', width: 90, sortable: true, dataIndex: 'name'},
			{header: 'Bestellsumme', width: 90, sortable: true, dataIndex: 'sum'}
		];
        statsTitle='Kunden mit den höchsten Umsätzen';
    }
    else
    {
        throw "undefined model to module_stats";
    }



    var statsStore = new Ext.data.Store
    ({
        proxy: new Ext.data.HttpProxy
        ({
            method:'post',
            url: '/admin/db.php',
            jsonData : Ext.util.JSON.encode
            ({
                model:model,
                action:'fetch'
            }),
        }),
        reader: statsReader,
        autoLoad: true

    });
 

    document.title = 'Litemin - '+statsTitle;
 
	var grid = new Ext.grid.GridPanel
    ({
		store: statsStore,
		columns:statsCols,
		viewConfig: {forceFit: true},
		autoHeight: true,
        border: false,
        autoScroll  :  'true',
        region:'center'
	});
 


    mainpanel.remove(0);
    mainpanel.add(grid);
    mainpanel.getLayout().setActiveItem(0);
    mainpanel.doLayout();
}

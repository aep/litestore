<?php
    require('includes/application_top.php');
    header('content-type','text/javascript');
?>
Ext.onReady(function(){


	    var myData = [
    <?php
            global $db;
            $i=1;
            $q=$db->query("select c.customers_firstname, c.customers_lastname, sum(op.final_price) as ordersum from " . TABLE_CUSTOMERS . " c, " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_ORDERS . " o where c.customers_id = o.customers_id and o.orders_id = op.orders_id group by c.customers_firstname, c.customers_lastname order by ordersum DESC");
            while ($products = $q->fetch()) 
            {
                echo '[\''.$i.'\',\''.$products['customers_firstname'].' '.$products['customers_lastname'].'\',\''.$products['ordersum'].'€\'],';
                ++$i;
            }
    ?>
	    ];
     
	    var myReader = new Ext.data.ArrayReader({}, [
		    {name: 'nr'},
		    {name: 'artikel'},
		    {name: 'besucht'},
	    ]);
     
	    var grid = new Ext.grid.GridPanel({
		    store: new Ext.data.Store({
			    data: myData,
			    reader: myReader
		    }),
		    columns: [
			    {header: 'Nr.', width: '1%', sortable: true, dataIndex: 'nr'},
			    {header: 'Name', width: 90, sortable: true, dataIndex: 'artikel'},
			    {header: 'Bestellsumme', width: 90, sortable: true, dataIndex: 'besucht'},
		    ],
		    viewConfig: {
			    forceFit: true
		    },
		    autoHeight: true,
            border: false,
            autoScroll  :  'true',
            region:'center',
            title: '<?php echo HEADING_TITLE; ?>'
	    });
     
        mainpanel.remove(0);
        mainpanel.add(grid );
        mainpanel.getLayout().setActiveItem(0);
        mainpanel.doLayout();

});


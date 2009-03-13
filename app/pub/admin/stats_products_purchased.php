<?php require('includes/application_top.php');
header('content-type','text/javascript');
?>

    Ext.onReady(function(){

	    var myData = [
    <?php

            global $db;
            $i=1;
            $q=$db->query("select p.products_id, p.products_ordered, pd.products_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where pd.products_id = p.products_id and pd.languages_id = '" . $_SESSION['languages_id'] . "' and p.products_ordered > 0 group by pd.products_id order by p.products_ordered DESC, pd.products_name");
            while ($products = $q->fetch()) 
            {
                echo '[\''.$i.'\',\''.$products['products_name'].'\',\''.$products['products_ordered'].'\'],';
                ++$i;
            }
    ?>
	    ];
     
	    var myReader = new Ext.data.ArrayReader({}, [
		    {name: 'nr'},
		    {name: 'artikel'},
		    {name: 'ordered'},
	    ]);


	    var grid = new Ext.grid.GridPanel({
		    store: new Ext.data.Store({
			    data: myData,
			    reader: myReader
		    }),
		    columns: [
			    {header: 'Nr.', width: '1%', sortable: true, dataIndex: 'nr'},
			    {header: 'Artikel', width: 90, sortable: true, dataIndex: 'artikel'},
			    {header: 'Verkauft', width: 90, sortable: true, dataIndex: 'ordered'},
		    ],
		    viewConfig: {
			    forceFit: true
		    },
		    autoHeight  : true,
            border      : false,
            autoScroll  : 'true',
            title       : '<?php echo HEADING_TITLE; ?>',
		    title: 'Verkaufte Artikel'

	    });

        mainpanel.remove(0);
        mainpanel.add(grid);
        mainpanel.getLayout().setActiveItem(0);
        mainpanel.doLayout();

    });


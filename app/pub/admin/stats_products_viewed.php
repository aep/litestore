<?php
    require('includes/application_top.php');
    header('content-type','text/javascript');
?>

	var myData = [
<?php
        global $db;
        $i=1;
        $q=$db->query("select p.products_id, pd.products_name, pd.products_viewed, l.name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_LANGUAGES . " l where p.products_id = pd.products_id and l.languages_id = pd.languages_id order by pd.products_viewed DESC");
        while ($products = $q->fetch()) 
        {
            echo '[\''.$i.'\',\''.$products['products_name'].'\',\''.$products['products_viewed'].'\'],';
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
			{header: 'Artikel', width: 90, sortable: true, dataIndex: 'artikel'},
			{header: 'Besucht', width: 90, sortable: true, dataIndex: 'besucht'},
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
        mainpanel.add(grid);
        mainpanel.getLayout().setActiveItem(0);
        mainpanel.doLayout();


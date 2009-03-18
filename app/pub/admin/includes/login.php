<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
    <title><?php echo TITLE; ?></title>
    <link rel="stylesheet" type="text/css" href="images/stylesheet.css">
    <script type="text/javascript" src="/pub/javascript/spin.js"></script>
    <script type="text/javascript" src="/pub/javascript/adapter/prototype/prototype.js"></script>
    <script type="text/javascript" src="/pub/javascript/adapter/prototype/ext-prototype-adapter.js"></script>
    <script type="text/javascript" src="/pub/javascript/adapter/prototype/scriptaculous.js?load=effects"></script>
    <script type="text/javascript" src="/pub/javascript/ext-all-debug.js"></script>
    <link rel="stylesheet" type="text/css"	href="/pub/javascript/resources/css/ext-all.css" >
    <style type="text/css" media="screen"><!--
        body 
        {
            color:black;
            background:white;
	        margin: 0px
        }

        #horizon        
        {
	        text-align: center;
	        position: absolute;
	        top: 50%;
	        left: 0px;
	        width: 100%;
	        height: 1px;
	        overflow: visible;
	        visibility: visible;
	        display: block
        }

        #content    
        {
	        margin-left: -110px;
	        position: absolute;
	        top: -35px;
	        left: 50%;
	        width: 220px;
	        height: 70px;
	        visibility: visible
        }



        --></style>
</head>
<body>
    <div id="horizon">
	    <div id="content">
	    </div>
    </div>

    <script type="text/javascript">


    
    var loginname = new Ext.form.TextField
    ({ 
        width:200,
        hideLabel: true,
        id: 'loginname',
        emptyText  : 'Login'
    });

    
    var password = new Ext.form.TextField
    ({ 
        width:200,
        hideLabel: true,
        id: 'password',
        inputType: 'password',
        emptyText  : 'Passwort'
    });


    Ext.onReady(function()
    {
        form = new Ext.form.FormPanel
        ({
            url:'/admin/',
            standardSubmit: true,
            width: 220,
            border: false,
            autoScroll  :  'true',
            renderTo: 'content',
            items: [loginname,password],
            buttons: 
            [{
                text: 'Login',
                handler: function() 
                {
    	    	    form.getForm().getEl().dom.action = '/admin/';
        	        form.getForm().getEl().dom.method = 'POST';
                    form.getForm().submit();
                }
            }]

        });
    });
    </script>

</body>
</html>

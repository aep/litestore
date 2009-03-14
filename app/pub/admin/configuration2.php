<?php
    require('includes/application_top.php');
    header('content-type','text/javascript');

    $cfg_group = $db->query("select configuration_group_title from " . TABLE_CONFIGURATION_GROUP . " where configuration_group_id = '" . (int)$_GET['gID'] . "'")->fetch();
    $cfg_group = $cfg_group['configuration_group_title'];

    $confs=$db->query("select configuration_key,configuration_id, configuration_value, use_function,set_function from " . TABLE_CONFIGURATION . " where configuration_group_id = '" . (int)$_GET['gID'] . "' order by sort_order");


    $defs='';

    while ($configuration = $confs->fetch()) 
    {
        $keys[]=$configuration['configuration_key'];

        $oerr=error_reporting(0);
            $con=constant(strtoupper($configuration['configuration_key'].'_TITLE'));
        error_reporting($oerr);

        echo '
            var kk_'.$configuration['configuration_key'].' = new Ext.form.TextField
            ({ 
                id: \''.$configuration['configuration_key'].'\',
                fieldLabel: \''.$con.'\'
            });
        ';
    }
?>

    var confstore = new Ext.data.Store
    ({
        proxy: new Ext.data.HttpProxy
        ({
            method: 'post',
            url: '/admin/db.php',
            jsonData : Ext.util.JSON.encode
            ({
                model:"configuration",
                action:"fetch",
                keys: ['<?php echo implode('\',\'',$keys); ?>']
            })
        }),
        reader: new Ext.data.JsonReader({},['<?php echo implode('\',\'',$keys); ?>']),
        remoteSort: false,
        autoLoad: false
    });
                
    var form = new Ext.form.FormPanel
    ({
        title: 'Mein Shop',
        labelWidth: 400,
        frame:  true,
        defaultType: 'textfield',
        autoScroll: true,
        disabled:true,
        items: [ kk_<?php echo implode(',kk_',$keys); ?>], 
        buttons: 
        [
            {
                text: 'Speichern',
                handler: function() 
                {       
                    Ext.Ajax.request
                    ({
                        method:     'POST',
                        url:        '/admin/db.php',
                        jsonData:   Ext.util.JSON.encode
                        ({
                            model:  "configuration",
                            action: "save",
                            keys:   form.getForm().getValues(),
                        }),
                        success: function ( result, request )
                        {
                            confstore.load();
                        },
                        failure: function ( result, request )
                        {
                            Ext.Msg.alert('Speichern fehlgeschlagen.', 'Beim Speichern Ihrer Daten ist ein Fehler aufgetreten. Bitte versuchen Sie es in einigen Minuten noch einmal. Sollte das Problem weiterhin bestehen kontaktieren Sie den Support. ');
                        }
                    });
                    form.disable();
                }
            }
        ]
    });
 

    mainpanel.remove(0);
    mainpanel.add(form);
    mainpanel.getLayout().setActiveItem(0);
    mainpanel.doLayout();


    confstore.on('load', function() 
    {
        var cobj=confstore.getAt(0).data;
        <?php 
            foreach($keys as $key)
            {
                echo 'kk_'.$key.'.setValue(cobj.'.$key.');';
            }
        ?>
        form.enable();

    });

    confstore.load();


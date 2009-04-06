<?php
    require ('includes/application_top.php');
    global $db;

    if(!$_POST['model'])
        $_POST=json_decode(file_get_contents("php://input"),true);

    if($_POST['model']=='tree')
    {
        header ('content-type : text/x-json');
        $q=$db->prepare('SELECT id, parent, uuid, name, `order` FROM `content` where `parent`=? order by `order` ASC');
        $q->execute(array($_POST['node']));

        $nodes=array();

        while($row=$q->fetch())
        {

            $qc=$db->prepare('SELECT COUNT(*)  FROM `content` where `parent`=? ');
            $qc->execute(array($row['id']));
            $qc=$qc->fetch();
            $qc=$qc['COUNT(*)'];

            $node['text']		= $row['name'];
            $node['id']			= $row['id'];
            $node['position']	= $row['order'];    
            $node['leaf']	    = (bool)($qc<1);

            //TODO
            if($row['uuid']=='{756d8484-0000-4000-a071-2ab6e1ec6785}')
            {
                $node['cls']	= 'folder';
            }
            else
            {
                $node['cls']	= 'file';
            }

            $nodes[]=$node;
        }

        echo json_encode($nodes);
    }
    else if($_POST['model']=='details')
    {
        header ('content-type : text/x-json');

        header ('content-type : text/x-json');
        $q=$db->prepare('SELECT id, parent, uuid, name, data, `order` FROM `content` where `id`=? ');
        $q->execute(array($_POST['node']));
        $node=$q->fetch();

        switch ($node['uuid'])
        {
            case '{756d8484-0000-4000-a071-2ab6e1ec6785}': //folder
            {
                echo json_encode(array('result'=>array
                (
                    array('key'=>'id','value'=>$node['id']),
                    array('key'=>'type','value'=>'folder'),
                    array('key'=>'name','value'=>$node['name'])
                )));            
                break;
            }
            case '{24f3af1a-043d-459e-adb8-48daa6645e6b}': //link
            {
                echo json_encode(array('result'=>array
                (
                    array('key'=>'id','value'=>$node['id']),
                    array('key'=>'type','value'=>'Link'),
                    array('key'=>'name','value'=>$node['name']),
                    array('key'=>'uri','value'=>$node['data']),
                )));            
                break;
            }
            case '{c21ced16-0000-4000-92c1-69d94afb4933}': //StaticContent
            {
                echo json_encode(array('result'=>array
                (
                    array('key'=>'id','value'=>$node['id']),
                    array('key'=>'type','value'=>'StaticContent'),
                    array('key'=>'name','value'=>$node['name'])
                )));            
                break;
            }
            case '{04b31d60-0000-4000-b981-2e18fd1eb9e8}': //DateCondition
            {
                echo json_encode(array('result'=>array
                (
                    array('key'=>'id','value'=>$node['id']),
                    array('key'=>'type','value'=>'DateCondition'),
                    array('key'=>'name','value'=>$node['name']),
                    array('key'=>'cond','value'=>$node['data'])
                )));            
                break;
            }
            case '{b4e3c4b6-0000-4000-af6b-d9464c2ce97a}': //Variable
            {
                echo json_encode(array('result'=>array
                (
                    array('key'=>'id','value'=>$node['id']),
                    array('key'=>'type','value'=>'DateCondition'),
                    array('key'=>'name','value'=>$node['name'])
                )));            
                break;
            }
            case '{fe61a8ac-0000-4000-9276-3eeb4185933d}': //File
            {
                echo json_encode(array('result'=>array
                (
                    array('key'=>'id','value'=>$node['id']),
                    array('key'=>'type','value'=>'File'),
                    array('key'=>'name','value'=>$node['name'])
                )));            
                break;
            }
            case '{e4527460-0000-4000-b52f-2d8668f85680}': //Image
            {
                echo json_encode(array('result'=>array
                (
                    array('key'=>'id','value'=>$node['id']),
                    array('key'=>'type','value'=>'Image'),
                    array('key'=>'name','value'=>$node['name']),
                    array('key'=>'uri','value'=>$node['data'])
                )));            
                break;
            }
            case '{3a2676a9-0000-4000-8491-702302a7c112}': //Randomizer
            {
                echo json_encode(array('result'=>array
                (
                    array('key'=>'id','value'=>$node['id']),
                    array('key'=>'type','value'=>'Randomizer'),
                    array('key'=>'name','value'=>$node['name'])
                )));            
                break;
            }
            case '{07331c60-0000-4000-b996-6618fa1eb9e8}': //UriSelector
            {
                echo json_encode(array('result'=>array
                (
                    array('key'=>'id','value'=>$node['id']),
                    array('key'=>'type','value'=>'UriSelector'),
                    array('key'=>'name','value'=>$node['name']),
                    array('key'=>'cond','value'=>$node['data'])
                )));            
                break;
            }
            case '{0ab256ea-0000-4000-9827-6556fa1eb9e8}': //Preset
            {
                echo json_encode(array('result'=>array
                (
                    array('key'=>'id','value'=>$node['id']),
                    array('key'=>'type','value'=>'Preset'),
                    array('key'=>'name','value'=>$node['name']),
                    array('key'=>'area','value'=>$node['data'])
                )));            
                break;
            }





            default:
            {
                echo json_encode(array('result'=>array
                (
                    array('key'=>'name','value'=>$node['name'])
                )));            
                break;
            }
        }



    }
    else if($_POST['model']=='editor')
    {
        header ('content-type : application/javascript');

        if($_POST['action']=='save')
        {
            $q=$db->prepare('update `content` set `data`=? where `id`=?;');
            $q->execute(array($_POST['data'],$_POST['node']));

            echo 'ok';
        }
        else
        {        

            $q=$db->prepare('SELECT id, parent, uuid, name, data, `order` FROM `content` where `id`=? ');
            $q->execute(array($_POST['node']));
            $node=$q->fetch();

            switch ($node['uuid'])
            {
                case '{c21ced16-0000-4000-92c1-69d94afb4933}': //StaticContent
                {
                    ?>

                    var htmleditor =new Ext.form.HtmlEditor
                    ({
                        value: <?php echo json_encode($node['data']); ?>,
                        border: false,
                        anchor: '100% -30'
                    });

                    var htmlbutton = new Ext.Button
                    ({
                        align: 'right',
                        text: 'Speichern',
                        handler:function()
                        {
                            
                            Ext.Ajax.request
                            ({
                                method:     'POST',
                                url:        '/admin/azrael_ajax.php',
                                jsonData:   Ext.util.JSON.encode
                                ({
                                    model:  "editor",
                                    action: "save",
                                    node: <?php echo $node['id']; ?>,
                                    data:   htmleditor.getValue()
                                }),
                                success: function ( result, request )
                                {
                                    editor.enable();
                                },
                                failure: function ( result, request )
                                {
                                    Ext.Msg.alert('Speichern fehlgeschlagen.', 'Beim Speichern Ihrer Daten ist ein Fehler aufgetreten. Bitte versuchen Sie es in einigen Minuten noch einmal. Sollte das Problem weiterhin bestehen kontaktieren Sie den Support. ');
                                }
                            });
                            editor.disable();
                        }
                    });
                            
                    var editor = new Ext.Panel
                    ({
                        border: true,
                        layout: 'anchor',
                        items: [htmleditor,htmlbutton]
                    });
                 


                    <?php
                    break;
                }
                case '{756d8484-0000-4000-a071-2ab6e1ec6785}': //folder
                default:
                {
                    ?>
                    var editor=new Ext.Panel
                    ({
                        html:'<div style="text-align:center"><br><br><br>nothing</div>'
                    });
                    <?php
                    break;
                }
            }
            ?>
            azrael_center.remove(0);
            azrael_center.add(editor);
            azrael_center.getLayout().setActiveItem(0);
            azrael_center.doLayout(); 
            <?php
        }
    }
    else if($_POST['model']=='itemcontext')
    {
        if($_POST['action']=='move')
        {
            $q=$db->prepare('update `content` set `order`=? , `parent`=? where `id`=?;');
            $q->execute(array($_POST['order'],$_POST['parent'],$_POST['node']));
            echo "ok";
        }
        else if($_POST['action']=='delete')
        {
            $delnodes=array();

            function r($id,&$delnodes )
            {
                global $db;
                $q=$db->prepare('select `id` from `content`  where `parent`=?;');
                $q->execute(array($id));
                while($x=$q->fetch())
                {
                    $delnodes[]=$x['id'];
                    r($x['id'],$delnodes);
                }
                $delnodes[]=$id;
            }
                    
            r($_POST['node'],$delnodes);

            $q=$db->prepare('delete from `content`  where `id`=?;');
            foreach ($delnodes as $delnode)
            {
                $q->execute(array($delnode));
            }
            echo "ok";
        }
    }



?>

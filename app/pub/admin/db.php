<?php
    require ('includes/application_top.php');
    header ('content-type : text/x-json');


    $post='';
    if($_POST["query"])
    {
        $post=$_POST["query"];
        $post=str_replace('\\"','"',$post);
        $post=json_decode($post,true);
    }
    else
    {
        $post=json_decode(file_get_contents("php://input"),true);
    }



    if($post['model']=="configuration")
    {
        if($post['action']=="fetch")
        {
            $r=array();

            foreach($post['keys'] as $key)
            {
                $q=$db->prepare("select configuration_key,configuration_value,use_function from configuration where configuration_key = ?");
                $q->execute(array($key));
                $m=$q->fetch();

    /*
                if($m['use_function'])
                {
                    $use_function = $m['use_function'];
                    if (ereg('->', $use_function)) 
                    {
                        $class_method = explode('->', $use_function);
                        if (!is_object(${$class_method[0]})) 
                        {
                            include(DIR_WS_CLASSES . $class_method[0] . '.php');
                            ${$class_method[0]} = new $class_method[0]();
                        }
                        $m['configuration_value'] = xtc_call_function($class_method[1], $m['configuration_value'], ${$class_method[0]});
                    } 
                    else 
                    {
                        $m['configuration_value'] = xtc_call_function($use_function, $m['configuration_value']);
                    }
                }
    */

                $r[$m['configuration_key']]=$m['configuration_value'];
            }
            echo json_encode(array($r));
        }
        else if($post['action']=="save")
        {
            foreach($post['keys'] as $key=>$value)
            {
                $q=$db->prepare("update configuration set configuration_value=? where configuration_key=?");
                $q->execute(array($value,$key));
            }
        }
    }
    else if($post['model']=="countries")
    {
        if ($post['action']=='fetch')
        {
            $q=$db->query("select countries_id,countries_name from countries");
            echo json_encode(array('result'=>($q->fetchAll())));
        }
    }
    else if($post['model']=="zones")
    {
        if ($post['action']=='fetch')
        {
            if($post['zone_country_id'])
            {
                $q=$db->prepare("select zone_id,zone_name from zones where zone_country_id=?");
                $q->execute(array($post['zone_country_id']));
                echo json_encode(array('result'=>($q->fetchAll())));
            }
            else
            {
                $q=$db->query("select zone_id,zone_name from zones");
                echo json_encode(array('result'=>($q->fetchAll())));
            }
        }
    }
    else if($post['model']=="customers_status")
    {
        if ($post['action']=='fetch')
        {
            $q=$db->query("select customers_status_id,customers_status_name from customers_status");
            echo json_encode(array('result'=>($q->fetchAll())));
        }
    }
    else if($post['model']=="templates")
    {
        if ($post['action']=='fetch')
        {
            $templates_array=array();
            if ($dir = opendir(DIR_FS_CATALOG.'pub/templates/'))
            {
                while (($templates = readdir($dir)) !== false) 
                {
                    if (is_dir(DIR_FS_CATALOG.'/pub/templates/'.$templates) and ($templates != "CVS") and ($templates != ".") and ($templates != "..")) 
                    {
                        $templates_array[] = array ('id' => 'default/'.$templates, 'name' => 'default/'.$templates);
                    }
                }
                closedir($dir);            }
            if ($dir = opendir(DIR_FS_USER.'templates/')) 
            {
                while (($templates = readdir($dir)) !== false) 
                {
                    if (is_dir(DIR_FS_USER.'templates'."//".$templates) and ($templates != "CVS") and ($templates != ".") and ($templates != "..")) 
                    {
                        $templates_array[] = array ('id' => 'user/'.$templates, 'name' => 'user/'.$templates);
                    }
                }
                closedir($dir);            }

            sort($templates_array);
            echo json_encode(array('result'=>($templates_array)));
        }
    }
    else if($post['model']=="template_css")
    {
        if ($post['action']=='fetch')
        {
            if($post['template'])
            {
                $cssdir= xtc_template_fs_path($post['template']).'/variant/css/';
                if ($dir = opendir($cssdir)) 
                {
                    while (($templates = readdir($dir)) !== false) 
                    {
                        if (
                                is_file($cssdir.'/'.$templates) and #
                                    ($templates != "CVS") and 
                                    ($templates != ".") and 
                                    ($templates != "..") and
                                    (!beginswith($templates,"condome_"))
                            ) 
                        {
                            $csss_array[] = array ('id' => $templates, 'name' => $templates);
                        }
                    }
                    closedir($dir);
                    sort($csss_array);
                    echo json_encode(array('result'=>($csss_array)));
                }
            }
        }
    }
    else if($post['model']=="template_background")
    {
        if ($post['action']=='fetch')
        {
            if($post['template'])
            {
                $backdir= xtc_template_fs_path($post['template']).'/variant/background/';
                if ($dir = opendir($backdir)) 
                {
                    while (($templates = readdir($dir)) !== false) 
                    {
                        if (is_file($backdir.'/'.$templates) and ($templates != "CVS") and ($templates != ".") and ($templates != "..")) 
                        {
                            $back_array[] = array ('id' => $templates, 'name' => $templates);
                        }
                    }
                    closedir($dir);
                    sort($back_array);
                    echo json_encode(array('result'=>($back_array)));
                }
            }
        }
    }
    else if($post['model']=="logo")
    {
        if ($post['action']=='fetch')
        {
            $back_array=array();
            if ($dir = opendir(DIR_FS_CATALOG_IMAGES.'/logo')) 
            {
                while (($templates = readdir($dir)) !== false) 
                {
                    if (is_file(DIR_FS_CATALOG_IMAGES.'/logo/'.$templates) and ($templates != "CVS") and ($templates != ".") and ($templates != "..")) 
                    {
                        $back_array[] = array ('id' => $templates, 'name' => $templates);
                    }
                }
                closedir($dir);
                sort($back_array);
                echo json_encode(array('result'=>($back_array)));
            }
        }
    }


?>

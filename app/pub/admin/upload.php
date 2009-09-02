<?php
    require('includes/application_top.php');
    defined('_VALID_XTC') or die('Login required.');
    require_once ('includes/classes/'.FILENAME_IMAGEMANIPULATOR);

    if($_POST['command']=='uploadProductsImage'){
        $file=$_FILES["azr_product_images_upload"];

        if($file['error']){
            echo htmlspecialchars(json_encode(array(
                'success'=>false,'errors'=>array('msg'=>'upload failed')
            )));
            die();
        }
        $pname_arr = explode('.',$file["name"]);
        $nsuffix = array_pop($pname_arr);

        $products_image_name=(integer)($_POST['products_id'])."_".(integer)$_POST['image_nr'].".".$nsuffix;

        


        if(!move_uploaded_file($file["tmp_name"],DIR_FS_CATALOG_ORIGINAL_IMAGES."/".$products_image_name))
            throw new Exception("rename failed (from '".$file["tmp_name"]."')");

        require (DIR_WS_INCLUDES.'product_thumbnail_images.php');
        require (DIR_WS_INCLUDES.'product_info_images.php');
        require (DIR_WS_INCLUDES.'product_popup_images.php');

        $db->exec("update products_images set "
            ."url_small   = '/user/images/product_images/thumbnail_images/$products_image_name'  , "
            ."url_middle  = '/user/images/product_images/info_images/$products_image_name'  , "
            ."url_big     = '/user/images/product_images/popup_images/$products_image_name'   "
            ."where image_nr='".(integer)($_POST['image_nr'])."'  and products_id='".(integer)($_POST["products_id"])."' ");


        echo htmlspecialchars(json_encode(array(
            'success'=>true,
            'url_small'=>'/user/images/product_images/thumbnail_images/'.$products_image_name,
            'url_middle'=>'/user/images/product_images/info_images/'.$products_image_name ,
            'url_big' => '/user/images/product_images/popup_images/'.$products_image_name 
        )));
    }
    else if($_POST['command']=='uploadCategoryImage'){


        $file=array();
        $targetsdir='';
        if($_POST['field']=='teaser'){
            $file=$_FILES["teaser"];
            $targetsdir='categories_teaser';
        }
        else if($_POST['field']=='image'){
            $file=$_FILES["image"];
            $targetsdir='categories';
        }
        else {
            echo htmlspecialchars(json_encode(array(
                'success'=>false,'errors'=>array('msg'=>'no such field')
            )));
            die();
        }

        if($file['error']){
            echo htmlspecialchars(json_encode(array(
                'success'=>false,'errors'=>array('msg'=>'upload failed')
            )));
            die();
        }
        $pname_arr = explode('.',$file["name"]);
        $nsuffix = array_pop($pname_arr);

        $products_image_name=(integer)($_POST['categories_id']).".".$nsuffix;

        

        if(!move_uploaded_file($file["tmp_name"],DIR_FS_CATALOG_IMAGES."/".$targetsdir."/".$products_image_name))
            throw new Exception("rename failed (from '".$file["tmp_name"]."')");


        
        $db->exec("update categories set  categories_"
            .$_POST['field']."  = '/user/images/$targetsdir/$products_image_name'  
                where categories_id='".(integer)($_POST["categories_id"])."' ");


        echo htmlspecialchars(json_encode(array(
            'success'=>true,
            'url'=>"/user/images/$targetsdir/$products_image_name",
        )));
    }

?>



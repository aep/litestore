<?php

    define('DIR_WS_BOXES',DIR_FS_CATALOG .'includes/boxes/');


    require(DIR_WS_INCLUDES . 'visualcontent/nodes.php');
    include_all_once(DIR_WS_BOXES."*.php");


    $r="";

    $bxal=array(
        "sidebar" => array(
                'BoxSearch',
                'BoxShoppingCart',
//                 'BoxAddAQuickie',
                'BoxAdmin',
                'BoxCategories',
                'BoxContent'
//                 'BoxManufacturers',
),
        "banner" => array(
                'BoxAdsense',
                'BoxBanner'),
        "login" => array(
                'BoxLogin')

        );


    foreach($bxal as $boxarea=>$bxl )
    {
        $r="";
        foreach($bxl as $boxname )
        {
            $a= new $boxname;
            $r.=$a->evaluate();
        }
        $smarty->assign($boxarea,$r);
    }
?>

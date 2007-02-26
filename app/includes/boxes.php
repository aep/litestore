<?php

    require_once(DIR_WS_INCLUDES . 'visualcontent/nodes.php');
    include_all_once(DIR_WS_BOXES."*.php");


    $r="";

    $bxal=array(
        "sidebar" => array(
                'BoxSearch',
                'BoxCategories',
                'BoxContent',
                'BoxAdmin'

        ),
        "cart" => array(
                'BoxShoppingCart',
        ),
        "banner" => array(
                'BoxAdsense',
                'BoxBanner')
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

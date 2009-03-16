<?php

    require_once (DIR_WS_CLASSES.'azrael.php');
    class AbstractVCBox extends AbstractVCNode
    {
        var $classid= "{674c79a1-0000-4000-ab51-035d1274e212}";
        function __construct()
        {
        }
        function walkthrough()
        {
            return false;
        }
        function evaluate()
        {
            return false;
        }
        function metatype()
        {
            return "special/xtcbox";
        }
    }

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

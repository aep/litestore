<?php
    sleep(3);

    if($APP_PATH[2]=="cart")
    {
        require_once(DIR_WS_INCLUDES . 'visualcontent/nodes.php');
        require_once(DIR_FS_CATALOG .'includes/boxes/shopping_cart.php');


        $b=new BoxShoppingCart;
        echo $b->evaluate();
    }


?>
<?php
    if($APP_PATH[2]=="cart")
    {
        require_once (DIR_WS_INCLUDES.'/asphyx/core.php');
        $b=new BoxShoppingCart;
        echo $b->evaluate();
    }


?>

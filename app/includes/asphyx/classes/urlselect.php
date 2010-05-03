<?php

asphyx_regme("com.handelsweise.litestore.uriselect","Page");
class Page extends A2YObject
{
    var $classid= "com.handelsweise.litestore.uriselect";
    function __construct()
    {
    }

    function walkthrough()
    {
        global $_GET;
        return eregi ($this->data,$_GET['path']);
    }
    function evaluate()
    {
        return false;
    }
}


?>

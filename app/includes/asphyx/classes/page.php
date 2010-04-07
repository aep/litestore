<?php

asphyx_regme("com.handelsweise.litestore.page","Page");
class Page extends A2YObject
{
    var $classid= "com.handelsweise.litestore.page";
    function __construct()
    {
    }

    function walkthrough()
    {
        return true;
    }
    function evaluate()
    {
        return false;
    }
}


?>

<?php

asphyx_regme("com.handelsweise.litestore.metatag","Metatag");
class Metatag extends A2YObject
{
    var $classid= "com.handelsweise.litestore.metatag";
    function __construct()
    {
    }

    function walkthrough()
    {
        return false;
    }
    function evaluate()
    {
        switch($this->_name){
            case 'keywords':
                global $meta_keywords;
                $meta_keywords.=$this->data;
                break;;
            case 'description':
                global $meta_description;
                $meta_description.=$this->data;
                break;;
            case 'title':
                global $meta_title;
                $meta_title.=$this->data;
                break;;
            default:
                break;;
        }
        return false;
    }
}


?>

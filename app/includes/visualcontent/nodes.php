<?php
class AbstractVCNode
{
    var $parentId;
    var $Id;
    var $name;
    var $order;

    function __construct()
    {
    }
    function walkthrough(){}
    function metatype(){}

    function evaluate(){}
    function setData($d)
    {
        $this->data=$d;
    }
    var $data;

    var $VisualContentInstance;
}


class XTCShop extends AbstractVCNode
{
    var $classid= "{1784e3c3-0000-4000-824f-76ba072694c5}";
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
        return "special/xtcshop";
    }
}


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

class StaticContent extends AbstractVCNode
{
    var $classid= "{c21ced16-0000-4000-92c1-69d94afb4933}";
    function __construct()
    {
    }
    function walkthrough()
    {
        return false;
    }
    function evaluate()
    {
        $e=$this->data;

        foreach ($this->VisualContentInstance->listGenerators($this->Id) as $n)
        {
            if($n->classid=="{b4e3c4b6-0000-4000-af6b-d9464c2ce97a}")
            {
                $e=str_replace("<%".$n->name."%>", $n->evaluate(),$e);
            }
        }


        /** 27.42.2008 hhl/shop/vc_leerevariablen */
        $e=preg_replace("/<%.*%>/", "", $e);

        return $e;
    }
    function metatype()
    {
        return "text/html";
    }

}

class Folder extends AbstractVCNode
{
    var $classid= "{756d8484-0000-4000-a071-2ab6e1ec6785}";
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
    function metatype()
    {
        return false;
    }

}

class DateCondition extends AbstractVCNode
{
    var $classid= "{04b31d60-0000-4000-b981-2e18fd1eb9e8}";
    function __construct()
    {
    }
    function walkthrough()    
    {
        $dd = explode(";",$this->data);
        $min = $dd[0];
        $max = $dd[1];

        if($min!="" && time()<strtotime($min))
            return false;
        if($max!="" && time()>strtotime($max))
            return false;
        return true;
    }
    function evaluate()
    {
        return false;
    }
    function metatype()
    {
        return false;
    }

}

class KGCondition extends AbstractVCNode
{
    var $classid= "{72a15ef5-0000-4000-adb2-1e71f2bfe45d}";
    function __construct()
    {
    }
    function walkthrough()
    {
        return in_array($_SESSION["customers_status"]["customers_status_id"],explode(";",$this->data));
    }
    function evaluate()
    {
        return false;
    }
    function metatype()
    {
        return false;
    }

}


class Variable extends AbstractVCNode
{
    var $classid= "{b4e3c4b6-0000-4000-af6b-d9464c2ce97a}";
    function __construct()
    {
    }
    function walkthrough()
    {
        return false;
    }
    function evaluate()
    {
        return $this->VisualContentInstance->evaluate($this->Id);
    }
    function metatype()
    {
        return "text/html"; ///for now. should be templated in future
    }

}


class FileNode extends AbstractVCNode
{
    var $classid= "{fe61a8ac-0000-4000-9276-3eeb4185933d}";
    function __construct()
    {
    }
    function walkthrough()
    {
        return false;
    }
    function evaluate()
    {
        return file_get_contents($this->data);
    }
    function metatype()
    {
        return "text/html";
    }

}


class Image extends AbstractVCNode
{
    var $classid=  "{e4527460-0000-4000-b52f-2d8668f85680}";
    function __construct()
    {
    }
    function walkthrough()
    {
        return false;
    }
    function evaluate()
    {
        $type=substr($this->data,0,3);
        $data=substr($this->data,4);

        if($type=="url")
            return "<img src=\"".$data."\" alt=\"".$this->name."\" > ";

        return "";
    }
    function metatype()
    {
        return "text/html";
    }
    function getUrl() ///this should be evaluate with a metatype instead
    {
        $type=substr($this->data,0,3);
        $data=substr($this->data,4);

        if($type=="url")
            return $data;

        return "";
    }
}

class Random extends AbstractVCNode
{
    var $classid= "{3a2676a9-0000-4000-8491-702302a7c112}";
    function __construct()
    {
    }
    function walkthrough()
    {
        return false;
    }
    function evaluate()
    {
        $r=$this->VisualContentInstance->listGenerators($this->Id);
        if(sizeof($r)<1)
            return "";
        return $r[rand(0,sizeof($r)-1)]->evaluate();
    }
    function metatype()
    {
        return "text/html";
    }
}


class HHLArchive extends AbstractVCNode
{
    var $classid= "{fbee9ccc-0000-4000-b02e-e39f26f3b143}";
    function __construct()
    {
    }
    function walkthrough()
    {
        return false;
    }
    function evaluate()
    {
        $e= "";
        $firsturl=false;


        foreach ($this->VisualContentInstance->listGenerators($this->Id) as $n)
        {
            if($n->classid=="{e4527460-0000-4000-b52f-2d8668f85680}")
            {
                $e.="
                    <script language=\"javascript\">
                    function switch_vc_HHLARchiv_".$this->Id." (x)
                    {
                        document.getElementById('hhlarchive_".$this->Id."_img').src=x;
                    }
                    </script>
                    <style type=\"text/css\">
                        #HHLArchiv a
                        {
                           display:block;
                           width:50%;
                           float:left;
                        }
                    </style>
                    <div id=\"HHLArchiv\">
                    <a href=\"javascript:switch_vc_HHLARchiv_".$this->Id." ('".$n->getUrl()."');\" >
                    ".$n->name."
                    </a> \n";

                if(!$firsturl)
                    $firsturl=$n->getUrl();
            }
        }
        $e.="<img id=\"hhlarchive_".$this->Id."_img\" src=\"$firsturl\" alt=\"\" /></div>";

        return $e;
    }
    function metatype()
    {
        return "text/html";
    }
}














?>
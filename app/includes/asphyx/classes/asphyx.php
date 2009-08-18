<?php

asphyx_regme("com.asgaartech.asphyx.link","Link");
class Link extends A2YObject
{
    var $classid= "com.asgaartech.asphyx.link";
    function __construct()
    {
    }
    function children()
    {
        $rnode=$this->stateEngine->Nodes[$this->data];
        if (!$rnode)
        {
            return array();
        }
        return $rnode->children();
    }
    function evaluate_anyway()
    {
        $rnode=$this->stateEngine->Nodes[$this->data];
        if (!$rnode)
        {
            return false;
        }
        return $rnode->evaluate_anyway();
    }
    function name()
    {
        $rnode=$this->stateEngine->Nodes[$this->data];
        if (!$rnode)
        {
            return $this->_name;
        }
        return $rnode->name();
    }
    function walkthrough()
    {
        $rnode=$this->stateEngine->Nodes[$this->data];
        if (!$rnode)
        {
            return false;
        }
        return $rnode->walkthrough();
    }
    function evaluate()
    {
        $rnode=$this->stateEngine->Nodes[$this->data];
        if (!$rnode)
        {
            return false;
        }
        return $rnode->evaluate();
    }
    function metatype()
    {
        $rnode=$this->stateEngine->Nodes[$this->data];
        if (!$rnode)
        {
            return false;
        }
        return $rnode->metatype();
    }
}




asphyx_regme("com.asgaartech.asphyx.static","StaticContent");
class StaticContent extends A2YObject
{
    var $classid= "com.asgaartech.asphyx.static";
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

        foreach ($this->childrenGenerators() as $n)
        {
            if($n->metatype()=="x-variable")
            {
                $e=str_replace("<%".$n->name()."%>", $n->evaluate_anyway(),$e);
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

asphyx_regme("com.asgaartech.asphyx.folder","Folder");
class Folder extends A2YObject
{
    var $classid= "com.asgaartech.asphyx.folder";
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

asphyx_regme("com.asgaartech.asphyx.conditional.datetime","DateCondition");
class DateCondition extends A2YObject
{
    var $classid= "com.asgaartech.asphyx.conditional.datetime";
    function __construct()
    {
    }
    function walkthrough()    
    {
        $dd = explode(";",$this->data);


        if(isset($dd[0]) && $dd[0]!="" && time()<strtotime($dd[0]))
            return false;
        if( isset($dd[1])  &&  $dd[1]!="" && time()>strtotime($dd[1]))
            return false;
        return true;
    }
    function children()
    {
        if($this->walkthrough())
            return A2YObject::children();
        return array();
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

asphyx_regme("com.asgaartech.asphyx.conditional.customergroup","CustomerGroupCondition");
class CustomerGroupCondition extends A2YObject
{
    var $classid= "com.asgaartech.asphyx.conditional.customergroup";
    function __construct()
    {
    }
    function walkthrough()    
    {
        foreach(explode(";",$this->data) as $cid){
            if($cid=='0')
                $cid=0;
            else if($cid==0)
                throw new AzraelException('Security Escalation cid==0 but is not 0');  
            if($cid==$_SESSION['customers_status']['customers_status_id'])
                return true;
        }
        return false;
    }
    function children()
    {
        if($this->walkthrough())
            return A2YObject::children();
        return array();
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


asphyx_regme("com.asgaartech.asphyx.variable","Variable");
class Variable extends A2YObject
{
    var $classid= "com.asgaartech.asphyx.variable";
    function __construct()
    {
    }
    function walkthrough()
    {
        return false;
    }
    function children()
    {
        return array();
    }
    function evaluate()
    {
        return false;
    }
    function evaluate_anyway()
    {
        return $this->stateEngine->evaluate($this->Id);
    }
    function metatype()
    {
        return "x-variable"; 
    }

}

asphyx_regme("com.asgaartech.asphyx.conditional.random","Random");
class Random extends A2YObject
{
    var $classid= "com.asgaartech.asphyx.conditional.random";
    function __construct()
    {
    }
    function walkthrough()
    {
        return false;
    }
    function children()
    {
        return array();
    }
    function evaluate()
    {
        $r=$this->stateEngine->listGenerators($this->Id);
        if(sizeof($r)<1)
            return "";
        return $r[rand(0,sizeof($r)-1)]->evaluate();
    }
    function metatype()
    {
        return "text/html";
    }
}

asphyx_regme("com.asgaartech.asphyx.conditional.uri","UriSelector");
class UriSelector extends A2YObject
{
    var $classid= "com.asgaartech.asphyx.conditional.uri";
    function __construct()
    {
    }
    function walkthrough()
    {
        return ereg ($this->data, $_SERVER['REQUEST_URI']);
    }
    function children()
    {
        if($this->walkthrough())
            return A2YObject::children();
        return array();
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

asphyx_regme("com.asgaartech.asphyx.preset","Preset");
class Preset extends A2YObject
{
    var $classid= "com.asgaartech.asphyx.preset";
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
?>

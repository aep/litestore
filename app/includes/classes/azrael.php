<?php

/********  NODES  ***********/

class AbstractVCNode
{
    var $parentId;
    var $Id;
    var $_name;
    var $order;




    function name()
    {
        return $this->_name;
    }
    function __construct()
    {
    }
    function walkthrough(){}
    function metatype(){}

    function evaluate_anyway(){}
    function evaluate(){}
    function setData($d)
    {
        $this->data=$d;
    }
    function children()
    {   
        if(!isset($this->VisualContentInstance->Tree["children"][$this->Id]))
            return array();
        return $this->VisualContentInstance->Tree["children"][$this->Id];
    }
    function childrenGenerators()
    {
        $e=array();
        foreach($this->children() as $kk)
        {
            foreach($kk as $cid)
            {
                if($this->VisualContentInstance->Nodes[$cid]->children())
                {
                    $e=array_merge($e,$this->VisualContentInstance->Nodes[$cid]->childrenGenerators($cid));
                }
                else if ($this->VisualContentInstance->Nodes[$cid]->metatype()!==false)
                {
                    $e[]=$this->VisualContentInstance->Nodes[$cid];
                }
            }
        }
        return $e;
    }


    var $data;

    var $VisualContentInstance;
}


class Link extends AbstractVCNode
{
    var $classid= "{24f3af1a-043d-459e-adb8-48daa6645e6b}";
    function __construct()
    {
    }
    function children()
    {
        $rnode=$this->VisualContentInstance->Nodes[$this->data];
        if (!$rnode)
        {
            return array();
        }
        return $rnode->children();
    }
    function evaluate_anyway()
    {
        $rnode=$this->VisualContentInstance->Nodes[$this->data];
        if (!$rnode)
        {
            return false;
        }
        return $rnode->evaluate_anyway();
    }
    function name()
    {
        $rnode=$this->VisualContentInstance->Nodes[$this->data];
        if (!$rnode)
        {
            return $this->_name;
        }
        return $rnode->name();
    }
    function walkthrough()
    {
        $rnode=$this->VisualContentInstance->Nodes[$this->data];
        if (!$rnode)
        {
            return false;
        }
        return $rnode->walkthrough();
    }
    function evaluate()
    {
        $rnode=$this->VisualContentInstance->Nodes[$this->data];
        if (!$rnode)
        {
            return false;
        }
        return $rnode->evaluate();
    }
    function metatype()
    {
        $rnode=$this->VisualContentInstance->Nodes[$this->data];
        if (!$rnode)
        {
            return false;
        }
        return $rnode->metatype();
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


        if(isset($dd[0]) && $dd[0]!="" && time()<strtotime($dd[0]))
            return false;
        if( isset($dd[1])  &&  $dd[1]!="" && time()>strtotime($dd[1]))
            return false;
        return true;
    }
    function children()
    {
        if($this->walkthrough())
            return AbstractVCNode::children();
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
        return $this->VisualContentInstance->evaluate($this->Id);
    }
    function metatype()
    {
        return "x-variable"; 
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
    function children()
    {
        return array();
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
    function children()
    {
        return array();
    }
    function evaluate()
    {
        $type=substr($this->data,0,3);
        $data=substr($this->data,4);

        if($type=="url")
            return "<img src=\"".$data."\" alt=\"".$this->name()."\" > ";

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
    function children()
    {
        return array();
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

class UriSelector extends AbstractVCNode
{
    var $classid= "{07331c60-0000-4000-b996-6618fa1eb9e8}";
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
            return AbstractVCNode::children();
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


class Preset extends AbstractVCNode
{
    var $classid= "{0ab256ea-0000-4000-9827-6556fa1eb9e8}";
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


class AzraelException extends Exception
{
};

class Azrael
{
    var $Root=0;
    var $Nodes=array();
    var $Tree=array();
    var $presets=array();

    function __construct()
    {
        global $db;
        $q = $db->query("SELECT id, parent, uuid, name, data, `order` FROM `content` order by `order`");
        while ($line = $q->fetch())
        {

            if($line["uuid"]=="{c21ced16-0000-4000-92c1-69d94afb4933}")
            {
                $tnode=new StaticContent;
            }
            else if($line["uuid"]=="{756d8484-0000-4000-a071-2ab6e1ec6785}")
            {
                $tnode=new Folder;
            }
            else if($line["uuid"]=="{04b31d60-0000-4000-b981-2e18fd1eb9e8}")
            {
                $tnode=new DateCondition;
            }
            else if($line["uuid"]=="{72a15ef5-0000-4000-adb2-1e71f2bfe45d}")
            {
                $tnode=new KGCondition;
            }
            else if($line["uuid"]=="{b4e3c4b6-0000-4000-af6b-d9464c2ce97a}")
            {
                $tnode=new Variable;
            }
            else if($line["uuid"]=="{fe61a8ac-0000-4000-9276-3eeb4185933d}")
            {
                $tnode=new FileNode;
            }
            else if($line["uuid"]=="{e4527460-0000-4000-b52f-2d8668f85680}")
            {
                $tnode=new Image;
            }
            else if($line["uuid"]=="{3a2676a9-0000-4000-8491-702302a7c112}")
            {
                $tnode=new Random;
            }
            else if($line["uuid"]=="{fbee9ccc-0000-4000-b02e-e39f26f3b143}")
            {
                $tnode=new HHLArchive;
            }
            else if($line["uuid"]=="{07331c60-0000-4000-b996-6618fa1eb9e8}")
            {
                $tnode=new UriSelector;
            }
            else if($line["uuid"]=="{24f3af1a-043d-459e-adb8-48daa6645e6b}")
            {
                $tnode=new Link;
            }
            else if($line["uuid"]=="{0ab256ea-0000-4000-9827-6556fa1eb9e8}")
            {
                $tnode=new Preset;
            }
            else
            {
                throw new AzraelException("unnkown entity with uuid '".$line["uuid"]."' called '".$line["name"]."' claiming id ".$line["id"]);
            }


            $tnode->parentId=$line["parent"];
            $tnode->Id=$line["id"];
            $tnode->data=$line["data"];
            $tnode->_name=$line["name"];
            $tnode->order=$line["order"];
            $tnode->VisualContentInstance=$this;

            $this->Nodes[$line["id"]]=$tnode;
            $this->Tree["children"][$line["parent"]][$line["order"]][]=$line["id"];
            if($line["parent"]==0)
                $this->Root=$tnode;

            if($line["uuid"]=="{0ab256ea-0000-4000-9827-6556fa1eb9e8}")
                $this->presets[$line["data"]]=$line["id"];

        }

    }


    function renderID($id)
    {
        if (!($this->Nodes[$id]))
        {
            header("HTTP/1.0 404 Not Found");
            throw new AzraelException("Direct call to invalid id '$id'");
        }

        $Node=$this->Nodes[$id];

        if($Node->walkthrough())
            return $this->evaluate($Node->Id);
        else
            return $Node->evaluate();
    }
    function renderPreset($area)
    {
        if (!($this->presets[$area]))
        {
            header("HTTP/1.0 404 Not Found");
            throw new AzraelException("Direct call to invalid id '$id'");
        }
        return $this->renderID($this->presets[$area]);
    }

    function evaluate($id)
    {
    $e='';
        if (!isset($this->Tree["children"][$id]))
            return $e;
        foreach($this->Tree["children"][$id] as $kk)
        foreach($kk as $cid)
        {
            if($this->Nodes[$cid]->walkthrough())
            {
                $e.=$this->evaluate($cid);
            }
            else
            {
                $ee=$this->Nodes[$cid]->evaluate();
                if($ee!==false)
                    $e.=$ee;
            }
        }
    return $e;
    }


    function listGenerators($id)
    {
        $e=array();
        if(!isset($this->Tree["children"][$id]))
            return array();

        foreach($this->Tree["children"][$id] as $kk)
        {
            foreach($kk as $cid)
            {
                if($this->Nodes[$cid]->walkthrough())
                {
                    $e=array_merge($e,$this->listGenerators($cid));
                }
                else if ($this->Nodes[$cid]->metatype()!==false)
                {
                    $e[]=$this->Nodes[$cid];
                }
            }
        }

        return $e;
    }

};


global $azrael;
$azrael=new Azrael;

?>


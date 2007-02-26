<?php
require_once ('nodes.php');


$vcglobalinstance= new VisualContent();




class VisualContent
{
    var $Root=AbstractNode;
    var $Nodes=array();
    var $Tree=array();

    function __construct()
    {
        $result = mysql_query("SELECT id, parent, uuid, name, data, `order` FROM vc2008 order by `order`");
        while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
        {
            $tnode=AbstractNode;
            if($line["uuid"]=="{1784e3c3-0000-4000-824f-76ba072694c5}")
            {
                $tnode=new XTCShop;
            }
            else if($line["uuid"]=="{674c79a1-0000-4000-ab51-035d1274e212}")
            {
                $tnode=new XTCBox;
            }
            else if($line["uuid"]=="{c21ced16-0000-4000-92c1-69d94afb4933}")
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
            else
            {
                die("unnkown entity ".$line["uuid"]);
            }



            $tnode->parentId=$line["parent"];
            $tnode->Id=$line["id"];
            $tnode->data=$line["data"];
            $tnode->name=$line["name"];
            $tnode->order=$line["order"];
            $tnode->VisualContentInstance=$this;

            $this->Nodes[$line["id"]]=$tnode;
            $this->Tree["children"][$line["parent"]][$line["order"]][]=$line["id"];
            if($line["parent"]==0)
                $this->Root=$tnode;
            $this->Tree["byName"][$line["name"]]=$line["id"];

        }

//         echo "<pre>";
//         print_r($this->Tree);
//         print_r($this->Nodes);
//         echo "</pre>";

        if ($this->Root->classid!="{1784e3c3-0000-4000-824f-76ba072694c5}")
        {
            echo "<h1>VC2008:  root node is not XTCShop</h1>";
            die();
        }
    }

    function page($id)
    {
        if (!($this->Nodes[$id]))
        {
            echo "<h1>404 No Node $id </h1>";
            die();
        }

        $Node=$this->Nodes[$id];

        if($Node->walkthrough())
            return $this->evaluate($Node->Id);
        else
            return $Node->evaluate();
    }
    function home()
    {
        if (!($this->Tree["byName"]["Home"]))
        {
            echo "<h1>404 No Node called \"Home\" </h1>";
            die();
        }
        return $this->page($this->Tree["byName"]["Home"]);
    }


    function lichtenstein_special($node)
    {
        if (!($this->Tree["byName"][$node]))
        {
            echo "<h1>404 No Node called \"$node\" </h1>";
            die();
        }
        return $this->page($this->Tree["byName"][$node]);
    }


    function evaluate($id)
    {
    $e;
        if (!$this->Tree["children"][$id])
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


    function box($name)
    {
        $Node=$this->Nodes[$this->Tree["byName"][$name]];

        if ($Node->classid!="{674c79a1-0000-4000-ab51-035d1274e212}")
        {
            echo "<h1>VC2008: requested node \"$name\" is not an XTCBox</h1>";
            die();
        }
        return $this->listGenerators($Node->Id);
    }


    function listGenerators($id)
    {
    $e=array();
        if($this->Tree["children"][$id])
        foreach($this->Tree["children"][$id] as $kk)
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
    return $e;
    }



};












?>
<?php

class A2YObject
{
    var $parentId;
    var $Id;
    var $_name;
    var $order;


    function name()
    {
        return $this->_name;
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
        if(!isset($this->stateEngine->Tree["children"][$this->Id]))
            return array();
        return $this->stateEngine->Tree["children"][$this->Id];
    }
    function childrenGenerators()
    {
        $e=array();
        foreach($this->children() as $kk)
        {
            foreach($kk as $cid)
            {
                if($this->stateEngine->Nodes[$cid]->children())
                {
                    $e=array_merge($e,$this->stateEngine->Nodes[$cid]->childrenGenerators($cid));
                }
                else if ($this->stateEngine->Nodes[$cid]->metatype()!==false)
                {
                    $e[]=$this->stateEngine->Nodes[$cid];
                }
            }
        }
        return $e;
    }


    var $data;

    var $stateEngine;
}


class AzraelException extends Exception
{
};

$Factories=array();
include_all_once(DIR_WS_INCLUDES."/asphyx/classes/*.php");


function asphyx_regme($classid,$classname)
{
    global $Factories;
    $Factories[$classid]=$classname;
}


class Azrael{

    var $Root=0;
    var $Nodes=array();
    var $Tree=array();
    var $presets=array();



    function __construct(){
        global $db;
        $q = $db->query("SELECT id, parent, uuid, name, data, `order` FROM `content` order by `order`");
        while ($line = $q->fetch()){

            $tnode=null;
            global $Factories;
            if(!$Factories[$line['uuid']]){
                throw new AzraelException("unnkown entity with uuid '".$line["uuid"]."' called '".$line["name"]."' claiming id ".$line["id"]);
            }

            $tnode=new $Factories[$line['uuid']];


            $tnode->parentId=$line['parent'];
            $tnode->Id=$line['id'];
            $tnode->data=$line['data'];
            $tnode->_name=$line['name'];
            $tnode->order=$line['order'];
            $tnode->stateEngine=$this;

            $this->Nodes[$line['id']]=$tnode;

            $this->Tree['children'][$line['parent']][$line['order']][]=$line['id'];

            if($line['parent']==0)
                $this->Root=$tnode;


            if($line['uuid']=='com.asgaartech.asphyx.preset'){
                $this->presets[$line['data']]=$line['id'];
            }

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


    function listGenerators($id,$recurcheck=array())
    {
        $recurcheck[]=$id;
        $e=array();
        if(!isset($this->Tree["children"][$id]))
            return array();


        foreach($this->Tree["children"][$id] as $kk)
        {
            foreach($kk as $cid)
            {
                if(in_array($cid,$recurcheck)){
                    throw new AzraelException("Corrupted Tree. '".$cid."'  has already ocured");
                    return;
                }

                if($this->Nodes[$cid]->walkthrough())
                {
                    $e=array_merge($e,$this->listGenerators($cid,$recurcheck));
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


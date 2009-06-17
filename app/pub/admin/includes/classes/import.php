<?php


/* --------------------------------------------------------------
   $Id: import.php 1319 2005-10-23 10:35:15Z mz $

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce

   Released under the GNU General Public License
   --------------------------------------------------------------
*/
defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

// ini_set("memory_limit","12M");

function sqlArrayCompare($a,$s=",")
{
    $rdd=array();
    foreach($a as $k=>$v)
        $rdd[].=" `".$k."` = '".$v."' ";
    return implode($s,$rdd);
}

function sqlArrayKeys($a)
{
    $rdd=array();
    foreach($a as $k=>$v)
        $rdd[]=" `".$k."` ";
    return implode(" , ",$rdd);
}

function sqlArrayValues($a)
{
    $rdd=array();
    foreach($a as $k=>$v)
        $rdd[]=" '".$v."' ";
    return implode(" , ",$rdd);
}





class reImportExport
{

    function reImportExport()
    {
        $this->TextSign = "\"";
        $this->seperator = "\t";
        $this->counter = array ('prod_new' => 0, 'cat_new' => 0, 'prod_upd' => 0, 'cat_upd' => 0);
        $this->errorlog = array ();
        $this->time_start = time();
        $this->format='csv';
    }



    function RemoveTextNotes($data) 
    {
        if (substr($data, -1) == $this->TextSign)
            $data = substr($data, 1, strlen($data) - 2);
        return $data;

    }

    function calcElapsedTime($time) 
    {

        // calculate elapsed time (in seconds!)
        $diff = time() - $time;
        $daysDiff = 0;
        $hrsDiff = 0;
        $minsDiff = 0;
        $secsDiff = 0;

        $sec_in_a_day = 60 * 60 * 24;
        while ($diff >= $sec_in_a_day) {
            $daysDiff ++;
            $diff -= $sec_in_a_day;
        }
        $sec_in_an_hour = 60 * 60;
        while ($diff >= $sec_in_an_hour) {
            $hrsDiff ++;
            $diff -= $sec_in_an_hour;
        }
        $sec_in_a_min = 60;
        while ($diff >= $sec_in_a_min) {
            $minsDiff ++;
            $diff -= $sec_in_a_min;
        }
        $secsDiff = $diff;

        return ('(elapsed time '.$hrsDiff.'h '.$minsDiff.'m '.$secsDiff.'s)');

    }

    function setScheme($d)
    {
        $this->scheme=$d;
    }
    function setSchemeName($d)
    {
        $this->schemename=$d;
    }
    function setFormat($d)
    {
        $this->format=$d;
    }

    function expand_condition($conn,$cond, & $main_a) 
    {
        if($cond['local']=='main_a')
        {
            return array('key'=>$conn ,'value'=>$main_a[$cond['var']]);
        }
        else if($cond['local']=='sql')
        {
            $xcr=xtc_db_fetch_array(xtc_db_query($cond['query']));
            return array('key'=>$conn ,'value'=>$xcr[$cond['var']]);
        }
        else if($cond['local']=='static')
        {
            return array('key'=>$conn ,'value'=>$cond['value']);
        }
    }

    function expand_export_index($idx, & $main_a)
    {
        $idx_comp=array();
        foreach($idx as $conn=>$cond)
        {
            if($cond['type']=='oneToOne')
            {
                $condret=$this->expand_condition($conn,$cond,$main_a);
                $idx_comp[]="`".$condret['key']."` = '".$condret['value']."'";
            }
            else if($cond['type']=='oneToMany')
            {
                $condret=$this->expand_condition($conn,$cond,$main_a);
                $idx_comp[]="`".$condret['key']."` = '".$condret['value']."'";
            }
            else if($cond['type']=='manyToOne')
            {
                $condret=$this->expand_condition($conn,$cond,$main_a);
                $idx_comp[]="`".$condret['key']."` = '".$condret['value']."'";
            }
            else if($cond['type']=='manyToMany')
            {
                $sibxs="";
                if($cond["index"])
                {
                    $sibx=$this->expand_export_index($cond["index"],$main_a);
                    $sibxs= sqlArrayCompare($sibx,' and ');
                }
                $xcq=xtc_db_query(
                    "select `$conn` from `".$cond['table']."` where ".$sibxs);

                $emx_c=array();
                while($xcr=xtc_db_fetch_array($xcq))
                {
                    $emx_c[]="`".$conn."` = '".$xcr[$conn]."'";
                }
                $idx_comp   []  =" ( ".implode(" or ",$emx_c)." ) ";
            }
        }
        return $idx_comp;
    }


    function export()
    {
        $r='';
        if($this->format=='xml')
        {
            $r.="<export>\n";

            reset($this->scheme);
            $main_table=key($this->scheme);
            $main_q = xtc_db_query( "select * from ".$main_table);

            while ($main_a = xtc_db_fetch_array($main_q))
            {
                $r.="\t<object>\n";
                foreach( $this->scheme[$main_table]['fields'] as $field)
                {
                    $r .= "\t\t<".$field.">".$main_a[$field]."</".$field.">\n";
                }
                reset($this->scheme);
                next($this->scheme);
                while ($table_a = current($this->scheme))
                {
                    $table_n=key($this->scheme);
                    $conditions="";

                    if($table_a["index"])
                    {
                        $conditions=" where ". implode(' and ',$this->expand_export_index($table_a["index"],$main_a));
                    }

                    reset($table_a["fields"]);
                    while ($fielda = current($table_a["fields"]))
                    {
                        if(is_array($fielda))
                        {
                            if($fielda["xmltype"]=="children")
                            {
                                $sub_q = xtc_db_query( "select ".implode(",",$fielda["fields"])." from ".$table_n.$conditions);
                                $r .= "\t\t<".key($table_a["fields"]).">\n";
                                while($sub_r=xtc_db_fetch_array($sub_q))
                                {
                                    foreach($fielda["fields"] as $ff)
                                    {
                                        $r .= "\t\t\t<".$ff.">".$sub_r[$ff]."</".$ff.">\n";
                                    }
                                    $k.=$fielda["seperator"];
                                }
                                $r .= "\t\t</".key($table_a["fields"]).">\n";
                            }
                            else if($fielda["type"]=="inlinetable")
                            {
                                $sub_q = xtc_db_query( "select ".implode(",",$fielda["fields"])." from ".$table_n.$conditions);
                                $k='';
                                while($sub_r=xtc_db_fetch_array($sub_q))
                                {
                                    foreach($sub_r as $ff=>$ffva)
                                    {
                                        $k.=$ffva.$fielda["seperator"];
                                    }
                                    $k.=$fielda["seperator"];
                                }
                                $r .= "\t\t<".key($table_a["fields"]).">".$k."</".key($table_a["fields"]).">\n";
                            }

                            else if($fielda["type"]=="tree")
                            {
                                $tree=array();
                                $treeq = xtc_db_query( "select ".$fielda["id"].",".$fielda["parent"]." from ".$fielda["table"]);
                                while($treeq_r=xtc_db_fetch_array($treeq))
                                {
                                    $tree[$treeq_r[$fielda["id"]]]=$treeq_r[$fielda["parent"]];
                                }


                                $sub_q_union=array();

                                $ids_q = xtc_db_query( "select ".$fielda["id"]." from ".$table_n.$conditions);
                                while($ids_r=xtc_db_fetch_array($ids_q))
                                {
                                    $xccid=$ids_r[$fielda["id"]];

                                    $xccids=array($xccid);


                                    $sub_q_fields       =array();
                                    $sub_q_tables       =array();
                                    $sub_q_conditions   =array();


                                    while(true)
                                    {
                                        $i=$xccid;
                                        $fieldb=array();
                                        foreach($fielda["fields"] as $fieldax)
                                        {
                                            $fieldb[]=" ct$i.".$fieldax." as c$i ";
                                        }
                                        $sub_q_fields[]=implode(",",$fieldb);

                                        $sub_q_tables[]=$table_n." as ct$i ";
                                        $sub_q_conditions[]=" ct$i.".$fielda["id"]." = '".$xccid."'";


                                        if(!$tree[$xccid])
                                            break;
                                        $xccid=$tree[$xccid];
                                    }
                                    $sub_q_fields=array_reverse($sub_q_fields);
                                    $sub_q_tables=array_reverse($sub_q_tables);
                                    $sub_q_conditions=array_reverse($sub_q_conditions);


                                    $fin=" select "
                                    .implode(" , ",$sub_q_fields)
                                    ." from "
                                    .implode(" join ",$sub_q_tables)
                                    ." where "
                                    .implode(" and ",$sub_q_conditions);
                                    $sub_q_union[]=$fin;
                                }

                                $k='';

                                foreach($sub_q_union as $sub_q_s)
                                {
                                    $sub_q = xtc_db_query($sub_q_s);
                                    while($sub_r=xtc_db_fetch_array($sub_q))
                                    {
                                        foreach($sub_r as $ff=>$ffva)
                                        {
                                            $k.=$ffva.$fielda["seperator"];
                                        }
                                        $k.=$fielda["seperator"];
                                    }
                                }
                                $r .= "\t\t<".key($table_a["fields"]).">".$k."</".key($table_a["fields"]).">\n";
                            }

                        }
                        else
                        {
                            $sub_q = xtc_db_fetch_array(xtc_db_query( "select ".$fielda." from ".$table_n.$conditions));
                            $r .= "\t\t<".$fielda.">".$sub_q[$fielda]."</".$fielda.">\n";
                        }
                        next($table_a["fields"]);
                    }
                    next($this->scheme);
                }
                $r .= "\t</object>\n";
            }



            $r.="</export>\n";
            return $r;
        }
        else
        {
            foreach($this->scheme as $expf)
            {
                reset($expf['fields']);
                while ($field = current($expf['fields']))
                {
                    $ff=$field;
                    if( is_array($ff))
                        $ff=key($expf['fields']);
                    $r .= $this->TextSign.$ff.$this->TextSign.$this->seperator;
                    next($expf['fields']);
                }
            }
            $r .= "\n";


            reset($this->scheme);
            $main_table=key($this->scheme);
            $main_q = xtc_db_query( "select * from ".$main_table);


            while ($main_a = xtc_db_fetch_array($main_q))
            {
                foreach( $this->scheme[$main_table]['fields'] as $field)
                {
                    $r .= $this->TextSign.$main_a[$field].$this->TextSign.$this->seperator;
                }
                reset($this->scheme);
                next($this->scheme);
                while ($table_a = current($this->scheme))
                {
                    $table_n=key($this->scheme);
                    $conditions="";

                    if($table_a["index"])
                    {
                        $conditions=" where ". implode(' and ',$this->expand_export_index($table_a["index"],$main_a));
                    }

                    reset($table_a["fields"]);
                    while ($fielda = current($table_a["fields"]))
                    {
                        if(is_array($fielda))
                        {
                            if($fielda["type"]=="inlinetable")
                            {
                                $sub_q = xtc_db_query( "select ".implode(",",$fielda["fields"])." from ".$table_n.$conditions);
                                $k='';
                                while($sub_r=xtc_db_fetch_array($sub_q))
                                {
                                    foreach($sub_r as $ff=>$ffva)
                                    {
                                        $k.=$ffva.$fielda["seperator"];
                                    }
                                    $k.=$fielda["seperator"];
                                }
                                $r .= $this->TextSign.$k.$this->TextSign.$this->seperator;
                            }
                            else if($fielda["type"]=="tree")
                            {
                                $tree=array();
                                $treeq = xtc_db_query( "select ".$fielda["id"].",".$fielda["parent"]." from ".$fielda["table"]);
                                while($treeq_r=xtc_db_fetch_array($treeq))
                                {
                                    $tree[$treeq_r[$fielda["id"]]]=$treeq_r[$fielda["parent"]];
                                }


                                $sub_q_union=array();

                                $ids_q = xtc_db_query( "select ".$fielda["id"]." from ".$table_n.$conditions);
                                while($ids_r=xtc_db_fetch_array($ids_q))
                                {
                                    $xccid=$ids_r[$fielda["id"]];

                                    $xccids=array($xccid);


                                    $sub_q_fields       =array();
                                    $sub_q_tables       =array();
                                    $sub_q_conditions   =array();


                                    while(true)
                                    {
                                        $i=$xccid;
                                        $fieldb=array();
                                        foreach($fielda["fields"] as $fieldax)
                                        {
                                            $fieldb[]=" ct$i.".$fieldax." as c$i ";
                                        }
                                        $sub_q_fields[]=implode(",",$fieldb);

                                        $sub_q_tables[]=$table_n." as ct$i ";
                                        $sub_q_conditions[]=" ct$i.".$fielda["id"]." = '".$xccid."'";


                                        if(!$tree[$xccid])
                                            break;
                                        $xccid=$tree[$xccid];
                                    }
                                    $sub_q_fields=array_reverse($sub_q_fields);
                                    $sub_q_tables=array_reverse($sub_q_tables);
                                    $sub_q_conditions=array_reverse($sub_q_conditions);


                                    $fin=" select "
                                    .implode(" , ",$sub_q_fields)
                                    ." from "
                                    .implode(" join ",$sub_q_tables)
                                    ." where "
                                    .implode(" and ",$sub_q_conditions);
                                    $sub_q_union[]=$fin;
                                }
                                $k='';
                                foreach($sub_q_union as $sub_q_s)
                                {
                                    $sub_q = xtc_db_query($sub_q_s);
                                    while($sub_r=xtc_db_fetch_array($sub_q))
                                    {
                                        foreach($sub_r as $ff=>$ffva)
                                        {
                                            $k.=$ffva.$fielda["seperator"];
                                        }
                                        $k.=$fielda["seperator"];
                                    }
                                }
                                $r .= $this->TextSign.$k.$this->TextSign.$this->seperator;
                            }

                        }
                        else
                        {
                            $sub_q = xtc_db_fetch_array(xtc_db_query( "select ".$fielda." from ".$table_n.$conditions));
                            $r .= $this->TextSign.str_replace("\n"," ",$sub_q[$fielda]).$this->TextSign.$this->seperator;
                        }
                        next($table_a["fields"]);
                    }
                    next($this->scheme);
                }
                $r .= "\n";
            }        }
        return $r;
    }





    function eval_import_index($idx, & $main_a, & $engine)
    {
        foreach($idx as $conn=>$cond)
        {
            if($cond['type']=='oneToOne')
            {
                $condret=$this->expand_condition($conn,$cond,$main_a);
                for($i=0;$i<count($engine['rows']);$i++)
                {
                    $engine['rows'][$i]['data'][$condret['key']]=$condret['value'];
                    $engine['rows'][$i]['action']="insert";
                    $engine['rows'][$i]['controll']="second";
                }
            }
            else if($cond['type']=='oneToMany')
            {
                $condret=$this->expand_condition($conn,$cond,$main_a);
                $mtemp=array();
                $mtemp[$condret['key']]=$condret['value'];

                if($engine["relativeTableDesc"]["clearBeforeUpdate"])
                {
                    xtc_db_query("delete from ".$engine["relativeTableName"]." where ".sqlArrayCompare($mtemp," and "));
                }



                for($i=0;$i<count($engine['rows']);$i++)
                {
                    if(!$engine['rows'][$i])
                        continue;

                    $engine['rows'][$i]['data'][$condret['key']]=$condret['value'];
                    $engine['rows'][$i]['action']="insert";
                    $engine['rows'][$i]['controll']="second";

                }
            }
            else if($cond['type']=='manyToOne')
            {
                if(!$engine['rows'][0])
                    continue;

                $reverseq=(xtc_db_fetch_array(xtc_db_query(
                    "select `".$cond["var"]."` from `".$engine['relativeTableName']."` where ".sqlArrayCompare($engine['rows'][0]['data']))));

                if(!$reverseq[$cond["var"]])
                {
                    xtc_db_query(
                        "insert into `".$engine['relativeTableName']."`  (".sqlArrayKeys($engine['rows'][0]['data']).")  values (".sqlArrayValues($engine['rows'][0]['data']).")");

                    $reverseq=(xtc_db_fetch_array(xtc_db_query(
                        "select `".$cond["var"]."` from `".$engine['relativeTableName']."` where ".sqlArrayCompare($engine['rows'][0]['data']))));


                }


                $engine['rows'][0]['index'][$cond["var"]]=$reverseq[$cond["var"]];
                $main_a[$cond["var"]]=$reverseq[$cond["var"]];
                $engine['rows'][0]['action']="reverse";
                xtc_db_query("update ".$engine["mainTableName"]." set  `".$cond["var"]."`='".$reverseq[$cond["var"]]."'  ".$engine["mainwhere"]);
                $engine['rows'][0]['controll']="finished";


            }
            else if($cond['type']=='manyToMany')
            {
                $sibxs="";
                if($cond["index"])
                {
                    $subengine=$engine;
                    $subengine=$this->eval_import_index($cond["index"],$main_a,$subengine);
                    pr($subengine['rows']);
                    die("can't do manyToMany yet2");
                    $sibxs= sqlArrayCompare($sibx['rows'][0]['controll']," and ");
                }
                $xcq=xtc_db_query( "select `$conn` from `".$cond['table']."` where ".$sibxs);
                pr("select `$conn` from `".$cond['table']."` where ".$sibxs);

                $emx_f=array();
                while($xcr=xtc_db_fetch_array($xcq))
                {
                
                    $emx_f[$conn]=$xcr[$conn];
                }
                if($emx_f)
                    $idx_f[]=$emx_f;
            }
        }


        for($i=0;$i<count($engine['rows']);$i++)
        {
            if($engine['rows'][$i]["controll"]=="second" )
            {
                if ( $engine['rows'][$i]["action"]=="insert")
                {
                    xtc_db_query(
                    "insert into ".$engine["relativeTableName"]."  (". sqlArrayKeys($engine['rows'][$i]['data']).") "
                    ."VALUES (". sqlArrayValues($engine['rows'][$i]['data'])." )"
                    ."on duplicate key update  ".sqlArrayCompare($engine['rows'][$i]['data']) );
                    $engine['rows'][$i]['controll']="finished";

                }
            }

        }

        return $engine;
    }


    function import($filename)
    {
        $head=array();

        if (!file_exists($filename))
        {
            $this->errorLog[] ="<b>ERROR:</b> file I/O error";
            return array ($this->counter, $this->errorLog, $this->calcElapsedTime($this->time_start));
        } 
        $this->fd   = fopen($filename, "r");

        $headlinea=explode($this->seperator,rtrim(fgets ($this->fd)));
        foreach ($headlinea as $key => $value)
        {
            $head[$key]=$this->RemoveTextNotes($value);
        }



        $i=0;
        while (!feof($this->fd))
        {
            reset($this->scheme);
            $mainTableDesc =current($this->scheme);
            $mainTableName =key($this->scheme);

            ++$i;
            $line_content = explode($this->seperator,rtrim(fgets($this->fd)));
            foreach ($head as $key => $value)
            {
                $line_data[$value] = $this->RemoveTextNotes($line_content[$key]);
            }



            //need all index fields or error
            $mainwhere=' where ';
            foreach($mainTableDesc["index"] as $indexkey)
            {
                $ok=true;
                if ($line_data[$indexkey] == '')
                {
                    $ok=false;
                    $this->errorLog[] ="<b>Zeile $i:</b> index key $indexkey cannot be null";
                }
                else
                {
                    $mainwhere.="`$indexkey` = '".$line_data[$indexkey]."'";
                    $mainwhere.=" and ";
                }
                if(!$ok)
                {
                    return array ($this->counter, $this->errorLog, $this->calcElapsedTime($this->time_start));
                }
            }
            $mainwhere.=" 1=1 ";

            $maintryupdateq=xtc_db_fetch_array(xtc_db_query("select count(*) from $mainTableName ".$mainwhere));
            if ($maintryupdateq["count(*)"])
            {
                $update=true;
            }
            else
            {
                $update=false;
            }

            //now build a data array

            $mainData  =array();

            foreach($mainTableDesc["fields"] as $field)
            {
                if($line_data[$field] != '')
                {
                        $mainData[$field]=$line_data[$field];
                }
            }


            if($update)
            {
                $this->counter['update']++;
                xtc_db_query("update `$mainTableName` set ". sqlArrayCompare($mainData)." ".$mainwhere);
            }
            else
            {
                $this->counter['new']++;
                xtc_db_query( "insert into `$mainTableName`  (". sqlArrayKeys($mainData).")  values (". sqlArrayValues($mainData)." )");
            }

            $main_a=xtc_db_fetch_array(xtc_db_query("select * from $mainTableName ".$mainwhere));


            //==related tables==

            next($this->scheme);
            while($relativeTableDesc     =current($this->scheme))
            {
                $relativeTableName =key($this->scheme);

                $engine=array();

                reset($relativeTableDesc["fields"]);
                while($rel_a_f=current($relativeTableDesc["fields"]))
                {
                    

                    $rel_a_k=key    ($relativeTableDesc["fields"]);

                    if(is_array($rel_a_f))
                    {

                        if($line_data[$rel_a_k] == '')
                        {
                            next($relativeTableDesc["fields"]);
                            continue;
                        }


                        if($rel_a_f["type"]=="inlinetable")
                        {
                            $rows =explode($rel_a_f["seperator"].$rel_a_f["seperator"],$line_data[$rel_a_k]);
                            foreach($rows as $row)
                            {
                                $s_dt_f=array();


                                $columns =explode($rel_a_f["seperator"],$row);
                                $di=0;
                                foreach($columns as $c)
                                {
                                    $s_dt_f[$rel_a_f["fields"][$di]]=$c;
                                    $di++;
                                }
                                $engine['rows'][]['data']=$s_dt_f;
                            }

                        }
                        else if($rel_a_f["type"]=="tree")
                        {
                            ///FIXME
                        }
                    }
                    else
                    {

                        if($line_data[$rel_a_f] == '')
                        {;
                            next($relativeTableDesc["fields"]);
                            continue;
                        }
                        $engine['rows'][0]['data'][$rel_a_f]= $line_data[$rel_a_f];

                    }

                    next($relativeTableDesc["fields"]);
                }





//                 echo '<div style="margin:10px;border:1px solid black;"><h1>'.$relativeTableName.'</h1>';



                if($relativeTableDesc["index"])
                {
//                     echo "<h2>Engine:</h2><br>";
                    $engine['relativeTableDesc']=&$relativeTableDesc;
                    $engine['relativeTableName']=$relativeTableName;
                    $engine['mainTableName']=$mainTableName;
                    $engine['mainwhere']=$mainwhere;

                    $evalr=$this->eval_import_index($relativeTableDesc["index"],$main_a,$engine);
//                     pr($evalr['rows']);
                }
//                 echo "</div>";


                next($this->scheme);
            }

        }

        fclose($this->fd);
        return array ($this->counter, $this->errorLog, $this->calcElapsedTime($this->time_start));
    }



}

?>

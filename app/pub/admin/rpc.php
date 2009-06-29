<?php
    require ('includes/application_top.php');
    defined('_VALID_XTC') or die('Login required.');


    header ('content-type : text/x-json');


    function nextKey($field,$table,$arg=array()){
        global $db;
        $q=$db->prepare("select $field from $table");
        $q->execute($arg);
        $a=array();
        while($x=$q->fetch()){
            $a[$x[$field]]=true;
        }
        $m=1;
        while($a[$m]){
            ++$m;
        }
        return $m;
    }


    $commands=json_decode(file_get_contents("php://input"),true);
    $return = array();
    foreach ($commands as $cmd){
        $return []=f($cmd);
    }
    echo json_encode($return);

    function f($cmd){
        $retval=array();
        $retok=false;
        $reterr='';
        global $db;
        if($cmd['command']=='checkRemoteUrl'){
            $ch=curl_init($cmd['url']);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
            curl_exec($ch);
            $retval=(curl_getinfo($ch,CURLINFO_HTTP_CODE)=='200');
            $reterr=curl_error($ch);
            $retok=true;
        }
        else if($cmd['command']=='asphyx'){
             if($cmd['aclass']=='com.handelsweise.litestore.product_image'){
                if ($cmd['action']=='set'){
                     $q=$db->prepare('update products_images
                                         set url_small = :url_small,
                                             url_middle = :url_middle,
                                             url_big = :url_big
                                       where products_id= :products_id 
                                         and image_nr= :image_nr ');
                        $retok=$q->execute($cmd['data']);
                        
                }
                else if ($cmd['action']=='create'){

                    $q=$db->prepare('insert into products_images (image_nr,products_id) values (?,?)');
                    $q->execute(array(nextKey('image_nr','products_images where products_id=?',array($cmd['product'])),$cmd['product']));
                    $liid=$db->lastInsertId();

                    $retval['text']		= $cmd['name'];
                    $retval['id']	    = 'image_'.$cmd['parent'].'_'.$cmd['product'].'_'.$liid;
                    $retval['data']     = array('image_nr'=>$liid,'products_id'=>$cmd['product']);
                    $retval['leaf']	    = true;
                    $retval['cls']	    = 'item_image';
                    $retval['aclass']	= 'com.handelsweise.litestore.product_image';

                    if($liid)
                        $retok=true;
                    else
                        $reterr='cannot get inserted id';
                }
                else if ($cmd['action']=='delete'){

                    $q=$db->prepare('delete from products_images where products_id=? and image_nr=?');
                    $retok=($q->execute(array($cmd['product'],$cmd['nr']))!=false);
                    $q=$db->prepare('update products_images set image_nr=image_nr-1 where products_id=? and image_nr > ? '); 
                    $q->execute(array($cmd['product'],$cmd['nr']));;
                }
                else if ($cmd['action']=='move'){
                    $q=$db->prepare('select image_nr from products_images where products_id=?'); 
                    $q->execute(array($cmd['productNew']));
                    $m=array();
                    while($x=$q->fetch()){  
                        $m[]=$x['image_nr'];
                    }
                    sort($m);
                    $m=array_reverse($m);

                    if($cmd['relative']=='append'){
                        $q=$db->prepare('update products_images set image_nr=?, products_id=? where image_nr=? and products_id=?'); 
                        $q->execute(array(
                            ($m[sizeof($m)-2])+1,
                            $cmd['productNew'],
                            $cmd['nrOld'],
                            $cmd['productOld']
                        ));
                    }
                    else if($cmd['relative']=='below' || $cmd['relative']=='above'){
                        $db->beginTransaction();
                        
                        //mysql fails at batch, so we do it manualy..
                        //first move the current row away so it doesnt get hit by the next step

                        $tmpprod=nextKey('products_id','products_images');
                        $q=$db->prepare('update products_images set  products_id=? where image_nr=? and products_id=?'); 
                        $q->execute(array(
                            $tmpprod,
                            $cmd['nrOld'],
                            $cmd['productOld']
                        ));
                        
                        //move all one down
                        foreach($m as $x){
                            if(($x > $cmd['relativeTo'])  ||  (($cmd['relative']=='above') && ($x == $cmd['relativeTo']))){
                                $q=$db->prepare('update products_images set image_nr=? where image_nr = ? and products_id=?');
                                $q->execute(array(
                                    $x+1,
                                    $x,
                                    $cmd['productNew']
                                ));
                            }
                        }
                        //finally get the node into position
                        $q=$db->prepare('update products_images set image_nr=?, products_id=? where image_nr=? and products_id=?'); 
                        $q->execute(array(
                            ($cmd['relative']=='below')?($cmd['relativeTo']+1):$cmd['relativeTo'],
                            $cmd['productNew'],
                            $cmd['nrOld'],
                            $tmpprod
                        ));
                        $db->commit();
                        $retok=true;
                    }
                }
            }
            else if($cmd['aclass']=='com.handelsweise.litestore.category'){
                if ($cmd['action']=='get'){
                    $q=$db->prepare('select categories_name  as name,
                                            categories_description as  description,
                                            categories_status as status,
                                            categories_heading_title as heading_title,
                                            categories_meta_title as meta_title,
                                            categories_meta_description as meta_description,
                                            categories_meta_keywords as meta_keywords
                                    from    categories as c, 
                                            categories_description as cd 
                                    where   c.categories_id=? 
                                    and     c.categories_id=cd.categories_id');
                    $q->execute(array($cmd['categories_id']));
                    $retval=$q->fetchObject();
                    if($retval)
                        $retok=true;
                    else
                        $reterr='empty result';
                }
                else if ($cmd['action']=='set'){
                    $db->beginTransaction();
                    $q=$db->prepare('update categories_description
                                            set categories_name = ?,
                                            categories_description = ?,
                                            categories_heading_title = ?,
                                            categories_meta_title = ?,
                                            categories_meta_description = ?,
                                            categories_meta_keywords = ?
                                    where   categories_id=? ');
                    $q->execute(array(
                        $cmd['data']['name'],
                        $cmd['data']['description'],
                        $cmd['data']['heading_title'],
                        $cmd['data']['meta_title'],
                        $cmd['data']['meta_description'],
                        $cmd['data']['meta_keywords'],
                        $cmd['data']['id']
                    ));

                    if($cmd['data']['status']=='on')
                        $cmd['data']['status']=1;

                    $q=$db->prepare('update categories
                                            set categories_status = ?
                                    where   categories_id=? ');
                    $q->execute(array(
                        $cmd['data']['status'],
                        $cmd['data']['id']
                    ));
                    $retok=$db->commit();
                }
                else if ($cmd['action']=='create'){

                    $q=$db->prepare('insert into categories (parent_id) values (?)');
                    $q->execute(array($cmd['parent']));
                    $liid=$db->lastInsertId();

                    $q=$db->prepare('insert into categories_description (categories_id,categories_name,languages_id) values (?,?,2)');
                    $q->execute(array($liid,$cmd['name']));

                    $retval['text']		= $cmd['name'];
                    $retval['id']	    = 'category_'.$liid;
                    $retval['data']     = array('categories_id'=>$liid);
                    $retval['leaf']	    = true;
                    $retval['cls']	    = 'item_category';
                    $retval['aclass']	= 'com.handelsweise.litestore.category';

                    if($liid)
                        $retok=true;
                    else
                        $reterr='cannot get inserted id';
                }
                else if ($cmd['action']=='delete'){
                    if($cmd['category']<2){
                        return array('success'=>'false','value'=>null,'error'=>'Cannot delete root');
                    }
                    $q=$db->prepare('select products_id from products_to_categories where categories_id=?');
                    $q->execute(array($cmd['category']));
                    while($x=$q->fetch()){
                        $a=array();
                        $a['command']='asphyx';
                        $a['category']=$cmd['category'];
                        $a['product']=$x['products_id'];
                        $a['aclass']='com.handelsweise.litestore.product';
                        $a['action']='delete';
                        $c=f($a);
                        if(!$c['success'])
                            return array('success'=>'false','value'=>null,'error'=>$c['error']);
                    }
                    $q=$db->prepare('delete from categories where categories_id=?');
                    $q->execute(array($cmd['category']));
                    $q=$db->prepare('delete from categories_description where categories_id=?');
                    $q->execute(array($cmd['category']));
                    $retok=true;
                }
            }
            else if($cmd['aclass']=='com.handelsweise.litestore.product'){
                if ($cmd['action']=='get'){
                    $q=$db->prepare('select products_name  as name,
                                            products_description as  description,
                                            products_short_description as  short_description,
                                            products_status as status,
                                            products_meta_title as meta_title,
                                            products_meta_description as meta_description,
                                            products_meta_keywords as meta_keywords,
                                            products_keywords as keywords,
                                            products_ean as ean,
                                            products_weight as weight,
                                            products_model as model
                                    from    products as c, 
                                            products_description as cd 
                                    where   c.products_id=? 
                                    and     c.products_id=cd.products_id');
                    $q->execute(array($cmd['products_id']));
                    $retval=$q->fetchObject();
                    if($retval)
                        $retok=true;
                    else
                        $reterr='empty result';
                }
                else if ($cmd['action']=='set'){
                    $db->beginTransaction();
                    $q=$db->prepare('update products_description
                                            set products_name = ?,
                                            products_description =?,
                                            products_short_description =?,
                                            products_meta_title =?,
                                            products_meta_description =?,
                                            products_meta_keywords =?,
                                            products_keywords =?
                                    where   products_id=? ');
                    $q->execute(array(
                        $cmd['data']['name'],
                        $cmd['data']['description'],
                        $cmd['data']['short_description'],
                        $cmd['data']['meta_title'],
                        $cmd['data']['meta_description'],
                        $cmd['data']['meta_keywords'],
                        $cmd['data']['keywords'],
                        $cmd['data']['id']
                    ));

                    if($cmd['data']['status']=='on')
                        $cmd['data']['status']=1;

                    $q=$db->prepare('update products
                                            set products_status = ?,
                                                products_ean=?,
                                                products_model=?,
                                                products_weight=?
                                    where   products_id=? ');
                    $q->execute(array(
                        $cmd['data']['status'],
                        $cmd['data']['ean'],
                        $cmd['data']['model'],
                        $cmd['data']['weight'],
                        $cmd['data']['id']
                    ));
                    $retok=$db->commit();
                }
                else if ($cmd['action']=='create'){


                    $q=$db->prepare('insert into products (products_model) values (?)');
                    $q->execute(array(nextKey('products_model','products')));
                    $liid=$db->lastInsertId();

                    $q=$db->prepare('insert into products_to_categories (products_id,categories_id) values (?,?)');
                    $q->execute(array($liid,$cmd['parent']));

                    $q=$db->prepare('insert into products_description (products_id,products_name,languages_id) values (?,?,2)');
                    $q->execute(array($liid,$cmd['name']));

                    $retval['text']		= $cmd['name'];
                    $retval['id']	    = 'product_'.$cmd['parent'].'_'.$liid;
                    $retval['data']     = array('products_id'=>$liid);
                    $retval['leaf']	    = true;
                    $retval['cls']	    = 'item_product';
                    $retval['aclass']	= 'com.handelsweise.litestore.product';

                    if($liid)
                        $retok=true;
                    else
                        $reterr='cannot get inserted id';
                }
                else if ($cmd['action']=='delete'){
                    $q=$db->prepare('delete from products_to_categories where products_id=? and categories_id=?');
                    $retok=($q->execute(array($cmd['product'],$cmd['category']))!=false);

                    $q=$db->prepare('select COUNT(*) from products_to_categories where products_id=? and categories_id=?');
                    $retok=($q->execute(array($cmd['product'],$cmd['category']))!=false);
                    $x=$q->fetch();
                    $x=$x['COUNT(*)'];
                    if($x==0){
                        $q=$db->prepare('delete from products where products_id=?');
                        $q->execute(array($cmd['product']));
                        $q=$db->prepare('delete from products_description where products_id=?');
                        $q->execute(array($cmd['product']));
                        $q=$db->prepare('delete from products_images where products_id=?');
                        $q->execute(array($cmd['product']));
                        $q=$db->prepare('delete from prices where products_id=?');
                        $q->execute(array($cmd['product']));
                    }
                    $retok=true;
                }
            }

        }
        else{
            $retok=false;
            $reterr='unknown command '.$cmd['command'];
        }

        return array('success'=>$retok,'value'=>$retval,'error'=>$reterr);
    }


?>

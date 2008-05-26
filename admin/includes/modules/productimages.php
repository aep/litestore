<?php
defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

$dttr_self=xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('productimagesaction','imagenr')));


$querystring= "select row_id,url_small,url_middle,url_big from products_images where products_id='".xtc_db_input($_GET['pID'])."'";

if(isset($_GET["imagenr"]) && $_GET["imagenr"]=="new")
{
    xtc_db_query("insert into products_images (products_id) values ('".xtc_db_input($_GET['pID'])."')");

}
else if(isset($_GET["imagenr"]) && $_FILES["datafile"]["name"])
{
    $file=$_FILES["datafile"];

    $pname_arr = explode('.',$file["name"]);
    $nsuffix = array_pop($pname_arr);

    $products_image_name=xtc_db_input($_GET['pID'])."_".xtc_db_input($_GET['imagenr']).".".$nsuffix;
    rename($file["tmp_name"],DIR_FS_CATALOG_ORIGINAL_IMAGES."/".$products_image_name);


    require (DIR_WS_INCLUDES.'product_thumbnail_images.php');
    require (DIR_WS_INCLUDES.'product_info_images.php');
    require (DIR_WS_INCLUDES.'product_popup_images.php');

    xtc_db_query("update products_images set "
        ."url_small   = '/images/product_images/thumbnail_images/$products_image_name'  , "
        ."url_middle  = '/images/product_images/info_images/$products_image_name'  , "
        ."url_big     = '/images/product_images/popup_images/$products_image_name'   "
        ."where row_id='".xtc_db_input($_GET['imagenr'])."'");

}

else if(isset($_GET["imagenr"]) && $_POST)
{
    $query = xtc_db_query($querystring);
    while($img = xtc_db_fetch_array($query))
    {
        $i=$img["row_id"];
        if (isset($_POST["delete_$i"]))
        {
            xtc_db_query("delete from products_images where row_id='$i'");
        }
        else if (isset($_POST["save_$i"]))
        {
            xtc_db_query("update products_images set "
                ."url_small  = \"".xtc_db_input($_POST["url_small_$i"])     ."\" , "
                ."url_middle = \"".xtc_db_input($_POST["url_middle_$i"])    ."\" , "
                ."url_big    = \"".xtc_db_input($_POST["url_big_$i"])       ."\" "
                ."where row_id='$i'");
        }
    }
}







$query = xtc_db_query($querystring);

?>


<h3> Bilder bearbeiten. Artikel <?php echo $_GET['pID'];?> </h3>
<hr/>


<?php while($img = xtc_db_fetch_array($query)){ $i=$img["row_id"]; ?>
    <form action="<?php echo $dttr_self."&amp;imagenr=$i" ?>"  method="post" enctype="multipart/form-data"  >


        <div style="margin:1em;border:1px solid grey;">


            <img width="200px" src="<?php echo $img["url_big"]; ?>"     style="float:left;"/>
            <img width="100px" src="<?php echo $img["url_middle"]; ?>"     style="float:left;margin-left:-200px;" />
            <img width="50px;" src="<?php echo $img["url_small"]; ?>"   style="float:left;margin-left:-200px;" />

            <div style="margin-left:200px;">
                    <table border="0">
                        <tr>
                            <td width="10%">Klein:</td>
                            <td><input style="width:70%" type="text" name="url_small_<?php echo $i;?>" value="<?php echo $img["url_small"]; ?>" /></td>
                        </tr>
                        <tr>
                            <td>Mittel:</td>
                            <td><input style="width:70%"  type="text" name="url_middle_<?php echo $i;?>" value="<?php echo $img["url_middle"]; ?>" /></td>
                        </tr>
                        <tr>
                            <td>Gross:</td>
                            <td><input style="width:70%"  type="text"  name="url_big_<?php echo $i;?>" value="<?php echo $img["url_big"]; ?>" /></td>
                        </tr>

                        <tr>
                            <td>Bild Hochladen:</td>
                            <td><input style="width:70%"  type="file" name="datafile" ></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" name="save_<?php echo $i;?>" value="Speichern"/>&nbsp;&nbsp;&nbsp;
                                <input type="submit" name="delete_<?php echo $i;?>" value="L&ouml;schen"/></td>
                        </tr>
                    </table>
            </div>

            <br style="clear:both" />
        </div>
    </form>
<?php } ?>

<form action="<?php echo $dttr_self."&amp;imagenr=new" ?>"  method="post" enctype="multipart/form-data"  >
    <input type="submit" value="+ Hinzuf&uuml;gen"/>
</form>


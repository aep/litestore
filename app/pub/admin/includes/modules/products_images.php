<table width="100%" border="0" bgcolor="f3f3f3" style="border: 1px solid; border-color: #cccccc;">

<?php

/* --------------------------------------------------------------
   $Id: products_images.php 1166 2005-08-21 00:52:02Z mz $

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce


   Released under the GNU General Public License
   --------------------------------------------------------------*/
defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');


// show images
if ($_GET['action'] == 'new_product') 
{
    $imagesq=xtDBquery("select  image_url  from products_images where products_id=".$pInfo->products_id." and image_sizetype=2");
    $i=0;
    while ($ikc= xtc_db_fetch_array($imagesq,true))
    {
        $ik=$ikc["image_url"];
        echo '<tr>';
        echo '<td><img width="100px" src="'.$ik.'" alt=""/>';
        echo '<td class="main">'.TEXT_PRODUCTS_IMAGE. '<br>'.xtc_draw_file_field('mo_pics_'.$i).'<br>'.xtc_draw_separator('pixel_trans.gif', '24', '15').'&nbsp;'.$ik.xtc_draw_hidden_field('products_previous_image_'. ($i +1), $ik).'</td>';
        echo '<td align="center" class="main" valign="middle">'.xtc_draw_selection_field('del_mo_pic[]', 'checkbox', $ik).' '.TEXT_DELETE.'</td>';
        echo '</tr>';
        $i++;
    }
}
?>
</table>

<?php
/* --------------------------------------------------------------
   $Id: categories_view.php 901 2005-04-29 10:32:14Z novalis $

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(categories.php,v 1.140 2003/03/24); www.oscommerce.com
   (c) 2003  nextcommerce (categories.php,v 1.37 2003/08/18); www.nextcommerce.org

   Released under the GNU General Public License
   --------------------------------------------------------------
   Third Party contribution:
   Enable_Disable_Categories 1.3               Autor: Mikel Williams | mikel@ladykatcostumes.com
   New Attribute Manager v4b                   Autor: Mike G | mp3man@internetwork.net | http://downloads.ephing.com
   Category Descriptions (Version: 1.5 MS2)    Original Author:   Brian Lowe <blowe@wpcusrgrp.org> | Editor: Lord Illicious <shaolin-venoms@illicious.net>
   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Released under the GNU General Public License
   --------------------------------------------------------------*/
 defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');  
    // get sorting option and switch accordingly        
    if ($_GET['sorting']) {
    switch ($_GET['sorting']){
        case 'sort'         : 
            $catsort    = 'c.sort_order ASC';
            $prodsort   = 'p.products_sort ASC';
            break;
        case 'sort-desc'    :
            $catsort    = 'c.sort_order DESC';
            $prodsort   = 'p.products_sort DESC';
        case 'name'         :
            $catsort    = 'cd.categories_name ASC';
            $prodsort   = 'pd.products_name ASC';
            break;
        case 'name-desc'    :
            $catsort    = 'cd.categories_name DESC';
            $prodsort   = 'pd.products_name DESC';
            break;                  
        case 'status'       :
            $catsort    = 'c.categories_status ASC';
            $prodsort   = 'p.products_status ASC';
            break;
        case 'status-desc'  :
            $catsort    = 'c.categories_status DESC';
            $prodsort   = 'p.products_status DESC';
            break;             
        case 'price'        :
            $catsort    = 'c.sort_order ASC'; //default
            $prodsort   = 'p.products_price ASC';            
            break;
        case 'price-desc'   :
            $catsort    = 'c.sort_order ASC'; //default
            $prodsort   = 'p.products_price DESC';            
            break;            
        case 'stock'        :
            $catsort    = 'c.sort_order ASC'; //default
            $prodsort   = 'p.products_quantity ASC';            
            break;
        case 'stock-desc'   :
            $catsort    = 'c.sort_order ASC'; //default
            $prodsort   = 'p.products_quantity DESC';            
            break;            
        case 'discount'     :
            $catsort    = 'c.sort_order ASC'; //default
            $prodsort   = 'p.products_discount_allowed ASC';            
            break;  
        case 'discount-desc':
            $catsort    = 'c.sort_order ASC'; //default
            $prodsort   = 'p.products_discount_allowed DESC';            
            break;                                   
        default             :
            $catsort    = 'cd.categories_name ASC';
            $prodsort   = 'pd.products_name ASC';
            break;
    }
    } else {
            $catsort    = 'c.sort_order, cd.categories_name ASC';
            $prodsort   = 'p.products_sort, pd.products_name ASC';
    }       
?>

    <!-- categories_view HTML part begin -->

    <tr>
     <td>
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
         <td align="right">
            <!-- search and quickjump -->
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
            <tr>
             <td class="smallText" align="right">
                <?php 
                    echo xtc_draw_form('search', FILENAME_CATEGORIES, '', 'get'); 
                    echo HEADING_TITLE_SEARCH . ' ' . xtc_draw_input_field('search', $_GET['search']).xtc_draw_hidden_field(xtc_session_name(), xtc_session_id()); 
                ?>
                </form>
             </td>
            </tr>
            <tr>
             <td class="smallText" align="right">
                <?php 
                    echo xtc_draw_form('goto', FILENAME_CATEGORIES, '', 'get');
                    echo HEADING_TITLE_GOTO . ' ' . xtc_draw_pull_down_menu('cPath', xtc_get_category_tree(), $current_category_id, 'onChange="this.form.submit();"').xtc_draw_hidden_field(xtc_session_name(), xtc_session_id()); 
                ?>
                </form>
             </td>
            </tr>
            </table>
        </td>
       </tr>
       </table>
     </td>
    </tr>
    <tr>
     <td>     
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
         <!-- categories & products column STARTS -->
         <td valign="top">
         
            <!-- categories and products table -->
            <table border="0" width="100%" cellspacing="0" cellpadding="2">
            <tr class="dataTableHeadingRow">
             <td class="dataTableHeadingContent" width="5%" align="center">
                <?php echo TABLE_HEADING_EDIT; ?>
                <input type="checkbox" onClick="javascript:CheckAll(this.checked);">
             </td>
             <td class="dataTableHeadingContent" align="center" width="7%">
                <?php echo TABLE_HEADING_SORT.xtc_sorting(FILENAME_CATEGORIES,'sort'); ?>
             </td>
             <td class="dataTableHeadingContent" align="center" width="30%">
                <?php echo TABLE_HEADING_CATEGORIES_PRODUCTS.xtc_sorting(FILENAME_CATEGORIES,'name'); ?>
             </td>
             <?php
             // check Produkt and attributes stock
             if (STOCK_CHECK == 'true') {
                    echo '<td class="dataTableHeadingContent" align="center" width="20%">' . TABLE_HEADING_STOCK . xtc_sorting(FILENAME_CATEGORIES,'stock') . '</td>';
             }
             ?>
             <td class="dataTableHeadingContent" align="center" width="7%">
                <?php echo TABLE_HEADING_STATUS.xtc_sorting(FILENAME_CATEGORIES,'status'); ?>
             </td>
             <td class="dataTableHeadingContent" align="center" width="7%">
                <?php echo TABLE_HEADING_STARTPAGE.xtc_sorting(FILENAME_CATEGORIES,'startpage'); ?>
             </td>
             <td class="dataTableHeadingContent" align="center" width="10%">
                <?php echo TABLE_HEADING_PRICE.xtc_sorting(FILENAME_CATEGORIES,'price'); ?>
             </td>
             <td class="dataTableHeadingContent" align="center" width="10%">
                <?php echo '% max' . xtc_sorting(FILENAME_CATEGORIES,'discount'); ?>
             </td>
             <td class="dataTableHeadingContent" width="10%" align="center">
                <?php echo TABLE_HEADING_ACTION; ?>
             </td>
            </tr>
            
    <?php
            
    //multi-actions form STARTS
    if (xtc_not_null($_POST['multi_categories']) || xtc_not_null($_POST['multi_products'])) { 
        $action = "action=multi_action_confirm&" . xtc_get_all_get_params(array('cPath', 'action')) . 'cPath=' . $cPath; 
    } else {
        $action = "action=multi_action&" . xtc_get_all_get_params(array('cPath', 'action')) . 'cPath=' . $cPath;
    }
    echo xtc_draw_form('multi_action_form', FILENAME_CATEGORIES, $action, 'post', 'onsubmit="javascript:return CheckMultiForm()"');
    //add current category id in $_POST
    echo '<input type="hidden" id="cPath" name="cPath" value="' . $cPath . '">';             
    
// ----------------------------------------------------------------------------------------------------- //    
// WHILE loop to display categories STARTS
// ----------------------------------------------------------------------------------------------------- //

    $categories_count = 0;
    $rows = 0;
    if ($_GET['search']) {
      $categories_query = xtc_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id, c.sort_order, c.date_added, c.last_modified, c.categories_status from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = cd.categories_id and cd.language_id = '" . (int)$_SESSION['languages_id'] . "' and cd.categories_name like '%" . $_GET['search'] . "%' order by " . $catsort);
    } else {
      $categories_query = xtc_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id, c.sort_order, c.date_added, c.last_modified, c.categories_status from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . $current_category_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$_SESSION['languages_id'] . "' order by " . $catsort);
    } 

    while ($categories = xtc_db_fetch_array($categories_query)) {
        
        $categories_count++;
        $rows++;

        if ($_GET['search']) $cPath = $categories['parent_id'];
        if ( ((!$_GET['cID']) && (!$_GET['pID']) || (@$_GET['cID'] == $categories['categories_id'])) && (!$cInfo) && (substr($_GET['action'], 0, 4) != 'new_') ) {
            $cInfo = new objectInfo($categories);
        }
      
        if ( (is_object($cInfo)) && ($categories['categories_id'] == $cInfo->categories_id) ) {
            echo '<tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'">' . "\n";
        } else {
            echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'">' . "\n";
        }
    ?>
        <td class="categories_view_data">
            <input type="checkbox" name="multi_categories[]" value="<?php  echo $categories['categories_id'] ; ?>" 
            <?php
            if (is_array($_POST['multi_categories'])) 
            { 
                if (in_array($categories['categories_id'], $_POST['multi_categories'])) 
                { 
                    echo 'checked="checked"'; 
                } 
            }
            ?>
            >
        </td>
             <td class="categories_view_data"><?php echo $categories['sort_order']; ?></td>
             <td class="categories_view_data" style="text-align: left; padding-left: 5px;">
             <?php 
                echo '<a href="' . xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('cPath', 'action', 'pID', 'cID')) . xtc_get_path($categories['categories_id'])) . '">' . xtc_image(DIR_WS_ICONS . 'folder.gif', ICON_FOLDER) . '<a>&nbsp;<b><a href="'.xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('cPath', 'action', 'pID', 'cID')) . 'cPath=' . $cPath . '&cID=' . $categories['categories_id']) .'">' . $categories['categories_name'] . '</a></b>'; 
             ?>
             </td>
        
             <?php
             // check product and attributes stock
             if (STOCK_CHECK == 'true') {
                     echo '<td class="categories_view_data">--</td>';
             }
             ?>
        
             <td class="categories_view_data">
             <?php
             //show status icons (green & red circle) with links
             if ($categories['categories_status'] == '1') {
                 echo xtc_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('cPath', 'action', 'pID', 'cID')) . 'action=setcflag&flag=0&cID=' . $categories['categories_id'] . '&cPath=' . $cPath) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
             } else {
                 echo '<a href="' . xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('cPath', 'action', 'pID', 'cID')) . 'action=setcflag&flag=1&cID=' . $categories['categories_id'] . '&cPath=' . $cPath) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . xtc_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
             }
             ?>
             </td>
             <td class="categories_view_data">--</td>
             <td class="categories_view_data">--</td>
             <td class="categories_view_data">--</td>
             <td class="categories_view_data">
             <?php
                //if active category, show arrow, else show symbol with link (action col)
                if ( (is_object($cInfo)) && ($categories['categories_id'] == $cInfo->categories_id) ) { 
                    echo xtc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); 
                } else { 
                    echo '<a href="' . xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('cPath', 'action', 'pID', 'cID')) . 'cPath=' . $cPath . '&cID=' . $categories['categories_id']) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; 
                } 
             ?>
             </td>
            </tr>
    <?php

// ----------------------------------------------------------------------------------------------------- //    
    } // WHILE loop to display categories ENDS    
// ----------------------------------------------------------------------------------------------------- //     
   
    //get products data 
    $products_count = 0;
    if ($_GET['search']) {
        $products_query = xtc_db_query("
        SELECT
        p.products_tax_class_id,
        p.products_id,
        pd.products_name,
        p.products_sort,
        p.products_quantity,
        p.products_price,
        p.products_discount_allowed,
        p.products_date_added,
        p.products_last_modified,
        p.products_date_available,
        p.products_status,
        p.products_startpage,
        p.products_startpage_sort,
        p2c.categories_id FROM " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c
        WHERE p.products_id = pd.products_id AND pd.language_id = '" . $_SESSION['languages_id'] . "' AND
        p.products_id = p2c.products_id AND (pd.products_name like '%" . $_GET['search'] . "%' OR
        p.products_model = '" . $_GET['search'] . "') ORDER BY " . $prodsort);
    } else {
        if($current_category_id)
        {
            $products_query = xtc_db_query("
            SELECT 
            p.products_tax_class_id,
            p.products_id, 
            pd.products_name, 
            p.products_quantity, 
            p.products_price, 
            p.products_discount_allowed, 
            p.products_date_added, 
            p.products_last_modified, 
            p.products_date_available, 
            p.products_status,
            p.products_startpage,
            p.products_startpage_sort FROM " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c 
            WHERE p.products_id = pd.products_id AND pd.language_id = '" . (int)$_SESSION['languages_id'] . "' AND 
            p.products_id = p2c.products_id AND p2c.categories_id = '" . $current_category_id . "'");
        }
        else
        {
            $products_query = xtc_db_query("
            select
            p.products_tax_class_id,
            p.products_id, 
            pd.products_name, 
            p.products_quantity, 
            p.products_price, 
            p.products_discount_allowed, 
            p.products_date_added, 
            p.products_last_modified, 
            p.products_date_available, 
            p.products_status,
            p.products_startpage,
            p.products_startpage_sort
            from products p
            join products_description pd
            where  p.products_id = pd.products_id and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
            and p.products_id  not in (SELECT  distinct products_id FROM  products_to_categories )
            union 
            SELECT 
            p.products_tax_class_id,
            p.products_id, 
            pd.products_name, 
            p.products_quantity, 
            p.products_price, 
            p.products_discount_allowed, 
            p.products_date_added, 
            p.products_last_modified, 
            p.products_date_available, 
            p.products_status,
            p.products_startpage,
            p.products_startpage_sort FROM " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c 
            WHERE p.products_id = pd.products_id AND pd.language_id = '" . (int)$_SESSION['languages_id'] . "' AND 
            p.products_id = p2c.products_id AND p2c.categories_id = '" . $current_category_id . "' ");
        }
    }

// ----------------------------------------------------------------------------------------------------- //    
// WHILE loop to display products STARTS
// ----------------------------------------------------------------------------------------------------- //
    
    while ($products = xtc_db_fetch_array($products_query)) {
      $products_count++;
      $rows++;

      // Get categories_id for product if search
      if ($_GET['search']) $cPath=$products['categories_id'];

      if ( ((!$_GET['pID']) && (!$_GET['cID']) || (@$_GET['pID'] == $products['products_id'])) && (!$pInfo) && (!$cInfo) && (substr($_GET['action'], 0, 4) != 'new_') ) {
        // find out the rating average from customer reviews
        $reviews_query = xtc_db_query("select (avg(reviews_rating) / 5 * 100) as average_rating from " . TABLE_REVIEWS . " where products_id = '" . $products['products_id'] . "'");
        $reviews = xtc_db_fetch_array($reviews_query);
        $pInfo_array = xtc_array_merge($products, $reviews);
        $pInfo = new objectInfo($pInfo_array);
      }

      if ( (is_object($pInfo)) && ($products['products_id'] == $pInfo->products_id) ) {
        echo '<tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" >' . "\n";
      } else {
        echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" >' . "\n";
      }

      ?>

      <?php
      //checkbox again after submit and before final submit 
      unset($is_checked);
      if (is_array($_POST['multi_products'])) { 
        if (in_array($products['products_id'], $_POST['multi_products'])) { 
            $is_checked = ' checked="checked"'; 
        }
      } 
      ?>      
      
      <td class="categories_view_data">        
        <input type="checkbox" name="multi_products[]" value="<?php echo $products['products_id']; ?>" <?php echo $is_checked; ?>>
      </td>
      <td class="categories_view_data">
        <?php 
        if ($current_category_id == 0){
        echo $products['products_startpage_sort'];
        } else {
        echo $products['products_sort'];
        }
         ?>
      </td>
      <td class="categories_view_data" style="text-align: left; padding-left: 8px;">
        <?php echo '<a href="' . xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('cPath', 'action', 'pID', 'cID')) . 'cPath=' . $cPath . '&pID=' . $products['products_id'] ) . '">' . xtc_image(DIR_WS_ICONS . 'preview.gif', ICON_PREVIEW) . '&nbsp;</a><a href="'.xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('cPath', 'action', 'pID', 'cID')) . 'cPath=' . $cPath . '&pID=' . $products['products_id']) .'">' . $products['products_name']; ?></a>
      </td>          
      <?php
      // check product and attributes stock
      if (STOCK_CHECK == 'true') { ?>
        <td class="categories_view_data">
        <?php echo check_stock($products['products_id']); ?>
        </td>
      <?php } ?>     
      <td class="categories_view_data">
      <?php
            if ($products['products_status'] == '1') {
                echo xtc_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('cPath', 'action', 'pID', 'cID')) . 'action=setpflag&flag=0&pID=' . $products['products_id'] . '&cPath=' . $cPath) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
            } else {
                echo '<a href="' . xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('cPath', 'action', 'pID', 'cID')) . 'action=setpflag&flag=1&pID=' . $products['products_id'] . '&cPath=' . $cPath) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . xtc_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
            }
      ?>
      </td>
      <td class="categories_view_data">
      <?php
            if ($products['products_startpage'] == '1') {
                echo xtc_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('cPath', 'action', 'pID', 'cID')) . 'action=setsflag&flag=0&pID=' . $products['products_id'] . '&cPath=' . $cPath) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
            } else {
                echo '<a href="' . xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('cPath', 'action', 'pID', 'cID')) . 'action=setsflag&flag=1&pID=' . $products['products_id'] . '&cPath=' . $cPath) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . xtc_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
            }
      ?>
      </td>
      <td class="categories_view_data">
      <?php
        //show price
        echo $currencies->format($products['products_price']);
      ?>
      </td>
      <td class="categories_view_data">
      <?php
        // Show Max Allowed discount
        echo $products['products_discount_allowed'] . '%';
      ?>
      </td>
      <td class="categories_view_data">
      <?php 
        if ( (is_object($pInfo)) && ($products['products_id'] == $pInfo->products_id) ) { echo xtc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('cPath', 'action', 'pID', 'cID')) . 'cPath=' . $cPath . '&pID=' . $products['products_id']) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } 
      ?>
      </td>
     </tr>    
<?php
// ----------------------------------------------------------------------------------------------------- //
    } //WHILE loop to display products ENDS
// ----------------------------------------------------------------------------------------------------- //    

    if ($cPath_array) {
      unset($cPath_back);
      for($i = 0, $n = sizeof($cPath_array) - 1; $i < $n; $i++) {
        if ($cPath_back == '') {
          $cPath_back .= $cPath_array[$i];
        } else {
          $cPath_back .= '_' . $cPath_array[$i];
        }
      }
    }

    $cPath_back = ($cPath_back) ? 'cPath=' . $cPath_back : '';
?>

        </tr>
        </table>
        <!-- categories and products table ENDS -->
        
        <!-- bottom buttons -->
        <table border="0" width="100%" cellspacing="0" cellpadding="2" style="padding-top: 10px; border-top: 1px solid Black">
        <tr>
         <td class="smallText">
            <?php echo TEXT_CATEGORIES . '&nbsp;' . $categories_count . '<br />' . TEXT_PRODUCTS . '&nbsp;' . $products_count; ?>
         </td>
         <td align="right" class="smallText">
         <?php
         	if ($cPath) echo '<a class="button" onClick="this.blur()" href="' . xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('cPath', 'action', 'pID', 'cID')) .  $cPath_back . '&cID=' . $current_category_id) . '">' . BUTTON_BACK . '</a>&nbsp;'; 
            echo '<a class="button" href="javascript:SwitchCheck()" onClick="this.blur()">' . BUTTON_REVERSE_SELECTION . '</a>&nbsp;';
            echo '<a class="button" href="javascript:SwitchProducts()" onClick="this.blur()">' . BUTTON_SWITCH_PRODUCTS . '</a>&nbsp;';
            echo '<a class="button" href="javascript:SwitchCategories()" onClick="this.blur()">' . BUTTON_SWITCH_CATEGORIES . '</a>&nbsp;';                                           
         ?>
         </td>
        </tr>
        </table>                

     </td>
     <!-- categories & products column ENDS -->

<?php
    $heading = array();
    $contents = array();



    switch ($_GET['action']) {

      case 'copy_to':
        //close multi-action form, not needed here
        $heading[] = array('text' => '</form><b>' . TEXT_INFO_HEADING_COPY_TO . '</b>');

        $contents   = array('form' => xtc_draw_form('copy_to', FILENAME_CATEGORIES, 'action=copy_to_confirm&cPath=' . $cPath) . xtc_draw_hidden_field('products_id', $pInfo->products_id));
        $contents[] = array('text' => TEXT_INFO_COPY_TO_INTRO);
        $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENT_CATEGORIES . '<br /><b>' . xtc_output_generated_category_path($pInfo->products_id, 'product') . '</b>');

		if (QUICKLINK_ACTIVATED=='true') {
        $contents[] = array('text' => '<hr noshade>');
        $contents[] = array('text' => '<b>'.TEXT_MULTICOPY.'</b><br />'.TEXT_MULTICOPY_DESC);
        $cat_tree=xtc_get_category_tree();
        $tree='';
        for ($i=0;$n=sizeof($cat_tree),$i<$n;$i++) {
        $tree .='<input type="checkbox" name="cat_ids[]" value="'.$cat_tree[$i]['id'].'"><font size="1">'.$cat_tree[$i]['text'].'</font><br />';
        }
        $contents[] = array('text' => $tree.'<br /><hr noshade>');
        $contents[] = array('text' => '<b>'.TEXT_SINGLECOPY.'</b><br />'.TEXT_SINGLECOPY_DESC);
        }
        $contents[] = array('text' => '<br />' . TEXT_CATEGORIES . '<br />' . xtc_draw_pull_down_menu('categories_id', xtc_get_category_tree(), $current_category_id));
        $contents[] = array('text' => '<br />' . TEXT_HOW_TO_COPY . '<br />' . xtc_draw_radio_field('copy_as', 'link', true) . ' ' . TEXT_COPY_AS_LINK . '<br />' . xtc_draw_radio_field('copy_as', 'duplicate') . ' ' . TEXT_COPY_AS_DUPLICATE);
        $contents[] = array('align' => 'center', 'text' => '<br /><input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_COPY . '"/> <a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('cPath', 'action', 'pID', 'cID')) . 'cPath=' . $cPath . '&pID=' . $pInfo->products_id) . '">' . BUTTON_CANCEL . '</a>');
        break;
        
      case 'multi_action':
        // --------------------
        // multi_move confirm
        // --------------------
        if (xtc_not_null($_POST['multi_move'])) {     
            $heading[]  = array('text' => '<b>' . TEXT_INFO_HEADING_MOVE_ELEMENTS . '</b>');
            $contents[] = array('text' => '<table width="100%" border="0">');
            
            if (is_array($_POST['multi_categories'])) {
                foreach ($_POST['multi_categories'] AS $multi_category) {
                    $category_query = xtc_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id, c.sort_order, c.date_added, c.last_modified, c.categories_status from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . $multi_category . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'");
                    $category = xtc_db_fetch_array($category_query);
                    $category_childs   = array('childs_count'   => $catfunc->count_category_childs($multi_category));
                    $category_products = array('products_count' => $catfunc->count_category_products($multi_category, true));
                    $cInfo_array = xtc_array_merge($category, $category_childs, $category_products);
                    $cInfo = new objectInfo($cInfo_array);                    
                    $contents[] = array('text' => '<tr><td style="border-bottom: 1px solid Black; margin-bottom: 10px;" class="infoBoxContent"><b>' . $cInfo->categories_name . '</b></td></tr>');
                    if ($cInfo->childs_count > 0)   $contents[] = array('text' => '<tr><td class="infoBoxContent">' . sprintf(TEXT_MOVE_WARNING_CHILDS, $cInfo->childs_count) . '</td></tr>');
                    if ($cInfo->products_count > 0) $contents[] = array('text' => '<tr><td class="infoBoxContent">' . sprintf(TEXT_MOVE_WARNING_PRODUCTS, $cInfo->products_count) . '</td></tr>');            
                }                
            }  
            
            if (is_array($_POST['multi_products'])) {
                foreach ($_POST['multi_products'] AS $multi_product) {
                
                    $contents[] = array('text' => '<tr><td style="border-bottom: 1px solid Black; margin-bottom: 10px;" class="infoBoxContent"><b>' . xtc_get_products_name($multi_product) . '</b></td></tr>');    
                    $product_categories_string = '';
                    $product_categories = xtc_output_generated_category_path($multi_product, 'product');
                    $product_categories_string = '<tr><td class="infoBoxContent">' . $product_categories . '</td></tr>';
                    $contents[] = array('text' => $product_categories_string); 
                }
            }                     
            
            $contents[] = array('text' => '<tr><td class="infoBoxContent"><strong>' . TEXT_MOVE_ALL . '</strong></td></tr><tr><td>' . xtc_draw_pull_down_menu('move_to_category_id', xtc_get_category_tree(), $current_category_id) . '</td></tr>');
            //close list table
            $contents[] = array('text' => '</table>');
            //add current category id, for moving products    
            $contents[] = array('text' => '<input type="hidden" name="src_category_id" value="' . $current_category_id . '">');
            $contents[] = array('align' => 'center', 'text' => '<input class="button" type="submit" name="multi_move_confirm" value="' . BUTTON_MOVE . '"> <a class="button" href="' . xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('cPath', 'action', 'pID', 'cID')) . 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&cID=' . $cInfo->categories_id) . '">' . BUTTON_CANCEL . '</a>');            
            //close multi-action form
            $contents[] = array('text' => '</form>'); 
        }
        // multi_move confirm ENDS        
        
        // --------------------
        // multi_delete confirm
        // --------------------
        if (xtc_not_null($_POST['multi_delete'])) {
            $heading[]  = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_ELEMENTS . '</b>');
            $contents[] = array('text' => '<table width="100%" border="0">');
            
            if (is_array($_POST['multi_categories'])) {
                foreach ($_POST['multi_categories'] AS $multi_category) {
                    $category_query = xtc_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id, c.sort_order, c.date_added, c.last_modified, c.categories_status from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . $multi_category . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'");
                    $category = xtc_db_fetch_array($category_query);
                    $category_childs   = array('childs_count'   => $catfunc->count_category_childs($multi_category));
                    $category_products = array('products_count' => $catfunc->count_category_products($multi_category, true));
                    $cInfo_array = xtc_array_merge($category, $category_childs, $category_products);
                    $cInfo = new objectInfo($cInfo_array);                    
                    $contents[] = array('text' => '<tr><td style="border-bottom: 1px solid Black; margin-bottom: 10px;" class="infoBoxContent"><b>' . $cInfo->categories_name . '</b></td></tr>');
                    if ($cInfo->childs_count > 0)   $contents[] = array('text' => '<tr><td class="infoBoxContent">' . sprintf(TEXT_DELETE_WARNING_CHILDS, $cInfo->childs_count) . '</td></tr>');
                    if ($cInfo->products_count > 0) $contents[] = array('text' => '<tr><td class="infoBoxContent">' . sprintf(TEXT_DELETE_WARNING_PRODUCTS, $cInfo->products_count) . '</td></tr>');            
                }                
            }
            
            if (is_array($_POST['multi_products'])) {
                foreach ($_POST['multi_products'] AS $multi_product) {                
                    $contents[] = array('text' => '<tr><td style="border-bottom: 1px solid Black; margin-bottom: 10px;" class="infoBoxContent"><b>' . xtc_get_products_name($multi_product) . '</b></td></tr>');    
                    $product_categories_string = '';
                    $product_categories = xtc_generate_category_path($multi_product, 'product');
                    for ($i = 0, $n = sizeof($product_categories); $i < $n; $i++) {
                      $category_path = '';
                      for ($j = 0, $k = sizeof($product_categories[$i]); $j < $k; $j++) {
                        $category_path .= $product_categories[$i][$j]['text'] . '&nbsp;&gt;&nbsp;';
                      }
                      $category_path = substr($category_path, 0, -16);
                      $product_categories_string .= xtc_draw_checkbox_field('multi_products_categories['.$multi_product.'][]', $product_categories[$i][sizeof($product_categories[$i])-1]['id'], true) . '&nbsp;' . $category_path . '<br />';
                    }
                    $product_categories_string = substr($product_categories_string, 0, -4);
                    $product_categories_string = '<tr><td class="infoBoxContent">' . $product_categories_string . '</td></tr>';
                    $contents[] = array('text' => $product_categories_string); 
                }
            }
            
            //close list table
            $contents[] = array('text' => '</table>');            
            $contents[] = array('align' => 'center', 'text' => '<input class="button" type="submit" name="multi_delete_confirm" value="' . BUTTON_DELETE . '"> <a class="button" href="' . xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('cPath', 'action', 'pID', 'cID')) . 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&cID=' . $cInfo->categories_id) . '">' . BUTTON_CANCEL . '</a>');
            //close multi-action form
            $contents[] = array('text' => '</form>');            
        }
        // multi_delete confirm ENDS
        
        // --------------------
        // multi_copy confirm
        // --------------------
        if (xtc_not_null($_POST['multi_copy'])) {     
            $heading[]  = array('text' => '<b>' . TEXT_INFO_HEADING_COPY_TO . '</b>');
            $contents[] = array('text' => '<table width="100%" border="0">');
            
            if (is_array($_POST['multi_categories'])) {
                foreach ($_POST['multi_categories'] AS $multi_category) {
                    $category_query = xtc_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id, c.sort_order, c.date_added, c.last_modified, c.categories_status from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . $multi_category . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'");
                    $category = xtc_db_fetch_array($category_query);
                    $category_childs   = array('childs_count'   => $catfunc->count_category_childs($multi_category));
                    $category_products = array('products_count' => $catfunc->count_category_products($multi_category, true));
                    $cInfo_array = xtc_array_merge($category, $category_childs, $category_products);
                    $cInfo = new objectInfo($cInfo_array);                    
                    $contents[] = array('text' => '<tr><td style="border-bottom: 1px solid Black; margin-bottom: 10px;" class="infoBoxContent"><b>' . $cInfo->categories_name . '</b></td></tr>');
                    if ($cInfo->childs_count > 0)   $contents[] = array('text' => '<tr><td class="infoBoxContent">' . sprintf(TEXT_MOVE_WARNING_CHILDS, $cInfo->childs_count) . '</td></tr>');
                    if ($cInfo->products_count > 0) $contents[] = array('text' => '<tr><td class="infoBoxContent">' . sprintf(TEXT_MOVE_WARNING_PRODUCTS, $cInfo->products_count) . '</td></tr>');            
                }                
            }  
            
            if (is_array($_POST['multi_products'])) {
                foreach ($_POST['multi_products'] AS $multi_product) {
                
                    $contents[] = array('text' => '<tr><td style="border-bottom: 1px solid Black; margin-bottom: 10px;" class="infoBoxContent"><b>' . xtc_get_products_name($multi_product) . '</b></td></tr>');    
                    $product_categories_string = '';
                    $product_categories = xtc_output_generated_category_path($multi_product, 'product');
                    $product_categories_string = '<tr><td class="infoBoxContent">' . $product_categories . '</td></tr>';
                    $contents[] = array('text' => $product_categories_string); 
                }
            }                     
            
            //close list table
            $contents[] = array('text' => '</table>');
    		if (QUICKLINK_ACTIVATED=='true') {
                $contents[] = array('text' => '<hr noshade>');
                $contents[] = array('text' => '<b>'.TEXT_MULTICOPY.'</b><br />'.TEXT_MULTICOPY_DESC);
                $cat_tree=xtc_get_category_tree();
                $tree='';
                for ($i=0;$n=sizeof($cat_tree),$i<$n;$i++) {
                    $tree .= '<input type="checkbox" name="dest_cat_ids[]" value="'.$cat_tree[$i]['id'].'"><font size="1">'.$cat_tree[$i]['text'].'</font><br />';
                }
                $contents[] = array('text' => $tree.'<br /><hr noshade>');
                $contents[] = array('text' => '<b>'.TEXT_SINGLECOPY.'</b><br />'.TEXT_SINGLECOPY_DESC);
            }
            $contents[] = array('text' => '<br />' . TEXT_SINGLECOPY_CATEGORY . '<br />' . xtc_draw_pull_down_menu('dest_category_id', xtc_get_category_tree(), $current_category_id) . '<br /><hr noshade>');
            $contents[] = array('text' => '<strong>' . TEXT_HOW_TO_COPY . '</strong><br />' . xtc_draw_radio_field('copy_as', 'link', true) . ' ' . TEXT_COPY_AS_LINK . '<br />' . xtc_draw_radio_field('copy_as', 'duplicate') . ' ' . TEXT_COPY_AS_DUPLICATE . '<br /><hr noshade>');
            $contents[] = array('align' => 'center', 'text' => '<input class="button" type="submit" name="multi_copy_confirm" value="' . BUTTON_COPY . '"> <a class="button" href="' . xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('cPath', 'action', 'pID', 'cID')) . 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&cID=' . $cInfo->categories_id) . '">' . BUTTON_CANCEL . '</a>');            
            //close multi-action form
            $contents[] = array('text' => '</form>'); 
        }
        // multi_copy confirm ENDS                        
        break;        

      default:
        if ($rows > 0) {
          if (is_object($cInfo)) { 
            // category info box contents
            $heading[]  = array('align' => 'center', 'text' => '<b>' . $cInfo->categories_name . '</b>');
            //Multi Element Actions
            $contents[] = array('align' => 'center', 'text' => '<div style="padding-top: 5px; font-weight: bold; width: 90%;">' . TEXT_MARKED_ELEMENTS . '</div>');
            $contents[] = array('align' => 'center', 'text' => '<input type="submit" class="button" name="multi_delete" onClick="this.blur();" value="'. BUTTON_DELETE . '">&nbsp;<input type="submit" class="button" onClick="this.blur();" name="multi_move" value="' . BUTTON_MOVE . '">&nbsp;<input type="submit" class="button" onClick="this.blur();" name="multi_copy" value="' . BUTTON_COPY . '">');
            $contents[] = array('align' => 'center', 'text' => '<input type="submit" class="button" name="multi_status_on" onClick="this.blur();" value="'. BUTTON_STATUS_ON . '">&nbsp;<input type="submit" class="button" onClick="this.blur();" name="multi_status_off" value="' . BUTTON_STATUS_OFF . '">');
            $contents[] = array('text'  => '</form>');



            //Single Element Actions

            $contents[] = array('align' => 'center', 'text' => '<div style="padding-top: 5px; font-weight: bold; width: 90%; border-top: 1px solid Black; margin-top: 5px;">' . TEXT_ACTIVE_ELEMENT . '</div>');
            $contents[] = array('align' => 'center', 'text' => '<a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('cPath', 'action', 'pID', 'cID')) . 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id . '&action=edit_category') . '">' . BUTTON_EDIT . '</a>');






            //Insert new Element Actions
            $contents[] = array('align' => 'center', 'text' => '<div style="padding-top: 5px; font-weight: bold; width: 90%; border-top: 1px solid Black; margin-top: 5px;">' . TEXT_INSERT_ELEMENT . '</div>');

            if (!$_GET['search']) {
            	$contents[] = array('align' => 'center', 'text' => '<a class="button" onClick="this.blur()" href="' . xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('cPath', 'action', 'pID', 'cID')) . 'cPath=' . $cPath . '&action=new_category') . '">' . BUTTON_NEW_CATEGORIES . '</a>&nbsp;<a class="button" onClick="this.blur()" href="' . xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('cPath', 'action', 'pID', 'cID')) . 'cPath=' . $cPath . '&action=new_product') . '">' . BUTTON_NEW_PRODUCTS . '</a>');            
            }
            //Informations
            $contents[] = array('align' => 'center', 'text' => '<div style="padding-top: 5px; font-weight: bold; width: 90%; border-top: 1px solid Black; margin-top: 5px;">' . TEXT_INFORMATIONS . '</div>');
            $contents[] = array('text'  => '<div style="padding-left: 50px;">' . TEXT_DATE_ADDED . ' ' . xtc_date_short($cInfo->date_added) . '</div>');
            if (xtc_not_null($cInfo->last_modified)) $contents[] = array('text' => '<div style="padding-left: 50px;">' . TEXT_LAST_MODIFIED . ' ' . xtc_date_short($cInfo->last_modified) . '</div>');            
            $contents[] = array('align' => 'center', 'text' => '<div style="padding: 10px;">' . xtc_info_image_c($cInfo->categories_image, $cInfo->categories_name, 200)  . '</div><div style="padding-bottom: 10px;">' . $cInfo->categories_image . '</div>');            
          } elseif (is_object($pInfo)) { 

            // product info box contents
            $heading[]  = array('align' => 'center', 'text' => '<b>' . xtc_get_products_name($pInfo->products_id, $_SESSION['languages_id']) . '</b>');
            //Multi Element Actions
            $contents[] = array('align' => 'center', 'text' => '<div style="padding-top: 5px; font-weight: bold; width: 90%;">' . TEXT_MARKED_ELEMENTS . '</div>');
            $contents[] = array('align' => 'center', 'text' => xtc_button(BUTTON_DELETE, 'submit', 'name="multi_delete"').'&nbsp;'.xtc_button(BUTTON_MOVE, 'submit', 'name="multi_move"').'&nbsp;'.xtc_button(BUTTON_COPY, 'submit', 'name="multi_copy"'));
            $contents[] = array('align' => 'center', 'text' => '<input type="submit" class="button" name="multi_status_on" onClick="this.blur();" value="'. BUTTON_STATUS_ON . '">&nbsp;<input type="submit" class="button" onClick="this.blur();" name="multi_status_off" value="' . BUTTON_STATUS_OFF . '">');
            $contents[] = array('text'  => '</form>');            
            //Single Product Actions

            $contents[] = array('align' => 'center', 'text' => '<div style="padding-top: 5px; font-weight: bold; width: 90%; border-top: 1px solid Black; margin-top: 5px;">' . TEXT_ACTIVE_ELEMENT . '</div>');


            $contents[] = array
            (
                'align' => 'center',
                 'text' =>


                '<form action="' . xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('cPath', 'action', 'pID', 'cID')) . 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=new_product') . '"  method="post">'
                .'<input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_EDIT . '">'
                .'</form>'


                .'<form action="' . xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('cPath', 'action', 'pID', 'cID')) . 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=productimages') . '"  method="post">'
                .'<input type="submit" class="button" onClick="this.blur();" value="Bilder Bearbeiten">'
                .'</form>'

                .'<form action="' . FILENAME_NEW_ATTRIBUTES . '" name="edit_attributes" method="post">'
                .'<input type="hidden" name="action" value="edit">'
                .'<input type="hidden" name="current_product_id" value="' . $pInfo->products_id . '">'
                .'<input type="hidden" name="cpath" value="' . $cPath . '">'
                .'<input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_EDIT_ATTRIBUTES . '">'
                .'</form>'


                .'<form action="' . FILENAME_CATEGORIES . '" name="edit_crossselling" method="GET">'
                .'<input type="hidden" name="action" value="edit_crossselling">'
                .'<input type="hidden" name="current_product_id" value="' . $pInfo->products_id . '">'
                .'<input type="hidden" name="cpath" value="' . $cPath  . '">'
                .'<input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_EDIT_CROSS_SELLING . '">'
                .'</form>'




                );



            //Insert new Element Actions
            $contents[] = array('align' => 'center', 'text' => '<div style="padding-top: 5px; font-weight: bold; width: 90%; border-top: 1px solid Black; margin-top: 5px;">' . TEXT_INSERT_ELEMENT . '</div>');

            if (!$_GET['search']) 
            {
            	$contents[] = array('align' => 'center', 'text' => '<a class="button" onClick="this.blur()" href="' . xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('cPath', 'action', 'pID', 'cID')) . 'cPath=' . $cPath . '&action=new_category') . '">' . BUTTON_NEW_CATEGORIES . '</a> <a class="button" onClick="this.blur()" href="' . xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('cPath', 'action', 'pID', 'cID')) . 'cPath=' . $cPath . '&action=new_product') . '">' . BUTTON_NEW_PRODUCTS . '</a>');            
            }            



            //Informations
            $contents[] = array('align' => 'center', 'text' => '<div style="padding-top: 5px; font-weight: bold; width: 90%; border-top: 1px solid Black; margin-top: 5px;">' . TEXT_INFORMATIONS . '</div>');
            $contents[] = array('text'  => '<div style="padding-left: 30px;">' . TEXT_DATE_ADDED . ' ' . xtc_date_short($pInfo->products_date_added) . '</div>');
            if (xtc_not_null($pInfo->products_last_modified))    $contents[] = array('text' => '<div style="padding-left: 30px;">' . TEXT_LAST_MODIFIED . '&nbsp;' . xtc_date_short($pInfo->products_last_modified) . '</div>');
            if (date('Y-m-d') < $pInfo->products_date_available) $contents[] = array('text' => '<div style="padding-left: 30px;">' . TEXT_DATE_AVAILABLE . ' ' . xtc_date_short($pInfo->products_date_available) . '</div>');            
            
            // START IN-SOLUTION Berechung des Bruttopreises
            $price = $pInfo->products_price;
            $price = xtc_round($price,PRICE_PRECISION);
            $price_string = '' . TEXT_PRODUCTS_PRICE_INFO . '&nbsp;' . $currencies->format($price);
            if (PRICE_IS_BRUTTO=='true' && ($_GET['read'] == 'only' || $_GET['action'] != 'new_product_preview') ){
                $price_netto = xtc_round($price,PRICE_PRECISION);
                $tax_query = xtc_db_query("select tax_rate from " . TABLE_TAX_RATES . " where tax_class_id = '" . $pInfo->products_tax_class_id . "' ");
                $tax = xtc_db_fetch_array($tax_query);
                $price = ($price*($tax[tax_rate]+100)/100);
                $price_string = '' . TEXT_PRODUCTS_PRICE_INFO . '&nbsp;' . $currencies->format($price) . ' - ' . TXT_NETTO . $currencies->format($price_netto);
            }
            $contents[] = array('text' => '<div style="padding-left: 30px;">' . $price_string.  '</div><div style="padding-left: 30px;">' . TEXT_PRODUCTS_DISCOUNT_ALLOWED_INFO . '&nbsp;' . $pInfo->products_discount_allowed . '</div><div style="padding-left: 30px;">' .  TEXT_PRODUCTS_QUANTITY_INFO . '&nbsp;' . $pInfo->products_quantity . '</div>');            
            // END IN-SOLUTION

            //$contents[] = array('text' => '<br />' . TEXT_PRODUCTS_PRICE_INFO . ' ' . $currencies->format($pInfo->products_price) . '<br />' . TEXT_PRODUCTS_QUANTITY_INFO . ' ' . $pInfo->products_quantity);
            $contents[] = array('text' => '<div style="padding-left: 30px; padding-bottom: 10px;">' . TEXT_PRODUCTS_AVERAGE_RATING . ' ' . number_format($pInfo->average_rating, 2) . ' %</div>');
            $contents[] = array('text' => '<div style="padding-left: 30px; padding-bottom: 10px;">' . TEXT_PRODUCT_LINKED_TO . '<br />' . xtc_output_generated_category_path($pInfo->products_id, 'product') . '</div>');
            $contents[] = array('align' => 'center', 'text' => '<div style="padding: 10px;">' . xtc_product_thumb_image($pInfo->products_image, $pInfo->products_name)  . '</div><div style="padding-bottom: 10px;">' . $pInfo->products_image.'</div>');
          }          
        } else { 
          // create category/product info
          $heading[] = array('text' => '<b>' . EMPTY_CATEGORY . '</b>');
          $contents[] = array('text' => sprintf(TEXT_NO_CHILD_CATEGORIES_OR_PRODUCTS, xtc_get_categories_name($current_category_id, $_SESSION['languages_id'])));
          $contents[] = array('align' => 'center', 'text' => '<BR /><a class="button" onClick="this.blur()" href="' . xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('cPath', 'action', 'pID', 'cID')) . 'cPath=' . $cPath . '&action=new_category') . '">' . BUTTON_NEW_CATEGORIES . '</a>&nbsp;<a class="button" onClick="this.blur()" href="' . xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('cPath', 'action', 'pID', 'cID')) . 'cPath=' . $cPath . '&action=new_product') . '">' . BUTTON_NEW_PRODUCTS . '</a><BR /><BR />');
        }
        break;
    }

    if ((xtc_not_null($heading)) && (xtc_not_null($contents))) {
      //display info box
      echo '<td width="265" valign="top" style="padding-left: 5px;">' . "\n";
      $box = new box;
      echo $box->infoBox($heading, $contents);
      echo '</td>' . "\n";
    }
?>

        </tr>
        </table>
     </td>
    </tr>
    <tr>
     <td>
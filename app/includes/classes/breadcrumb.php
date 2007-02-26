<?php
/* -----------------------------------------------------------------------------------------
   $Id: breadcrumb.php 899 2005-04-29 02:40:57Z hhgag $   

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(breadcrumb.php,v 1.3 2003/02/11); www.oscommerce.com 
   (c) 2003	 nextcommerce (breadcrumb.php,v 1.5 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  class breadcrumb {
    var $_trail;

    function breadcrumb() {
      $this->reset();
    }

    function reset() {
      $this->_trail = array();
    }

    function add($title, $link = '') {
      $this->_trail[] = array('title' => $title, 'link' => $link);
    }

    function trail($separator = ' - ') {
      $trail_string = '';

      for ($i=0, $n=sizeof($this->_trail); $i<$n; $i++) {
        if (isset($this->_trail[$i]['link']) && xtc_not_null($this->_trail[$i]['link'])) {
          $trail_string .= '<a href="' . $this->_trail[$i]['link'] . '" class="headerNavigation">' . $this->_trail[$i]['title'] . '</a>';
        } else {
          $trail_string .= $this->_trail[$i]['title'];
        }

        if (($i+1) < $n) $trail_string .= $separator;
      }

      return $trail_string;
    }
    
        // Begin Econda-Monitor

    function econda() { // for drill-down

      $econda_string = '';

      for ($i=1, $n=sizeof($this->_trail); $i<$n; $i++) {

        $econda_string .= $this->_trail[$i]['title'];

        if (($i+1) < $n) $econda_string .= '/';

      }

      return $econda_string;

    }

    function addCategory ($cPath_array=array())
    {
        if (isset ($cPath_array)) 
        {
            $p;
            for ($i = 0, $n = sizeof($cPath_array); $i < $n; $i ++) 
            {
                if (GROUP_CHECK == 'true') 
                {
                    $group_check = "and c.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
                }
                $categories_query = xtDBquery("select
                    cd.categories_name
                    from ".TABLE_CATEGORIES_DESCRIPTION." cd,
                    ".TABLE_CATEGORIES." c
                    where cd.categories_id = '".$cPath_array[$i]."'
                    and c.categories_id=cd.categories_id
                    ".$group_check."
                    and cd.languages_id='".(int) $_SESSION['languages_id']."'");
                if (xtc_db_num_rows($categories_query,true) > 0) 
                {
                    $categories = xtc_db_fetch_array($categories_query,true);
                    $p.="/".$cPath_array[$i];
                    $this->add($categories['categories_name'], "/catalog".$p);
                
                } 
                else 
                {
                    break;
                }
            }
        }
        elseif (xtc_not_null($_GET['manufacturers_id'])) 
        {
            $manufacturers_query = xtDBquery("select manufacturers_name from ".TABLE_MANUFACTURERS." where manufacturers_id = '".(int) $_GET['manufacturers_id']."'");
            $manufacturers = xtc_db_fetch_array($manufacturers_query, true);
        
            $this->add($manufacturers['manufacturers_name'], xtc_href_link(FILENAME_DEFAULT, xtc_manufacturer_link((int) $_GET['manufacturers_id'], $manufacturers['manufacturers_name'])));
        
        }
    }

    // End Econda-Monitor
    
  }
?>
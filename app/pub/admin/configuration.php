

<?php
/* --------------------------------------------------------------
   $Id: configuration.php 1125 2005-07-28 09:59:44Z novalis $   

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(configuration.php,v 1.40 2002/12/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (configuration.php,v 1.16 2003/08/19); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

    require('includes/application_top.php');

    if($_GET['action']=='save') 
    {
        $configuration_query = xtc_db_query("select configuration_key,configuration_id, configuration_value, use_function,set_function from " . TABLE_CONFIGURATION . " where configuration_group_id = '" . (int)$_GET['gID'] . "' order by sort_order");
        while ($configuration = xtc_db_fetch_array($configuration_query))
        {
            if(array_key_exists($configuration['configuration_key'],$_POST))
            {
                $q=$db->prepare("UPDATE ".TABLE_CONFIGURATION." SET configuration_value=? where configuration_key=?");
                $q->execute(array($_POST[$configuration['configuration_key']],$configuration['configuration_key']));
            }
        }
        if($_GET['ajax']!='true')
        {
            xtc_redirect(FILENAME_CONFIGURATION. '?gID=' . (int)$_GET['gID']);
        }
    }

  $cfg_group_query = xtc_db_query("select configuration_group_title from " . TABLE_CONFIGURATION_GROUP . " where configuration_group_id = '" . (int)$_GET['gID'] . "'");
  $cfg_group = xtc_db_fetch_array($cfg_group_query);
?>
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<h1><?php echo $cfg_group['configuration_group_title']; ?></h1>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td></td>
      </tr>
      <tr>
        <td style="border-top: 3px solid; border-color: #cccccc;" class="main"><table border="0" width="100%" cellspacing="0" cellpadding="0">          
          <tr>
            <td valign="top" align="right">
            
<?php echo xtc_draw_form('configuration', FILENAME_CONFIGURATION, 'gID=' . (int)$_GET['gID'] . '&action=save'); ?>
            <table width="100%"  border="0" cellspacing="0" cellpadding="4">
<?php
  $configuration_query = xtc_db_query("select configuration_key,configuration_id, configuration_value, use_function,set_function from " . TABLE_CONFIGURATION . " where configuration_group_id = '" . (int)$_GET['gID'] . "' order by sort_order");

  while ($configuration = xtc_db_fetch_array($configuration_query)) {

    if (xtc_not_null($configuration['use_function'])) {
      $use_function = $configuration['use_function'];
      if (ereg('->', $use_function)) {
        $class_method = explode('->', $use_function);
        if (!is_object(${$class_method[0]})) {
          include(DIR_WS_CLASSES . $class_method[0] . '.php');
          ${$class_method[0]} = new $class_method[0]();
        }
        $cfgValue = xtc_call_function($class_method[1], $configuration['configuration_value'], ${$class_method[0]});
      } else {
        $cfgValue = xtc_call_function($use_function, $configuration['configuration_value']);
      }
    } else {
      $cfgValue = $configuration['configuration_value'];
    }

    if (((!$_GET['cID']) || (@$_GET['cID'] == $configuration['configuration_id'])) && (!$cInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
      $cfg_extra_query = xtc_db_query("select configuration_key,configuration_value, date_added, last_modified, use_function, set_function from " . TABLE_CONFIGURATION . " where configuration_id = '" . $configuration['configuration_id'] . "'");
      $cfg_extra = xtc_db_fetch_array($cfg_extra_query);

      $cInfo_array = xtc_array_merge($configuration, $cfg_extra);
      $cInfo = new objectInfo($cInfo_array);
    }
    if ($configuration['set_function']) {
        eval('$value_field = ' . $configuration['set_function'] . '"' . htmlspecialchars($configuration['configuration_value']) . '");');
      } else {
        $value_field = xtc_draw_input_field($configuration['configuration_key'], $configuration['configuration_value'],'size=40');
      }
   // add

   if (strstr($value_field,'configuration_value')) $value_field=str_replace('configuration_value',$configuration['configuration_key'],$value_field);




   echo '
  <tr>
    <td width="300" valign="top" class="dataTableContent"><b>'.constant(strtoupper($configuration['configuration_key'].'_TITLE')).'</b></td>
    <td valign="top" class="dataTableContent">
    <table width="100%"  border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td style="background-color:#FCF2CF ; border: 1px solid; border-color: #CCCCCC;" class="dataTableContent">'.$value_field.'</td>
      </tr>
    </table>
    <br />'.constant(strtoupper( $configuration['configuration_key'].'_DESC')).'</td>
  </tr>
  ';

  }
?>
            </table>
<?php echo '<input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_SAVE . '"/>'; ?></form>
            </td>

          </tr>
        </table></td>
      </tr>
    </table>
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>

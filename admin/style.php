<?php 

require('includes/application_top.php'); 





if ($_POST['action']=="save") 
{

    $configuration_query = xtc_db_query("select configuration_key,configuration_id, configuration_value, use_function,set_function from " . TABLE_CONFIGURATION . " where configuration_group_id ='666' order by sort_order");

    while ($configuration = xtc_db_fetch_array($configuration_query))
    {
        xtc_db_query("UPDATE ".TABLE_CONFIGURATION." SET configuration_value='".$_POST[$configuration['configuration_key']]."' where configuration_key='".$configuration['configuration_key']."'");

    }


    xtc_redirect("/admin/style.php");

}


?>
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<h1>Style</h1>

        <form name="configuration" action="/admin/style.php" method="post">
        <input type="hidden" name="action" value="save" />
        <table width="100%"  border="0" cellspacing="0" cellpadding="4">

 <tr>
    <td width="300" valign="top" class="dataTableContent"><b>Templateset (Theme)</b></td>
    <td valign="top" class="dataTableContent">
    <table width="100%"  border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td style="background-color:#FCF2CF ; border: 1px solid; border-color: #CCCCCC;" class="dataTableContent">


<?php
    if ($dir = opendir(DIR_FS_CATALOG.'../templates/')) {
        while (($templates = readdir($dir)) !== false) 
        {
            if (is_dir(DIR_FS_CATALOG.'../templates/'."//".$templates) and ($templates != "CVS") and ($templates != ".") and ($templates != "..")) {
                $templates_array[] = array ('id' => $templates, 'text' => $templates);
            }
        }
        closedir($dir);
        sort($templates_array);
        echo xtc_draw_pull_down_menu("CURRENT_TEMPLATE", $templates_array, CURRENT_TEMPLATE);
    }
?>


        </td>
      </tr>
    </table>
    <br />W&auml;hlen Sie ein Templateset (Theme) aus. Das Theme muss sich im Ordner www.Ihre-Domain.com/templates/ befinden.<br />
  </tr>


 <tr>
    <td width="300" valign="top" class="dataTableContent"><b>CSS Variant</b></td>
    <td valign="top" class="dataTableContent">
    <table width="100%"  border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td style="background-color:#FCF2CF ; border: 1px solid; border-color: #CCCCCC;" class="dataTableContent">


<?php

    $cssdir= DIR_FS_CATALOG.'../templates/'.CURRENT_TEMPLATE.'/variant/css/';

    if ($dir = opendir($cssdir)) 
    {
        while (($templates = readdir($dir)) !== false) 
        {
            if (
                    is_file($cssdir.'/'.$templates) and #
                        ($templates != "CVS") and 
                        ($templates != ".") and 
                        ($templates != "..") and
                        (!beginswith($templates,"condome_"))
                ) 
            {
                $csss_array[] = array ('id' => $templates, 'text' => $templates);
            }
        }
        closedir($dir);
        sort($csss_array);
        echo xtc_draw_pull_down_menu("CURRENT_CSS", $csss_array, CURRENT_CSS);
    }
?>



</td>
      </tr>
    </table>
    <br />W&auml;hlen Sie eine Variante.<br />
  </tr>
  

 <tr>
    <td width="300" valign="top" class="dataTableContent"><b>Hintergrund</b></td>
    <td valign="top" class="dataTableContent">
    <table width="100%"  border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td style="background-color:#FCF2CF ; border: 1px solid; border-color: #CCCCCC;" class="dataTableContent">

<?php

    $backdir= DIR_FS_CATALOG.'../templates/'.CURRENT_TEMPLATE.'/variant/background/';

    if ($dir = opendir($backdir)) {
        while (($templates = readdir($dir)) !== false) {
            if (is_file($backdir.'/'.$templates) and ($templates != "CVS") and ($templates != ".") and ($templates != "..")) {
                $back_array[] = array ('id' => $templates, 'text' => $templates);
            }
        }
        closedir($dir);
        sort($back_array);
        echo xtc_draw_pull_down_menu("CURRENT_BACKGROUND", $back_array, CURRENT_BACKGROUND);
    }
?>
</td>
      </tr>
    </table>
    <br />W&auml;hlen Sie ein Hintergrundbild.<br />
  </tr>
  


 <tr>
    <td width="300" valign="top" class="dataTableContent"><b>Logo</b></td>
    <td valign="top" class="dataTableContent">
    <table width="100%"  border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td style="background-color:#FCF2CF ; border: 1px solid; border-color: #CCCCCC;" class="dataTableContent">
<?php

    $logodir= DIR_FS_CATALOG.'../templates/'.CURRENT_TEMPLATE.'/variant/logo/';

    if ($dir = opendir($logodir)) {
        while (($templates = readdir($dir)) !== false) {
            if (is_file($logodir.'/'.$templates) and ($templates != "CVS") and ($templates != ".") and ($templates != "..")) {
                $logo_array[] = array ('id' => $templates, 'text' => $templates);
            }
        }
        closedir($dir);
        sort($logo_array);
        echo xtc_draw_pull_down_menu("CURRENT_LOGO", $logo_array, CURRENT_LOGO);
    }
?>
</td>
      </tr>
    </table>
    <br />W&auml;hlen Sie ein Logo<br />
  </tr>
  



        </table>
<input type="submit" class="button" onClick="this.blur();" value="Speichern"/>

        </form>



</table>

<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
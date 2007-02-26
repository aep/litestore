<?php 

require('includes/application_top.php'); 





if ($_GET['action']=="save") 
{

    print_r($_POST);

    $configuration_query = xtc_db_query("select configuration_key,configuration_id, configuration_value, use_function,set_function from " . TABLE_CONFIGURATION . " where configuration_group_id ='667' order by sort_order");

    while ($configuration = xtc_db_fetch_array($configuration_query))
    {
        xtc_db_query("UPDATE ".TABLE_CONFIGURATION." SET configuration_value='".$_POST[$configuration['configuration_key']]."' where configuration_key='".$configuration['configuration_key']."'");

    }


    xtc_redirect("/admin/adsense.php");

}


?>
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<h1>Google adsense (tm)</h1>



        <form name="configuration" action="/admin/adsense.php?action=save" method="post">            
        <table width="100%"  border="0" cellspacing="0" cellpadding="4">



 <tr>
    <td width="300" valign="top" class="dataTableContent"><b>Adsense aktivieren</b></td>
    <td valign="top" class="dataTableContent">
    <table width="100%"  border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td style="background-color:#FCF2CF ; border: 1px solid; border-color: #CCCCCC;" class="dataTableContent">
            <input type="checkbox" name="ADSENSE_ACTIVE" <?php if (ADSENSE_ACTIVE=="on") echo 'checked="checked"'; ;?>  >aktivieren</input>
        </td>
      </tr>
    </table><br />
  </tr>


 <tr>
    <td width="300" valign="top" class="dataTableContent"><b>Publisher-ID (zB. pub-1234567891234345)</b></td>
    <td valign="top" class="dataTableContent">
    <table width="100%"  border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td style="background-color:#FCF2CF ; border: 1px solid; border-color: #CCCCCC;" class="dataTableContent">
            <input type="text" name="ADSENSE_PUBID" value="<?php echo ADSENSE_PUBID ;?>"  ></input>
        </td>
      </tr>
    </table>
    <br />Geben Sie ihre Google adsense  Publisher-ID id ein<br />
  </tr>


 <tr>
    <td width="300" valign="top" class="dataTableContent"><b>Slot</b></td>
    <td valign="top" class="dataTableContent">
    <table width="100%"  border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td style="background-color:#FCF2CF ; border: 1px solid; border-color: #CCCCCC;" class="dataTableContent">

            <input type="text" name="ADSENSE_SLOT" value="<?php echo ADSENSE_SLOT ;?>"  ></input>

</td>
      </tr>
    </table>
    <br />Geben sie die ID des Anzeigeblocks ein.<br />
  </tr>
  



        </table>
<input type="submit" class="button" onClick="this.blur();" value="Speichern"/>

        </form>



<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
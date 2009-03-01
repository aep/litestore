<?php
require('includes/application_top.php');
require(DIR_WS_INCLUDES . 'header.php');

if ($_POST['set_metatags']) 
{
    foreach ($_POST['set_metatags'] as $mi=>$mt)
    {
        if($mt['delete']!='')
        {
                xtc_db_query("delete from `metatags` where id='".$mi."'");
        }
        else if($mt['name']!='')
        {
            if($mi=='new')
            {
                xtc_db_query("insert into `metatags` (`name`,`content`) values  ('".$mt['name']."' ,'".$mt['content']."')");
            }
            else
            {
                xtc_db_query("update `metatags` set `name`='".$mt['name']."' , `content`='".$mt['content']."' where id='".$mi."'");
            }
        }
    }}






echo '<form action="metatags.php" method="post" ><input type="hidden" name="newfields" value="'.$newfields.'"> 
    <table><tr><th>Name</th><th>Content</th><th></th></tr>';

$cfg_group_query = xtc_db_query('select id,name,content from metatags');while($cfg = xtc_db_fetch_array($cfg_group_query))
{
    echo '
    <tr>
        <td width="300" valign="top" class="dataTableContent">'.xtc_draw_input_field('set_metatags['.$cfg['id'].'][name]',$cfg['name'],'size=50').'</b></td>
        <td class="dataTableContent">'.xtc_draw_input_field('set_metatags['.$cfg['id'].'][content]',$cfg['content'],'size=50').'</td>
        <td><input type="checkbox" name="set_metatags['.$cfg['id'].'][delete]" value="delete"> entfernen</td>
    </tr>
    ';
}

    echo '
    <tr>
        <td colspan="3">Hinzuf&uuml;gen:</td>
    </tr>
    <tr>
        <td width="300" valign="top" class="dataTableContent">'.xtc_draw_input_field('set_metatags[new][name]','','size=50').'</b></td>
        <td class="dataTableContent">'.xtc_draw_input_field('set_metatags[new][content]','','size=50').'</td>
        <td></td>

    </tr>
    ';


echo '</table>';
echo '<input name="button_save" type="submit" class="button" onClick="this.blur();" value="' . BUTTON_SAVE . '">';
echo '</form>';


require(DIR_WS_INCLUDES . 'footer.php');
require(DIR_WS_INCLUDES . 'application_bottom.php'); 

?>

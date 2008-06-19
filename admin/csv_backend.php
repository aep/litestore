<?php
    require('includes/application_top.php');
    define('FILENAME_CSV_BACKEND','csv_backend.php');





    $schemes;
    $dir = opendir(DIR_WS_INCLUDES.'/scheme/');
    while (($scheme = readdir($dir)) !== false)
    {
        if (is_file(DIR_WS_INCLUDES.'/scheme/'.$scheme) && endswith($scheme,'.xq')) 
        {
            $schemes[] = substr ( $scheme , 0 ,strlen($scheme)-3);
        }
    }
    closedir($dir);
    sort($schemes);


    require(DIR_WS_INCLUDES . 'header.php'); 
?>
<h1>Import</h1>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td>
<pre>
<?php 
    if( isset ( $_FILES["file_upload"])  &&  $_FILES["file_upload"]["name"] )
    {
        if($_POST['scheme'] && in_array ( $_POST['scheme'] , $schemes ) )
        {
            $vengeance="/home/aep/cpp/vengeance/vengeance";
            $o=array();
            echo "<pre>";
            system(
                $vengeance." transform  ".getcwd()."/". DIR_WS_INCLUDES.'/scheme/'.$_POST['scheme'].".xq < ".$_FILES["file_upload"]["tmp_name"] ."  "
                ." | ".$vengeance." import  QMYSQL://".DB_SERVER_USERNAME.":".DB_SERVER_PASSWORD."@".DB_SERVER."/".DB_DATABASE." ",$o);
            if($o!=0)
                echo "<font color=\"red\"> Import failed, please contact the system administrator</font>";
            echo "</pre>";
        }
        else
        {
            die("unknown scheme");
        }
    }
?>
</pre>


<table class="dataTableHeadingContent" width="100%"  border="0" cellspacing="2" cellpadding="0">
    <tr>
        <td width="7%"></td>
        <td width="93%" class="infoBoxHeading">Bitte w&auml;hlen Sie eine xml Datei zum hochladen und ein Umformungsschmema.</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>

            <form name="upload" action="/admin/csv_backend.php?action=upload" method="POST" enctype="multipart/form-data">
                <input type="file" name="file_upload">
                <br/>
                <br/>
                Schema: 
                <select  name="scheme">
                    <?php foreach($schemes as $scheme) {?>
                    <option  value="<?php echo $scheme;?>"><?php echo $scheme;?></option>
                    <?php } ?>
                </select>
                <br/>
                <br/>
                <input type="submit" class="button" value="import"/>
            </form>
        </td>
    </tr>
</table>
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
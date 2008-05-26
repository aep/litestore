<?php
/* --------------------------------------------------------------
   $Id: csv_backend.php 1030 2005-07-14 20:22:32Z novalis $

   ReStore - an XT-Commerce fork to restore sanity
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercecoding standards (a typical file) www.oscommerce.com

   Released under the GNU General Public License
   --------------------------------------------------------------*/

    require('includes/application_top.php');
    require(DIR_WS_CLASSES . 'import.php');
    require_once(DIR_FS_INC . 'xtc_format_filesize.inc.php');

    define('FILENAME_CSV_BACKEND','csv_backend.php');





    $schemes;
    $dir = opendir(DIR_WS_INCLUDES.'/scheme/');
    while (($scheme = readdir($dir)) !== false)
    {
        if (is_file(DIR_WS_INCLUDES.'/scheme/'.$scheme) && endswith($scheme,'.php')) 
        {
            $schemes[] = substr ( $scheme , 0 ,strlen($scheme)-4);
        }
    }
    closedir($dir);
    sort($schemes);


    if( isset ( $_FILES["file_upload"])  &&  $_FILES["file_upload"]["name"] )
    {
        if($_POST['scheme'] && in_array ( $_POST['scheme'] , $schemes ) )
        {
            $h= new reImportExport();
            require(DIR_WS_INCLUDES."/scheme/".$_POST['scheme'].".php");

            $h->setScheme($scheme);
            $h->setSchemeName($_GET['scheme']);
            $h->setFormat("csv");

            $result=$h->import($_FILES["file_upload"]["tmp_name"]);
        }
        else
        {
            die("unknown scheme");
        }
    }






    require(DIR_WS_INCLUDES . 'header.php'); 
?>
<h1>Import</h1>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td>

<?php 
    if (isset($result)) 
    {
        echo "<h4>Ergebnis:</h4><br/>";
        echo "<table style=\"width:20%\">";
        echo "<tr><td>Updates:</td><td> ".$result[0]["update"]."</td></tr>";
        echo "<tr><td>Neue:</td><td> ".$result[0]["new"]."</td></tr>";
        echo "</table><br/>";

        if( isset ($result[1]))
        {
            echo "<h4>Fehler:</h4><br/>";
            foreach($result[1] as $err)
                echo $err."<br/>";
        }
    }
?>



<table width="100%"  border="0" cellspacing="5" cellpadding="0">
  <tr>
    <td class="dataTableHeadingContent">
      <table width="100%"  border="0" cellspacing="2" cellpadding="0">
        <tr>
          <td width="7%"></td>
          <td width="93%" class="infoBoxHeading">Eine CSV datei ausw&auml;hlen.  Trennzeichen ist Tab (\t) und Texterkennungszeichen "</td>
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
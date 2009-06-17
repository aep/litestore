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


    if($_GET['scheme'] && in_array ( $_GET['scheme'] , $schemes ) )
    {
        header("Content-Disposition: attachment");
        $handler = new reImportExport();

        require(DIR_WS_INCLUDES."/scheme/".$_GET['scheme'].".php");
        $handler->setScheme($scheme);
        $handler->setSchemeName($_GET['scheme']);

        if($_GET['format']=='xml')
        {
            header('Content-type: text/xml');
            $handler->setFormat("xml");
        }
        else
        {
            header('Content-type: text/plain');
            $handler->setFormat("csv");
        }

        echo $handler->export();
        return;
    }


require(DIR_WS_INCLUDES . 'header.php');
?>
<h1>Export</h1>

<p>
    Eine Datei w&auml;hlen zum herunterladen.
</p>
<p>
    <h6>CSV</h6>
    <ul>
        <?php foreach($schemes as $scheme) {?>
        <li><a href="/admin/export/<?php echo $scheme;?>.csv" ><?php echo $scheme;?>.csv</a></li>
        <?php }; ?>
    </ul>
</p>
<p>
    <h6>xml</h6>
    <ul>
        <?php foreach($schemes as $scheme) {?>
        <li><a href="/admin/export/<?php echo $scheme;?>.xml" ><?php echo $scheme;?>.xml</a></li>
        <?php }; ?>
    </ul>
<p>
<?php 
require(DIR_WS_INCLUDES . 'footer.php'); 
require(DIR_WS_INCLUDES . 'application_bottom.php'); 
?>

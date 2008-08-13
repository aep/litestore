<?php
/*********************************************************************************************************
 This code is part of the FileManager software (www.gerd-tentler.de/tools/filemanager), copyright by
 Gerd Tentler. Obtain permission before selling this code or hosting it on a commercial website or
 redistributing it over the Internet or in any other medium. In all cases copyright must remain intact.
*********************************************************************************************************/
defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');
  error_reporting(E_WARNING);

//========================================================================================================
// Start session and get session variables; needs PHP 4 or higher
//========================================================================================================

  if(function_exists('session_start')) session_start();

  $fmCurDir = $_SESSION['fmCurDir'];

//========================================================================================================
// Set variables, if they are not registered globally; needs PHP 4.1.0 or higher
//========================================================================================================

  if(isset($_REQUEST['file'])) $file = $_REQUEST['file'];

  if(isset($_SERVER['HTTP_HOST'])) $HTTP_HOST = $_SERVER['HTTP_HOST'];

//========================================================================================================
// Includes
//========================================================================================================

  if($HTTP_HOST == 'localhost' || $HTTP_HOST == '127.0.0.1' || ereg('^192\.168\.0\.[0-9]+$', $HTTP_HOST)) {
    include('config_local.inc.php');
  }
  else {
    include('config_main.inc.php');
  }

  if(!isset($language)) $language = 'en';
  include("languages/lang_$language.inc");
  include('fmlib.inc.php');

//========================================================================================================
// Main
//========================================================================================================

  // make sure that filename contains no path
  $file = basename($file);

  $filename = $file;

  if($ftp_server) {
    if($ftp = fm_connect()) {
      $file = fm_get("$fmCurDir/$file");
      @ftp_quit($ftp);
    }
  }
  else $file = "$fmCurDir/$file";

  if(file_exists($file)) {
    if($replSpacesDownload) $filename = str_replace(' ', '_', $filename);
    if($lowerCaseDownload) $filename = strtolower($filename);

    header('Content-Type: application/octetstream');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');
    readfile($file);
  }
  else {
?>
    <html>
    <head>
    <link rel="stylesheet" href="filemanager.css" type="text/css">
    </head>
    <body>
<?php
    fm_view_error($msg['errOpen'] . ": $filename");
?>
    </body>
    </html>
<?php
  }
?>

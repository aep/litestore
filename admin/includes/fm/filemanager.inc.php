<?php
/*
 +-------------------------------------------------------------------+
 |                     F I L E M A N A G E R   (v3.2)                |
 |                                                                   |
 | Copyright Gerd Tentler               www.gerd-tentler.de/tools    |
 | Created: Dec. 7, 2006                Last modified: Mar. 30, 2008 |
 +-------------------------------------------------------------------+
 | This program may be used and hosted free of charge by anyone for  |
 | personal purpose as long as this copyright notice remains intact. |
 |                                                                   |
 | Obtain permission before selling the code for this program or     |
 | hosting this software on a commercial website or redistributing   |
 | this software over the Internet or in any other medium. In all    |
 | cases copyright must remain intact.                               |
 +-------------------------------------------------------------------+
*/


defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');


error_reporting(E_WARNING);

//========================================================================================================
// Set variables, if they are not registered globally; needs PHP 4.1.0 or higher
//========================================================================================================

  if(isset($_REQUEST['fmMode'])) $fmMode = $_REQUEST['fmMode'];
  if(isset($_REQUEST['fmObject'])) $fmObject = $_REQUEST['fmObject'];
  if(isset($_REQUEST['fmSortField'])) $fmSortField = $_REQUEST['fmSortField'];
  if(isset($_REQUEST['fmSortOrder'])) $fmSortOrder = $_REQUEST['fmSortOrder'];
  if(isset($_REQUEST['fmChangeDir'])) $fmChangeDir = $_REQUEST['fmChangeDir'];
  if(isset($_REQUEST['fmEdit'])) $fmEdit = $_REQUEST['fmEdit'];
  if(isset($_REQUEST['fmDelFile'])) $fmDelFile = $_REQUEST['fmDelFile'];
  if(isset($_REQUEST['fmRemDir'])) $fmRemDir = $_REQUEST['fmRemDir'];
  if(isset($_REQUEST['fmSent'])) $fmSent = $_REQUEST['fmSent'];
  if(isset($_REQUEST['fmText'])) $fmText = $_REQUEST['fmText'];
  if(isset($_REQUEST['fmName'])) $fmName = $_REQUEST['fmName'];
  if(isset($_REQUEST['fmPerms'])) $fmPerms = $_REQUEST['fmPerms'];
  if(isset($_REQUEST['fmReplSpaces'])) $fmReplSpaces = $_REQUEST['fmReplSpaces'];
  if(isset($_REQUEST['fmLowerCase'])) $fmLowerCase = $_REQUEST['fmLowerCase'];

  if(isset($_FILES['fmFile'])) $fmFile = $_FILES['fmFile'];

  if(isset($_SERVER['PHP_SELF'])) $PHP_SELF = $_SERVER['PHP_SELF'];
  if(isset($_SERVER['HTTP_HOST'])) $HTTP_HOST = $_SERVER['HTTP_HOST'];

//========================================================================================================
// Get / set session variables; needs PHP 4 or higher
//========================================================================================================

  if(!isset($fmSortField)) $fmSortField = $_SESSION['fmSortField'];
  else $_SESSION['fmSortField'] = $fmSortField;

  if(!isset($fmSortOrder)) $fmSortOrder = $_SESSION['fmSortOrder'];
  else $_SESSION['fmSortOrder'] = $fmSortOrder;

  if(!isset($fmChangeDir)) $fmChangeDir = $_SESSION['fmChangeDir'];
  else $_SESSION['fmChangeDir'] = $fmChangeDir;

  $fmCurDir = $_SESSION['fmCurDir'];

//========================================================================================================
// Make sure that file and directory names contain no path and initialize variables
//========================================================================================================

  $fmEdit = basename($fmEdit);
  $fmDelFile = basename($fmDelFile);
  $fmRemDir = basename($fmRemDir);
  $fmChangeDir = basename($fmChangeDir);

  $fmError = '';
  $fmPrevDir = '';

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
  require("languages/lang_$language.inc");
  include('fmlib.inc.php');

//========================================================================================================
// Main
//========================================================================================================
?>
<script language="JavaScript" src="<?php echo $fmWebPath; ?>/filemanager.js"></script>
<link rel="stylesheet" href="<?php echo $fmWebPath; ?>/filemanager.css" type="text/css">
<div id="fmListing" align="<?php echo $fmAlign; ?>" style="margin:<?php echo $fmMargin; ?>px">
<?php
  if($ftp_server == '' && $startDir == '') {
    $fmError = "SECURITY ALERT:<br>Please set a start directory or an FTP server!";
  }
  else {
    if($ftp_server) $ftp = fm_connect();
    else $ftp = false;

    if(!$ftp_server || $ftp) {
      $startDir = str_replace('\\', '/', ($ftp ? $startDir : realpath($startDir)));
      if($ftp && $startDir == '.') $startDir = '';
      if(!$fmCurDir) $fmCurDir = $startDir;
      $fmPrevDir = $fmCurDir;

      if($fmChangeDir) {
        if($fmChangeDir == '..') $fmCurDir = ereg_replace('/[^/]+$', '', $fmCurDir);
        else $fmCurDir .= '/' . $fmChangeDir;
        if(substr($fmCurDir, 0, strlen($startDir)) != $startDir) $fmCurDir = $startDir;
        $_SESSION['fmChangeDir'] = '';
      }
      $_SESSION['fmCurDir'] = $fmCurDir;

      if($fmEdit && $enableEdit) {
        include('edit.inc.php');
      }
      else {
        if($fmMode == 'rename' && $enableRename) {
          if($fmName && $fmObject) {
            if(!fm_rename("$fmCurDir/$fmObject", "$fmCurDir/$fmName")) {
              $fmError = $msg['errRename'] . ": $fmObject &raquo; $fmName";
            }
          }
        }
        else if($fmMode == 'permissions' && $enablePermissions) {
          if($fmPerms && $fmObject) {
            $mode = '0';
            for($i = $cnt = 0; $i < 3; $i++) {
              for($j = $sum = 0; $j < 3; $j++) $sum += $fmPerms[$cnt++];
              $mode .= $sum;
            }
            if(!fm_chmod("$fmCurDir/$fmObject", $mode)) $fmError = $msg['errPermChange'] . ": $fmObject";
          }
        }
        else if($fmMode == 'newDir' && $enableNewDir) {
          if($fmName) {
            if(!fm_mkdir("$fmCurDir/$fmName")) $fmError = $msg['errDirNew'] . ": $fmName";
            else if($defaultDirPermissions) {
              if(!fm_chmod("$fmCurDir/$fmName", $defaultDirPermissions)) {
                $fmError = $msg['errPermChange'] . ": $fmName";
              }
            }
          }
        }
        else if($fmMode == 'newFile' && $enableUpload) {
          if($fmFile) {
            for($i = 0; $i < count($fmFile['size']); $i++) {
              if($fmFile['size'][$i]) {
                $newFile = $fmFile['name'][$i];
                if($fmReplSpaces) $newFile = str_replace(' ', '_', $newFile);
                if($fmLowerCase) $newFile = strtolower($newFile);
                if(!fm_upload($fmFile['tmp_name'][$i], "$fmCurDir/$newFile")) {
                  $fmError .= $msg['errSave'] . ": $newFile<br>";
                }
                else if($defaultFilePermissions) {
                  if(!fm_chmod("$fmCurDir/$newFile", $defaultFilePermissions)) {
                    $fmError .= $msg['errPermChange'] . ": $newFile<br>";
                  }
                }
              }
              else if($fmFile['name'][$i] != '') {
                $fmError .= $msg['error'] . ': ' . $fmFile['name'][$i] . ' = 0 Bytes<br>';
              }
            }
          }
        }
        else if($fmDelFile && $enableDelete) {
          if(!fm_delete("$fmCurDir/$fmDelFile")) $fmError = $msg['errDelete'] . ": $fmDelFile";
        }
        else if($fmRemDir && $enableDelete) {
          if(!fm_rmdir("$fmCurDir/$fmRemDir")) $fmError = $msg['errDelete'] . ": $fmRemDir";
        }
        include('listing.inc.php');
      }

      if($ftp) {
        @ftp_quit($ftp);

        $tmp = str_replace('\\', '/', dirname(__FILE__)) . '/tmp';
        if($dp = @opendir($tmp)) {
          while($file = @readdir($dp)) {
            if($file != '.' && $file != '..') @unlink("$tmp/$file");
          }
          @closedir($tmp);
        }
      }
    }
  }
?>
</div>
<?php
//========================================================================================================
// Dialog Boxes
//========================================================================================================
?>
<div id="fmInfo" class="fmDialog">
<table border="0" cellspacing="0" cellpadding="0"><tr>
<td class="fmTH1" style="padding:4px" align="left"><?php echo $msg['fileInfo']; ?></td>
<td class="fmTH1" style="padding:2px" align="right"><?php echo fm_close_button(); ?></td>
</tr><tr>
<td class="fmTH1" colspan="2" style="padding:1px">
<div id="fmInfoText" class="fmTD2" style="padding:4px"></div></td>
</tr></table>
</div>

<div id="fmError" class="fmDialog">
<table border="0" cellspacing="0" cellpadding="0" width="400"><tr>
<td class="fmTH1" style="padding:4px" align="left"><?php echo $msg['error']; ?></td>
<td class="fmTH1" style="padding:2px" align="right"><?php echo fm_close_button(); ?></td>
</tr><tr>
<td class="fmTH3" colspan="2" style="padding:4px">
<div id="fmErrorText" class="fmError"></div></td>
</tr></table>
</div>

<div id="fmRename" class="fmDialog">
<form name="fmRename" class="fmForm" action="<?php echo $PHP_SELF; ?>" method="post">
<input type="hidden" name="fmMode" value="rename">
<input type="hidden" name="fmObject" value="">
<table border="0" cellspacing="0" cellpadding="0"><tr>
<td id="fmRenameText" class="fmTH1" style="padding:4px" align="left" nowrap></td>
<td class="fmTH1" style="padding:2px" align="right"><?php echo fm_close_button(); ?></td>
</tr><tr>
<td class="fmTH3" colspan="2" align="center" style="padding:4px">
<input type="text" name="fmName" size="40" maxlength="60" class="fmField" value=""><br>
<input type="submit" class="fmButton" value="<?php echo $msg['cmdRename']; ?>">
</td>
</tr></table>
</form>
</div>

<div id="fmPerm" class="fmDialog">
<form name="fmPerm" class="fmForm" action="<?php echo $PHP_SELF; ?>" method="post">
<input type="hidden" name="fmMode" value="permissions">
<input type="hidden" name="fmObject" value="">
<table border="0" cellspacing="0" cellpadding="0"><tr>
<td id="fmPermText" class="fmTH1" style="padding:4px" align="left" nowrap></td>
<td class="fmTH1" style="padding:2px" align="right"><?php echo fm_close_button(); ?></td>
</tr><tr>
<td class="fmTH3" colspan="2" align="center" style="padding:4px">
<table border="0" cellspacing="2" cellpadding="4"><tr align="center">
<td class="fmTH2"><?php echo $msg['owner']; ?></td>
<td class="fmTH2"><?php echo $msg['group']; ?></td>
<td class="fmTH2"><?php echo $msg['other']; ?></td>
</tr><tr align="left">
<?php
  for($i = 0; $i < 9; $i += 3) {
?>
    <td class="fmTD2" nowrap>
    <input type="checkbox" name="fmPerms[<?php echo $i; ?>]" value="4"> <?php echo $msg['read']; ?><br>
    <input type="checkbox" name="fmPerms[<?php echo $i+1; ?>]" value="2"> <?php echo $msg['write']; ?><br>
    <input type="checkbox" name="fmPerms[<?php echo $i+2; ?>]" value="1"> <?php echo $msg['execute']; ?>
    </td>
<?php
  }
?>
</tr></table>
<input type="submit" class="fmButton" value="<?php echo $msg['cmdChangePerm']; ?>">
</td>
</tr></table>
</form>
</div>

<div id="fmNewFile" class="fmDialog">
<form name="fmNewFile" class="fmForm" action="<?php echo $PHP_SELF; ?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="fmMode" value="newFile">
<table border="0" cellspacing="0" cellpadding="0"><tr>
<td id="fmNewFileText" class="fmTH1" style="padding:4px" align="left" nowrap></td>
<td class="fmTH1" style="padding:2px" align="right"><?php echo fm_close_button(); ?></td>
</tr><tr>
<td class="fmTH3" colspan="2" align="center" style="padding:4px">
<input type="file" name="fmFile[0]" size="20" class="fmField" onClick="fmNewFileSelector(1)" onChange="fmNewFileSelector(1)">
<input type="file" name="fmFile[1]" size="20" class="fmField" onClick="fmNewFileSelector(2)" onChange="fmNewFileSelector(2)" style="display:none">
<input type="file" name="fmFile[2]" size="20" class="fmField" onClick="fmNewFileSelector(3)" onChange="fmNewFileSelector(3)" style="display:none">
<input type="file" name="fmFile[3]" size="20" class="fmField" onClick="fmNewFileSelector(4)" onChange="fmNewFileSelector(4)" style="display:none">
<input type="file" name="fmFile[4]" size="20" class="fmField" onClick="fmNewFileSelector(5)" onChange="fmNewFileSelector(5)" style="display:none">
<input type="file" name="fmFile[5]" size="20" class="fmField" onClick="fmNewFileSelector(6)" onChange="fmNewFileSelector(6)" style="display:none">
<input type="file" name="fmFile[6]" size="20" class="fmField" onClick="fmNewFileSelector(7)" onChange="fmNewFileSelector(7)" style="display:none">
<input type="file" name="fmFile[7]" size="20" class="fmField" onClick="fmNewFileSelector(8)" onChange="fmNewFileSelector(8)" style="display:none">
<input type="file" name="fmFile[8]" size="20" class="fmField" onClick="fmNewFileSelector(9)" onChange="fmNewFileSelector(9)" style="display:none">
<input type="file" name="fmFile[9]" size="20" class="fmField" style="display:none">
<div class="fmTH3" style="font-weight:normal; text-align:left; border:none">
<input type="checkbox" name="fmReplSpaces" value="1"<?php if($replSpacesUpload) echo ' checked'; ?>>
file name =&gt; file_name<br>
<input type="checkbox" name="fmLowerCase" value="1"<?php if($lowerCaseUpload) echo ' checked'; ?>>
FileName =&gt; filename
</div>
<input type="submit" class="fmButton" value="<?php echo $msg['cmdUploadFile']; ?>">
</td>
</tr></table>
</form>
</div>

<div id="fmNewDir" class="fmDialog">
<form name="fmNewDir" class="fmForm" action="<?php echo $PHP_SELF; ?>" method="post">
<input type="hidden" name="fmMode" value="newDir">
<table border="0" cellspacing="0" cellpadding="0"><tr>
<td id="fmNewDirText" class="fmTH1" style="padding:4px" align="left" nowrap></td>
<td class="fmTH1" style="padding:2px" align="right"><?php echo fm_close_button(); ?></td>
</tr><tr>
<td class="fmTH3" colspan="2" align="center" style="padding:4px">
<input type="text" name="fmName" size="40" maxlength="60" class="fmField"><br>
<input type="submit" class="fmButton" value="<?php echo $msg['cmdNewDir']; ?>">
</td>
</tr></table>
</form>
</div>
<?php
//========================================================================================================

  if($fmError) {
?>
    <script language="JavaScript"> <!--
    setTimeout('fmViewError("<?php echo $fmError; ?>")', 500);
    //--> </script>
<?php
  }
?>

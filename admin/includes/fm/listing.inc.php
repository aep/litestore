<?php
/*********************************************************************************************************
 This code is part of the FileManager software (www.gerd-tentler.de/tools/filemanager), copyright by
 Gerd Tentler. Obtain permission before selling this code or hosting it on a commercial website or
 redistributing it over the Internet or in any other medium. In all cases copyright must remain intact.
*********************************************************************************************************/
defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');
  clearstatcache();
  $info = array();

  if($ftp) {
    $systype = @ftp_systype($ftp);
    $list = @ftp_rawlist($ftp, $fmCurDir);

    if(!$list) {
      $fmCurDir = $_SESSION['fmCurDir'] = $fmPrevDir;
      $list = @ftp_rawlist($ftp, $fmCurDir);
      $fmError = $msg['errOpen'] . ": $fmChangeDir";
    }
    if(is_array($list)) foreach($list as $row) {
      $arr = fm_get_info($row, $systype);
      if($arr) $info[] = $arr;
    }
    else $fmError = $msg['errOpen'];
  }
  else {
    $systype = function_exists('php_uname') ? php_uname() : PHP_OS;

    if(!is_dir($fmCurDir)) {
      $fmCurDir = $_SESSION['fmCurDir'] = $fmPrevDir;
      $fmError = $msg['errOpen'] . ": $fmChangeDir";
    }
    if($dp = @opendir($fmCurDir)) {
      while($file = readdir($dp)) {
        $arr = fm_get_info("$fmCurDir/$file");
        if($arr) $info[] = $arr;
      }
      @closedir($dp);
    }
    else $fmError = $msg['errOpen'];
  }
  if(strlen($systype) > 15) $systype = substr($systype, 0, 15) . '...';
  $icons = $fmWebPath . '/icons';

  if(!$fmSortField) {
    $fmSortField = 'permissions';
    $fmSortOrder = 'desc';
  }
  $sr = ($fmSortOrder == 'asc') ? 'desc' : 'asc';
  $tooltip = ($sr == 'asc') ? $msg['cmdSortAsc'] : $msg['cmdSortDesc'];
  $imgSort = "$icons/sort_$fmSortOrder.gif";
  $pImg = ($fmSortField == 'permissions') ? $imgSort : "$icons/blank.gif";

  if(strlen($fmCurDir) > 40) {
    $arr = explode('/', $fmCurDir);
    $len = count($arr);
    $short = $arr[0] . '/' . $arr[1] . '/.../' . $arr[$len-2] . '/' . $arr[$len-1];
    $title = "[$systype] $short";
  }
  else $title = "[$systype] $fmCurDir";
?>
<script language="JavaScript"> <!--
function fmFileInfo(permissions, owner, group, size, changed, name, thumb, width, height) {
  var info = '<table border="0" cellspacing="1" cellpadding="1"><tr>' +
             '<td class="fmContent"><b><?php echo $msg['name']; ?>:</b></td><td class="fmContent" nowrap>' + name + '</td>' +
             '</tr><tr>' +
             '<td class="fmContent"><b><?php echo $msg['permissions']; ?>:</b></td><td class="fmContent">' + permissions + '</td>' +
             '</tr><tr>' +
             '<td class="fmContent"><b><?php echo $msg['owner']; ?>:</b></td><td class="fmContent">' + owner + '</td>' +
             '</tr><tr>' +
             '<td class="fmContent"><b><?php echo $msg['group']; ?>:</b></td><td class="fmContent">' + group + '</td>' +
             '</tr><tr>' +
             '<td class="fmContent"><b><?php echo $msg['lastChange']; ?>:</b></td><td class="fmContent" nowrap>' + changed + '</td>' +
             '</tr><tr>' +
             '<td class="fmContent"><b><?php echo $msg['size']; ?>:</b></td><td class="fmContent">' + size + '</td>' +
             ((thumb && width && height) ? '</tr><tr><td colspan="2" height="8"></td></tr><tr><td class="frmContent" colspan="2"><img src="' + thumb + '" width="' + width + '" height="' + height + '"></td>' : '') +
             '</tr></table>';
  fmOpenDialog('fmInfo', info);
}
//--> </script>
<table border="0" cellspacing="0" cellpadding="0" width="<?php echo $fmWidth; ?>"><tr>
<td class="fmTH1" style="padding:4px" align="left"><?php echo $title; ?></td>
</tr><tr>
<td class="fmTH1">
<table border="0" cellspacing="1" cellpadding="0" width="100%"><tr>
<td class="fmTH2">
<table border="0" cellspacing="1" cellpadding="2" width="100%"><tr align="center">
<td class="fmTH3" width="14" title="<?php echo $tooltip; ?>"
 onMouseOver="this.className='fmTH4'; window.status='<?php echo $tooltip; ?>'; return true"
 onMouseOut="this.className='fmTH3'; window.status=''"
 onMouseDown="this.className='fmTH5'"
 onMouseUp="this.className='fmTH4'"
 onClick="fmGoTo('<?php echo "$PHP_SELF?fmSortField=permissions&fmSortOrder=$sr"; ?>')">
<img src="<?php echo $pImg; ?>" border="0" width="8" height="7">
</td>
<td class="fmTH3" title="<?php echo $tooltip; ?>"
 onMouseOver="this.className='fmTH4'; window.status='<?php echo $tooltip; ?>'; return true"
 onMouseOut="this.className='fmTH3'; window.status=''"
 onMouseDown="this.className='fmTH5'"
 onMouseUp="this.className='fmTH4'"
 onClick="fmGoTo('<?php echo "$PHP_SELF?fmSortField=name&fmSortOrder=$sr"; ?>')">
&nbsp;<?php echo $msg['name']; ?>&nbsp;
<?php if($fmSortField == 'name') echo ' <img src="' . $imgSort . '" border="0" width="8" height="7">'; ?>
</td>
<td class="fmTH3" width="15%" title="<?php echo $tooltip; ?>"
 onMouseOver="this.className='fmTH4'; window.status='<?php echo $tooltip; ?>'; return true"
 onMouseOut="this.className='fmTH3'; window.status=''"
 onMouseDown="this.className='fmTH5'"
 onMouseUp="this.className='fmTH4'"
 onClick="fmGoTo('<?php echo "$PHP_SELF?fmSortField=size&fmSortOrder=$sr"; ?>')">
&nbsp;<?php echo $msg['size']; ?>&nbsp;
<?php if($fmSortField == 'size') echo ' <img src="' . $imgSort . '" border="0" width="8" height="7">'; ?>
</td>
<td class="fmTH3" width="25%" title="<?php echo $tooltip; ?>"
 onMouseOver="this.className='fmTH4'; window.status='<?php echo $tooltip; ?>'; return true"
 onMouseOut="this.className='fmTH3'; window.status=''"
 onMouseDown="this.className='fmTH5'"
 onMouseUp="this.className='fmTH4'"
 onClick="fmGoTo('<?php echo "$PHP_SELF?fmSortField=changed&fmSortOrder=$sr"; ?>')">
&nbsp;<?php echo $msg['lastChange']; ?>&nbsp;
<?php if($fmSortField == 'changed') echo ' <img src="' . $imgSort . '" border="0" width="8" height="7">'; ?>
</td>
<?php
  if($enableNewDir) {
?>
    <td class="fmTH3" width="26" title="<?php echo $msg['cmdNewDir']; ?>"
     onMouseOver="this.className='fmTH4'; window.status='<?php echo $msg['cmdNewDir']; ?>'; return true"
     onMouseOut="this.className='fmTH3'; window.status=''"
     onMouseDown="this.className='fmTH5'"
     onMouseUp="this.className='fmTH4'"
     onClick="fmOpenDialog('fmNewDir', '<?php echo $msg['cmdNewDir']; ?>')">
    <img src="<?php echo $icons; ?>/newDir.gif" border="0" width="15" height="14" alt="<?php echo $msg['cmdNewDir']; ?>">
    </td>
<?php
  }
  else {
    $error = $msg['cmdNewDir'] . ': ' . $msg['errDisabled'];
?>
    <td class="fmTH2" width="26"><a href="javascript:fmOpenDialog('fmError', '<?php echo $error; ?>')" onMouseOver="window.status=''; return true">
    <img src="<?php echo $icons; ?>/newDir_x.gif" border="0" width="15" height="14"></a></td>
<?php
  }

  if($enableUpload) {
?>
    <td class="fmTH3" width="26" title="<?php echo $msg['cmdUploadFile']; ?>"
     onMouseOver="this.className='fmTH4'; window.status='<?php echo $msg['cmdUploadFile']; ?>'; return true"
     onMouseOut="this.className='fmTH3'; window.status=''"
     onMouseDown="this.className='fmTH5'"
     onMouseUp="this.className='fmTH4'"
     onClick="fmOpenDialog('fmNewFile', '<?php echo $msg['cmdUploadFile']; ?>')">
    <img src="<?php echo $icons; ?>/new.gif" border="0" width="14" height="14" alt="<?php echo $msg['cmdUploadFile']; ?>">
    </td>
<?php
  }
  else {
    $error = $msg['cmdUploadFile'] . ': ' . $msg['errDisabled'];
?>
    <td class="fmTH2" width="26"><a href="javascript:fmOpenDialog('fmError', '<?php echo $error; ?>')" onMouseOver="window.status=''; return true">
    <img src="<?php echo $icons; ?>/new_x.gif" border="0" width="14" height="14"></a></td>
<?php
  }
?>
</tr>
<?php
  if(strlen($fmCurDir) > strlen($startDir)) {
?>
    <tr class="fmTD1" onMouseOver="this.className='fmTD2'" onMouseOut="this.className='fmTD1'">
    <td class="fmContent" align="center">
    <a href="<?php echo "$PHP_SELF?fmChangeDir=.."; ?>"
     title="<?php echo $msg['cmdParentDir']; ?>"
     onMouseOver="window.status='<?php echo $msg['cmdParentDir']; ?>'; return true"
     onMouseOut="window.status=''">
    <img src="<?php echo $icons; ?>/cdup.gif" border="0" width="12" height="10" alt="<?php echo $msg['cmdParentDir']; ?>"></a>
    </td>
    <td class="fmContent" align="left">..</td>
    <td class="fmContent">&nbsp;</td>
    <td class="fmContent">&nbsp;</td>
    <td class="fmTD2" colspan="2"><img src="<?php echo $icons; ?>/blank.gif" width="10" height="10"></td>
    </tr>
<?php
  }

  if(is_array($info)) {
    $info = fm_sort_field($info, $fmSortField, $fmSortOrder);

    foreach($info as $val) {
      $file = $val['name'];
?>
      <tr class="fmTD1" onMouseOver="this.className='fmTD2'" onMouseOut="this.className='fmTD1'">
      <td class="fmContent" align="center">
<?php
      if($val['icon'] == 'dir') {
        $tooltip = $msg['cmdChangeDir'];
?>
        <a href="<?php echo "$PHP_SELF?fmChangeDir=" . urlencode($file); ?>"
         title="<?php echo $tooltip; ?>"
         onMouseOver="window.status='<?php echo $tooltip; ?>'; return true"
         onMouseOut="window.status=''">
<?php
      }
      else if($enableDownload) {
        $tooltip = $msg['cmdGetFile'];
        $url = "/admin/get_file.php?file=" . urlencode($file);
?>
        <a href="<?php echo $url; ?>"
         title="<?php echo $tooltip; ?>"
         onMouseOver="window.status='<?php echo $tooltip; ?>'; return true"
         onMouseOut="window.status=''">
<?php
      }
?>
      <img src="<?php echo "$icons/" . $val['icon']; ?>.gif" border="0" width="12" height="10" alt="<?php echo $tooltip; ?>"></a>
      </td>
      <td class="fmContent" align="left">
      <a href="javascript:fmFileInfo(<?php echo "'$val[permissions]', '$val[owner]', '$val[group]', '$val[size]', '$val[changed]', '$val[name]', '$val[thumb]', '$val[width]', '$val[height]'"; ?>)" class="fmLink"
       title="<?php echo $msg['cmdFileInfo']; ?>"
       onMouseOver="window.status='<?php echo $msg['cmdFileInfo']; ?>'; return true"
       onMouseOut="window.status=''">
      <?php echo $val['name']; ?></a>
      </td>
      <td class="fmContent" align="right">
<?php
      $size = $val['size'] / 1024;
      if($size > 999) echo number_format($size / 1024, 1) . ' MB';
      else echo number_format($size, 1) . ' KB';
?>
      </td>
      <td class="fmContent" align="center"><?php echo $val['changed']; ?></td>
      <td class="fmTD2" align="center" colspan="2" nowrap>
<?php
      if($enableRename) {
?>
        <a href="javascript:fmOpenDialog('fmRename', '<?php echo $msg['cmdRename'] . ": $file"; ?>', '<?php echo $file; ?>')"
         title="<?php echo $msg['cmdRename']; ?>"
         onMouseOver="window.status='<?php echo $msg['cmdRename']; ?>'; return true"
         onMouseOut="window.status=''">
        <img src="<?php echo $icons; ?>/rename.gif" border="0" width="10" height="10" alt="<?php echo $msg['cmdRename']; ?>"></a>
<?php
      }
      else {
        $error = $msg['cmdRename'] . ': ' . $msg['errDisabled'];
?>
        <a href="javascript:fmOpenDialog('fmError', '<?php echo $error; ?>')" onMouseOver="window.status=''; return true">
        <img src="<?php echo $icons; ?>/rename_x.gif" border="0" width="10" height="10"></a>
<?php
      }

      if($enablePermissions) {
?>
        <a href="javascript:fmOpenDialog('fmPerm', '<?php echo $msg['cmdChangePerm'] . ": $file"; ?>', '<?php echo $file; ?>', '<?php echo $val['permissions']; ?>')"
         title="<?php echo $msg['cmdChangePerm']; ?>"
         onMouseOver="window.status='<?php echo $msg['cmdChangePerm']; ?>'; return true"
         onMouseOut="window.status=''">
        <img src="<?php echo $icons; ?>/permissions.gif" border="0" width="10" height="10" alt="<?php echo $msg['cmdChangePerm']; ?>"></a>
<?php
      }
      else {
        $error = $msg['cmdChangePerm'] . ': ' . $msg['errDisabled'];
?>
        <a href="javascript:fmOpenDialog('fmError', '<?php echo $error; ?>')" onMouseOver="window.status=''; return true">
        <img src="<?php echo $icons; ?>/permissions_x.gif" border="0" width="10" height="10"></a>
<?php
      }

      if($enableDelete) {
        if($val['icon'] == 'dir') {
          $cmd = 'fmRemDir';
          $confirm = $msg['msgRemoveDir'];
        }
        else {
          $cmd = 'fmDelFile';
          $confirm = $msg['msgDeleteFile'];
        }
?>
        <a href="javascript:fmGoToOK('<?php echo $file . ':\n' . $confirm; ?>', '<?php echo "$PHP_SELF?$cmd=" . urlencode($file); ?>')"
         title="<?php echo $msg['cmdDelete']; ?>"
         onMouseOver="window.status='<?php echo $msg['cmdDelete']; ?>'; return true"
         onMouseOut="window.status=''">
        <img src="<?php echo $icons; ?>/delete.gif" border="0" width="10" height="10" alt="<?php echo $msg['cmdDelete']; ?>"></a>
<?php
      }
      else {
        $error = $msg['cmdDelete'] . ': ' . $msg['errDisabled'];
?>
        <a href="javascript:fmOpenDialog('fmError', '<?php echo $error; ?>')" onMouseOver="window.status=''; return true">
        <img src="<?php echo $icons; ?>/delete_x.gif" border="0" width="10" height="10"></a>
<?php
      }

      if($val['icon'] == 'text') {

        if($enableEdit) {
?>
          <a href="<?php echo "$PHP_SELF?fmEdit=" . urlencode($file); ?>"
           title="<?php echo $msg['cmdEdit']; ?>"
           onMouseOver="window.status='<?php echo $msg['cmdEdit']; ?>'; return true"
           onMouseOut="window.status=''">
          <img src="<?php echo $icons; ?>/edit.gif" border="0" width="10" height="10" alt="<?php echo $msg['cmdEdit']; ?>"></a>
<?php
        }
        else {
          $error = $msg['cmdEdit'] . ': ' . $msg['errDisabled'];
?>
          <a href="javascript:fmOpenDialog('fmError', '<?php echo $error; ?>')" onMouseOver="window.status=''; return true">
          <img src="<?php echo $icons; ?>/edit_x.gif" border="0" width="10" height="10"></a>
<?php
        }
      }
      else echo ' <img src="' . $icons . '/blank.gif" width="10" height="10">';
?>
      </td>
      </tr>
<?php
    }
  }
?>
</table>
</td>
</tr></table>
</td>
</tr></table>

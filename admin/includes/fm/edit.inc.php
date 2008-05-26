<?php
/*********************************************************************************************************
 This code is part of the FileManager software (www.gerd-tentler.de/tools/filemanager), copyright by
 Gerd Tentler. Obtain permission before selling this code or hosting it on a commercial website or
 redistributing it over the Internet or in any other medium. In all cases copyright must remain intact.
*********************************************************************************************************/
defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');
  if($fmSent) {
    $ok = false;
    if(get_magic_quotes_gpc()) $fmText = stripslashes($fmText);

    if($ftp) {
      $tmp = str_replace('\\', '/', dirname(__FILE__)) . '/tmp';
      if($fp = @fopen("$tmp/$fmEdit", 'w')) {
        @fwrite($fp, $fmText);
        @fclose($fp);
        $ok = fm_upload("$tmp/$fmEdit", "$fmCurDir/$fmEdit");
      }
    }
    else if($fp = @fopen("$fmCurDir/$fmEdit", 'w')) {
      $ok = @fwrite($fp, $fmText);
      @fclose($fp);
    }

    if(!$ok) $fmError = $msg['errSave'] . ": $fmEdit";

    include('listing.inc.php');
  }
  else if($file = fm_get("$fmCurDir/$fmEdit")) {
?>
    <form name="fEdit" class="fmForm" action="<?php echo $PHP_SELF; ?>" method="post">
    <input type="hidden" name="fmSent" value="1">
    <input type="hidden" name="fmEdit" value="<?php echo $fmEdit; ?>">
    <table border="0" cellspacing="0" cellpadding="4"><tr>
    <td class="fmTH1" align="left"><?php echo $msg['cmdEdit'] . ": $fmEdit"; ?></td>
    <td class="fmTH1" align="right" nowrap>
    <a href="<?php echo $PHP_SELF; ?>"
     title="<?php echo $msg['cmdViewList']; ?>"
     onMouseOver="window.status='<?php echo $msg['cmdViewList']; ?>'; return true"
     onMouseOut="window.status=''">
    <img src="<?php echo $fmWebPath; ?>/icons/list.gif" border="0" width="14" height="14" alt="<?php echo $msg['cmdViewList']; ?>"></a>
    &nbsp;
    <a href="javascript:document.fEdit.reset()"
     title="<?php echo $msg['cmdReset']; ?>"
     onMouseOver="window.status='<?php echo $msg['cmdReset']; ?>'; return true"
     onMouseOut="window.status=''">
    <img src="<?php echo $fmWebPath; ?>/icons/reset.gif" border="0" width="14" height="14" alt="<?php echo $msg['cmdReset']; ?>"></a>
    <a href="javascript:fmGoToOK('<?php echo $msg['msgSaveFile']; ?>', 'javascript:document.fEdit.submit()')"
     title="<?php echo $msg['cmdSave']; ?>"
     onMouseOver="window.status='<?php echo $msg['cmdSave']; ?>'; return true"
     onMouseOut="window.status=''">
    <img src="<?php echo $fmWebPath; ?>/icons/save.gif" border="0" width="14" height="14" alt="<?php echo $msg['cmdSave']; ?>"></a>
    </td>
    </tr><tr>
    <td class="fmTH3" colspan="2" align="center">
    <?php
      if($fp = @fopen($file, 'r')) {
        $content = @fread($fp, filesize($file));
        @fclose($fp);
      }
    ?>
    <textarea name="fmText" style="width:<?php echo $fmWidth - 20; ?>px; height:<?php echo $maskHeight - 80; ?>px" wrap="off" class="fmField"><?php echo htmlspecialchars($content); ?></textarea>
    </td>
    </tr></table>
    </form>
<?php
  }
  else {
    $fmError = $msg['errOpen'] . ": $fmEdit";
    include('listing.inc.php');
  }
?>

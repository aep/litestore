<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="images/stylesheet.css">

<script type="text/javascript" src="/pub/javascript/spin.js"></script>
<script type="text/javascript" src="/pub/javascript/adapter/prototype/prototype.js"></script>
<script type="text/javascript" src="/pub/javascript/adapter/prototype/ext-prototype-adapter.js"></script>
<script type="text/javascript" src="/pub/javascript/adapter/prototype/scriptaculous.js?load=effects"></script>
<script type="text/javascript" src="/pub/javascript/ext-all.js"></script>

<link rel="stylesheet" type="text/css"	href="/pub/javascript/resources/css/ext-all.css" >
<!--<link rel="stylesheet" type="text/css" href="/pub/javascript/resources/css/xtheme-slate.css" >-->

<script type="text/javascript" src="images/general.js"></script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
<!-- header //-->
<?php

  if ($messageStack->size > 0) {
    echo $messageStack->output();
  }




?>
<noscript>
    Diese Anwendung  benötigt Javascript.
</noscript>








        

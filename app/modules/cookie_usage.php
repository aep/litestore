<?php
function module()
{
    $smarty = new Smarty;

    $smarty->assign('language', $_SESSION['language']);

    global $breadcrumb;
    $breadcrumb->add(NAVBAR_TITLE_COOKIE_USAGE, xtc_href_link(FILENAME_COOKIE_USAGE));
    return $smarty->fetch('module/cookie_usage.html', $cache_id);
}
?>

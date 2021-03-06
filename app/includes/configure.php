<?php
    /* --------------------------------------------------------------

    ReStore - an XT-Commerce fork to restore sanity
    http://www.xt-commerce.com

    Copyright (c) 2003 XT-Commerce
    --------------------------------------------------------------
    based on:
    (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
    (c) 2002-2003 osCommerce (configure.php,v 1.13 2003/02/10); www.oscommerce.com

    Released under the GNU General Public License
    --------------------------------------------------------------*/

    // Define the webserver and path parameters
    // * DIR_FS_* = Filesystem directories (local/physical)
    // * DIR_WS_* = Webserver directories (virtual/URL)
    define('HTTP_SERVER',         ''); // eg, http://localhost - should not be empty for productive servers
    define('HTTPS_SERVER',        'https://'.$_SERVER["SERVER_NAME"]); // eg, https://localhost - should not be empty for productive servers
    define('ENABLE_SSL',          false); // secure webserver for checkout procedure?
    define('DIR_WS_CATALOG',      '/'); // absolute path required
    define('DIR_FS_DOCUMENT_ROOT',$APPDIR);
    define('DIR_FS_CATALOG',      $APPDIR);
    define('DIR_WS_IMAGES',       '/user/images/');
    define('DIR_WS_ORIGINAL_IMAGES',  DIR_WS_IMAGES .     'product_images/original_images/');
    define('DIR_WS_THUMBNAIL_IMAGES', DIR_WS_IMAGES .     'product_images/thumbnail_images/');
    define('DIR_WS_INFO_IMAGES',  DIR_WS_IMAGES .         'product_images/info_images/');
    define('DIR_WS_POPUP_IMAGES', DIR_WS_IMAGES .         'product_images/popup_images/');
    define('DIR_WS_BOXES',DIR_FS_CATALOG .'/boxes/');
    define('DIR_WS_ICONS',        DIR_WS_IMAGES .         'icons/');
    define('DIR_WS_INCLUDES',     DIR_FS_DOCUMENT_ROOT.   'includes/');
    define('DIR_WS_FUNCTIONS',    DIR_WS_INCLUDES .       'functions/');
    define('DIR_WS_CLASSES',      DIR_WS_INCLUDES .       'classes/');
    define('DIR_WS_MODULES',      DIR_FS_DOCUMENT_ROOT .  'modules/');
    define('DIR_WS_LANGUAGES',    DIR_FS_CATALOG .        'lang/');
    define('DIR_WS_DOWNLOAD_PUBLIC', DIR_WS_CATALOG . 'pub/');
    define('DIR_FS_DOWNLOAD',     DIR_FS_CATALOG . 'download/');
    define('DIR_FS_DOWNLOAD_PUBLIC', DIR_FS_CATALOG . 'pub/');
    define('DIR_FS_INC',          DIR_FS_CATALOG . 'includes/inc/');

    define('DIR_FS_USER',getenv("RESTORE_USER_PATH").'/');

?>

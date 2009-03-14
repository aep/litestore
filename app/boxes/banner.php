<?php
class BoxBanner extends AbstractVCBox
{
    var $classid= "{1784e3c3-0000-4000-824f-76b767236604}";
    function __construct()
    {
    }

    function walkthrough()
    {
        return false;
    }
    function evaluate()
    {
	//needs to be patched to use userdir
	return '';

        require_once(DIR_FS_INC . 'xtc_banner_exists.inc.php');
        require_once(DIR_FS_INC . 'xtc_display_banner.inc.php');
        require_once(DIR_FS_INC . 'xtc_update_banner_display_count.inc.php');


        if ($banner = xtc_banner_exists('dynamic', 'banner'))
        {
            return xtc_display_banner('static', $banner);
        }

    }
}


?>

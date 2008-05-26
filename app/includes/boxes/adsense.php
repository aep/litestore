<?php
class BoxAdsense extends AbstractVCBox
{
    var $classid= "{1784e3c3-0000-4000-824f-76b767236694}";
    function __construct()
    {
    }

    function walkthrough()
    {
        return false;
    }
    function evaluate()
    {
    if (ADSENSE_ACTIVE!="on")
        return;
    return
    '  <div class="adsense"> <script type="text/javascript"><!--
            google_ad_client = "'.ADSENSE_PUBID.'";
            google_ad_slot = "'.ADSENSE_SLOT.'";
            google_ad_width = 120;
            google_ad_height = 600;
            //-->
        </script>
        <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
        </script>
        </div>
    ';

    }
}


?>
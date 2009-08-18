<?php

asphyx_regme("com.handelsweise.litestore.gadget.adsense","BoxAdsense");
class BoxAdsense extends A2YObject
{
    var $classid= "com.handelsweise.litestore.gadget.adsense";
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

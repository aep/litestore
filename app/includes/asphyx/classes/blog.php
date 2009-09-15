<?php

asphyx_regme("com.handelsweise.litestore.sidebar.blogs","BoxBLogs");
class BoxBLogs extends A2YObject
{
    var $classid= "com.handelsweise.litestore.sidebar.blogs";
    function __construct()
    {
    }

    function walkthrough()
    {
        return false;
    }
    function evaluate()
    {      

        $ch =curl_init();
        curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
        curl_setopt( $ch, CURLOPT_URL, $this->data);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt( $ch, CURLOPT_TIMEOUT, 5 );
        curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
        $c=curl_exec($ch);
        curl_close($ch);
        if(!$c)
            return "load error";

        $xmlDoc = new DOMDocument();
        $r= $xmlDoc->loadXML($c);
        if(!$r)
            return "xml error";            

        $r='';
        foreach($xmlDoc->getElementsByTagName('channel') as $channel){

            $r.= '<div id="content_box" class="box">
                    <h5>'.$channel->getElementsByTagName('title')->item(0)->textContent.'</h5>
                        <div class="box_content">
                            <ul>';


            foreach($channel->getElementsByTagName('item') as $item){
                $name=$item->getElementsByTagName('title')->item(0)->textContent;
                $url=$item->getElementsByTagName('link')->item(0)->textContent;

                $r.='               <li><a href="'.$url.'">'.$name.' </a></li>';
            }
                

            $r.='          </ul>
                </div>
            </div>
            ';
        }

        return $r;
    }
}
?>

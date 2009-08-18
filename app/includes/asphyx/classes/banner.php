<?php
class BoxBanner extends A2YObject
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

        $r='';
        global $azrael;
        foreach( $azrael->listGenerators($azrael->presets['Banner']) as $node)
        {
            $r.=$node->evaluate();
        }

        return $r;
    }
}


?>

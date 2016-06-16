<?php
class render{
    private $path;
    function _construct($p){
        $this->path=$p;
    }
            function getRenderedPHP()
{
    ob_start();
    $pages=$this->path;
    include("$pages.php");
    $var=ob_get_contents(); 
    ob_end_clean();
    return $var;
}
}
?>

<?php
class TextBox {
    var $text;

    function display(){
        echo "<table border=\"1\"><tr><td>";
        echo $this->text;
        echo "</td></tr></table>";
    }
}

$box1= new TextBox("");
$box1->text = "สวัสดี";
$box1->display();

$box2= new TextBox("PHP");
$box2->display();
?>
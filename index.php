<?php require 'header.php';?>
<!-- Content Header (Page header) -->
    <?php
   function getRenderedHTML($path)
{
    ob_start();
    include("$path.php");
    $var=ob_get_contents(); 
    ob_end_clean();
    return $var;
}
    if(isset($_SESSION['user'])){
        if(isset($_REQUEST['page'])){
       $page=$_REQUEST['page'];
       echo getRenderedHTML($page);
    /*    require 'class/renderPHP.php';
      $render_php=new renderPHP("$page");
      $render_php->display();
      echo $render_php;*/
    }else{?>
    
               <section class="content-header">
            <div>
              <ol class="breadcrumb">
            <!--<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>-->
                  <li class="active"><i class="glyphicon glyphicon-home"></i> หน้าหลัก</li>
          </ol>  
            </div>
     </section>
<section class="content">
            
            
</section>
    <?php }}else{?>
        

        <!-- Main content -->
<section class="content">
 NO LOGIN.           
            
</section>
    <?php }?>


<?php require 'footer.php';?>
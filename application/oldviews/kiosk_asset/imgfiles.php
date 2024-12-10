<?php 
     $imgList = glob('assets/images/*.png');
     foreach($imgList as $filename){
         if(is_file($filename)){
             echo base_url().$filename.'|';
         }   
     }
?> 

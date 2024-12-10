<?php 
     $imgList = glob('assets/videos/*.mp4');
     foreach($imgList as $filename){
         if(is_file($filename)){
             echo base_url().$filename.'|';
         }   
     }
?> 
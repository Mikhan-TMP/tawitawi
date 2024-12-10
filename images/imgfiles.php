
  <?php 
    // $varfile = array();

     $imgList = glob('upload/*');
     $n = 0;
     foreach($imgList as $filename){
         if(is_file($filename)){
            $n++;
             echo $filename.','; 
            //  array_push($varfile, $filename);
         }   
     }

    //  print_r($varfile);
     
    //  echo '<br><br>';

    //  $imgList = glob('images/upload/*');
    //  foreach($imgList as $imgname){
    //      if(is_file($imgname)){
    //          echo $imgname, '<br>'; 
    //      }   
    //  }
?> 


  <?php 
    // $varfile = array();

     $vidList = glob('videos/*');
     $n = 0;
     foreach($vidList as $filename){
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

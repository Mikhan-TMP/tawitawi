<div class="ml-3">
      <div class="card rounded m-5 pr-2">
         <div class="card-body">
               <section class="">
                  <div class="container-fluid">
                  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
                     <?= $this->session->flashdata('message'); ?>
                  </div>
                  <hr>
                  <div class="container-fluid">
                    <h5>School Announcement</h5>
                     <div class="container-fluid" style="display: flex; justify-content: start;">
                        <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups"><br>
                           <div>
                              <button type="button" class="btn btn-dark mt-4" data-toggle="modal" data-target="#imgamodal" style="margin-right: 3px;">
                              Add Image
                              </button>
                              
                              
                           </div>
                           <!-- MODAL -->
                           <div class="modal" id="imgamodal">
                              <div class="modal-dialog">
                                 <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                       <h4 class="modal-title">Upload Image</h4>
                                       <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <!-- Modal body -->
                                    <form action="<?= base_url()?>Admin/do_upload_L" method="post" enctype="multipart/form-data">
                                       <div class="modal-body">
                                          <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups" style="display: flex; justify-content: center; align-items: center; margin: 20px;">
                                             <div class="input-group mb-3">
                                                <div class="custom-file">
                                                   <input type="file" name="customFile" onchange="preview()" class="custom-file-input text-wrap" id="inputGroupFile03">
                                                   <label class="custom-file-label" for="inputGroupFile03">
                                                      <div id="imgSrc"></div>
                                                   </label>
                                                </div>
                                             </div>
                                             <img id="frame" src="" class="img-fluid" height="150px"/>
                                          </div>
                                       </div>
                                       <!-- end Modal body -->
                                       <!-- Modal footer -->
                                       <div class="modal-footer">
                                          <input type="submit" name="Upload" class="btn btn-secondary" id="inputGroupFileAddon03">
                                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <!-- Gallery -->
                     <div class="card shadow-sm p-3 mb-5 bg-body rounded">
                        <div class="card-body">
                           <div class="container-fluid">
                              <div class="row">
                                 <?php 
                                    $dir = "assets/images_L"; 
                                    $map = directory_map($dir); 
                                    $id = 0;
                                    foreach ($map as $k)
                                    {$id++;?>
                                 <div class="col-lg-2 col-md-12 mb-4 mb-lg-0 image-area">
                                    <button value="<?php echo $k;?>" type="button" class="btn btnModal" data-toggle="modal" data-target="#vid<?php echo $id;?>">
                                    <img alt="Cant see image" style="width:50%" class="w-100 shadow-1-strong rounded mb-2" src="<?php echo base_url($dir)."/".$k;?>" alt="">
                                    </button>
                                    <div class="remove-image d-flex justify-content-end">
                                       <a type="button" class="btn-sm btn-danger btn-circle" href="?delete=<?php echo $k;?>"><i class="fas fa-trash-alt"></i></a>
                                    </div>
                                    <?php
                                    if (isset($_GET['delete'])) {
                                          $filename = $dir . "/" . $_GET['delete'];
                                          if (file_exists($filename)) {
                                             echo ($filename);
                                             $status = unlink($filename) ? 'File <span class="badge badge-danger">' . $filename . '</span> has been deleted' : 'Error deleting ' . $filename;
                                             echo $status;
                                             $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">You have deleted an image.</div>');
                                             
                                             header("Location: cms");
                                             exit();
                                          } else {
                                             $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">File does not exist.</div>');
                                             
                                             header("Location: cms");
                                             exit();
                                          }
                                    }
                                    ?>

                                 </div>
                                 <!-- start Modal -->
                                 <div class="modal" id="<?php echo "vid".$id;?>">
                                    <div class="modal-dialog">
                                       <div class="modal-content" style="width: 1100px; margin-left: -300px;">
                                          <?php
                                          $images = "assets/images_L";
                                          $dmapImg = directory_map($images);
                                          $i = 0;
                                          foreach($dmapImg as $k)
                                          {
                                            $i++;
                                            if($i == $id){
                                              ?>  
                                          <!-- Modal Header -->
                                          <div class="modal-header">
                                             <h5 class="modal-title"><?php echo $k ?></h5>
                                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          </div>
                                          <!-- Modal body -->
                                          <div class="modal-body d-flex justify-content-center">
                                          <img class="rounded" src="<?php echo base_url($images)."/".$k;?>" id="" style="width: 1000px;" >
                                          </div>
                                          <!-- Modal footer -->
                                          <div class="modal-footer">
                                             <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                          </div>
                                          <!-- End modal -->
                                          <?php  }
                                          }?>
                                          
                                         
                                          
                                       </div>
                                    </div>
                                 </div>
                                 <?php } ?> 
                              </div>
                           </div>
                        </div>
                     </div>
                  <hr>
                  <h5>Librarian Announcement</h5>
                     <div class="container-fluid" style="display: flex; justify-content: start;">
                        <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups"><br>
                          <button type="button" class="btn btn-dark mt-4" data-toggle="modal" data-target="#uploadImgS" style="margin-right: 3px;">
                            Add Image
                          </button>
                          <!-- <h4 class="mt-3">Small Images</h4> -->
                        </div>
                        <div class="modal" id="uploadImgS">
                           <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title">Upload Image</h4>
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              <!-- Modal Body -->
                                <form action="<?= base_url()?>Admin/do_upload_S" method="post" enctype="multipart/form-data">
                                       <div class="modal-body">
                                          <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups" style="display: flex; justify-content: center; align-items: center; margin: 20px;">
                                             <div class="input-group mb-3">
                                                <div class="custom-file">
                                                <input type="file" name="customFile" onchange="preview_Img()" class="custom-file-input text-wrap" id="inputGroupFile03">
                                                   <label class="custom-file-label" for="inputGroupFile03">
                                                      <div id="imgSrcs"></div>
                                                   </label>
                                                </div>
                                             </div>
                                             <img id="frames" src="" class="img-fluid" height="150px"/>
                                          </div>
                                       </div>
                                       <!-- end Modal body -->
                                       <!-- Modal footer -->
                                       <div class="modal-footer">
                                          <input type="submit" name="Upload" class="btn btn-secondary" id="inputGroupFileAddon03">
                                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                       </div>
                                </form>
                            </div>
                           </div>
                        </div>
                     </div>
                     <!-- Upload Small Img -->
                     <div class="card shadow-sm p-3 mb-5 bg-body rounded">
                        <div class="card-body">
                          <div class="container-fluid">
                            <h4 class="text-dark"></h4>
                            <div class="row">
                            <?php 
                                    $dir = "assets/images_S"; 
                                    $map = directory_map($dir); 
                                    $id = 0;
                                    foreach ($map as $k)
                                    {$id++;?>
                                 <div class="col-lg-2 col-md-12 mb-4 mb-lg-0 image-area">
                                    <button value="<?php echo $k;?>" type="button" class="btn btnModal" data-toggle="modal" data-target="#vids<?php echo $id;?>">
                                    <img alt="Cant see image" style="width:50%" class="w-100 shadow-1-strong rounded mb-4" src="<?php echo base_url($dir)."/".$k;?>" alt="">
                                    </button>
                                    <div class="remove-image d-flex justify-content-end">
                                       <a type="button" class="btn-sm btn-danger btn-circle" href="?deleteImg=<?php echo $k;?>"><i class="fas fa-trash-alt"></i></a>
                                    </div>
                                    <?php
                                    if (isset($_GET['deleteImg'])) {
                                          $filename = $dir . "/" . $_GET['deleteImg'];
                                          if (file_exists($filename)) {
                                             echo ($filename);
                                             $status = unlink($filename) ? 'File <span class="badge badge-danger">' . $filename . '</span> has been deleted' : 'Error deleting ' . $filename;
                                             echo $status;
                                             $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">You have deleted an image.</div>');
                                             
                                             header("Location: cms");
                                             exit();
                                          } else {
                                             $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">File does not exist.</div>');
                                             
                                             header("Location: cms");
                                             exit();
                                          }
                                    }
                                    ?>
                                    </div>

                                    <div class="modal" id="<?php echo "vids".$id;?>">
                                    <div class="modal-dialog">
                                       <div class="modal-content">
                                          <?php
                                          $image = "assets/images_S";
                                          $dmapImgs = directory_map($image);
                                          $is = 0;
                                          foreach($dmapImgs as $t)
                                          {
                                            $is++;
                                            if($is == $id){
                                          ?>
                                          <!-- Modal Header -->
                                          <div class="modal-header">
                                             <h5 class="modal-title"><?php echo $t ?> </h5>
                                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          </div>
                                          <!-- Modal body -->
                                          <div class="modal-body d-flex justify-content-center">
                                          <img class="rounded" src="<?php echo base_url($image)."/".$t ?>" id="" style="width: 300px;" >
                                          </div>
                                          <!-- Modal footer -->
                                          <div class="modal-footer">
                                             <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                          </div>
                                          <!-- End modal -->
                                          <?php }
                                          }?>
                                       </div>
                                    </div>
                                 </div>
                              <?php } ?> 
                            </div>
                          </div>
                        </div>                           
                     </div>
                  <hr>
                  <h5>Highlights</h5>
                        <div class="container-fluid">
                           <div style="display: flex; justify-content: start;">
                              <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
                                 <div>
                                    <button type="button" class="btn btn-dark mt-4" data-toggle="modal" data-target="#uploadMod" style="margin-right: 3px;">
                                    Add Video
                                    </button>
                                 </div>
                                 <div class="modal" id="uploadMod">
                                    <div class="modal-dialog">
                                       <div class="modal-content">
                                          <!-- Modal Header -->
                                          <div class="modal-header">
                                             <h4 class="modal-title">Upload Video</h4>
                                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          </div>
                                          <!-- Modal body -->
                                          <form action="<?= base_url()?>Upload/vid_upload" method="post" enctype="multipart/form-data">
                                             <div class="modal-body">
                                                <!-- Video Uploading -->
                                                <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups" style="display: flex; justify-content: center; align-items: center; margin: 20px;">
                                                   <div class="input-group mb-3">
                                                      <div class="custom-file">
                                                         <input type="file" name="videoFile" placeholder="Video" class="custom-file-input" id="inputGroupFile03" onchange='changeEventHandler(event);'>
                                                         <label class="custom-file-label" for="inputGroupFile03">
                                                            <div id="vidSrc"></div>
                                                         </label>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <!-- end Modal body -->
                                             <!-- Modal footer -->
                                             <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                <input type="submit" name="Upload" class="btn btn-secondary" id="inputGroupFileAddon03">
                                             </div>
                                          </form>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Videos -->
                        <div class="card shadow-sm p-3 mb-5 bg-body rounded">
                        <div class="card-body">
                           <div class="container-fluid">
                           <h4 class="text-dark">Videos</h4>
                           <div class="row">
                              <?php 
                                 $vids = "assets/videos/"; 
                                 $mapVid = directory_map($vids); 
                                 foreach ($mapVid as $v)
                                    {
                                       ?>
                              <div class="col-lg-4 col-md-12 mb-4 mb-lg-0">
                                 <video width="100%" height="100%" controls="controls" style="padding-bottom: 10px!important;">
                                    <source src="<?php echo base_url($vids)."/".$v;?>" type="video/mp4" />
                                 </video>
                                 <div class="remove-image d-flex justify-content-end">
                                    <a type="button" class="btn-sm btn-danger btn-circle" href="?deletevid=<?php echo $v;?>"><i class="fas fa-trash-alt"></i></a>
                                 </div>
                                 <?php
                                    if(isset($_GET['deletevid']))
                                    {$filename = $vids."/".$_GET['deletevid'];
                                       if(file_exists($filename)) {
                                          $status  = unlink($filename) ? 'File <span class="badge badge-danger">'.$filename.'</span> has been deleted' : 'Error deleting '.$filename;
                                          echo $status;
                                          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">You have Deleted a Video.</div>');
                                          redirect('/admin/cms');
                                       }
                                       else{
                                          $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">File Does Not Exist.</div>');
                                          redirect('/admin/cms');
                                          }
                                    }
                                    ?>
                              </div>
                              <?php } ?> 
                           </div>
                           </div>
                        </div>     
                        </div>
                                  
               <br>
               </section>
         </div>
      </div>
   </div>
<style>
   .image-area {
   position: relative;
   }
   .image-area img{
   max-width: 100%;
   height: auto;
   }
   .remove-image {
   display: none;
   position: absolute;
   top: -10px;
   right: -10px;
   border-radius: 10em;
   text-decoration: none;
   color: #FFF;
   box-shadow: 0 2px 6px rgba(0,0,0,0.5), inset 0 2px 4px rgba(0,0,0,0.3);
   text-shadow: 0 1px 2px rgba(0,0,0,0.5);
   -webkit-transition: ;
   }
   .remove-image:hover {
   background: #E54E4E;
   top: -11px;
   right: -11px;
   }
   .remove-image:active {
   background: #E54E4E;
   top: -11px;
   right: -11px;
   }
   
</style>
<script type="text/javascript" src="assets/gallery-script.js"></script>
<script type="text/javascript">
   function preview() {
               frame.src = URL.createObjectURL(event.target.files[0]);
               document.getElementById("imgSrc").innerHTML = event.target.value;
       console.log(event.target.value); 
           }
   function preview_Img(){
               var frames = document.getElementById("frames");
               frames.src = URL.createObjectURL(event.target.files[0]);
               document.getElementById("imgSrcs").innerHTML = event.target.value;
       console.log(event.target.value); 
   }
   function changeEventHandler(event){
       // alert(event.target.value);
       document.getElementById("vidSrc").innerHTML = event.target.value;
       console.log(event.target.value); 
   }
   
</script>

<script>
   // Initialize tooltips
   var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
   var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
     return new bootstrap.Tooltip(tooltipTriggerEl);
   });
</script>


<div class="loading" style="display: none; position: fixed; width: 100%; height: 100%; 
    top: 0; left: 0; background: #212121; z-index: 9999; 
    text-align: center; justify-content: center; align-items: center;
    transition: display 0.3s ease-in-out;">
   <div class="loader">
   <div class="dot dot-1"></div>
   <div class="dot dot-2"></div>
   <div class="dot dot-3"></div>
   <div class="dot dot-4"></div>
   <div class="dot dot-5"></div>
   
   <div class="dot dot-6"></div>
   <div class="dot dot-7"></div>
   <div class="dot dot-8"></div>
   </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loadingScreen = document.querySelector('.loading');
    const forms = document.querySelectorAll('form'); // Apply to all forms

    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent immediate submission

            // Show loading screen
            loadingScreen.style.display = 'flex';

            // Wait for 3 seconds before reloading the page or submitting the form
            setTimeout(() => {
                form.submit(); // Submit the form after delay
            }, 3000); // 3000 ms = 3 seconds
        });
    });
});
</script>
<div class="loading" style="display: none; position: fixed; width: 100%; height: 100%; top: 0; left: 0; background: rgba(0, 0, 0, 0.5); z-index: 9999; text-align: center; justify-content: center; align-items: center;">
  <div style="color: white; font-size: 20px;">Loading...</div>
</div>
<div class="ml-3">
      <div class="card rounded m-5 pr-2">
         <div class="card-body">
               <section class="">
                  <div class="container-fluid" >
                  <h1 class="h3 mb-4 text-gray-800">Content Management Page</h1>
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
                                    <form action="<?= base_url()?>Admin/do_upload_L" method="post" enctype="multipart/form-data" onsubmit="showLoadingScreen();">
                                       <div class="modal-body">
                                          <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups" style="display: flex; justify-content: center; align-items: center; margin: 20px;">
                                             <div class="input-group mb-3">
                                                <div class="custom-file">
                                                   <input type="file" name="customFile" onchange="preview()" class="custom-file-input text-wrap" id="inputGroupFile03" accept="image/jpeg, image/png, image/gif, image/jpg">
                                                   <label class="custom-file-label" for="inputGroupFile03">
                                                      <div id="imgSrc"></div>
                                                   </label>
                                                </div>
                                             </div>
                                             <p class="text-danger small text-center" style="margin-top: 10px;">* Please upload an image with a 16:9 aspect ratio.</p>
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

                     <!-- SHOW AND DELETE --> 
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
                                             $this->session->set_flashdata('warning', 'You have deleted an image.');
                                             
                                             header("Location: cms");
                                             exit();
                                          } else {
                                             $this->session->set_flashdata('cms_fail', 'File does not exist.');
                                             
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
                        <!-- MODAL -->
                        <div class="modal" id="uploadImgS">
                           <div class="modal-dialog">
                              <div class="modal-content">
                                 <!-- Modal Header -->
                                 <div class="modal-header">
                                    <h4 class="modal-title">Upload Image</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                 </div>
                                 <!-- Modal Body -->
                                 <form action="<?= base_url()?>Admin/do_upload_S" method="post" enctype="multipart/form-data" onsubmit="showLoadingScreen();">
                                    <div class="modal-body">
                                       <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups" style="display: flex; justify-content: center; align-items: center; margin: 20px;">
                                          <div class="input-group mb-3">
                                             <div class="custom-file">
                                                <input type="file" name="customFile" onchange="preview_Img()" class="custom-file-input text-wrap" id="inputGroupFile03" accept="image/*">
                                                <label class="custom-file-label" for="inputGroupFile03">
                                                   <div id="imgSrcs"></div>
                                                </label>
                                             </div>
                                          </div>
                                          <p class="text-danger small text-center" style="margin-top: 10px;">* Please upload an image with a 16:9 aspect ratio.</p>
                                          <img id="frames" src="" class="img-fluid" height="150px"/>
                                       </div>
                                    </div>
                                    <!-- Modal Footer -->
                                    <div class="modal-footer">
                                       <input type="submit" name="Upload" class="btn btn-secondary" id="inputGroupFileAddon03">
                                       <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- SHOW AND DELETE --> 
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
                                             $this->session->set_flashdata('warning', 'You have deleted an Image.');
                                             
                                             header("Location: cms");
                                             exit();
                                          } else {
                                             $this->session->set_flashdata('cms_fail', 'File does not exist.');
                                             
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
                        <!-- MODAL -->
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
                                          <!-- Modal Body -->
                                          <form action="<?= base_url()?>Admin/vid_upload" method="post" enctype="multipart/form-data" onsubmit="showLoadingScreen();">
                                             <div class="modal-body">
                                                <!-- Video Uploading -->
                                                <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups" style="display: flex; justify-content: center; align-items: center; margin: 20px;">
                                                   <div class="input-group mb-3">
                                                      <div class="custom-file">
                                                         <input type="file" name="videoFile" placeholder="Video" class="custom-file-input" id="inputGroupFile03" accept="video/*" onchange="previewVideo(event); updateFileName(event);">
                                                         <label class="custom-file-label" for="inputGroupFile03">
                                                            <div id="vidSrc"></div>
                                                         </label>
                                                      </div>
                                                   </div>
                                                </div>
                                                <p class="text-danger small text-center" style="margin-top: 10px;">* Please upload a video that is less than 100MB.</p>
                                                <div id="videoPreview" style="display: none; text-align: center;">
                                                   <video id="videoElement" width="320" height="240" controls></video>
                                                </div>
                                             </div>
                                             <!-- Modal Footer -->
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
                                             $this->session->set_flashdata('warning', 'You have Deleted a Video.');
                                             header("Location: cms");
                                             exit();
                                          }
                                          else{
                                             $this->session->set_flashdata('cms_fail', 'File Does Not Exist.');
                                             header("Location: cms");
                                             exit();
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
         <!-- ALERT MESSAGES -->
         <?php 
        //get the toasterhelper
          $this->load->helper('toast');

          if ($this->session->flashdata('cms_scs')) {
           echo getAlertMessages('success', $this->session->flashdata('cms_scs'));
          }
          if ($this->session->flashdata('cms_fail')) {
           echo getAlertMessages('error', $this->session->flashdata('cms_fail'));
          }
          if ($this->session->flashdata('warning')) {
            echo getAlertMessages('warning', $this->session->flashdata('warning'));
          }
          
          //unset it after use
          $this->session->unset_userdata('cms_scs');
          $this->session->unset_userdata('cms_fail');
          $this->session->unset_userdata('warning');
        ?> 
<script>
   function showLoadingScreen() {
      // Hide other modals
      $('.modal').modal('hide');
      
      const loadingScreen = document.getElementById('loading-screen');
      loadingScreen.style.display = 'flex'; // Show the loading overlay
      
      // Ensure the loading screen is shown for at least 3 seconds
      setTimeout(() => {
         loadingScreen.style.display = 'none'; // Hide the loading overlay after 3 seconds
      }, 3000);
   }
</script>
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
   /* From Uiverse.io by Fadhilmagass */ 
.loader {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  height: 100%;
}

.dot {
  display: inline-block;
  width: 10px;
  height: 10px;
  margin-right: 6px;
  border-radius: 50%;
  -webkit-animation: dot-pulse2 1.5s ease-in-out infinite;
  animation: dot-pulse2 1.5s ease-in-out infinite;
}

.dot-1 {
  background-color: #4285f4;
  -webkit-animation-delay: 0s;
  animation-delay: 0s;
}

.dot-2 {
  background-color: #34a853;
  -webkit-animation-delay: 0.3s;
  animation-delay: 0.3s;
}

.dot-3 {
  background-color: #fbbc05;
  -webkit-animation-delay: 0.6s;
  animation-delay: 0.6s;
}

.dot-4 {
  background-color: #ea4335;
  -webkit-animation-delay: 0.9s;
  animation-delay: 0.9s;
}

.dot-5 {
  background-color: #4285f4;
  -webkit-animation-delay: 1.2s;
  animation-delay: 1.2s;
}

/* Variasi baru */
.dot-6 {
  background-color: #0f9d58;
  -webkit-animation-delay: 1.5s;
  animation-delay: 1.5s;
}

.dot-7 {
  background-color: #673ab7;
  -webkit-animation-delay: 1.8s;
  animation-delay: 1.8s;
}

.dot-8 {
  background-color: #ff5722;
  -webkit-animation-delay: 2.1s;
  animation-delay: 2.1s;
}

@keyframes dot-pulse2 {
  0% {
    -webkit-transform: scale(0.5);
    transform: scale(0.5);
    opacity: 0.5;
  }

  50% {
    -webkit-transform: scale(1);
    transform: scale(1);
    opacity: 1;
  }

  100% {
    -webkit-transform: scale(0.5);
    transform: scale(0.5);
    opacity: 0.5;
  }
}
</style>

<script>
   function preview() {
    const fileInput = document.getElementById('inputGroupFile03');
    const file = fileInput.files[0];
    const img = new Image();
    
    img.onload = function() {
        const width = img.width;
        const height = img.height;
        if (Math.round((width / height) * 100) / 100 !== 16 / 9) {
            alert("The image must have a 16:9 aspect ratio.");
            fileInput.value = ""; // Clear the input
        } else {
            document.getElementById('frame').src = URL.createObjectURL(file);
        }
    };
    img.src = URL.createObjectURL(file);
}
</script>
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
<script>
// Video preview function
function previewVideo(event) {
   var file = event.target.files[0];
   var videoElement = document.getElementById('videoElement');
   var videoPreview = document.getElementById('videoPreview');

   // Show video preview if the file is a video
   if (file && file.type.startsWith('video')) {
      var fileURL = URL.createObjectURL(file);
      videoElement.src = fileURL;
      videoPreview.style.display = 'block';
   } else {
      videoPreview.style.display = 'none';
   }

   // Check file size, if it's larger than 100MB, show an error message
   if (file.size > 100 * 1024 * 1024) {
      alert('Video file is too large. Please upload a video smaller than 100MB.');
      event.target.value = '';  // Clear the file input
      videoPreview.style.display = 'none';  // Hide the preview
   }
}

// Update file name in the label when a file is selected
function updateFileName(event) {
   var input = event.target;
   var label = input.nextElementSibling; // The label element
   var fileName = input.files[0].name; // Get the selected file name
   label.textContent = fileName; // Update the label with the file name
}
</script>

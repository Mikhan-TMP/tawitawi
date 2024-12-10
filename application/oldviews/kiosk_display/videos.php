<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="content-body">
                <p class="page-title">Kiosk Displays</p>
                <div class="container">
                    <div class="row mt-2">
                        <div class="card">
                            <div class="card-headers bg-carnal-red">
                                <p class="text-title">Featured Videos</p>
                            </div>
                            <?php if (session()->getFlashdata('success') !== NULL) : ?>
                                    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                                        <?php echo session()->getFlashdata('success'); ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>

                            <?php endif; ?>
                            <?php if (session()->getFlashdata('error') !== NULL) : ?>
                                    <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                                        <?php echo session()->getFlashdata('error'); ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                            <?php endif; ?>

                            <?php if (session()->getFlashdata('validation') !== NULL) : ?>
                                    <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                                        <?php echo session()->getFlashdata('validation'); ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                            <?php endif; ?>
                            <div>
                                <button type="button" class="btn-control" data-toggle="modal" data-target="#videoModal">
                                    Upload Video
                                </button>
                            </div>

                            <div class="card-2 mt-2">
                                <div class="card-row-data p-2">
                                <?php foreach ($videos as $item): ?>
                                    <div class="col-md-4 mb-4 mt-2">
                                        <div class="card">
                                            <!-- Video Player -->
                                            <div class="embed-responsive embed-responsive-16by9">
                                                <video controls class="embed-responsive-item">
                                                    <source src="<?= esc($item['path']) ?>" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h5 class="card-title"><?= esc($item['title']) ?></h5>
                                                        <p class="card-text"><?= esc($item['description']) ?></p>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end mt-2">
                                                        <button type="button" class="btn btn-edit" data-toggle="modal" data-target="#editImageModal<?= esc($item['id']) ?>">
                                                                    <i class="fas fa-edit"></i>
                                                        </button>
                                                    <!-- Delete Button -->
                                                        <form action="<?php echo base_url('/delete_video');?>" method="post">
                                                            <input type="hidden" name="video_id" value="<?= esc($item['id']) ?>">
                                                        <button type="button" class="btn btn-delete" data-toggle="modal" data-target="#deleteVideoModal" data-video-id="<?= esc($item['id']) ?>">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                        </form>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>

                                                <!-- Edit Image Modal -->
                                    <div class="modal fade" id="editImageModal<?= esc($item['id']) ?>" tabindex="-1" role="dialog" aria-labelledby="editImageModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editImageModalLabel">Edit Image</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="<?php echo base_url('/update_video');?>" method="post">
                                                        <input type="hidden" name="video_id" value="<?= esc($item['id']) ?>">
                                                        <div class="form-group">
                                                            <label for="editTitle">Edit Title</label>
                                                            <input type="text" class="form-control" id="editTitle" name="editTitle" value="<?= esc($item['title']) ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="editDescription">Edit Description</label>
                                                            <textarea class="form-control" id="editDescription" name="editDescription" rows="3"><?= esc($item['description']) ?></textarea>
                                                        </div>
                                                        <div class="d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<div class="modal fade" id="imageModal" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Upload Image</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                    <form action="<?php echo base_url('/imgUpload');?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="inputTitle" class="form-label">Image Title</label>
                            <input type="text" name="title" class="form-control" id="inputTitle" placeholder="Enter title..." required>
                        </div>
                        <div class="mb-3">
                            <label for="inputDescription" class="form-label">Image Description</label>
                            <input type="text" name="description" class="form-control" id="inputDescription" placeholder="Enter description..." required>
                        </div>
                            <input type="hidden" name="media_type" id="selectType" class="form-control" value="image" placeholder="Image" readonly>
                        <div class="mb-3">
                            <label for="inputFile" class="form-label">Browse Media</label>
                                <input type="file" name="mediafile" onchange="preview()" class="form-control" id="inputFile" required>
                        </div>
                        <div class="d-flex justify-content-center">
                                <img id="upload" class="mb-3 rounded" src="./public/images/default_banner.jpg" width="100%" class="img-fluid"/>
                        </div>
                        <div class="mb-3">
                            <input type="submit" value="Upload" class="btn btn-success btn-block">
                        </div>
                    </form>
             </div>
        </div>
    </div>
</div>

<!-- Modal for Delete Confirmation -->
<div class="modal fade" id="deleteVideoModal" tabindex="-1" role="dialog" aria-labelledby="deleteVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteVideoModalLabel">Delete Video Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this video?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form id="deleteVideoForm" action="" method="post">
                    <input type="hidden" name="video_id">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- --VIDEO UPLOAD MODAL--- -->
<div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Video</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="<?php echo base_url('/vidUpload');?>" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="inputTitle" class="form-label">Video Title</label>
                        <input type="text" name="title" class="form-control" id="inputTitle" placeholder="Enter title..." required>
                    </div>
                    <div class="mb-3">
                        <label for="inputDescription" class="form-label">Video Description</label>
                        <input type="text" name="description" class="form-control" id="inputDescription" placeholder="Enter description..." required>
                    </div>
                        <input type="hidden" name="media_type" id="selectType" class="form-control" value="video" placeholder="Video" required>
                    <div class="mb-3">
                        <label for="inputFile" class="form-label">Browse Media</label>
                            <input type="file" name="mediafile" class="form-control" id="inputFile" required>
                    </div>
                    <div class="mb-3">
                        <input type="submit" value="Save" class="btn btn-success btn-block">
                    </div>
                </form>
      </div>
    </div>
  </div>
</div>


<script>
        document.addEventListener("DOMContentLoaded", function () {
        // When the delete button is clicked, set the video ID in the form and trigger the modal
        const deleteButtons = document.querySelectorAll('[data-toggle="modal"]');
        const deleteVideoForm = document.getElementById('deleteVideoForm');

        deleteButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const videoId = button.getAttribute('data-video-id');
                deleteVideoForm.action = '<?= base_url('/delete_video')?>'; // Set the form action
                deleteVideoForm.querySelector('[name="video_id"]').value = videoId;
            });
        });

        // Reset the form action when the modal is closed
        $('#deleteVideoModal').on('hidden.bs.modal', function () {
            deleteVideoForm.action = '';
            deleteVideoForm.querySelector('[name="video_id"]').value = '';
        });
    });

</script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="content-body">
    <p class="page-title">Kiosk Displays</p>
    <div class="container">
        <div class="row mt-2">
            <div class="card">
                <div class="card-headers bg-carnal-red">
                    <p class="text-title">Featured Images</p>
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
                    <button type="button" class="btn-control" data-toggle="modal" data-target="#imageModal">
                        Upload Image
                    </button>
                </div>

                <div class="card-2 mt-2">
    <div class="card-row-data p-2">
        <?php foreach ($images as $item): ?>
            <div class="col-md-4 mb-4 mt-2">
                <div class="card w-10 h-10">
                    <!-- Image (thumbnail) -->
                    <img src="<?= esc($item['path']) ?>" alt="Image" class="img-fluid" width="100%" data-toggle="modal" data-target="#imageModal<?= esc($item['id']) ?>">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title"><?= esc($item['title']) ?></h5>
                                <p class="card-text"><?= esc($item['description']) ?></p>
                            </div>
                            <!-- Edit and Delete Buttons -->
                        </div>
                        <div class="d-flex justify-content-end mt-2">
                                <button type="button" class="btn btn-edit" data-toggle="modal" data-target="#editImageModal<?= esc($item['id']) ?>">
                                            <i class="fas fa-edit"></i>
                                </button>
                                <form action="<?php echo base_url('/delete_image');?>" method="post">
                                    <input type="hidden" name="image_id" value="<?= esc($item['id']) ?>">
                                    <button type="button" class="btn btn-delete" data-toggle="modal" data-target="#deleteConfirmationModal" data-image-id="<?= esc($item['id']) ?>">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                    </div>
                </div>
            </div>

            <!-- Image Modal for Full View -->
            <div class="modal fade" id="imageModal<?= esc($item['id']) ?>" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="imageModalLabel"><?= esc($item['title']) ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <img src="<?= esc($item['path']) ?>" alt="<?= esc($item['title']) ?>" class="img-fluid" width="100%">
                            <hr>
                            <p><?= esc($item['description']) ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                            <form action="<?php echo base_url('/update_image');?>" method="post">
                                <input type="hidden" name="image_id" value="<?= esc($item['id']) ?>">
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
                                <img id="upload" class="mb-3 rounded" src="<?= base_url('public/images/default_banner.jpg');?>" width="100%" class="img-fluid"/>
                        </div>
                        <div class="mb-3">
                            <input type="submit" value="Upload" class="btn btn-success btn-block">
                        </div>
                    </form>
             </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this image?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form id="deleteForm" action="" method="post">
                    <input type="hidden" name="image_id">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
        document.addEventListener("DOMContentLoaded", function () {
        // When the delete button is clicked, set the image ID in the form and trigger the modal
        const deleteButtons = document.querySelectorAll('[data-toggle="modal"]');
        const deleteForm = document.getElementById('deleteForm');

        deleteButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const imageId = button.getAttribute('data-image-id');
                deleteForm.action = '<?= base_url('/delete_image')?>'; // Set the form action
                deleteForm.querySelector('[name="image_id"]').value = imageId;
            });
        });

        // Reset the form action when the modal is closed
        $('#deleteConfirmationModal').on('hidden.bs.modal', function () {
            deleteForm.action = '';
            deleteForm.querySelector('[name="image_id"]').value = '';
        });
    });
</script>
<script src="<?= base_url('./public/js/image.js') ?>"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
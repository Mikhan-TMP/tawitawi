<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="content-body">
                <p class="page-title">Kiosk Displays</p>
                <div class="container">
                    <div class="row mt-2">
                        <div class="card">
                            <div class="card-headers bg-carnal-red">
                                <p class="text-title">Librarian</p>
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

                        <div class="container center">
                            <div class="row">
                                <?php foreach ($librarian as $item): ?>
                                    <div class="col-md-4 mb-4 mt-2">
                                        <div class="card" style="position: relative;">
                                        <img src="<?= esc($item['path']) ?>" alt="Image" class="img-fluid" width="100%" data-toggle="modal" data-target="#imageModal<?= esc($item['id']) ?>">

                                            <!-- Delete Button -->
                                                <form action="<?php echo base_url('/delete_librarian');?>" method="post" style="position: absolute; top: 0; right: 0; margin: 10px;">
                                                    <input type="hidden" name="lib_image_id" value="<?= esc($item['id']) ?>">
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteConfirmationModal" data-librarian-id="<?= esc($item['id']) ?>">
                                                            <i class="fas fa-trash-alt"></i>
                                                    </button>                 
                                                </form>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>

                            <div class="card-2 mt-2">
                                <div class="card-row-data p-2">
                                <?php foreach ($librarian as $item): ?>
                                <div class="container center">
                                    <div class="modal fade" id="imageModal<?= esc($item['id']) ?>" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <img src="<?= esc($item['path']) ?>" class="img-fluid" width="100%">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                    <form action="<?php echo base_url('/librarianUpload');?>" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="media_type" id="selectType" class="form-control" value="image" placeholder="Image" readonly>
                        <div class="mb-3">
                            <label for="inputFile" class="form-label">Browse Media</label>
                                <input type="file" name="mediafile" onchange="preview()" class="form-control" id="inputFile" required>
                        </div>
                        <div class="d-flex justify-content-center">
                                <img id="upload" class="mb-3 rounded" src="<?= base_url('public/images/default_user.png');?>" width="100%" class="img-fluid"/>
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
                    <input type="hidden" name="lib_image_id">
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
                const imageId = button.getAttribute('data-librarian-id');
                deleteForm.action = '<?= base_url('/delete_librarian')?>'; // Set the form action
                deleteForm.querySelector('[name="lib_image_id"]').value = imageId;
            });
        });

        // Reset the form action when the modal is closed
        $('#deleteConfirmationModal').on('hidden.bs.modal', function () {
            deleteForm.action = '';
            deleteForm.querySelector('[name="lib_image_id"]').value = '';
        });
    });
</script>
<script src="<?= base_url('./public/js/image.js') ?>"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
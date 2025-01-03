<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="row">
    <div class="col-sm-10">
      <h1 class="h3 mb-4 text-gray-900">Welcome, <?= $account['name']  ?>! </h1>
    </div>
  </div>
  <div class="row">
    <!-- left -->
    <div class="col-sm-10 col-md-5 col-lg-4 col-xl-2 ml-5 offset-sm-1 offset-md-0 offset-lg-0 offset-xl-0">
      <!-- Display profile image or default avatar -->
      <img src="<?= $imageSrc ?>" alt="Profile Image" style="width: 300px; height: 300px; cursor: pointer; border-radius: 50%; border: 5px solid rgb(15, 39, 175);" id="uploadImage">
    </div>
    <!-- right -->
    <div class="col-sm-10 col-md-6 offset-sm-1">
      <h1 class="h3 text-white rounded mt-1 mb-5 p-3" style="background: linear-gradient(180deg, #031084, #000748); ">Librarian Data</h1>
      <table class="table">
        <tbody>
          <tr>
            <?php 
            ?>
            <th scope="row">Librarian ID</th>
            <td><?= $account['id']; ?></td>
          </tr>
          <tr>
            <th scope="row">Name</th>
            <td><?= $account['name'] ?></td>
          </tr>
          <!-- <tr>
            <th scope="row">Email</th>
            <td><?= $account['email'] ?></td>
          </tr> -->

        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- /.container-fluid -->

<!-- Modal for Image Upload -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="uploadModalLabel">Upload New Image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="imageUploadForm" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label for="imageFile">Select Image</label>
            <input type="file" class="form-control-file" id="imageFile" name="imageFile" accept="image/*">
          </div>
          <button type="submit" class="btn btn-primary">Upload</button>
        </form>
      </div>
    </div>
  </div>
</div>
</div>


<!-- End of Main Content -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // Open modal on image click
    $('#uploadImage').click(function () {
        $('#uploadModal').modal('show'); // Show the modal
    });

    // Handle form submission
    $('#imageUploadForm').on('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        formData.append('id', <?= $account['id']; ?>); // Pass user ID dynamically

        $.ajax({
            url: '<?= base_url('master/upload_image') ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                response = JSON.parse(response);
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Image Uploaded',
                        text: response.message,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload(); // Refresh to show the updated image
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Upload Failed',
                        text: $('<div>').html(response.message).text(),
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function () {
                alert('An error occurred. Please try again.');
            }
        });
    });
});
</script>

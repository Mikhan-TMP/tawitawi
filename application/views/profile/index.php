<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="row">
    <div class="col-sm-10">
      <h1 class="h3 mb-4 text-gray-900">Welcome, <?= $account['name'] ?></h1>
    </div>
  </div>
  <div class="row">
    <!-- left -->
    <div class="col-sm-10 col-md-5 col-lg-4 col-xl-2 ml-5 offset-sm-1 offset-md-0 offset-lg-0 offset-xl-0">
    <!-- If profile image exists, display it. Otherwise, show default avatar -->
    <?php
    $imageSrc = base_url('profilecontroller/get_image/'.$account['id']);
    $defaultAvatar = base_url('images/default-avatar.jpg');
    if (empty($account['profile_image'])) {
        $imageSrc = $defaultAvatar;
    }
    ?>
    <!-- Add a trigger to open the modal when the image is clicked -->
    <img src="<?= $imageSrc ?>" alt="Profile Image" style="width: 300px; cursor: pointer;" id="uploadImage">
</div>


    <!-- right -->
    <div class="col-sm-10 col-md-6 offset-sm-1">
      <h1 class="h3 text-white p-1 rounded mt-1 mb-5" style="background: linear-gradient(180deg, #BE110E, #630908);">Data</h1>
      <table class="table">
        <tbody>
          <tr>
            <th scope="row">Librarian ID</th>
            <td><?= $account['id']; ?></td>
          </tr>
          <tr>
            <th scope="row">Name</th>
            <td><?= $account['name'] ?></td>
          </tr>
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
        <form id="imageUploadForm" enctype="multipart/form-data">
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
<script>
document.addEventListener("DOMContentLoaded", function () {
  // Open the modal when the image is clicked
  document.getElementById('uploadImage').addEventListener('click', function () {
    $('#uploadModal').modal('show');
  });

  // Handle the image upload form submission (using AJAX)
  document.getElementById('imageUploadForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent the default form submission

    // Create FormData object to handle file uploads
    var formData = new FormData(this);

    // Send the data via AJAX
    $.ajax({
      url: '<?= base_url('profilecontroller/upload_image') ?>',  // URL to your controller method
      type: 'POST',
      data: formData,
      contentType: false,  // Important for file upload
      processData: false,  // Important for file upload
      success: function (response) {
          console.log(response);  // Check the raw response
          var res = JSON.parse(response);
          if (res.status == 'success') {
              alert(res.message);
              $('#uploadModal').modal('hide');
              // Optionally, update the profile image in the UI
              $('#uploadImage').attr('src', '<?= base_url('profilecontroller/get_image/' . $account['id']) ?>'); // Update image source dynamically
          } else {
              alert(res.message);
          }
      },
      error: function () {
        alert('Failed to upload image.');
      }
    });
  });
});


</script>
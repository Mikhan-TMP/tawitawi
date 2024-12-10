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
      <img src="<?= base_url('images/logoMSU.png')?>" style="width: 300px; height: auto;">
    </div>

    <!-- right -->
    <div class="col-sm-10 col-md-6 offset-sm-1">
      <h1 class="h3 text-white p-1 rounded mt-1 mb-5" style="background: linear-gradient(180deg, #0F25EE, #1F2DB0);">Data</h1>
      <table class="table">
        <tbody>
          <tr>
            <th scope="row">Librarian ID</th>
            <td>: <?= $account['id']; ?></td>
          </tr>
          <tr>
            <th scope="row">Name</th>
            <td>: <?= $account['name'] ?></td>
          </tr>
          <!-- <tr>
            <th scope="row">Location</th>
            <td>: <?= $account['id'] ?></td>
          </tr> -->
          <!-- OG code -->          
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
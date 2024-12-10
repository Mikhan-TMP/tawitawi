<div class="container-fluid">  
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
  <a href="<?= base_url('mater') ?>" class="btn btn-md btn-info mb-2">Back</a>
  <br>
  <div class="row">
    <div class="col-lg-12 col-md-9 col-sm-9">
      <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
          <h5>Operation Close </h5>
          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#dayCloseModal"><i class="fas fa-plus-circle"></i> ADD</button>
        </div>
        <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Date</th>
                    <th scope="col">Title</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>              
                <tbody>
                  <?php foreach ($close_schedule as $day): ?>
                    <tr>
                      <td><?= $day['id']; ?></td>
                      <td><?= $day['date'] ?></td>
                      <td><?= $day['title'] ?></td>
                      <td class="text-center align-middle">
                        <!-- Edit Button -->
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#editModal<?= $day['id'] ?>">
                        <span class="icon text-white" title="Edit">
                          <i class="fas fa-edit"></i>
                        </span>
                          </button> |

                        <a href="<?= site_url('master/d_schedule/' . $day['id']) ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this schedule?')"><span class="icon text-white" title="Delete">
                          <i class="fas fa-trash-alt"></i>
                        </span></a>

                      </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal<?= $day['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="editModalLabel">Modified Event</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                            <form action="<?= base_url('master/e_schedule/' . $day['id']) ?>" method="post">
                                <div class="form-group">
                                  <label for="editTitle">Event Title</label>
                                  <input type="text" class="form-control" id="editTitle" name="title" value="<?= $day['title'] ?>" required>
                                </div>
                                <div class="form-group">
                                  <label for="editDate">Event Date</label>
                                  <!-- <?php echo $day['date'] ?> -->
                                  <input type="date" class="form-control" id="editDate" name="date" value="<?= $day['date'] ?>" required>
                                </div>
                                <div class="form-group">
                                  <label for="editCategory">Event Category</label>
                                  <select class="form-control" id="editCategory" name="category">
                                    <option value="close" <?= ($day['category'] == 'close') ? 'selected' : '' ?>>Close</option>
                                    <option value="open" <?= ($day['category'] == 'open') ? 'selected' : '' ?>>Open</option>
                                  </select>
                                </div>
                                <button type="submit" class="btn btn-warning float-right">Save Changes</button>
                            </form>
                          </div>
                        </div>
                      </div>
                      </div>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
        </div>
      </div>
    </div>

    <br>
    <div class="col-lg-12 col-md-9 col-sm-9 mt-5">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5>Special Open</h5>
          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#dayOpenModal"><i class="fas fa-plus-circle"></i>ADD</button>
        </div>
        <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Date</th>
                  <th scope="col">Title</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>            
              <tbody>             
                  <?php foreach ($open_schedule as $day): ?>
                    <tr>
                      <td><?= $day['id']; ?></td>
                      <td><?= $day['date'] ?></td>
                      <td><?= $day['title'] ?></td>
                      <td class="text-center align-middle">
                        <!-- Edit Button -->
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#editModal<?= $day['id'] ?>">
                        <span class="icon text-white" title="Edit">
                          <i class="fas fa-edit"></i>
                        </span>
                          </button> |

                        <a href="<?= site_url('master/d_schedule/' . $day['id']) ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this schedule?')"><span class="icon text-white" title="Delete">
                          <i class="fas fa-trash-alt"></i>
                        </span></a>

                      </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal<?= $day['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="editModalLabel">Modified Event</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                            <form action="<?= base_url('master/e_schedule/' . $day['id']) ?>" method="post">
                                <div class="form-group">
                                  <label for="editTitle">Event Title</label>
                                  <input type="text" class="form-control" id="editTitle" name="title" value="<?= $day['title'] ?>" required>
                                </div>
                                <div class="form-group">
                                  <label for="editDate">Event Date</label>
                                  <?php echo $day['date'] ?>
                                  <input type="date" class="form-control" id="editDate" name="date" value="<?= $day['date'] ?>" required>
                                </div>
                                <div class="form-group">
                                  <label for="editCategory">Event Category</label>
                                  <select class="form-control" id="editCategory" name="category">
                                    <option value="close" <?= ($day['category'] == 'close') ? 'selected' : '' ?>>Close</option>
                                    <option value="open" <?= ($day['category'] == 'open') ? 'selected' : '' ?>>Open</option>
                                  </select>
                                </div>
                                <button type="submit" class="btn btn-warning float-right">Save Changes</button>
                            </form>
                          </div>
                        </div>
                      </div>
                      </div>
                  <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<br>

<!-- Day Close Modal -->
<div class="modal fade" id="dayCloseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Operation Close</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url()?>/master/add_schedule" method="POST">
          <div class="form-group">
              <label for="eventTitle">Title</label>
              <input type="text" class="form-control" name="title" id="inputETitle" placeholder="Enter title" required>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Select Date</label>
              <input type="date" class="form-control" name="date" id="inputETitle" required>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Select Category</label>
              <select name="category" id="filterCategory" class="form-control">
                <option value="close">--- Select category ---</option>
                  <option value="close">Close</option>
                  <option value="close">Open</option>
              </select>
            </div>

            <button type="submit" class="btn btn-success float-right">Set Close Operation</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Day Open Modal -->
<div class="modal fade" id="dayOpenModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Special Open</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url()?>/master/add_schedule" method="POST">
          <div class="form-group">
              <label for="eventTitle">Title</label>
              <input type="text" class="form-control" name="title" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter title">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Select Date</label>
              <input type="date" class="form-control" name="date" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Select Category</label>
              <select name="category" id="filterCategory" class="form-control">
                <option value="close">--- Select category ---</option>
                  <option value="close">Close</option>
                  <option value="open">Open</option>
              </select>
            </div>
            <button type="submit" class="btn btn-success float-right">Set Special Open</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit Operation Close -->

<div class="modal fade" id="editOperationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Day Open Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url()?>/master/add_schedule" method="POST">
          <div class="form-group">
              <label for="eventTitle">Title</label>
              <input type="text" class="form-control" name="title" id="editTitle" aria-describedby="emailHelp" placeholder="Enter title">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Select Date</label>
              <input type="date" class="form-control" name="date" id="editDate" aria-describedby="emailHelp" placeholder="Enter email">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Select Category</label>
              <select name="category" id="editCategory" class="form-control">
                <option value="close">--- Select category ---</option>
                  <option value="close">Close</option>
                  <option value="close">Open</option>
              </select>
            </div>
            <div class="row">
              <input type="submit" value="Save Holiday" class="btn btn-success">
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
        $(document).ready(function() {
            $('#dataTable1').DataTable();
            $('#dataTable2').DataTable();
        });
    </script>


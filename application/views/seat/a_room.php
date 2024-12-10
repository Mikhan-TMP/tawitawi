<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

<a href="<?= base_url('Seat'); ?>" class="btn btn-secondary btn-icon-split mb-4">
  <span class="icon text-white">
    <i class="fas fa-chevron-left"></i>
  </span>
  <span class="text">Back</span>
</a>

<form action="" method="POST" class="col-lg-5  p-0">
  <div class="card">
    <h5 class="card-header">Room reservation</h5>
    <div class="card-body">            
        <div class="col-lg-2">
            <div class="form-group">
            <label for="floor" class="col-form-label">Floor</label>
            <input type="text"  class="form-control form-control-lg" name="floor" >
            <?= form_error('d_id', '<small class="text-danger">', '</small>') ?>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
            <label for="room" class="col-form-label">Room name</label>
            <input type="text"  class="form-control form-control-lg" name="room" >
            <?= form_error('d_id', '<small class="text-danger">', '</small>') ?>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
            <label for="date" class="col-form-label">Date</label>
            <input type="text" class="form-control form-control-lg" name="date" id="date" > 
            <?= form_error('d_id', '<small class="text-danger">', '</small>') ?>
            </div>
        </div>
        <div class="row">
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label for="start_time" class="col-form-label">Start Time</label>
                        <select class="form-control" name="start_time" id="start_time">                                                    
                          <option value=8 > 8AM</option>
                          <option value=9 >9AM</option>
                          <option value=10 >10AM</option>
                          <option value=11 >11AM</option>
                          <option value=12 >12PM</option>
                          <option value=13 >1PM</option>
                          <option value=14 >2PM</option>
                          <option value=15 >3PM</option>
                          <option value=16 >4PM</option>
                          <option value=17 >5PM</option>
                          <option value=18 >6PM</th>   
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label for="start_time" class="col-form-label">End Time</label>
                          <select class="form-control" name="end_time" id="end_time">                                                    
                            <option value=8 > 8AM</option>
                            <option value=9 >9AM</option>
                            <option value=10 >10AM</option>
                            <option value=11 >11AM</option>
                            <option value=12 >12PM</option>
                            <option value=13 >1PM</option>
                            <option value=14 >2PM</option>
                            <option value=15 >3PM</option>
                            <option value=16 >4PM</option>
                            <option value=17 >5PM</option>
                            <option value=18 >6PM</th>   
                          </select>                        
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label for="Noa" class="col-form-label"> No of Attendee </label>
                        <input type="number" class="form-control" min=1  max =50 name="Noa"  id="Noa" >
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label for="e_title" class="col-form-label">Title </label>
                        <input type="text" class="form-control" name="e_title" id="e_title" value="<?= " Seminar of Mathmetics" ?>">                      
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label for="Organizer" class="col-form-label">Organizer</label>
                        <input type="text" class="form-control" name="Organizer" id='Organizer' >
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group">
                        <label for="contact" class="col-form-label">Contact number </label>
                        <input type="tel" class="form-control" name="contact" id="contact"  >
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="email" class="col-form-label"> Email  </label>
                        <input type="email" class="form-control" name="email"  id="email" >
                      </div>
                    </div>                  
                  </div>
                  <div class="row">                  
                    <div class="col-lg-10">
                      <div class="form-group">
                        <label for="description" class="col-form-label">Description </label>
                        <textarea class="form-control" rows="5"  data-mdb-showcounter="true" maxlength="200" id="description"><?= " Seminar of Mathmetics" ?></textarea>                 
                      </div>
                    </div>  
                  </div>
        
        <button type="submit" class="btn btn-success btn-icon-split mt-4 float-right">
          <span class="icon text-white">
            <i class="fas fa-plus-circle"></i>
          </span>
          <span class="text">Add to system</span>
        </button>      
    </div>
  </div>
</form>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
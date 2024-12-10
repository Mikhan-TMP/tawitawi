       <!-- Begin Page Content -->
       <div class="container-fluid">

         <!-- Page Heading -->
         <div class="d-sm-flex align-items-center justify-content-between mb-4">
           <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
         </div>

         <!-- Content Row -->
         <div class="row">

           <div class="col">
             <div class="row">

               <!-- Area Chart -->
               <div class="col-xl-12 col-lg-7">
                 <div class="card shadow mb-4" style="min-height: 543px">
                   <!-- Card Header - Dropdown -->
                   <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                     <h6 class="m-0 font-weight-bold text-gray-700">Attendance Check</h6>
                     <!-- div class="col-lg-3">                            
                        <button type="submit" class="btn btn-success btn-icon-split mt-2 float-right">
                          <span class="icon text-white"> <i class="fas fa-plus-circle"></i>  </span>
                          <span class="text">get attendance data</span>
                        </button>
                      </div>
                      <div class="col-lg-3">
                        <button type="" class="btn btn-primary btn-icon-split mt-2 float-right">
                          <span class="icon text-white"> <i class="fas fa-plus-circle"></i>  </span>
                          <span class="text">Check In</span>
                        </button>
                      </div>
                      <div class="col-lg-3">
                        <button type="" class="btn btn-info btn-icon-split mt-2 float-right">
                          <span class="icon text-white"> <i class="fas fa-plus-circle"></i>  </span>
                          <span class="text">Check Out</span>
                        </button>
                      </div -->
                   </div>
                   <Card Body >
                   <div class="card-body">
                     <?php if ($weekends == true) : ?>
                       <h1 class="text-center my-3">THANK YOU FOR THIS WEEK!</h1>
                       <h5 class="card-title text-center mb-4 px-4">Have a Good Rest this <b>WEEKEND</b></h5>
                       <b><p class="text-center text-primary pt-3">See You on Monday!</p></b>
                       <div class="row">
                         <button disabled class="btn btn-danger btn-circle mx-auto" style="font-size: 35px; width: 200px; height: 200px">
                           <i class="fas fa-fw fa-sign-out-alt fa-2x"></i>
                         </button>
                       </div>
                     <?php else : ?>
                       <?php if ($in == false) : ?>                        
                         <form action="<?= base_url('attendance') ?>" method="POST">                          
                          <div class="row mb-3">
                             <div class="table-responsive">
                                <table class="table table-bordered" id="AttendTable" width="100%" cellspacing="0">
                                  <thead class="text-white" style="background-color: #C41E3A;">
                                    <tr>
                                      <tr>                                        
                                        <th class="header">Name</th>
                                        <th class="header">SR code</th> 
                                        <th class="header">College</th>
                                        <th class="header">Course</th>
                                        <th class="header">Floor</th>
                                        <th class="header">Time In</th>
                                        <th class="header">Time Out</th>
                                        <!-- th class="header">Image</th> 
                                        <th class="header">Detail</th -->                                        
                                      </tr>
                                      <tr>                                        
                                        <th class="header"><input class="form-control" type="text" id="sname" placeholder="xxxxxx" value="" name="sname" ></th>
                                        <th class="header"><input class="form-control" type="text" id="srcode"  value="" name="srcode" ></th> 
                                        <th class="header"> <select class="form-control" name="sel_course"  id='sel_course'>
                                             <option value=''>-- Select course --</option>
                                             <?php 
                                                    foreach($course as $c_course){
                                                      echo "<option value='".$c_course['course']."'>".$c_course['course']."</option>";
                                                    }
                                                    ?>
                                                  </select> </th>                                        
                                        <th class="header"><select class="form-control" name=" floor" id="floor">
                                                            <option value="">- All --</option>
                                                            <option value="GF">GF</option>
                                                            <option value="2F">2F</option>
                                                            <option value="3F">3F</option>                                                           
                                                            <option value="4F">4F</option>
                                                            <option value="5F">5F</option>
                                                            <option value="6F">6F</option>                                                             
                                                            <option value="7F">7F</option>                                                             
                                                            </select></th>
                                        <th class="header"></th>
                                        <th class="header"></th>
                                        <th class="header"></th>
                                      </tr>

                                  </thead>                                  
                                  <tbody>   
                                  <?php foreach ($attendance as $attend) :  ?>                                 
                                      <tr>
                                        <td><?php if(isset($attend['username'])) echo $attend['username']; else echo "no data"; ?></td>
                                        <td><?php if(isset($attend['srcode'])) echo $attend['srcode']; else echo "no data"; ?></td>   
                                        <td><?php if(isset($attend['course'])) echo $attend['course']; else echo "-"; ?> </td>                                     
                                        <td><?php if(isset($attend['course'])) echo $attend['course']; else echo "-"; ?> </td>
                                        <td><?php if(isset($attend['floor'])) echo $attend['floor']; else echo "-"; ?></td>                                        
                                        <td><?php if(isset($attend['in_time'])) echo $attend['in_time']; else echo "-"; ?></td>                                        
                                        <td><?php if(isset($attend['out_time'])) echo $attend['out_time']; else echo "-"; ?></td>                                        
                                        <!-- td class="text-center"><img src="<?= base_url('images/pp/') . "s2.png" ?>" style="width: 40px; height:40px" class="img-rounded"> </td -->
                                        <!-- td class="align-middle text-center">
                                              <a href="" class="btn btn-primary btn-circle">
                                                <span class="icon text-white" title="Edit"> <i class="fas fa-edit"></i> </span>
                                              </a> </td -->
                                      </tr>                                    
                                      <?php endforeach; ?>
                                  </tbody>
                                </table>
                              </div> 
                          </form>
                       <?php else : ?>
                         <h3 class="text-center my-3">THANK YOU FOR TODAY</h3>
                         <h6 class="card-title text-center mb-4 px-4">The world of business survives less on leadership skills and more on the commitment and dedication of passionate employees like you.<br>Thank you for your hard work.</h6>
                         <?php if ($disable == false) : ?>
                           <b><p class="text-center text-primary pt-3">Check Out!</p></b>
                           <div class="row">
                             <a href="<?= base_url('attendance/checkout') ?>" onclick="return confirm('Check out now? Make sure you are done with you work!')" class="btn btn-danger btn-circle mx-auto" style="font-size: 35px; width: 200px; height: 200px">
                               <i class="fas fa-fw fa-sign-out-alt fa-2x"></i>
                             </a>
                           <?php else : ?>
                             <b><p class="text-center text-primary pt-3">See You Tomorrow!</p></b>
                             <div class="row">
                               <button disabled class="btn btn-danger btn-circle mx-auto" style="font-size: 35px; width: 200px; height: 200px">
                                 <i class="fas fa-fw fa-sign-out-alt fa-2x"></i>
                               </button>
                             <?php endif; ?>
                             </div>
                           <?php endif; ?>
                         <?php endif; ?>
                           </div>
                   </div>
                 </div>
               </div>
             </div>
           </div>
           <!-- End  -->
         </div>
         <!-- /.container-fluid -->

       </div>
       <!-- End of Main Content -->
    
    
    
<script>
$(document).ready(function() {
  var table = $('#AttendTable').DataTable({
        columns: [
            { title: 'Name' },
            { title: 'Position' },
            { title: 'Office' },
            { title: 'Age' },
            { title: 'Start date' },
            { title: 'Salary' }
        ]
    });
    function filterData() {                
        $.ajax({
            url: 'your_data_endpoint', // Replace with your actual data endpoint
            method: 'GET',
            data: {
                name: $('#filterName').val(),
                position: $('#filterPosition').val(),
                office: $('#filterOffice').val(),
                age: $('#filterAge').val(),
                startDate: $('#filterStartDate').val(),
                salary: $('#filterSalary').val(),
            },
            success: function(response) {
                // Update the DataTable with the new data
                table.clear().rows.add(response).draw();
            },
            error: function(error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    // Event listeners for select inputs
    $('#filterName, #sel_course, #gender, #floor ')
        .on('change', function() {
            filterData();
        });

    // Initial data load
    filterData();
});
</script>
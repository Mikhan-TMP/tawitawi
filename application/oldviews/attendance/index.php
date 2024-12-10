<!-- Begin Page Content -->
<div class="container-fluid">          
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>         
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col">
            <div class="row">
                <!-- Area Chart -->
                <div class="col-xl-12 col-lg-7">
                
                </div>
                <div class="col-lg-12 mb-4">
                        <div class="row">
                            <div class="col-lg-2">
                                <label for="startDate" class="text-dark" style="font-weight: bold;">Start Date</label>
                                <input type="date" id="startDate" name="startDate" class="form-control"
                                style="border-radius:10px;  padding: 15px;">
                            </div>
                            <div class="col-lg-2">
                                <label for="endDate" class="text-dark" style="font-weight: bold;">End Date</label>
                                <input type="date" id="endDate" name="endDate" class="form-control"
                                style="border-radius:10px;  padding: 15px;">
                            </div>
                            <div class="col-lg-6">
                                <!-- <button type="submit" class="mt-4 btn btn-md btn-fill text-light" style=" background: linear-gradient(180deg, #0F25EE, #1F2DB0);">Show</button>
                                &nbsp &nbsp -->
                                <!-- <button type="button" id="exportCsv" class=" mt-4 btn btn-md btn-fill text-light" style=" background: linear-gradient(180deg, #0F25EE, #1F2DB0);">Export CSV</button> -->
                            </div>
                            <div class="col">
                                <!-- <input class="form-control mt-4" type="text" id="searchInput" placeholder="Search"> -->
                            </div>
                        </div>
                    </div>
                <div class="col-xl-12 col-lg-7">
                    <div class="card shadow mb-4" style="min-height: 543px">
                        <!-- Card Header - Dropdown -->
                        <!-- <form action="" method="get">
                            <div class="text-right p-2 mr-3">
                                <button type="submit" name="submit" value="Print" class="btn btn-md btn-fill text-light" style="background-color: #6f1926;">Print</button>
                            </div>
                        </form> -->
                        <form action="" method="POST">
                        <div class="card-header py-3 d-flex" 
                                style="justify-content: space-between;
                                    border-top-left-radius: 15px;
                                    border-top-right-radius: 15px;
                                    background: linear-gradient(180deg, #0F25EE, #1F2DB0);
                                    ">
                            <div class="d-flex align-items-center">
                                <h6 class="m-0 text-light" 
                                    style="font-size:1.5rem;
                                    font-family: 'Inter', sans-serif;">Attendance Sheet</h6>
                            </div>
                            <div class="">
                                <!-- excel icon -->
                                
                                <button type="button" id="exportCsv" class="btn btn-md btn-fill" style="color: green; background: #FFFFFF;">
                                    <i class="fas fa-file-excel"></i>
                                Export CSV</button>
                            </div>
                        </div>
                        
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table" id="dataTable" width="100%" cellspacing="0">
                                                <thead style="color: #272727; font-weight: 500;">
                                                    <tr>
                                                        <!-- Header columns here -->
                                                        <th class="header">Name</th>
                                                        <th class="header">SR code</th> 
                                                        <th class="header">College</th>
                                                        <th class="header">Course</th>
                                                        <th class="header">Kiosk</th>
                                                        <th class="header">Time In</th>
                                                        <th class="header">Time Out</th>
                                                        <th class="header">Duration</th>
                                                    </tr>
                                                    <!-- <tr>                                        
                                                        <th class="header">
                                                        </th>
                                                        <th class="header"></th>
                                                        <th class="header"></th>
                                                        <th class="header">
                                                            
                                                        </th>                                        
                                                        <th class="header"></th>
                                                        <th class="header"></th>
                                                        <th class="header"></th>
                                                        <th class="header">
                                                            <input class="form-control" type="text" id="searchInput" placeholder="Search">
                                                        </th>
                                                    </tr> -->
                                                </thead>                                  
                                                <tbody style="color: #272727;">  
                                                    <?php foreach ($attendance as $attend) :  ?>
                                                        <tr>
                                                            <!-- Data rows here -->
                                                            <td><?php if(isset($attend['username'])) echo $attend['username']; else echo "no data"; ?></td>
                                                            <td><?php if(isset($attend['srcode'])) echo $attend['srcode']; else echo "no data"; ?></td>                                        
                                                            <td><?php if(isset($attend['college'])) echo $attend['college']; else echo "-"; ?> </td>
                                                            <td><?php if(isset($attend['course'])) echo $attend['course']; else echo "-"; ?> </td>
                                                            <td><?php if(isset($attend['kiosk'])) echo $attend['kiosk']; else echo "-"; ?></td>
                                                            <td><?php if(isset($attend['in_time'])) echo $attend['in_time']; else echo "-"; ?></td>                                        
                                                            <td><?php if(isset($attend['out_time'])) echo $attend['out_time']; else echo "-"; ?></td>
                                                            <td>
                                                            <?php if (isset($attend['in_time']) && isset($attend['out_time'])) {
                                                                    $inTime = strtotime($attend['in_time']);
                                                                    $outTime = strtotime($attend['out_time']);
                                                                    $timeDifference = $outTime - $inTime;
                                                                    $formattedTimeDifference = gmdate("H:i:s", $timeDifference);
                                                                    echo $formattedTimeDifference;
                                                                } else {
                                                                    echo "-";
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>                                    
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>                
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End  -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- End of Main Content -->

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // $('#searchInput').on('keyup', function () {
        //     var value = $(this).val().toLowerCase();
        //     $('.table tbody tr').filter(function () {
        //         $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        //     });
        // });

        // // Handle form submission to trigger date filtering
        // $('form').on('submit', function (event) {
        //     event.preventDefault(); // Prevent default form submission

        //     filterByDate(); // Call function to filter table rows by date
        // });

        // // Function to filter table rows based on date range
        // function filterByDate() {
        //     var startDate = $('#startDate').val();
        //     var endDate = $('#endDate').val();

        //     if (startDate && endDate) {
        //         var start = new Date(startDate).getTime();
        //         var end = new Date(endDate).getTime();

        //         $('#dataTable tbody tr').each(function () {
        //             var inTime = new Date($(this).find('td').eq(5).text()).getTime();

        //             if (inTime >= start && inTime <= end) {
        //                 $(this).show();
        //             } else {
        //                 $(this).hide();
        //             }
        //         });
        //     }
        // }
        var dataTable = $('#dataTable').DataTable(); // Initialize DataTable

        // Custom filter event
        $('#startDate, #endDate').on('change', function () {
            dataTable.draw(); // Redraw DataTable on date input change
        });

        // Custom date range filter
        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();
            
            // Date in 'Time In' column (assuming it's in 5th column)
            var inTimeText = data[5] || ""; // use the proper index for your 'Time In' column
            var inTime = new Date(inTimeText).getTime();

            if (startDate) {
                var start = new Date(startDate).getTime();
            }
            if (endDate) {
                var end = new Date(endDate).getTime() + 86400000; // Include end day fully
            }

            // Apply filter
            if (
                (!startDate || inTime >= start) &&
                (!endDate || inTime <= end)
            ) {
                return true;
            }
            return false;
        });
        $('#exportCsv').on('click', function () {
            var csv = [];
            var rows = $(".table tr:visible");

            // Get headers
            var headers = [];
            $(rows[0]).find('th').each(function() {
                headers.push($(this).text().trim());
            });
            csv.push(headers.join(","));

            // Get data
            $(rows).slice(2).each(function() {  // Skip filter row
                var row = [];
                $(this).find('td').each(function() {
                    var cellData = $(this).text().trim().replace(/(\r\n|\n|\r)/gm, '');  // Remove newline characters
                    cellData = cellData.replace(/"/g, '""');  // Escape double quotes
                    row.push('"' + cellData + '"');  // Enclose in double quotes
                });
                csv.push(row.join(","));
            });

            // Download CSV
            var csvFile = new Blob([csv.join("\n")], {type: "text/csv"});
            var downloadLink = document.createElement("a");
            downloadLink.download = "attendance.csv";
            downloadLink.href = window.URL.createObjectURL(csvFile);
            downloadLink.style.display = "none";
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        });
    });
</script>
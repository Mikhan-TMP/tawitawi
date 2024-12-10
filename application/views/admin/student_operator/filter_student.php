<!DOCTYPE html>
<html>
<head>
	<title>DataTables AJAX pagination with Custom filter in CodeIgniter</title>

	<!-- Datatable CSS -->
	<link href='https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>

	<!-- jQuery Library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Datatable JS -->
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

</head>
<body>

	<!-- Search filter -->
	<div>
		<!-- City -->
		<select id='sel_city'>
			<option value=''>-- Select city --</option>
			<?php 
			foreach($cities as $city){
				echo "<option value='".$city['course']."'>".$city['course']."</option>";
			}
			?>
		</select>

		<!-- Gender -->
		<select id='sel_gender'>
			<option value=''>-- Select Gender --</option>
			<option value='M'>M</option>
			<option value='F'>F</option>
		</select>

		<!-- Name -->
		<input type="text" id="searchName" placeholder="Search Name">
	</div>

	<!-- Table -->
	<table id='userTable' class='display dataTable'>

	  <thead>
	    <tr>
		<th>first Name</th>
		<th>Last Name</th>
		<th>srcode</th>
		<th>program</th>
		<th>rfid</th>
		<th>qrcode</th>
		<th>gender</th>
		<th>course</th>
		<th>schoolyear</th>
		<th>actions</th>
	    </tr>
	  </thead>

	</table>

	<!-- Script -->
	<script type="text/javascript">
	$(document).ready(function(){
	   	var userDataTable = $('#userTable').DataTable({
	      	'processing': true,
	      	'serverSide': true,
	      	'serverMethod': 'post',
	      	//'searching': false, // Remove default Search Control
	      	'ajax': {
	          'url':'<?=base_url()?>index.php/Filter_Data/userList',
	          'data': function(data){
	          		data.searchCity = $('#sel_city').val();
	          		data.searchGender = $('#sel_gender').val();
	          		data.searchName = $('#searchName').val();
	          }
	      	},
	      	'columns': [
	         	{ data: 'first_name' },
	         	{ data: 'last_name' },
	         	{ data: 'srcode' },
	         	{ data: 'program' },
	         	{ data: 'rfid' },
				 { data: 'qrcode' },
	         	{ data: 'gender' },
	         	{ data: 'course' },
	         	{ data: 'schoolyear' }
	      	]
	   	});

	   	$('#sel_city,#sel_gender').change(function(){
	   		userDataTable.draw();
	   	});
	   	$('#searchName').keyup(function(){
	   		userDataTable.draw();
	   	});
	});
	</script>
</body>
</html>




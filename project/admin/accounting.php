
<?php
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0)
{ 
	header('location:index.php');
}
else{
	$Programmer=4;
	$English=5;
	$Finance=4;

	?>
	<!DOCTYPE html>
	<html lang="en">
	<head>

		<title>  Add Category</title>

		<!-- App css -->
		
		<link href="assets/css/jquery.datatables.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/core.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/components.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="../plugins/switchery/switchery.min.css">
		<script src="assets/js/modernizr.min.js"></script>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ"
		crossorigin="anonymous" />
		<style>
			body *{
				font-family: "phetsarath OT";
				font-size: 12px;
			}
			input[type=text] {
				border: 2 solid gold;
				border-radius: 10px;
				height: 45px;
			}
		</style>

	</head>
	
	<body class="fixed-left" ng-app='myapp'>
		<div id="wrapper" ng-controller="fetchCtrl">
			<?php include('includes/topheader.php');?>
			<?php include('includes/leftsidebar.php');?>
			<div class="content-page">
				<div class="content">
					<div class="container">
						<div class="row">
							<div class="col-xs-12">
								<div class="page-title-box">
									<h4 class="page-title">ພາກເຊົ້າ</h4>
									<ol class="breadcrumb p-0 m-0">
										<li>
											<a href="<?php echo header('refesrch:0'); ?>">Refesft</a>
										</li>
										<li>
											<a href="#">ນັກຮຽນ</a>
										</li>
										<li class="active"> view</li>
									</ol>
								</div>
							</div>
						</div>
						<div class="card-box bg-success">
							<div class="row">
								<div class="col-xs-8">
									<div id="piechart"></div>
								</div>	
								<div class="col-xs-4">
									<div class="table-responsive">
										<table class="table table-bordered table-striped" width="100%">
											<thead>
												<tr>
													<th>ຈ່່າຍແລ້ວ</th>
													<th>ຈ່າຍເຄີງໜື່ງ</th>
													<th>ບໍ່ທັນຈ່າຍ</th>
												</tr>
											</thead>
											<tbody>
												<?php
   $sql=mysqli_query($con,"SELECT `SID`, `SName`, `Slastname`, `DName`, `STname`, `Yname`,COUNT( PTstatus)as count , `PTmoney` FROM `viewpay` WHERE PTstatus=2 and DName='Finance And Accounting Audit' ");
      if($row=mysqli_fetch_assoc($sql));
   $sql=mysqli_query($con,"SELECT `SID`, `SName`, `Slastname`, `DName`, `STname`, `Yname`,COUNT( PTstatus)as count , `PTmoney` FROM `viewpay` WHERE PTstatus=1 and DName='Finance And Accounting Audit'  ");
      if($rows=mysqli_fetch_assoc($sql));
   $sql=mysqli_query($con,"SELECT `SID`, `SName`, `Slastname`, `DName`, `STname`, `Yname`,COUNT( PTstatus)as count , `PTmoney` FROM `viewpay` WHERE PTstatus=0 and DName='Finance And Accounting Audit'  ");
      if($rw=mysqli_fetch_assoc($sql));
												?>
												<tr>
													<td><?php echo $row['count']; ?></td>
													<td><?php echo $rows['count']; ?></td>
													<td><?php echo $rw['count']; ?></td>
												</tr>
												
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="card-box">
							<div class="form-inline">
								<label for="time">ພາກຮຽນ:</label>
								<select name="searchText" ng-model='searchText' class="form-control">
	<?php 
     $sql= mysqli_query($con,"SELECT * FROM `tbl_shoolterm`");
     while ($row=mysqli_fetch_array($sql)){?>  
                    <option><?php echo $row['STname']; ?></option>
                    <?php } ?>
								</select>
								<label for=year>ປີຮຽນ:</label>
								<select name="searchsarary" ng-model='searchsarary' class="form-control">
									<option>1</option>
									<option>2</option>
									<option>3</option>
								</select>&nbsp;&nbsp;
						<button type="button" class="btn btn-danger btn-lg" ng-click="fetch()" >ຄົ້ນຫາ</button>

							</div>
						</div>
						<div class="card-box">
							<div class="row">
								<div class="col-xs-12">
									<div class="table-responsive">
										<table class="table table-bordered table-striped" width="100%" id="sent">
											<thead>
												<tr>
													<th>ລະຫັດນັກສືກສາ</th>
													<th>ຊື່ນັກ ສືກສາ</th>
													<th>ນາມສະກຸນ ນັກສືກສາ</th>
													<th>ວິຊາທີ່ຮຽນ</th>
													<th>ພາກຮຽນ</th>
													<th>ປີທີ່ຮຽນ</th>
													<th>ຄ່າຮຽນທີ່ຈ່າຍ</th>
												</tr>
											</thead>
											<tbody>
												<tr  ng-repeat='students in student'>
													<td>{{students.SID}}</td>
													<td>{{students.SName}}</td>
													<td>{{students.Slastname}}</td>
													<td>{{students.DName}}</td>
													<td>{{students.STname}}</td>
													<td>{{students.Yname}}</td>
													<td>{{students.PTmoney}}</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php include('includes/footer.php');?>
			</div>

		</div>
		<script>
			var resizefunc = [];
		</script>

		<!-- jQuery  -->

		<script src="assets/js/chart.load.js"></script>
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/detect.js"></script>
		<script src="assets/js/fastclick.js"></script>
		<script src="assets/js/jquery.blockUI.js"></script>
		<script src="assets/js/waves.js"></script>
		<script src="assets/js/jquery.slimscroll.js"></script>
		<script src="assets/js/jquery.scrollTo.min.js"></script>
		<script src="../plugins/switchery/switchery.min.js"></script>
		<script src="assets/js/jquery.datatables.min.js"></script>
		<script src="assets/js/table.bootstrap.min.js"></script>


		<!-- App js -->
		<script src="assets/js/jquery.core.js"></script>
		<script src="assets/js/jquery.app.js"></script>
		<script type="text/javascript"></script>

		<script type="text/javascript">
			$(document).ready(function() {
				$('#sent').DataTable();
			} );
		</script>

		<script type="text/javascript">
      // Load google charts
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

     // Draw the chart and set the chart values
     function drawChart() {
     	var a=<?php  echo $Programmer; ?>;
     	var b=<?php  echo $English; ?>;
     	var c=<?php  echo $Finance; ?>;
     	var data = google.visualization.arrayToDataTable([
     		['Task', 'ປະມວນຜົນອັດຕາສະເລ່ຍ....'],
     		['Programmer Development', a],
     		['English Business', b],
     		['Finance And Accounting Audit', c]

     		]);

  // Optional; add a title and set the width and height of the chart
  var options = {'title':'ປະມວນຜົນອັດຕາສະເລ່ຍ....', 'width':800, 'height':350};

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
}
</script>
<script  src="assets/js/angular.min.js"></script>
    <script>
        var fetch = angular.module('myapp', []);

        fetch.controller('fetchCtrl', ['$scope', '$http', function ($scope, $http) {

            $scope.fetch = function(){
                
                var searchText = $scope.searchText;
                var searchsarary=$scope.searchsarary;
                if(searchText == undefined){
                    searchText = '';
                    searchsarary='';
                }

                $http({
                method: 'post',
                url: 'content/getaccount.php',
                data: {searchText:searchText,searchsarary:searchsarary}
                }).then(function successCallback(response) {
                    $scope.student = response.data;
                });
            }

            $scope.fetch();
        }]);

        </script>
</body>
</html>
<?php
}
?>

  
<?php
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0)
{ 
  header('location:index.php');
}
else{
  $_SESSION['msg'];

  if(isset($_POST['btn_search'])){
    
  $code=$_REQUEST['txt_id'];
   $sname=$_REQUEST['txt_names'];
   $slname=$_REQUEST['txt_lnames'];

   $code;
   $names="";
   $lnames="";
   $sql_s=mysqli_query($con,"SELECT * FROM `viewstudent` WHERE (SName='$sname' and Slastname='$slname') and (Yname= 1 and SID='$code') ");
    $rw=mysqli_fetch_array($sql_s);
    if($rw>0)
    {

         $code=$rw['SID'];
         $names=$rw['SName'];
         $lnames=$rw['Slastname'];

     
    }
    else
    {
      $error="ຊື່ທີ່ ທ່ານປ້ອນບໍ່ມີໃນລະບົບ";
    }
}



// this is code save dataTable to tb_two



if(isset($_POST['btn_saveth'])){ 

  $id_th=$_REQUEST['txt_code'];
  $date=date("Y:m:d");
 $sql_th=mysqli_query($con,"UPDATE `tbl_student` SET `s_active`=2,YID=10  WHERE `SID`='$id_th'");
 if($sql_th){
   $sql_t=mysqli_query($con,"UPDATE `tbl_register` SET `SFID`=0,`YID`=10,`Rdate`='$date',`R_active`=2  WHERE `SID`='$id_th'");

   $sectecl=mysqli_query($con,"SELECT * from tbl_register where SID='$id_th'");
        if($row=mysqli_fetch_array($sectecl)){
           $RID=$row['RID'];
        }
          $inserpay=mysqli_query($con,"INSERT INTO `tbl_paystudent`(`SFID`, `RID`, `SID`, `YID`, `PTstatus`, `PTmoney`, `P_datae`, `py_active`) VALUES (0,'$RID','$id_th',10,0,0,'$date',2)");
          
    if($inserpay)
    {
      $msg="ບັນທືກ ສຳເລັດແລ້ວ";

      header("refresh:2; url=add_studentup.php");
    }
}
else{
  $error =" ມີບ້າງຍ່າງຜີດພາດ";

}


}
// end save

///edit


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
  <!--       <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css"> -->
  <script src="assets/js/modernizr.min.js"></script>
  <script src="assets/js/sweetalert.min.js"></script>
  <!--       <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script> -->

  <style>

   body *{
    font-family: "phetsarath OT";
    font-size: 12px;
  }
  td{
    font-size: 12px !important;
  }
  th{
    font-size: 12px !important;
  }
</style>

</head>
<body class="fixed-left">
  <div id="wrapper">
    <?php include('includes/topheader.php');?> 
    <?php include('includes/leftsidebar.php');?>
    <br>
    <div class="content-page">
     <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
           <div class="page-title-box">
            <h4 class="page-title" style="font-family: 'phetsarath OT'">ເພີ່ມຂໍ້ມູນນັກສືກສາ</h4>
            <ol class="breadcrumb p-0 m-0">
              <li>
                <a href="#">Admin</a>
              </li>
              <li>
                <a href="#">ນັກສືກສາ</a>
              </li>
              <li class="active">
                ADD  
              </li>
            </ol>
            <div class="clearfix"></div>
          </div>

          <!-- ............................. -->
          <div class="row">
           <div class="col-xl-12">
            <div class="card-box" style="background: #E5F1FB;">
              <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">ນັກສືກສາທິ່ ສະມັກເຂົ້າຮຽນຕໍ່ລະບົບຊັ້ນສຸງ</a>
                <form class="form-inline my-2 my-lg-1">
                  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#Search">
                    Search
                  </button>
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal<?php echo $code; ?>">
                    Add
                  </button>
                  <a href="add_studentup.php" class="btn btn-secondary">Refesrch</a>
                  <br><br>
                  <div>
                   <?php if($error){ ?>
                    <div class="alert alert-danger" role="alert">
                      <strong>Oh error!</strong> <?php echo htmlentities($error);?></div>
                    <?php } ?>

                    <?php if($msg){ ?>
                      <div class="alert alert-info" role="alert">
                        <strong>Oh snap!</strong> <?php echo htmlentities($msg);?></div>
                      <?php } ?>

                    </div>
                  </form>                                          
                </nav>
                <form  method="post" class="form-inline">
                  <div class="form-group">
                    <input type="text" id="id" name="id" class="form-control my-2 mr-sm-2" required placeholder="ລະຫັດນັກສາ" value="<?php echo $code; ?>">
                  </div>
                  <div class="form-group">
                   <input type="text" id="id" name="id" class="form-control my-2 mr-sm-2" required placeholder="ຊື່ ນັກສືສາ" value="<?php echo $names; ?>">
                 </div>
                 <div class="form-group">
                  <input type="text" id="id" name="id" class="form-control my-2 mr-sm-2" required placeholder="ນາມສະກຸນ" value="<?php echo $lnames; ?>">
                </div>
                <div class="form-group ">
                 <select class="form-control mr-sm-2" id="year1" name="sellist1">
                   <option>2</option>
                 </select>
               </div>
             </form><br>
             <hr>

             <div class="table-responsive">
              <table id="example" class="table table-striped table-bordered table-colored table-danger" style="width:100%">

               <thead>
                <tr>
                  <th>ລະຫັດນັກສືກສາ</th>
                  <th>ວັນທີສະມັກຮຽນ</th>
                  <th>ຊື່ນັກສືກສາ</th>
                  <th>ນາມສະກຸນ</th>
                  <th>ວິຊາຮຽນ</th>
                  <th>ພາກຮຽນ</th>           
                  <th>ຫຼັກສູດ</th>
                  <th>ເບິໂທລະສັບ </th>
                  <th>ຢັງຍື່ນ</th>
                </tr>
              </thead>
              <?php
              $id=0;
            $sql_r= mysqli_query($con,"SELECT tbl_student.SID,tbl_student.S_update,tbl_student.SName,tbl_student.Slastname,tbl_deparment.DName,tbl_shoolterm.STname,tbl_years.Yname ,tbl_student.SN_tell FROM tbl_student LEFT JOIN tbl_deparment ON tbl_deparment.DID=tbl_student.DID LEFT JOIN tbl_shoolterm ON tbl_shoolterm.STID=tbl_student.STID LEFT JOIN tbl_years on tbl_years.YID=tbl_student.YID LEFT JOIN tbl_register on tbl_register.SID=tbl_student.SID WHERE tbl_student.S_active=2 and tbl_years.Yname=2 and tbl_register.R_active=0  ");
              while ($row=mysqli_fetch_array($sql_r)) {   
               $id=$row['SID'];       
               ?>
               <tbody>
                <tr> 
                  <td><?php echo $row['SID']; ?></td>
                  <td><?php echo $row['S_update']; ?></td>
                  <td><?php echo $row['SName']; ?></td>
                  <td><?php echo $row['Slastname']; ?></td>
                  <td><?php echo $row['DName']; ?></td>
                  <td><?php echo $row['STname']; ?></td>
                  <td><?php echo $row['Yname']; ?></td> 
                  <td><?php echo $row['SName_tell']; ?></td>

                  <td>  <a href="opentwo.php?id=<?php echo $id; ?>" class="btn btn-warning btn-sm"><i class="fa fa-unlock"></i>ໄດ້ຮຽນ</a></td>
                </tr>

                <!-- /////////////////// -->

                <div  class="container text-left">

 
                <!-- end edit -->
               
              </div>
              <!-- end -->
            </tbody>
          <?php }  $countt; ?>
        </table>
      </div>
      <br>
      <hr>
      <h2 class="text-info h2" style="font-family: 'phetsarath OT'">ລາຍການນັກສືກສາ</h2>
      <div class="form-inline">
                  <form method="POST" name="frmdisplay">
                  <label> ສາຂາວິຊາ:</label>
                  <select name="s_deparment" class="form-control" >
                  <?php 
     $sql= mysqli_query($con,"SELECT * FROM `tbl_deparment`");
     while ($row=mysqli_fetch_array($sql)){?>  
                    <option><?php echo $row['DName']; ?></option>
                    <?php } ?>
                  </select>

                    <label> ພາກຮຽນ:</label>
                  <select name="stime" class="form-control md-3" >
                                <?php 
     $sql= mysqli_query($con,"SELECT * FROM `tbl_shoolterm` `");
     while ($row=mysqli_fetch_array($sql)){?>  
                    <option><?php echo $row['STname']; ?></option>
                    <?php } ?>
                  </select>

                  <input type="submit" class="btn btn-info" name="search" value="ຄົ້ນຫາ">
                  </form>

                </div><br>

                <?php 
    if(isset($_POST['search'])){
      $deparment=$_REQUEST['s_deparment'];
      $times=$_REQUEST['stime'];

      $sql=mysqli_query($con,"SELECT * FROM `viewstudent` WHERE DName='$deparment' and STname='$times' AND S_active=2");

       $check= mysqli_num_rows($sql);

                echo 'ຈຳນວນນັກສຶກສາ :  '. htmlentities($check);} ?><br><br>

                <div class="table-responsive">
                 <table class="table table-bordered table-colored table-info table-striped" width="100%" id="sent">
                  <thead>
                    <tr>
                      <th>ເບີງຂໍ້ມູນ</th>
                      <th>ລະຫັດນັກສືກສາ</th>
                      <th>ວັນທີສະມັກ</th>
                      <th>ຊື່</th>
                      <th>ນາມສະກຸນ</th>
                      <th>ປິ</th>
                      <th>ວີຊາຮຽນ</th>
                      <th>ພາກຮຽນ</th>
                      <th>ບ້ານ</th>
                      <th>ເມືອງ</th>
                      <th>ແຂວງ</th>
                      <th>ເບີໂທລະສັບ</th>
                      <th>ຮຽນຈົບຊັ້ນມໍ</th>
                      <th>ທີ່ໂຮງຮຽນ</th>
                      <th>ສົກປິ</th>
                      <th>ເລກທິໃບປະກາດ</th>
                    </tr>
                  </thead>
                  <tbody>
 <?php

    
 while ($row=mysqli_fetch_array($sql)) {
$id=$row['SID'];
 ?>
                      <tr>
                        <td><a href="view-data-only.php?id=<?php echo $id;?>" target="_black"  class="btn btn-info btn-xs">ເບີງຂໍ້ມູນ</a></td>
                        <td><?php echo  $row['SID']; ?></td>
                        <td><?php echo  $row['Sdate']; ?></td>
                        <td><?php echo  $row['SName']; ?></td>
                        <td><?php echo  $row['Slastname']; ?></td> 
                        <td><?php echo  $row['S_active']; ?></td>
                        <td><?php echo  $row['DName']; ?></td>
                        <td><?php echo  $row['STname']; ?></td>
                        <td><?php echo  $row['SN_village']; ?></td>
                        <td><?php echo  $row['SN_district']; ?></td>
                        <td><?php echo  $row['SN_province']; ?></td>
                        <td><?php echo  $row['SN_tell']; ?></td>
                        <td><?php echo  $row['SN_classroot']; ?></td>
                        <td><?php echo  $row['SN_atschool']; ?></td>
                        <td><?php echo  $row['SN_year']; ?></td>
                        <td><?php echo  $row['SN_number_notice']; ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
    
       
      <!-- modal add -->
      <div class="modal fade " id="Search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">ລົງທະບຽຍປິ 2</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <form name="fromsearch" method="POST">
                <div class="row">
                  <div class="col-sm-8">
                    <div class="form-group">
                      <label for="code">ລະຫັດນັກສືກສາ</label>
                      <input type="text" name="txt_id" id="code" class="form-control" required>
                    </div>
                    <div class="form-group">
                      <label for="code">ຊື່ນັກສືກສາ</label>
                      <input type="text" name="txt_names" id="code" class="form-control" required>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="code">ນາມສະກຸນນັກສືກສາ</label>
                      <input type="text" name="txt_lnames" id="code" class="form-control" required>
                    </div>

                  </div>
                </div>  
                <br>
                <input type="submit" class="btn btn-primary" name="btn_search" value="search">
                <input type="reset" class="btn btn-warning" value="Reset">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </form>
            </div>
          </div>  
        </div>
      </div>
      <!-- end add -->
      <!-- save data -->
      <div  class="container">    
        <div class="modal fade " id="addModal<?php echo $code;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ລົງທະບຽນປີ 2</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <?php 
                $sql_add=mysqli_query($con,"SELECT `SID`, `Sdate`, `SName`, `Slastname`, `DName`, `STname`, `Yname`, `SN_tell` FROM `viewstudentone` WHERE SID ='$code'");
                if($row=mysqli_fetch_assoc($sql_add)){
                  ?>
                  <form  method="POST">
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="code">ລະຫັດນັກສືກສາ</label>
                          <input type="text" name="txt_code" id="code" class="form-control" value="<?php echo  $row['SID']; ?>">
                        </div>
                      </div>
                      <div class="col-sm-8">
                        <div class="form-group">
                          <label for="code">ຊື່ນັກສືກສາ</label>
                          <input type="text" name="txt_name" id="code" class="form-control" value="<?php echo  $row['SName']; ?>">
                        </div>

                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="code"> ນາມສະກຸນນັກສືກສາ</label>
                          <input type="textt" name="txt_lname" id="code" class="form-control" value="<?php  echo  $row['Slastname'];?>">
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label for="code">ປິຮຽນ</label>
                          <input type="text" name="txt_year" id="code" class="form-control" value="<?php  echo  $row['Yname']+1;?>">
                        </div>

                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="code">ພາກຮຽນ</label>
                          <input type="text" name="txt_time" id="code" class="form-control" value="<?php  echo  $row['STname'];?>">
                        </div>

                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="forn-group">
                          <label for="deparment">ວິຊາທີ່ຮຽນ</label>
                          <input type="text" name="txt_deparment" class="form-control" value="<?php  echo  $row['DName'];?>">
                        </div>
                      </div>
                    </div><br>
                    <input type="submit" class="btn btn-primary" value="save Change" name="btn_saveth">&nbsp;
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </form>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
        <!-- end save data -->
      </div>
    </div>
  </div>

</div>
</div>
</div>
</div>
</div>
</div>
<script>
  var resizefunc = [];
</script>

<!-- jQuery  -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery.datatables.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/detect.js"></script>
<script src="assets/js/fastclick.js"></script>
<script src="assets/js/jquery.blockUI.js"></script>
<script src="assets/js/waves.js"></script>
<script src="assets/js/jquery.slimscroll.js"></script>
<script src="assets/js/jquery.scrollTo.min.js"></script>
<script src="assets/js/table.bootstrap.min.js"></script>
<script src="../plugins/switchery/switchery.min.js"></script>

<!-- App js -->
<script src="assets/js/jquery.core.js"></script>
<script src="assets/js/jquery.app.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#example').DataTable();
    $('#sent').DataTable();
  } );
</script>

</script>
</body>
</html>
<?php
}
?>

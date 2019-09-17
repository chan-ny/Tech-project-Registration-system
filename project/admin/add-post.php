<?php 
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0)
{ 
    header('location:index.php');
}
else{

 
    if(isset($_POST['submit']))
    {
        $posttitle=$_POST['posttitle'];
        $catid=$_POST['category'];
        $postdetails=$_REQUEST['postdescription'];
        $arr = explode(" ",$posttitle);
        $url=implode("-",$arr);
        $imgfile=$_FILES["postimage"]["name"];

        $extension = substr($imgfile,strlen($imgfile)-4,strlen($imgfile));
// allowed extensions
        $allowed_extensions = array(".jpg","jpeg",".png",".gif");
// Validation for allowed extensions .in_array() function searches an array for a specific value.
        if(!in_array($extension,$allowed_extensions))
        {
            echo "<script>alert(' ຮູບຕ້ອງເປັນໃນຮູບແບບ jpg / jpeg/ png /gif format allowed');</script>";
        }
        else
        {
//rename the image file
            $imgnewfile=md5($imgfile).$extension;
// Code for move image into directory
            move_uploaded_file($_FILES["postimage"]["tmp_name"],"postimages/".$imgnewfile);
            $date=date("Y-m-d H:s:i");
            $status=1;
            $query=mysqli_query($con,"insert into tb_post (C_ID,P_Title,P_Content,P_date,P_active,P_url,P_imge) values('$catid','$posttitle','$postdetails','$date','$status','$url','$imgnewfile')");
            if($query)
            {
                $msg="Post successfully added ";
            }
            else{
                $error="Something went wrong . Please try again.";    
            } 
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <!-- App title -->
        <title>ຂ່າວສານ | ສ້າງໂພຣ</title>

        <!-- Summernote css -->
        <link href="../plugins/summernote/summernote.css" rel="stylesheet" />

        <!-- Select2 -->
        <link href="../plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

        <!-- Jquery filer css -->
        <link href="../plugins/jquery.filer/css/jquery.filer.css" rel="stylesheet" />
        <link href="../plugins/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css" rel="stylesheet" />

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="../plugins/switchery/switchery.min.css">
        <script src="assets/js/modernizr.min.js"></script>

<!--         <script>
            function getSubCat(val) {
              $.ajax({
                  type: "POST",
                  url: "get_subcategory.php",
                  data:'catid='+val,
                  success: function(data){
                    $("#subcategory").html(data);
                }
            });
          }
      </script> -->
      

      <style >
        body *{
            font-family: "phetsarath OT";
            font-size: 12px;
        }
    </style>
</head>


<body class="fixed-left">

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Top Bar Start -->
        <?php include('includes/topheader.php');?>
        <!-- ========== Left Sidebar Start ========== -->
        <?php include('includes/leftsidebar.php');?>
        <!-- Left Sidebar End -->



        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="content-page">
            <!-- Start content -->
            <div class="content">
                <div class="container">


                    <div class="row">
                       <div class="col-xs-12">
                        <div class="page-title-box">
                            <h4 class="page-title" style="font-family: 'phetsarath OT'">ເພີ່ມ ໂພຣ </h4>
                            <ol class="breadcrumb p-0 m-0">
                                <li>
                                    <a href="#">ໂພຣ</a>
                                </li>
                                <li>
                                    <a href="#">ເພິ່ມ ໂພຣ </a>
                                </li>
                                <li class="active">
                                    Add ໂພຣ
                                </li>
                            </ol>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-sm-6">  

                        <?php if($msg){ ?>
                            <div class="alert alert-success" role="alert">
                                <strong>Well done!</strong> <?php echo htmlentities($msg);?>
                            </div>
                        <?php } ?>


                        <?php if($error){ ?>
                            <div class="alert alert-danger" role="alert">
                                <strong>Oh snap!</strong> <?php echo htmlentities($error);?></div>
                            <?php } ?>


                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="p-6">
                                <div class="">
                                    <form name="addpost" method="post" enctype="multipart/form-data">
                                     <div class="form-group m-b-20">
                                        <label for="exampleInputEmail1">ຫົວຂໍ້ (Post Title)</label>
                                        <input type="text" class="form-control" id="posttitle" name="posttitle" placeholder="ຫົວຂໍ້" required>
                                    </div>



                                    <div class="form-group m-b-20">
                                        <label for="exampleInputEmail1">ປະເພດ</label>
                                        <select class="form-control" name="category" id="category" onChange="getSubCat(this.value);" required>
                                            <option value="">ເລືອກປະເພດ </option>
                                            <?php
// Feching active categories
                                            $ret=mysqli_query($con,"select C_ID,C_CategoryName from  tb_newcategory  where c_active=1");
                                            while($result=mysqli_fetch_array($ret))
                                            {    
                                                ?>
                                                <option value="<?php echo htmlentities($result['C_ID']);?>"><?php echo htmlentities($result['C_CategoryName']);?></option>
                                            <?php } ?>

                                        </select> 
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                         <div class="card-box">
                                            <h4 class="m-b-30 m-t-0 header-title"><b>ເນື້ອຄວາມຂອງໂພຣ</b></h4>
                                            <textarea class="summernote " name="postdescription" ></textarea>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-12">
                                     <div class="card-box">
                                        <h4 class="m-b-30 m-t-0 header-title"><b>ເລືອກຮູບ</b></h4>
                                        <input type="file" class="form-control" id="postimage" name="postimage"  required>
                                    </div>
                                </div>
                            </div>


                            <button type="submit" name="submit" class="btn btn-success waves-effect waves-light" >ໂພຣ</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light">ຍົກເລີກ</button>
                        </form>
                    </div>
                </div> <!-- end p-20 -->
            </div> <!-- end col -->
        </div>
        <!-- end row -->



    </div> <!-- container -->

</div> <!-- content -->

<?php include('includes/footer.php');?>

</div>


<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->


</div>
<!-- END wrapper -->



<script>
    var resizefunc = [];
</script>

<!-- jQuery  -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/detect.js"></script>
<script src="assets/js/fastclick.js"></script>
<script src="assets/js/jquery.blockUI.js"></script>
<script src="assets/js/waves.js"></script>
<script src="assets/js/jquery.slimscroll.js"></script>
<script src="assets/js/jquery.scrollTo.min.js"></script>
<script src="../plugins/switchery/switchery.min.js"></script>

<!--Summernote js-->
<script src="../plugins/summernote/summernote.min.js"></script>
<!-- Select 2 -->
<script src="../plugins/select2/js/select2.min.js"></script>
<!-- Jquery filer js -->
<script src="../plugins/jquery.filer/js/jquery.filer.min.js"></script>

<!-- page specific js -->
<script src="assets/pages/jquery.blog-add.init.js"></script>

<!-- App js -->
<script src="assets/js/jquery.core.js"></script>
<script src="assets/js/jquery.app.js"></script>

<script>

    jQuery(document).ready(function(){

        $('.summernote').summernote({
                    height: 240,                 // set editor height
                    minHeight: null,             // set minimum height of editor
                    maxHeight: null,             // set maximum height of editor
                    focus: false                 // set focus to editable area after initializing summernote
                });
                // Select2
                $(".select2").select2();

                $(".select2-limiting").select2({
                    maximumSelectionLength: 2
                });
            });
        </script>
        <script src="../plugins/switchery/switchery.min.js"></script>

        <!--Summernote js-->
        <script src="../plugins/summernote/summernote.min.js"></script>




    </body>
    </html>
    <?php } ?>
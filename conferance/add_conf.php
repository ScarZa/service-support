<?php session_start(); ?>
 <section class="content-header">
 <div class="row">
          <div class="col-lg-12">
              <h1> <font color="blue">ตั้งค่าห้องประชุม</font></h1>
            <ol class="breadcrumb alert-warning">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-gear"></i> ตั้งค่าห้องประชุม</li>
            </ol>
          </div>
        </div><!-- /.row -->
</section>
			<?php include 'connection/connect.php';
                          if($_REQUEST['method']=='update'){
                             $room_id= $_GET['room_id'];
                        
			 $sqlGet=mysqli_query($db,"select * from  ss_room 
                             where room_id='$room_id'");
			 $resultGet=mysqli_fetch_assoc($sqlGet);
			  }elseif ($_REQUEST['method']=='delete') {
                              $room_id= $_GET['room_id'];
                             $sql_del = "delete from ss_room where room_id = '$room_id'";
                            mysqli_query($db,$sql_del) or die(mysqli_error($db)); 
}
			   ?> 
<section class="content">
<div class="row">
          <div class="col-lg-6 col-xs-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">เพิ่มห้องประชุมในระบบ</h3>
                    </div>
                <div class="panel-body">		
                    <form name='form1' class="navbar-form navbar-left"  action='index.php?page=process/prcroom' method='post' enctype="multipart/form-data">
                        <div class="form-group">	
			<b>ห้องประชุม</b>
			<input type='text' name='conf'  size="50"  id='conf' placeholder='ใส่ห้องประชุม' class='form-control' value='<?php echo $resultGet['room_name'];?>' required>
			 </div> 
                        <br><br>
                        
 <?PHP 
	if($_REQUEST['method']=='update'){
                echo "<input type='hidden' name='room_id' value='".$resultGet['room_id']."'>";
		echo "<input type='hidden' name='method' value='edit_conf'>";
                ?>
        <p><button  class="btn btn-warning" id='save'> แก้ไข </button > <input type='reset' class="btn btn-danger"> </p>
	<?php }  else {?>
                <input type='hidden' name='method' value='add_conf'>
         <p><button  class="btn btn-success" id='save'> บันทึก </button > <input type='reset' class="btn btn-danger"> </p>
              <?php } ?>
		</form>

      </div>
    </div>
              </div>
          <div class="col-lg-6 col-xs-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">ห้องประชุมในระบบระบบ</h3>
                    </div>
                  <div class="panel-body">
                    
<?php include 'listconf.php';?> 
      <!--  row of columns -->
 </div>
              </div></div>
</div>
</section>
<?php session_start(); ?>
 <section class="content-header">
 <div class="row">
          <div class="col-lg-12">
              <h1> <font color="blue">ตั้งค่ารถยนต์</font></h1>
            <ol class="breadcrumb alert-warning">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-gear"></i> ตั้งค่ารถยนต์</li>
            </ol>
          </div>
        </div><!-- /.row -->
</section>
			<?php include 'connection/connect.php';
                          if($_REQUEST['method']=='update'){
                             $car_id= $_GET['car_id'];
                        
			 $sqlGet=mysqli_query($db,"select * from  ss_carlicense 
                             where license_id='$car_id'");
			 $resultGet=mysqli_fetch_assoc($sqlGet);
			  }elseif ($_REQUEST['method']=='delete') {
                              $car_id= $_GET['car_id'];
                             $sql_del = "delete from ss_carlicense where license_id = '$car_id'";
                            mysqli_query($db,$sql_del) or die(mysqli_error($db)); 
}
			   ?> 
<section class="content">
<div class="row">
          <div class="col-lg-5">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">เพิ่มรถยนต์ในระบบ</h3>
                    </div>
                <div class="panel-body">		
                    <form name='form1' class="navbar-form navbar-left"  action='index.php?page=process/prccar' method='post' enctype="multipart/form-data">
                        <div class="form-group">	
			<b>ทะเบียนรถยนต์</b>
			<input type='text' name='license'  size="4"  id='license' placeholder='ใส่ทะเบียนรถยนต์' class='form-control' value='<?php echo $resultGet['license_name'];?>' required>
			 </div> 
                        <div class="form-group">
                            <b>ประเภทรถยนต์ </b>
                         	<select name="cartype" id="cartype" required  class="form-control"  onkeydown="return nextbox(event, 'fname');"> 
				<?php	$sql = mysqli_query($db,"SELECT * FROM ss_car_type order by cartype_id ");
				 echo "<option value=''>เลือกประเภทรถยนต์</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['cartype_id']==$resultGet['cartype_id']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['cartype_id']."' $selected>".$result['cartype_name']." </option>";
				 } ?>
			 </select>
 			 </div> 
                        <div class="form-group">
                            <b>ผู้รับผิดชอบ </b>
                        <select name="rider" id="rider"  class="form-control"> 
				<?php	$sql = mysqli_query($db,"SELECT concat(firstname,' ',lastname) as fullname, empno  FROM emppersonal 
                                            where depid='23' order by empno");
				 echo "<option value=''>--เลือกผู้รับผิดชอบ--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['empno']==$resultGet['rider']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['empno']."' $selected>".$result['fullname'] ."</option>";
				 } ?>
			 </select>
                             </div>
                        <div class="form-group">
                            <b>เติมน้ำมันชนิด </b>
                        <select name="oil_type" id="oil_type"  class="form-control" required=""> 
				<?php	$sql = mysqli_query($db,"SELECT *  FROM ss_oil_type");
				 echo "<option value=''>--เลือกชนิดน้ำมัน--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['oil_id']==$resultGet['oil_type']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['oil_id']."' $selected>".$result['oil_name'] ."</option>";
				 } ?>
                        </select></div>
                        <div class="form-group">
                            <b>วันที่รับรถ </b>
                            <input type="date" name="recive_date" class="form-control" value="<?= $resultGet['recive_date']?>">
                        </div>
                        <div class="form-group">
                            <b>สถานะรถยนต์ </b>
                            <select name="car_status" class="form-control" required="">
                                <?php	$sql = mysqli_query($db,"SELECT *  FROM ss_car_status");
				 echo "<option value=''>--เลือกสถานะ--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['carstatus_id']==$resultGet['car_status']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['carstatus_id']."' $selected>".$result['carstatus_name'] ."</option>";
				 } ?>
                            </select>
                        </div>
                        <br><br>
                        
 <?PHP 
	if($_REQUEST['method']=='update'){
                echo "<input type='hidden' name='license_id' value='".$resultGet['license_id']."'>";
		echo "<input type='hidden' name='method' value='edit_license'>";
                ?>
        <p><button  class="btn btn-warning" id='save'> แก้ไข </button > <input type='reset' class="btn btn-danger"   > </p>
	<?php }  else {?>
                <input type='hidden' name='method' value='add_license'>
         <p><button  class="btn btn-success" id='save'> บันทึก </button > <input type='reset' class="btn btn-danger"   > </p>
              <?php } ?>
		</form>

      </div>
    </div>
              </div>
          <div class="col-lg-7">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">รถยนต์ในระบบระบบ</h3>
                    </div>
                  <div class="panel-body">
                    
<?php include 'listcar.php';?> 
      <!--  row of columns -->
 </div>
              </div></div>   
</section>
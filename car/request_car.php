<?php if(empty($_SESSION['ss_id'])){echo "<meta http-equiv='refresh' content='0;url=index.php'/>";exit();} ?>
<script type="text/javascript">
function nextbox(e, id) {
    var keycode = e.which || e.keyCode;
    if (keycode == 13) {
        document.getElementById(id).focus();
        return false;
    }
}
</script>
    <section class="content-header">
        <div class="row">
          <div class="col-lg-12">
              <?php if($_REQUEST['method']=='edit'){?>
            <h1><font color='blue'>  แก้ไขขอใช้รถยนต์ </font></h1> 
            <ol class="breadcrumb alert-warning">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li><a href="index.php?page=car/pre_request"><i class="fa fa-edit"></i> ผู้ขอใช้รถยนต์</a></li>
              <li class="active"><i class="fa fa-edit"></i> แก้ไขขอใช้รถยนต์</li>
              <?php }else{?>
            <h1><img src='images/adduser.ico' width='75'><font color='blue'>  เขียนขอใช้รถยนต์ </font></h1> 
            <ol class="breadcrumb alert-warning">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-edit"></i> เขียนขอใช้รถยนต์</li>
              <?php }?>
            </ol>
          </div>
      </div>
    </section>
<?php    include 'connection/connect.php';
    if($_REQUEST['method']=='edit'){
        $edit_id=$_REQUEST['id'];
        $edit_per=  mysqli_query($db,"select ssc.*, concat(e1.firstname,' ',e1.lastname) as fullname, d.depName
            from ss_car ssc  
            inner join emppersonal e1 on e1.empno=ssc.empno_request
            inner join department d on d.depId=e1.depid
            where ssc.car_id='$edit_id'");
        $edit_person=  mysqli_fetch_assoc($edit_per);
    }
    $sql = mysqli_query($db,"select * from  hospital");
                            $resultHos = mysqli_fetch_assoc($sql);
    $sql2=  mysqli_query($db, "select depName from department where depId='".$_SESSION['ss_dep']."'"); 
    $resultDep = mysqli_fetch_assoc($sql2);
?>
    <section class="content">
        <form class="navbar-form" role="form" action='index.php?page=process/prccar' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()">
<div class="row">
    <div class="col-lg-2"></div>
          <div class="col-lg-8">
              <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title"><img src='images/phonebook.ico' width='25'> <font color='brown'>เขียนขอใช้รถยนต์</font></h3>
                    </div>
                <div class="panel-body">
                    <div align='center'>
                                <h4>แบบฟอร์มการขออนุญาตใช้รถส่วนกลาง</h4><p>
                    </div>
                    <b>เรียน ผู้อำนวยการ <?= $resultHos['name']?></b><br><?php if($_SESSION['ss_status']=='USER'){ ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    ข้าพเจ้า <b><?php if($_REQUEST['method']=='edit') { echo $edit_person['fullname'];}else{ echo $_SESSION['ssfullname'];}?></b> 
                                    ฝ่าย/งาน/กลุ่มงาน <b><?php if($_REQUEST['method']=='edit') { echo $edit_person['depName'];}else{ echo $resultDep['depName'];}?></b> ขออนุญาตใช้รถราชการ<p>
<?php }else{?>
                                        <div class="form-group">
                        <label for="empno">ผู้ขอ</label>
                        <select name="empno" id="empno" required  class="form-control" onkeydown="return nextbox(event, 'dep');"> 
				<?php	$sql = mysqli_query($db,"SELECT concat(firstname,' ',lastname) as fullname, empno  FROM emppersonal 
                                            order by firstname");
				 echo "<option value=''>--เลือกผู้ขอ--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['empno']==$edit_person['empno_request']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['empno']."' $selected>".$result['fullname'] ."</option>";
				 } ?>
			 </select> 
                                        </div><?php } ?><p>
                    <div class="form-group" > 
                        <label for="place">เพื่อไปที่ &nbsp;</label>
                        <input value="<?=$edit_person['place'];?>" NAME="place" id="place"  class="form-control" onkeydown="return nextbox(event, 'start_date')" placeholder="สถานที่ที่ต้องไป" size="80" required>
                    </div><p>
                        <div class="form-group" > 
                            <?php include 'car/address.php';?>
                        </div>
                    <div class="form-group">
                    <label>ในวันที่ &nbsp;</label>
                <?php
 		/*if($_GET[method]!=''){
 			$take_date=$edit_person[birthdate];
 			edit_date($take_date);
                        }*/
 		?>
                    <input name="start_date" type="text" id="datepicker"  placeholder='รูปแบบ 2016-01-31' class="form-control"  value="<?= $edit_person['start_date']?>" required>
                    </div>
                <div class="form-group">
                    <label for="end_date">ถึงวันที่ &nbsp;</label>
                    <input name="end_date" type="text" id="datepicker2"  placeholder='รูปแบบ 2016-01-31' class="form-control"  value="<?= $edit_person['end_date']?>" required>
                </div><p>
                <div class="row">  
                <div class="form-group col-lg-5 col-xs-12">  <label for="take_hour_st">ตั้งแต่&nbsp;</label>  
                <div class="form-group sm"> 
                <select name="take_hour_st" id="take_hour" class="form-control" required>
                    <option value="">ชั่วโมง</option>
                    <?php for($i=0;$i<=23;$i++){
                        if((!empty($edit_person['start_time']))and($i== substr($edit_person['start_time'],0,2))){$selected='selected';}else{$selected='';}
                        if($i<10){
                        echo "<option value='0".$i."' $selected>0".$i."</option>";    
                        }else{
                        echo "<option value='".$i."' $selected>".$i."</option>";}
                    }?>
                </select>
                </div>
                    <div class="form-group">
                <select name="take_minute_st" id="take_minute" class="form-control" required>
                    <option value="">นาที</option>
                    <?php for($i=0;$i<=59;$i++){
                        if((!empty($edit_person['start_time']))and($i== substr($edit_person['start_time'],3,2))){$selected='selected';}else{$selected='';}
                    if($i<10){
                        echo "<option value='0".$i."' $selected>0".$i."</option>";    
                        }else{
                        echo "<option value='".$i."' $selected>".$i."</option>";}
                    }?>
                </select>
                    </div></div>
                <div class="form-group col-lg-5 col-xs-12"> <label for="take_hour_st">ถึงเวลา </label>   
                <div class="form-group"> 
                <select name="take_hour_en" id="take_hour" class="form-control" required>
                    <option value="">ชั่วโมง</option>
                    <?php for($i=0;$i<=23;$i++){
                        if((!empty($edit_person['end_time']))and($i== substr($edit_person['end_time'],0,2))){$selected='selected';}else{$selected='';}
                        if($i<10){
                        echo "<option value='0".$i."' $selected>0".$i."</option>";    
                        }else{
                        echo "<option value='".$i."' $selected>".$i."</option>";}
                    }?>
                </select>
                </div>
                    <div class="form-group"> 
                <select name="take_minute_en" id="take_minute" class="form-control" required>
                    <option value="">นาที</option>
                    <?php for($i=0;$i<=59;$i++){
                        if((!empty($edit_person['end_time']))and($i== substr($edit_person['end_time'],3,2))){$selected='selected';}else{$selected='';}
                    if($i<10){
                        echo "<option value='0".$i."' $selected>0".$i."</option>";    
                        }else{
                        echo "<option value='".$i."' $selected>".$i."</option>";}
                    }?>
                </select>
                    </div></div></div><p> 
                     <div class="form-group">
                        <label for="amount_date">จำนวนวันที่ไป</label>
                        <input name="amount_date" id="amount_date" type="text" value="<?= $edit_person['amount_date']?>" size="1" onkeyup="javascript:inputDigits(this);" class="form-control" placeholder='จำนวนวัน'>
                        <font color="red"><b>** หากไม่ถึงครึ่งวัน ไม่ต้องใส่</b></font>
                     </div>
                    <br><p>
                <div class="form-group" > 
                        <label for="obj">เพื่อ &nbsp;</label>
                        <input value="<?=$edit_person['obj'];?>" NAME="obj" id="obj"  class="form-control" onkeydown="return nextbox(event, 'start_date')" placeholder="วัตถุประสงค์" size="80" required>
                    </div><p>
                    <div class="form-group">
                        <label for="amount">จำนวนผู้ร่วมทาง</label>
                        <input name="amount" id="amount" type="number" value="<?= $edit_person['amount']?>" required="" size="1" class="form-control" placeholder='จำนวนคน'>
                    </div>
                    <br><p>
                    <div class="form-group">
                        <label for="passenger">เพื่อให้</label>
                        <select name="passenger" id="passenger" required  class="form-control" onkeydown="return nextbox(event, 'dep');"> 
				<?php	$sql = mysqli_query($db,"SELECT concat(firstname,' ',lastname) as fullname, empno  FROM emppersonal 
                                            order by firstname");
				 echo "<option value=''>--เลือกผู้ควบคุม--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['empno']==$edit_person['passenger']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['empno']."' $selected>".$result['fullname'] ."</option>";
				 } ?>
			 </select> เป็นผู้ควบคุม
                    </div><p>
                    <?php if($edit_person['wait']=='Y') {
                        $checked='checked';
                        $check='';
                    }else{ $checked='';
                           $check='checked';
                    } ?>
                    <div>
                        <b>การใช้รถครั้งนี้ขอให้พนักงานขับรถ</b><br>
                    <div class="form-group">
                        <input type="radio" name="wait" id="wait" value="N" <?= $check?>> 
                        ไม่รอรับ </div><br>
                    <div class="form-group">
                                <input type="radio" name="wait" id="wait" value="Y" <?= $checked?>> 
                    รอรับ </div>
                    </div>

                    <br><br>
                    <div align="center">
                    <?php if($_REQUEST['method']=='edit'){?>
    <input type="hidden" name="method" id="method" value="edit_car">
    <input type="hidden" name="edit_id" id="edit_id" value="<?=$edit_person['car_id'];?>">
   <input class="btn btn-warning" type="submit" name="Submit" id="Submit" value="แก้ไข">
   <?php }else{?> 
   <input type="hidden" name="method" id="method" value="request_car">
   <input class="btn btn-success" type="submit" name="Submit" id="Submit" value="บันทึก">
   <?php }?></div>
                </div>
                </div>


          </div>
    
</div>
</form>
    
   </section>

         
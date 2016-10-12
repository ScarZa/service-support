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
            <h1><font color='blue'>  แก้ไขขอใช้ห้องประชุม </font></h1> 
            <ol class="breadcrumb alert-warning">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li><a href="index.php?page=conferance/pre_request"><i class="fa fa-edit"></i> ผู้ขอใช้ห้องประชุม</a></li>
              <li class="active"><i class="fa fa-edit"></i> แก้ไขขอใช้ห้องประชุม</li>
              <?php }else{?>
            <h1><img src='images/adduser.ico' width='75'><font color='blue'>  เขียนขอใช้ห้องประชุม </font></h1> 
            <ol class="breadcrumb alert-warning">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-edit"></i> เขียนขอใช้ห้องประชุม</li>
              <?php }?>
            </ol>
          </div>
      </div>
    </section>
<?php    include 'connection/connect.php';
    if($_REQUEST['method']=='edit'){
        $edit_id=$_REQUEST['id'];
        $edit_per=  mysqli_query($db,"select ssc.*, concat(e1.firstname,' ',e1.lastname) as fullname, d.depName
            from ss_conferance ssc  
            inner join emppersonal e1 on e1.empno=ssc.empno_request
            inner join department d on d.depId=e1.depid
            where ssc.conf_id='$edit_id'");
        $edit_person=  mysqli_fetch_assoc($edit_per);
    }
    $sql = mysqli_query($db,"select * from  hospital");
                            $resultHos = mysqli_fetch_assoc($sql);
    $sql2=  mysqli_query($db, "select depName from department where depId='".$_SESSION['ss_dep']."'"); 
    $resultDep = mysqli_fetch_assoc($sql2);
?>
    <section class="content">
        <form class="navbar-form" role="form" action='index.php?page=process/prcroom' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()">
<div class="row">
    <div class="col-lg-2"></div>
          <div class="col-lg-8">
              <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title"><img src='images/phonebook.ico' width='25'> <font color='brown'>เขียนขอใช้ห้องประชุม</font></h3>
                    </div>
                <div class="panel-body">
                    <div align='center'>
                                <h4>แบบฟอร์มการขอใช้ห้องประชุม/อุปกรณ์โสตฯ<p>
                            บริหารงานทั่วไป <?= $resultHos['name']?>
                                    </p></h4>
                                    <?php if($_SESSION['ss_status']=='USER'){ ?>
                                    ข้าพเจ้า <b><?php if($_REQUEST['method']=='edit') { echo $edit_person['fullname'];}else{ echo $_SESSION['ssfullname'];}?></b> 
                                    ฝ่าย/งาน/กลุ่มงาน <b><?php if($_REQUEST['method']=='edit') { echo $edit_person['depName'];}else{ echo $resultDep['depName'];}?></b><p> มีความประสงค์ที่จะขอใช้ห้องประชุมและอุปกรณ์โสตฯ
                                    
                    </div><?php }else{?>
                </div>
                    <div class="form-group">
                        <label for="empno">ผู้ขอ</label>
                        <select name="empno" id="empno" required  class="form-control" onkeydown="return nextbox(event, 'dep');"> 
				<?php	$sql = mysqli_query($db,"SELECT concat(firstname,' ',lastname) as fullname, empno  FROM emppersonal 
                                            order by empno");
				 echo "<option value=''>--เลือกผู้ขอ--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['empno']==$edit_person['empno_request']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['empno']."' $selected>".$result['fullname'] ."</option>";
				 } ?>
			 </select> 
                    </div>
                  <div class="form-group" > 
                        <label for="obj">วันที่ขอ &nbsp;</label>
                        <input type="text" value="<?=$edit_person['record_date'];?>" NAME="record_date" id="datepicker"  placeholder='รูปแบบ 2016-01-31' class="form-control" onkeydown="return nextbox(event, 'start_date')" placeholder="" required>
                    </div>
                  <p><?php } ?>
                    <div class="form-group" > 
                        <label for="obj">เพื่อ &nbsp;</label>
                        <input value="<?=$edit_person['obj'];?>" NAME="obj" id="obj"  class="form-control" onkeydown="return nextbox(event, 'start_date')" placeholder="วัตถุประสงค์ที่ต้องการใช้ห้องประชุม" size="80" required>
                    </div><p>
                    <div class="form-group">
                    <label>ในวันที่ &nbsp;</label>
                <?php /*
 		if($_GET[method]!=''){
 			$take_date=$edit_person[birthdate];
 			edit_date($take_date);
                        }*/
 		?>
                    <input name="start_date" type="text" id="datepicker2"  placeholder='รูปแบบ 2016-01-31' class="form-control"  value="<?= $edit_person['start_date']?>" required>
                    </div>
                <div class="form-group">
                    <label for="end_date">ถึงวันที่ &nbsp;</label>
                    <input name="end_date" type="text" id="datepicker3"  placeholder='รูปแบบ 2016-01-31' class="form-control"  value="<?= $edit_person['end_date']?>" required>
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
                        <label for="amount">จำนวนผู้เข้าร่วมประชุม</label>
                        <input name="amount" id="amount" type="number" value="<?= $edit_person['amount']?>" required="" size="1" class="form-control" placeholder='จำนวนคน'>
                    </div>
                    <br><p>
                    
                    <?php if($edit_person['equip']=='Y') {
                        $checked='checked';
                        $check='';
                    }else{ $checked='';
                           $check='checked';
                    } ?>
                    <div>
                        <b>ในการนี้ข้าพเจ้า</b><br>
                    <div class="form-group">
                        <input type="radio" name="equip" id="equip" value="N" <?= $check?>> 
                        ไม่ขอรับการสนับสนุนอุปกรณ์โสตฯ </div><br>
                        <div class="form-group">
                                <input type="radio" name="equip" id="equip" value="Y" <?= $checked?>> 
                    ขอรับการสนับสนุนอุปกรณ์โสตฯ </div>
                    </div>
                    <div class="alert alert-warning row">
                        
                        <div class="col-lg-6 col-xs-12">
                            <?php if($edit_person['equip']=='Y') {
                            $achecked='checked';}?>
                          <div class="form-group">
                              <input type="checkbox" name="audio" value="Y" <?= $achecked?>> &nbsp;เครื่องเสียงในห้องประชุม
                          </div>
                          
                          <?php if($edit_person){
                            if($edit_person['mic_table']!='0') {$mtchecked='checked';}
                            if($edit_person['mic_wireless']!='0') { $mwchecked='checked';}
                            if($edit_person['mic_line']!='0') {$mlchecked='checked';}
                          }else{$mtchecked='';$mwchecked='';$mlchecked='';}
                            ?>
                          
                            <div class="form-group">
                              <input type="checkbox" name="mic_table" value="Y" <?= $mtchecked?>> 
                            &nbsp;ไมค์ตั้งโต๊ะประชุม จำนวน <input type="text" name="mic_table" value="<?= $edit_person['mic_table']?>" size="1" onKeyUp="javascript:inputDigits(this);"> ตัว<br>
                            </div>
                            <div class="form-group">
                              <input type="checkbox" name="mic_wireless" value="Y" <?= $mwchecked?>> 
                            &nbsp;ไมค์ลอย จำนวน <input type=textnumber" name="mic_wireless" value="<?= $edit_person['mic_wireless']?>" size="1" onKeyUp="javascript:inputDigits(this);"> ตัว<br>
                            </div>
                            <div class="form-group">
                              <input type="checkbox" name="mic_line" value="Y" <?= $mlchecked?>> 
                            &nbsp;ไมค์สาย จำนวน <input type=textnumber" name="mic_line" value="<?= $edit_person['mic_line']?>" size="1" onKeyUp="javascript:inputDigits(this);"> ตัว<br>
                        </div></div>
                        <div class="col-lg-6 col-xs-12">
                            <?php if($edit_person['visualizer']=='Y') {
                            $vchecked='checked';}?>
                        <div class="form-group">
                              <input type="checkbox" name="visualizer" value="Y" <?= $vchecked?>> 
                        &nbsp;เครื่องฉาบภาพ(visualizer)</div>
                        <?php if($edit_person['projector']=='Y') {
                            $pchecked='checked';}?>
                        <div class="form-group">
                              <input type="checkbox" name="projector" value="Y" <?= $pchecked?>> 
                        &nbsp;เครื่องฉายโปรเจ็กเตอร์ พร้อมจอ</div>
                        <?php if($edit_person['comp']=='Y') {
                            $cchecked='checked';}?>
                        <div class="form-group">
                              <input type="checkbox" name="comp" value="Y" <?= $cchecked?>> 
                        &nbsp;เครื่องคอมพิวเตอร์</div>
                        </div>
                       
                    </div>
                    <div class="form-group">
                        <label for="format">รูปแบบการจัโต๊ะห้องประชุม</label>
                        <select name="format" id="format" required  class="form-control"> 
                        <?php if($edit_person['format']=='1'){
                            $fselect1='selected';$fselect2='';
                        }elseif ($edit_person['format']=='2') {$fselect1='';$fselect2='selected';}?>    
                            <option value="1" <?= $fselect1?>>ประชุม</option> 
                            <option value="2" <?= $fselect2?>>สัมมนา</option>
			</select>
                    </div>
                    <div class="form-group">
                        <label for="room">ห้องประชุม</label>
                        <select name="room" id="room" required  class="form-control" onkeydown="return nextbox(event, 'dep');"> 
				<?php	$sql = mysqli_query($db,"SELECT *  FROM ss_room order by room_id");
				 echo "<option value=''>--เลือกห้องประชุม--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['room_id']==$edit_person['room']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['room_id']."' $selected>".$result['room_name'] ."</option>";
				 } ?>
			 </select>
                    </div><br><br>
                    <div align="center">
                    <?php if($_REQUEST['method']=='edit'){?>
    <input type="hidden" name="method" id="method" value="edit_room">
    <input type="hidden" name="edit_id" id="edit_id" value="<?=$edit_person['conf_id'];?>">
   <input class="btn btn-warning" type="submit" name="Submit" id="Submit" value="แก้ไข">
   <?php }else{?> 
   <input type="hidden" name="method" id="method" value="request_room">
   <input class="btn btn-success" type="submit" name="Submit" id="Submit" value="บันทึก">
   <?php }?></div>
                </div>
                </div>


          </div>
    
</div>
</form>
    
   </section>

         
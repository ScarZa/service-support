<?php @session_start(); ?>
<?php include '../connection/connect.php';?>
<?php if($_REQUEST['method']!='back'){
 if(empty($_SESSION['ss_id'])){echo "<meta http-equiv='refresh' content='0;url=index.php'/>";exit();}   
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>ระบบบริการและสนับสนุนโรงพยาบาล</title>
<LINK REL="SHORTCUT ICON" HREF="images/logo.png">
<!-- Bootstrap core CSS -->
<link href="../option/css/bootstrap.css" rel="stylesheet">
<!--<link href="option/css2/templatemo_style.css" rel="stylesheet">-->
<!-- Add custom CSS here -->
<link href="../option/css/sb-admin.css" rel="stylesheet">
<link rel="stylesheet" href="option/font-awesome/css/font-awesome.min.css">
<!-- Page Specific CSS -->
<link rel="stylesheet" href="../option/css/morris-0.4.3.min.css">
<link rel="stylesheet" href="../option/css/stylelist.css">
</head>
    <body>            
        <form class="navbar-form" role="form" action='../process/prccar.php' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()">
        <div class="row">
    <div class="col-lg-12" align="center">
        <div class="panel panel-primary">
           <?php if($_REQUEST['method']=='confirm_car'){?> 
            <div class="panel-heading" align="center">
                <h3 class="panel-title"> ยืนยันการอนมัติใช้รถยนต์</h3>
            </div>
            <div class="panel-body" align='center'>
                <div class="well well-sm">
                <b>ยืนยันการอนมัติใช้รถยนต์</b>
                <div class="form-group">
                    <input type="radio" name="confirm" id="confirm" value="Y" required>&nbsp;&nbsp; อนุมัติ<br> 
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="confirm" id="confirm" value="N" required>&nbsp;&nbsp; ไม่อนุมัติ
                </div>
                </div>
                <?php }elseif($_REQUEST['method']=='pay_car'){?> 
            <div class="panel-heading" align="center">
                <h3 class="panel-title"> ยืนยันการจ่ายรถยนต์</h3>
            </div>
            <div class="panel-body" align='center'>
                <div class="well well-sm">
                <b>ยืนยันการจ่ายรถยนต์</b>
                <div class="form-group">
                    <input type="radio" name="pay" id="pay" value="Y" required>&nbsp;&nbsp; จ่าย<br> 
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="pay" id="pay" value="N" required>&nbsp;&nbsp; ไม่จ่าย
                </div>
                </div>
                <?php }else{ ?>
                 <div class="panel-heading" align="center">
                <h3 class="panel-title"> ใบขอใช้รถยนต์</h3>
            </div>
            <div class="panel-body" align='center'>
                <?php }?>
                                        <?php include_once ('../option/funcDateThai.php');
                                        
                                        $car_id=$_REQUEST['id'];
                                        
                            $check_det=  mysqli_query($db,"SELECT pay FROM ss_car WHERE car_id ='$car_id'");
                            $check_detial= mysqli_fetch_assoc($check_det);
                            if(is_null($check_detial['pay']) or $check_detial['pay']=='N'){
                               $code1="";
                               $code2="";
                               $code3="";
                            }else{
                               $code1="ct.cartype_name as cartype_name, lc.license_name as license_name,";
                               $code2=", (SELECT CONCAT(e1.firstname,  ' ', e1.lastname ) FROM ss_car ssc INNER JOIN emppersonal e1 ON e1.empno = ssc.rider WHERE ssc.rider=e1.empno and ssc.car_id ='$car_id') rider_name"; 
                               $code3="INNER JOIN ss_car_type ct ON ct.cartype_id=ssc.car_type
                                       INNER JOIN ss_carlicense lc ON lc.license_id=ssc.license_plate";
                            }
                                        
                            $select_det=  mysqli_query($db,"SELECT ssc . * , CONCAT( p1.pname, e1.firstname,  ' ', e1.lastname ) AS fullname, d1.depName AS dep, e1.empno AS empno,
                                 am.AMPHUR_NAME as amphur, pv.PROVINCE_NAME as province, ssc.passenger,$code1 
(SELECT CONCAT(e1.firstname,  ' ', e1.lastname ) FROM ss_car ssc INNER JOIN emppersonal e1 ON e1.empno = ssc.passenger WHERE ssc.passenger=e1.empno and ssc.car_id ='$car_id') pass_name $code2  
FROM ss_car ssc
INNER JOIN emppersonal e1 ON e1.empno = ssc.empno_request
INNER JOIN pcode p1 ON e1.pcode = p1.pcode
INNER JOIN department d1 ON e1.depid = d1.depId
INNER JOIN amphur am on am.AMPHUR_ID=ssc.amphur
INNER JOIN province pv on pv.PROVINCE_ID=ssc.province
$code3
WHERE ssc.car_id ='$car_id'");
                            $detial_l= mysqli_fetch_assoc($select_det);
                            
                            if(isset($_REQUEST['method'])=='edit_mile_car'){
                                $sql_mile=  mysqli_query($db, "select befor_mile, after_mile from ss_car where car_id='$car_id'");
                                $edit_mile= mysqli_fetch_assoc($sql_mile);
                            }
                        ?>
                        <table align="center" width='100%'>
                        <thead>
                            <tr>
                  <td width='50%' align="right" valign="top"><b>เลขที่ใบคำขอ : </b></td>
                  <td colspan="3">&nbsp;&nbsp;<?= $detial_l['car_no'];?></td>
              </tr>
              <tr>
                  <td width='50%' align="right" valign="top"><b>ชื่อ-นามสกุล ผู้ขอ : </b></td>
                  <td colspan="3">&nbsp;&nbsp;<?= $detial_l['fullname'];?></td>
              </tr>
              <tr>
                  <td align="right"><b>ฝ่าย-งาน : </b></td>
                  <td colspan="3">&nbsp;&nbsp; <?=$detial_l['dep'];?></td></tr>
              <tr>
                  <td align="right"><b>วันที่เขียนขอใช้รถยนต์ : </b></td>
                  <td  colspan="3">&nbsp;&nbsp; <?= substr($detial_l['request_date'], 11,5)=='00:00'? DateThai1($detial_l['request_date']) : DateTimeThai($detial_l['request_date']).' น.';?> </td>
              </tr>
              <tr>
                  <td align="right" valign="top"><b>สถานที่ : </b></td>
                  <td  colspan="3">&nbsp;&nbsp; <?=$detial_l['place']."&nbsp;จ.".$detial_l['province']."&nbsp;อ.".$detial_l['amphur'];?> </td>
              </tr>
              <tr>
                  <td align="right" valign="top"><b>จุดประสงค์ : </b></td>
                  <td colspan="3">&nbsp;&nbsp; <?= $detial_l['obj']?>
                  </td>
              </tr>
              <tr><td align="right"><b>วันที่ใช้ : </b></td>
                  <td  colspan="3">&nbsp;&nbsp; <?=DateThai1($detial_l['start_date']);?> <b>ถึง</b> <?=DateThai1($detial_l['end_date']);?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><b>เวลา : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?=$detial_l['start_time'];?> <b>ถึง</b> <?=$detial_l['end_time'];?></td>
              </tr>
              <tr>
                <td align="right"><b>จำนวนผู้ร่วมทาง : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?=$detial_l['amount'];?>&nbsp; <b>คน</b></td>
              </tr>
              
              <tr>
                <td align="right" valign="top"><b>ผู้ควบคุม : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?=$detial_l['pass_name'];?></td>
              </tr>
              <tr>
                <td align="right"><B>การใช้รถครั้งนี่ขอให้ : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?php if($detial_l['wait']=='Y'){echo 'รอรับ';}elseif ($detial_l['wait']=='N') {echo 'ไม่ต้องรอรับ';}?></td>
              </tr>
              <?php if(!empty($detial_l['pay'])) {
                  if($detial_l['pay']=='Y'){?>
              <tr>
                <td align="right" valign="top"><B>ใช้รถประเภท : </b></td>
                <td colspan="3"><select name="car_type" id="car_type"  class="form-control" required> 
				<?php	$sql = mysqli_query($db,"SELECT *  FROM ss_car_type");
				 echo "<option value=''>--เลือกประเภทรถยนต์--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['cartype_id']==$detial_l['car_type']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['cartype_id']."' $selected>".$result['cartype_name'] ."</option>";
				 } ?>
			 </select></td>
              </tr>
              <tr>
                <td align="right" valign="top"><B>หมายเลขทะเบียน : </b></td>
                <td colspan="3"><select name="license_plate" id="license_plate"  class="form-control" required> 
				<?php	$sql = mysqli_query($db,"SELECT *  FROM ss_carlicense");
				 echo "<option value=''>--เลือกรถยนต์--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['license_id']==$detial_l['license_plate']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['license_id']."' $selected>".$result['license_name'] ."</option>";
				 } ?>
			 </select></td>
              </tr>
              <tr>
                <td align="right" valign="top"><B>ผู้ขับคือ : </b></td>
                <td colspan="3"><select name="rider" id="rider"  class="form-control" required> 
				<?php	$sql = mysqli_query($db,"SELECT concat(firstname,' ',lastname) as fullname, empno  FROM emppersonal 
                                            where depid='23' order by empno");
				 echo "<option value=''>--เลือกผู้ขับ--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['empno']==$detial_l['rider']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['empno']."' $selected>".$result['fullname'] ."</option>";
				 } ?>
			 </select></td>
              </tr>
                  <?php } ?>
              <tr>
                <td align="right" valign="top"><b>ความคิดเห็นเพิ่มเติม : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?=$detial_l['other'];?></td>
              </tr>
              <?php }?>
              <?php if(!is_null($detial_l['befor_mile']) and !is_null($detial_l['after_mile'])) {?>
              <tr>
                <td align="right" valign="top"><b>เลขไมล์ : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?=$detial_l['befor_mile']." ถึง ".$detial_l['after_mile'];?></td>
              </tr>
              <tr>
                <td align="right" valign="top"><b>ใช้ระยะทาง : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?=$detial_l['after_mile']-$detial_l['befor_mile'];?> ก.ม.</td>
              </tr>
              <?php }?>
              <?php if($_REQUEST['method']=='pay_car'){?>
              <tr>
                <td align="right" valign="top"><B>ใช้รถประเภท : </b></td>
                <td colspan="3"><select name="car_type" id="car_type"  class="form-control" required> 
				<?php	$sql = mysqli_query($db,"SELECT *  FROM ss_car_type");
				 echo "<option value=''>--เลือกประเภทรถยนต์--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['cartype_id']==$edit_person['car_type']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['cartype_id']."' $selected>".$result['cartype_name'] ."</option>";
				 } ?>
			 </select>
                </td>
              </tr>
              <tr>
                <td align="right" valign="top"><B>หมายเลขทะเบียน : </b></td>
                <td colspan="3"><select name="license_plate" id="license_plate"  class="form-control" required> 
				<?php	$sql = mysqli_query($db,"SELECT *  FROM ss_carlicense");
				 echo "<option value=''>--เลือกรถยนต์--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['license_id']==$edit_person['license_plate']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['license_id']."' $selected>".$result['license_name'] ."</option>";
				 } ?>
			 </select>
                </td>
              </tr>
              <tr>
                <td align="right" valign="top"><B>ผู้ขับคือ : </b></td>
                <td colspan="3"><select name="rider" id="rider"  class="form-control" required> 
				<?php	$sql = mysqli_query($db,"SELECT concat(firstname,' ',lastname) as fullname, empno  FROM emppersonal 
                                            where depid='23' order by empno");
				 echo "<option value=''>--เลือกผู้ขับ--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['empno']==$edit_person['rider']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['empno']."' $selected>".$result['fullname'] ."</option>";
				 } ?>
			 </select>
                </td>
              </tr>
              <tr>
                <td align="right" valign="top"><b>ความคิดเห็นเพิ่มเติม : </b></td>
                <td colspan="3"><input name="other" type="text" class="form-control" placeholder='แสดงความคิดเห็น'></td>
              </tr>
              <?php }  elseif($_REQUEST['method']=='confirm_car'){ ?>
              <tr>
                <td align="right" valign="top"><b>เหตุผลเพิ่มเติม : </b></td>
                <td colspan="3"><input name="reason" type="text" class="form-control" placeholder='แสดงเหตุผล'></td>
              </tr>
              <?php }?>
              <?php if($_REQUEST['method']=='mile_car' or $_REQUEST['method']=='edit_mile_car'){ ?>
              <tr>
                <td align="right" valign="top"><b>เลขไมล์ก่อนเดินทาง : </b></td>
                <td colspan="3"><input name="befor_mile" type="text" class="form-control" placeholder='เลขไมล์ก่อนเดินทาง' value="<?= $edit_mile['befor_mile']?>"></td>
              </tr>
              <tr>
                <td align="right" valign="top"><b>เลขไมล์หลังเดินทาง : </b></td>
                <td colspan="3"><input name="after_mile" type="text" class="form-control" placeholder='เลขไมล์เมื่อสิ้นสุดการเดินทาง' value="<?= $edit_mile['after_mile']?>"></td>
              </tr>
              <?php }?>
                        </thead>
                        </table><br>
                        <center>
                        <input type="hidden" name="car_id" value="<?=$car_id;?>">
                        <?php if($_REQUEST['method']=='pay_car'){?>
                        <input type="hidden" name="passenger" value="<?=$detial_l['pass_name'];?>">
                        <input type="hidden" name="event_start" value="<?=$detial_l['start_date']." ".$detial_l['start_time'];?>">
                        <input type="hidden" name="event_end" value="<?=$detial_l['end_date']." ".$detial_l['end_time'];?>">
                        <input type="hidden" name="empno" value="<?=$detial_l['passenger'];?>">
                        <input type="hidden" name="method" value="pay_car">
                        <input class="btn btn-success" type="submit" name="submit" value="ยืนยันสั่งจ่ายรถ">
                        <?php }elseif($_REQUEST['method']=='confirm_car'){?> 
                    <input type="hidden" name="passenger" value="<?=$detial_l['pass_name'];?>">
                    <input type="hidden" name="method" value="confirm_car">
                    <input class="btn btn-success" type="submit" name="submit" value="ยืนยันกระบวนการ">
                        <?php }elseif($_REQUEST['method']=='cancle_car'){?>
                    <input type="hidden" name="method" value="cancle_car">    
                    <input class="btn btn-danger" type="submit" name="submit" value="ยกเลิก">
                        <?php }elseif($_REQUEST['method']=='mile_car'){?>
                    <input type="hidden" name="method" value="mile_car">
                    <input class="btn btn-success" type="submit" name="submit" value="เพิ่มระยะทาง">
                        <?php }elseif($_REQUEST['method']=='edit_mile_car'){?>
                    <input type="hidden" name="method" value="edit_mile_car">
                    <input class="btn btn-warning" type="submit" name="submit" value="แก้ไขระยะทาง">
                        <?php }?>
                    </center>
           </div>
            
            </div>
                <?php if($_REQUEST['method']=='back'){
                    $select_url=  mysqli_query($db,"select url from hospital");
                    $url=  mysqli_fetch_assoc($select_url);
                    ?>
                <a href="<?= $url['url']?>service&support/fullcalendar/fullcalendar2.php"><img src="../images/undo.ico" width="20"  title="ย้อนกลับ"> กลับไปปฏิทิน</a>
                <?php }?>
        </div>
            </div>
            </div>
        </div>
        </form>

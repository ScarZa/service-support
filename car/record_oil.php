<?php @session_start(); ?>
<?php include '../connection/connect.php';?>
<?php
if (empty($_SESSION['ss_id'])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
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
        <?php if(!empty($_REQUEST['method'])){
            if($_REQUEST['method']=='sel_car'){?>
        
        <form class="navbar-form navbar-left" role="form" action='record_oil.php' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()">
            <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading" align="center">
                <h3 class="panel-title"> บันทึกการใช้น้ำมันเชื้อเพลิง</h3>
            </div>
            <div class="panel-body" align='center'>
        <b>หมายเลขทะเบียน</b>
                <select name="license_plate" id="license_plate"  class="form-control" onkeydown="return nextbox(event, 'dep');"> 
				<?php	$sql = mysqli_query($db,"SELECT *  FROM ss_carlicense");
				 echo "<option value=''>--เลือกรถยนต์--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['license_id']==$edit_person['license_plate']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['license_id']."' $selected>".$result['license_name'] ."</option>";
				 } ?>
                </select><br>
        <input class="btn btn-success" type="submit" name="submit" value="ตกลง">
            </div></div></div></div>
        </form>
        <?php }}  else {
            if(empty($_GET['edit_oil'])){
                echo '555';
            $license_plate=$_POST['license_plate'];
            $sel_lp=  mysqli_query($db, "select license_name from ss_carlicense where license_id='$license_plate'");
            $lp=   mysqli_fetch_assoc($sel_lp);
            
            $sel_detial_oil=  mysqli_query($db, "select * from ss_detial_oil  where license_id='$license_plate' order by do_id desc");
            $detial_oil=  mysqli_fetch_assoc($sel_detial_oil);
            }  else {
                echo '666';
            echo $oil_id=$_GET['id'];
            $sel_detial_oil=  mysqli_query($db, "select * from ss_detial_oil  where do_id='$oil_id'");
            $detial_oil=  mysqli_fetch_assoc($sel_detial_oil);
            
            $sel_lp=  mysqli_query($db, "select license_name from ss_carlicense where license_id=".$detial_oil['license_id']."");
            $lp=   mysqli_fetch_assoc($sel_lp);
            }?>
        <form class="navbar-form navbar-left" role="form" action='../process/prccar.php' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()">
        <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading" align="center">
                <h3 class="panel-title"> รายงานการใช้น้ำมันเชื้อเพลิง</h3>
            </div>
            <div class="panel-body" align='center'>
                <b>รถยนต์หมายเลขทะเบียน <?= $lp['license_name'];?></b><br>
                
                                        <?php include_once ('../option/funcDateThai.php');?>
                        <table align="center" width='100%'>
                        <thead>
                            <tr>
                  <td width='50%' align="right" valign="top"><b>วันที่เติมน้ำมัน : </b></td>
                  <td colspan="3">&nbsp;&nbsp;<input type="date" class="" name="reg_date" value="<?php if(!empty($_GET['edit_oil'])){ echo $detial_oil['reg_date'];}?>" required=""></td>
              </tr>
              <tr>
                  <td width='50%' align="right" valign="top"><b>เลขไมล์ครั้งก่อน : </b></td>
                  <td colspan="3">&nbsp;&nbsp;<input type="text" class="" name="pass_mile" placeholder="เลขครั้งที่แล้ว" 
                   value="<?php if(empty($_GET['edit_oil'])){ echo $detial_oil['this_mile'];}  else { echo $detial_oil['pass_mile'];}?>" required=""></td>
              </tr>
              <tr>
                  <td align="right" valign="top"><b>เลขไมล์ครั้งนี้ : </b></td>
                  <td colspan="3">&nbsp;&nbsp;<input type="text" class="" name="this_mile" placeholder="เลขครั้งนี้" value="<?php if(!empty($_GET['edit_oil'])){ echo $detial_oil['this_mile'];}?>" required=""></td>
              </tr>
              <tr>
                  <td align="right" valign="top"><b>ชนิดน้ำมัน : </b></td>
                  <td colspan="3">&nbsp;&nbsp;<select name="oil_type" id="oil_type"  class="" required=""> 
				<?php	$sql = mysqli_query($db,"SELECT *  FROM ss_oil_type");
				 echo "<option value=''>--เลือกชนิดน้ำมัน--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['oil_id']==$detial_oil['oil_type']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['oil_id']."' $selected>".$result['oil_name'] ."</option>";
				 } ?>
                </select></td>
              </tr>
              <tr>
                  <td align="right" valign="top"><b>จำนวนลิตร : </b></td>
                  <td colspan="3">&nbsp;&nbsp;<input type="text" class="" name="liter" placeholder="จำนวนลิตร" value="<?php if(!empty($_GET['edit_oil'])){ echo $detial_oil['liter'];}?>" required=""></td>
              </tr>
              <tr>
                  <td align="right" valign="top"><b>จำนวนเงิน : </b></td>
                  <td colspan="3">&nbsp;&nbsp;<input type="text" class="" name="bath" placeholder="บาท" value="<?php if(!empty($_GET['edit_oil'])){ echo $detial_oil['bath'];}?>" required=""></td>
              </tr>
              <tr>
                  <td align="right" valign="top"><b>ค่าซ่อมบำรุง : </b></td>
                  <td colspan="3">&nbsp;&nbsp;<input type="text" class="" name="maintenance" placeholder="บาท" value="<?php if(!empty($_GET['edit_oil'])){ echo $detial_oil['maintenance'];}?>"></td>
              </tr>
              <tr>
                  <td align="right" valign="top"><b>หมายเหตุ : </b></td>
                          <td colspan="3">&nbsp;&nbsp;<select name="other" id="other" required="">
                                  <option value="">เลือกประเภทการเติมน้ำมัน</option>
                                  <?php if(empty($_GET['edit_oil'])){?>
                                  <option value="1">เงินสด</option>
                                  <option value="2">บิลน้ำมัน</option>
                                  <?php }  else {
                                      if($detial_oil['other']==1){?>
                                  <option value="1" selected="">เงินสด</option>
                                  <option value="2">บิลน้ำมัน</option>
                                      <?php }  elseif ($detial_oil['other']==2) {?>
                                  <option value="1">เงินสด</option>
                                  <option value="2" selected="">บิลน้ำมัน</option>
                                  <?php }}?>
                      </select></td>
              </tr>
              
                        </thead>
                        </table><br>
                        <center>
                            <?php if(empty($_GET['edit_oil'])){?>
                    <input type="hidden" name="license_id" value="<?= $license_plate?>">
                    <input type="hidden" name="method" value="detial_oil">
                    <input class="btn btn-success" type="submit" name="submit" value="ตกลง">
                            <?php }else {?>
                    <input type="hidden" name="do_id" value="<?= $oil_id?>">
                    <input type="hidden" name="license_id" value="<?= $detial_oil['license_id']?>">
                    <input type="hidden" name="method" value="edit_oil">
                    <input class="btn btn-warning" type="submit" name="submit" value="แก้ไข">
                    <?php }?>
                    </center>
           </div>
            
            </div>
        </div>
            </div>
            </div>
        </div>
        </form>
<?php }?>
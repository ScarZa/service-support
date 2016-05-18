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
        <form class="navbar-form" role="form" action='../process/prcroom.php' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()">
        <div class="row">
    <div class="col-lg-12" align="center">
        <div class="panel panel-primary">
           <?php if($_REQUEST['method']=='confirm_conf'){?> 
            <div class="panel-heading" align="center">
                <h3 class="panel-title"> ยืนยันการอนมัติใช้ห้องสมุด</h3>
            </div>
            <div class="panel-body" align='center'>
                <div class="well well-sm">
                <b>ยืนยันการอนมัติใช้ห้องประชุม</b>
                <div class="form-group">
                    <input type="radio" name="confirm" id="confirm" value="Y" required>&nbsp;&nbsp; อนุมัติ<br> 
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="confirm" id="confirm" value="N" required>&nbsp;&nbsp; ไม่อนุมัติ
                </div>
                </div>
                <?php }else{?>
                 <div class="panel-heading" align="center">
                <h3 class="panel-title"> ใบขอใช้ห้องประชุม</h3>
            </div>
            <div class="panel-body" align='center'>
                <?php }?>
                                        <?php include_once ('../option/funcDateThai.php');
                                        
                                        $conf_id=$_REQUEST['id'];
                                        
                            $select_det=  mysqli_query($db,"SELECT ssc . * , CONCAT( p1.pname, e1.firstname,  ' ', e1.lastname ) AS fullname, d1.depName AS dep, e1.empno AS empno, r.room_name
FROM ss_conferance ssc
INNER JOIN emppersonal e1 ON e1.empno = ssc.empno_request
INNER JOIN pcode p1 ON e1.pcode = p1.pcode
INNER JOIN department d1 ON e1.depid = d1.depId
INNER JOIN ss_room r ON r.room_id = ssc.room
WHERE ssc.conf_id ='$conf_id'");
                            $detial_l= mysqli_fetch_assoc($select_det);
                            $idAdmin=$detial_l[idAdmin];
                            $select_admin=mysqli_query($db,"select concat(e.firstname,' ',e.lastname) as adminname
                                                        from emppersonal e
                                                        inner join work w on e.empno=w.idAdmin
                                                        where w.idAdmin='$idAdmin'");
                            $detial_admin= mysqli_fetch_assoc($select_admin);        
                        ?>
                        <table align="center" width='100%'>
                        <thead>
              <tr>
                  <td width='50%' align="right" valign="top"><b>ชื่อ-นามสกุล : </b></td>
                  <td colspan="3">&nbsp;&nbsp;<?= $detial_l['fullname'];?></td>
              </tr>
              <tr>
                  <td align="right"><b>ฝ่าย-งาน : </b></td>
                  <td colspan="3">&nbsp;&nbsp; <?=$detial_l['dep'];?></td></tr>
              <tr>
                  <td align="right"><b>วันที่เขียนขอใช้ห้องประชุม : </b></td>
                  <td  colspan="3">&nbsp;&nbsp; <?=DateThai1($detial_l['record_date']);?></td>
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
                <td align="right"><b>จำนวนผู้เข้าร่วม : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?=$detial_l['amount'];?>&nbsp; <b>คน</b></td>
              </tr>
              
              <tr>
                <td align="right" valign="top"><b>ห้องประชุม : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?=$detial_l['room_name'];?></td>
              </tr>
              <tr>
                <td align="right"><B>รูปแบบ : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?php if($detial_l['format']=='1'){echo 'ประชุม';}elseif ($detial_l['format']=='2') {echo 'สัมมนา';}?></td>
              </tr>
              <?php
              if($detial_l['equip']=='Y'){
                  
              ?>
              <tr>
                <td align="right" valign="top"><B>การสนับสนุนอุปกรณ์โสตฯ : </b></td>
                <td colspan="3">&nbsp;&nbsp; <?php 
                if($detial_l['audio']=='Y'){echo 'ใช้เครื่องเสียง,&nbsp;&nbsp;';}
                if ($detial_l['mic_table']!='0') {echo 'ไมค์ตั้งโต๊ะ&nbsp;'.$detial_l['mic_table'].'&nbsp;ตัว,&nbsp;&nbsp;';}
                if ($detial_l['mic_wireless']!='0') {echo 'ไมค์ลอย&nbsp;'.$detial_l['mic_wireless'].'&nbsp;ตัว,&nbsp;&nbsp;';}
                if ($detial_l['mic_line']!='0') {echo 'ไมค์สาย&nbsp;'.$detial_l['mic_line'].'&nbsp;ตัว,&nbsp;&nbsp;';}
                if($detial_l['visualizer']=='Y'){echo 'ใช้เครื่องฉายภาพ(visualizer),&nbsp;&nbsp;';}
                if($detial_l['projector']=='Y'){echo 'ใช้เครื่องฉายโปรเจ็กเตอร์ พร้อมจอ,&nbsp;&nbsp;';}
                if($detial_l['comp']=='Y'){echo 'ใช้เครื่องคอมพิวเตอร์&nbsp;&nbsp;';}
                ?>
                </td>
              </tr>
              <?php }?>
                        </thead>
                        </table><br>
                        <center>
                        <input type="hidden" name="conf_id" value="<?=$conf_id;?>">
                        
                        <?php if($_REQUEST['method']=='confirm_conf'){?> 
                        <input type="hidden" name="depName" value="<?=$detial_l['dep'];?>">
                        <input type="hidden" name="event_start" value="<?=$detial_l['start_date']." ".$detial_l['start_time'];?>">
                        <input type="hidden" name="event_end" value="<?=$detial_l['end_date']." ".$detial_l['end_time'];?>">
                        <input type="hidden" name="empno" value="<?=$detial_l['empno_request'];?>">
                        <input type="hidden" name="room" value="<?=$detial_l['room'];?>">    
                    <input type="hidden" name="method" value="confirm_conf">
                    <input class="btn btn-success" type="submit" name="submit" value="ยืนยันกระบวนการ">
                        <?php }elseif($_REQUEST['method']=='cancle_conf'){?>
                    <input type="hidden" name="method" value="cancle_conf">    
                    <input class="btn btn-danger" type="submit" name="submit" value="ยกเลิก">
                        <?php }?>
                    </center>
           </div></div>
            <?php if($_REQUEST['method']=='back'){?>
                <a href="http://localhost:808/service&support/fullcalendar/fullcalendar1.php"><img src="../images/undo.ico" width="20"  title="ย้อนกลับ"> กลับไปปฏิทิน</a>
                <?php }?>
            
        </div>
            </div>
            </div>
        </form>
<?php include '../footer.php';?>
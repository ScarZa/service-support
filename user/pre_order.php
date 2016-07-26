<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'>  บันทึกสถานะการขอใช้ห้องประชุม/รถยนต์ </font></h1> 
        <ol class="breadcrumb alert-warning">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> บันทึกสถานะการขอใช้ห้องประชุม/รถยนต์</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title"><font color='brown'>ตารางบันทึกสถานะการขอใช้ห้องประชุม/รถยนต์</font></h3>
            </div>
            <div class="panel-body table-responsive">
                <?php

                include 'connection/connect.php';                
                include 'option/function_date.php';
if($date >= $bdate and $date <= $edate){
 $this_year=$y;
    $next_year=$Yy;
}  else {
    $this_year=$Y;
    $next_year=$y;
} 
if($_SESSION['ss_status']=='USER'){ 
  $dep=$_SESSION['ss_dep'];  
  $code="e.depid='$dep' and";  
}  else {
  $code="";  
}
    $q="select r.room_name, d.depName, ssc.start_date, ssc.end_date, ssc.start_time, ssc.end_time, ssc.amount, ssc.conf_id, ssc.approve, ssc.conferance_no
            from ss_conferance ssc
            inner join ss_room r on r.room_id=ssc.room
            inner join emppersonal e on e.empno=ssc.empno_request
            inner join department d on d.depId=e.depid
            where $code ssc.start_date between '$this_year-10-01' and '$next_year-09-30'
            order by ssc.conf_id desc";
    $qr = mysqli_query($db,$q);
    $q2="SELECT ssc . * , CONCAT( p1.pname, e.firstname,  ' ', e.lastname ) AS fullname, d1.depName AS dep, e.empno AS empno,
                                 am.AMPHUR_NAME as amphur, pv.PROVINCE_NAME as province, ssc.passenger
FROM ss_car ssc
INNER JOIN emppersonal e ON e.empno = ssc.empno_request
INNER JOIN pcode p1 ON e.pcode = p1.pcode
INNER JOIN department d1 ON e.depid = d1.depId
INNER JOIN amphur am on am.AMPHUR_ID=ssc.amphur
INNER JOIN province pv on pv.PROVINCE_ID=ssc.province
where $code ssc.start_date between '$this_year-10-01' and '$next_year-09-30'
order by ssc.car_id desc";
    $qr2 = mysqli_query($db,$q2);

                
                ?>
                <div class="table-responsive">
                    <?php include_once ('option/funcDateThai.php'); ?>
                <div align="center"><h4><b>สถานะการขอใช้ห้องประชุม</b></h4></div>
                    <table align="center" width="100%" class="table-responsive table-bordered table-hover">
                        <thead>
                    <tr align="center" bgcolor="#898888">
                        <td width="3%" align="center"><b>ลำดับ</b></td>
                        <td width="8%" align="center"><b>เลขใบคำขอ</b></td>
                        <td width="15%" align="center"><b>ห้องประชุม</b></td>
                        <td width="19%" align="center"><b>หน่วยงาน</b></td>
                        <td width="20%" align="center"><b>จากวันที่</b></td>
                        <td width="15%" align="center"><b>เวลา</b></td>
                        <td width="6%" align="center"><b>จำนวนผู้เข้าร่วม</b></td>
                        <td width="6%" align="center"><b>สถานะ</b></td>
                    </tr>
                        </thead>
                        <tbody>
                    <?php
                    $i = 1;
                    while ($result = mysqli_fetch_assoc($qr)) {
                        ?>
                        <tr>
                            <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                            <td align="center"><a href="#" onclick="return popup('conferance/confirm_conf.php?id=<?= $result['conf_id']; ?>',popup,550,550);"><?= $result['conferance_no']; ?></a>
                            </td>
                            <td align="center"><a href="#" onclick="return popup('conferance/confirm_conf.php?id=<?= $result['conf_id']; ?>',popup,550,550);"><?= $result['room_name']; ?></a>
                            </td>
                            <td align="center"><a href="#" onclick="return popup('conferance/confirm_conf.php?id=<?= $result['conf_id']; ?>',popup,550,550);"><?= $result['depName']; ?></a></td>
                            <td align="center"><?= DateThai1($result['start_date']);?> <b>ถึง</b> <?= DateThai1($result['end_date']);?></td>
                            <td align="center"><?= $result['start_time']; ?> <b>ถึง</b> <?= $result['end_time']; ?></td>
                            <td align="center"><?= $result['amount']; ?></td>
                            <td align="center">
                            <?php if($result['approve']==''){ ?>
                                <i class="fa fa-spinner fa-spin" title="รอการตรวจรับ"></i>
                            <?php } elseif ($result['approve']=='Y') {?>
                                    <img src="images/Symbol_-_Check.ico" width="20"  title="อนุมัติ">
                                     <?php } elseif ($result['approve']=='C') {?>
                                    <img src="images/close.ico" width="20" title="ยกเลิก">
                                    <?php } elseif ($result['approve']=='N') {?>
                                    <img src="images/button_cancel.ico" width="20" title="ไม่อนุมัติ">
                                     <?php }?>
                            </td>
                        </tr>
                    <?php $i++;
                }
                ?>
                        </tbody>
                    </table></div><br>
                    <div class="table-responsive">
                <div align="center"><h4><b>สถานะการขอใช้รถยนต์</b></h4></div>
                <table align="center" width="100%" class="table-responsive table-bordered table-hover">
                    <thead>
                    <tr align="center" bgcolor="#898888">
                        <td width="3%" align="center"><b>ลำดับ</b></td>
                        <td width="8%" align="center"><b>เลขใบคำขอ</b></td>
                        <td width="15%" align="center"><b>ผู้ขอ</b></td>
                        <td width="19%" align="center"><b>สถานที่ที่ไป</b></td>
                        <td width="20%" align="center"><b>จากวันที่</b></td>
                        <td width="15%" align="center"><b>เวลา</b></td>
                        <td width="6%" align="center"><b>จำนวนผู้ร่วมทาง</b></td>
                        <td width="6%" align="center"><b>สถานะ</b></td>
                        <td width="6%" align="center"><b>พิมพ์แบบขออนุญาต</b></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $c = 1;
                    while ($result2 = mysqli_fetch_assoc($qr2)) {
                        ?>
                        <tr>
                            <td align="center"><?= ($chk_page * $e_page) + $c ?></td>
                            <td align="center"><a href="#" onclick="return popup('car/confirm_car.php?id=<?= $result2['car_id']; ?>',popup,550,600);"><?= $result2['car_no']; ?></a>
                            </td>
                            <td align="center"><a href="#" onclick="return popup('car/confirm_car.php?id=<?= $result2['car_id']; ?>',popup,550,600);"><?= $result2['fullname']; ?></a>
                            </td>
                            <td align="center"><a href="#" onclick="return popup('car/confirm_car.php?id=<?= $result2['car_id']; ?>',popup,550,600);">
                            <?=$result2['place']."&nbsp;จ.".$result2['province']."&nbsp;อ.".$result2['amphur'];?> </td></a></td>
                            <td align="center"><?= DateThai1($result2['start_date']);?> <b>ถึง</b> <?= DateThai1($result2['end_date']);?></td>
                            <td align="center"><?= $result2['start_time']; ?> <b>ถึง</b> <?= $result2['end_time']; ?></td>
                            <td align="center"><?= $result2['amount']; ?></td>
                            <td align="center">
                            <?php if($result2['pay']=='Y' and $result2['approve']==''){ ?>
                                <i class="fa fa-spinner fa-spin" title="รอการตรวจรับ"></i>
                            <?php } elseif ($result2['pay']=='Y' and $result2['approve']=='') {?>
                                    <img src="images/email.ico" width="20" title="รออนุมัติ">
                            <?php } elseif ($result2['pay']=='Y' and $result2['approve']=='Y') {?>
                                    <img src="images/Symbol_-_Check.ico" width="20"  title="อนุมัติ">
                                     <?php } elseif ($result2['pay']=='Y' and $result2['approve']=='C') {?>
                                    <img src="images/close.ico" width="20" title="ยกเลิก">
                                    <?php } elseif ($result2['pay']=='Y' and $result2['approve']=='N') {?>
                                    <img src="images/button_cancel.ico" width="20" title="ไม่อนุมัติ">
                                     <?php }elseif ($result2['pay']=='N') {?>
                                        <img src="images/warning.png" width="20" title="ไม่จ่ายรถ">
                                     <?php }elseif ($result2['pay']=='') {?>
                                        <i class="fa fa-spinner" title="เจ้าหน้าที่ยังไม่ได้รับใบคำขอ"></i>
                                     <?php }?>
                            </td>
                            <?php if (($result2['pay']=='Y' and $result2['approve']=='') or ($result2['pay']=='Y' and $result2['approve']=='Y')) {?>
                            <td align="center"><a href="#" onClick="window.open('car/car_request_paper.php?car_id=<?= $result2['car_id']; ?>','','width=700,height=900'); return false;" title="พิมพ์ใบขอรถยนต์"><img src='images/printer.ico' alt="" width='30' /></a></td>
                        <?php }else{ ?>
                            <td align="center">&nbsp;</td>
                        <?php }?>
                        </tr>
                    <?php $c++;
                }
                ?>
                    </tbody>
                </table>
                    </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>

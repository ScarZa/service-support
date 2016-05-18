<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'>  บันทึกการไม่อนุมัติ/ยกเลิกใช้รถยนต์ </font></h1> 
        <ol class="breadcrumb alert-warning">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> บันทึกการไม่อนุมัติ/ยกเลิกใช้รถยนต์</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title"><font color='brown'>ตารางบันทึกการไม่อนุมัติ/ยกเลิกใช้รถยนต์</font></h3>
            </div>
            <div class="panel-body">
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
    $q="SELECT ssc . * , CONCAT( p1.pname, e1.firstname,  ' ', e1.lastname ) AS fullname, d1.depName AS dep, e1.empno AS empno,
                                 am.AMPHUR_NAME as amphur, pv.PROVINCE_NAME as province, ssc.passenger
FROM ss_car ssc
INNER JOIN emppersonal e1 ON e1.empno = ssc.empno_request
INNER JOIN pcode p1 ON e1.pcode = p1.pcode
INNER JOIN department d1 ON e1.depid = d1.depId
INNER JOIN amphur am on am.AMPHUR_ID=ssc.amphur
INNER JOIN province pv on pv.PROVINCE_ID=ssc.province
where ssc.approve='N' and ssc.start_date between '$this_year-10-01' and '$next_year-09-30'
order by ssc.car_id desc";
    $qr = mysqli_query($db,$q);
    $q2="SELECT ssc . * , CONCAT( p1.pname, e1.firstname,  ' ', e1.lastname ) AS fullname, d1.depName AS dep, e1.empno AS empno,
                                 am.AMPHUR_NAME as amphur, pv.PROVINCE_NAME as province, ssc.passenger
FROM ss_car ssc
INNER JOIN emppersonal e1 ON e1.empno = ssc.empno_request
INNER JOIN pcode p1 ON e1.pcode = p1.pcode
INNER JOIN department d1 ON e1.depid = d1.depId
INNER JOIN amphur am on am.AMPHUR_ID=ssc.amphur
INNER JOIN province pv on pv.PROVINCE_ID=ssc.province
where ssc.approve='C'and ssc.start_date between '$this_year-10-01' and '$next_year-09-30'
order by ssc.car_id desc";
    $qr2 = mysqli_query($db,$q2);
    $q3="SELECT ssc . * , CONCAT( p1.pname, e1.firstname,  ' ', e1.lastname ) AS fullname, d1.depName AS dep, e1.empno AS empno,
                                 am.AMPHUR_NAME as amphur, pv.PROVINCE_NAME as province, ssc.passenger
FROM ss_car ssc
INNER JOIN emppersonal e1 ON e1.empno = ssc.empno_request
INNER JOIN pcode p1 ON e1.pcode = p1.pcode
INNER JOIN department d1 ON e1.depid = d1.depId
INNER JOIN amphur am on am.AMPHUR_ID=ssc.amphur
INNER JOIN province pv on pv.PROVINCE_ID=ssc.province
where ssc.pay='N'and ssc.start_date between '$this_year-10-01' and '$next_year-09-30'
order by ssc.car_id desc";
    $qr3= mysqli_query($db,$q3);

                
                ?>

                    <?php include_once ('option/funcDateThai.php'); ?>
                <div align="center"><h4><b>ไม่อนุมัติการขอใช้รถยนต์</b></h4></div>
                <table align="center" width="100%" border="1">
                    <tr align="center" bgcolor="#898888">
                        <td width="3%" align="center"><b>ลำดับ</b></td>
                        <td width="8%" align="center"><b>เลขใบคำขอ</b></td>
                        <td width="15%" align="center"><b>ผู้ขอ</b></td>
                        <td width="19%" align="center"><b>สถานที่ที่ไป</b></td>
                        <td width="20%" align="center"><b>จากวันที่</b></td>
                        <td width="15%" align="center"><b>เวลา</b></td>
                        <td width="6%" align="center"><b>จำนวนผู้ร่วมทาง</b></td>
                        <td width="6%" align="center"><b>สถานะ</b></td>
                    </tr>

                    <?php
                    $i = 1;
                    while ($result = mysqli_fetch_assoc($qr)) {
                        ?>
                        <tr>
                            <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                            <td align="center"><a href="#" onclick="return popup('car/confirm_car.php?id=<?= $result['car_id']; ?>',popup,490,450);"><?= $result['car_no']; ?></a>
                            </td>
                            <td align="center"><a href="#" onclick="return popup('car/confirm_car.php?id=<?= $result['car_id']; ?>',popup,490,450);"><?= $result['fullname']; ?></a>
                            </td>
                            <td align="center"><a href="#" onclick="return popup('car/confirm_car.php?id=<?= $result['car_id']; ?>',popup,490,450);">
                            <?=$result['place']."&nbsp;จ.".$result['province']."&nbsp;อ.".$result['amphur'];?> </td></a></td>
                            <td align="center"><?= DateThai1($result['start_date']);?> <b>ถึง</b> <?= DateThai1($result['end_date']);?></td>
                            <td align="center"><?= $result['start_time']; ?> <b>ถึง</b> <?= $result['end_time']; ?></td>
                            <td align="center"><?= $result['amount']; ?></td>
                            <td align="center">
                            <?php if($result['payer']==''){ ?>
                            <i class="fa fa-spinner fa-spin"></i>
                            <?php } elseif ($result['payer']!='' and $result['approve']=='') {?>
                                    <img src="images/email.ico" width="20">
                            <?php } elseif ($result['payer']!='' and $result['approve']=='Y') {?>
                                    <img src="images/Symbol_-_Check.ico" width="20"  title="อนุมัติ">
                                     <?php } elseif ($result['payer']!='' and $result['approve']=='N') {?>
                                    <img src="images/button_cancel.ico" width="20" title="ไม่อนุมัติ">
                                     <?php }?>
                            </td>
                        </tr>
                    <?php $i++;
                }
                ?>

                </table><br>
                <div align="center"><h4><b>ยกเลิกการขอใช้รถยนต์</b></h4></div>
                <table align="center" width="100%" border="1">
                    <tr align="center" bgcolor="#898888">
                        <td width="3%" align="center"><b>ลำดับ</b></td>
                        <td width="8%" align="center"><b>เลขใบคำขอ</b></td>
                        <td width="15%" align="center"><b>ผู้ขอ</b></td>
                        <td width="19%" align="center"><b>สถานที่ที่ไป</b></td>
                        <td width="20%" align="center"><b>จากวันที่</b></td>
                        <td width="15%" align="center"><b>เวลา</b></td>
                        <td width="6%" align="center"><b>จำนวนผู้ร่วมทาง</b></td>
                        <td width="6%" align="center"><b>สถานะ</b></td>
                    </tr>

                    <?php
                    $c = 1;
                    while ($result2 = mysqli_fetch_assoc($qr2)) {
                        ?>
                        <tr>
                            <td align="center"><?= ($chk_page * $e_page) + $c ?></td>
                            <td align="center"><a href="#" onclick="return popup('car/confirm_car.php?id=<?= $result2['car_id']; ?>',popup,490,450);"><?= $result2['car_no']; ?></a>
                            </td>
                            <td align="center"><a href="#" onclick="return popup('car/confirm_car.php?id=<?= $result2['car_id']; ?>',popup,490,450);"><?= $result2['fullname']; ?></a>
                            </td>
                            <td align="center"><a href="#" onclick="return popup('car/confirm_car.php?id=<?= $result2['car_id']; ?>',popup,490,450);">
                            <?=$result2['place']."&nbsp;จ.".$result2['province']."&nbsp;อ.".$result2['amphur'];?> </td></a></td>
                            <td align="center"><?= DateThai1($result2['start_date']);?> <b>ถึง</b> <?= DateThai1($result2['end_date']);?></td>
                            <td align="center"><?= $result2['start_time']; ?> <b>ถึง</b> <?= $result2['end_time']; ?></td>
                            <td align="center"><?= $result2['amount']; ?></td>
                            <td align="center">
                            <?php if($result2['payer']==''){ ?>
                            <i class="fa fa-spinner fa-spin"></i>
                            <?php } elseif ($result2['payer']!='' and $result2['approve']=='') {?>
                                    <img src="images/email.ico" width="20">
                            <?php } elseif ($result2['payer']!='' and $result2['approve']=='Y') {?>
                                    <img src="images/Symbol_-_Check.ico" width="20"  title="อนุมัติ">
                                     <?php } elseif ($result2['payer']!='' and $result2['approve']=='C') {?>
                                    <img src="images/close.ico" width="20" title="ยกเลิก">
                                     <?php }?>
                            </td>
                        </tr>
                    <?php $c++;
                }
                ?>

                </table><br>
                <div align="center"><h4><b>ไม่จ่ายรถยนต์</b></h4></div>
                <table align="center" width="100%" border="1">
                    <tr align="center" bgcolor="#898888">
                        <td width="3%" align="center"><b>ลำดับ</b></td>
                        <td width="8%" align="center"><b>เลขใบคำขอ</b></td>
                        <td width="15%" align="center"><b>ผู้ขอ</b></td>
                        <td width="19%" align="center"><b>สถานที่ที่ไป</b></td>
                        <td width="20%" align="center"><b>จากวันที่</b></td>
                        <td width="15%" align="center"><b>เวลา</b></td>
                        <td width="6%" align="center"><b>จำนวนผู้ร่วมทาง</b></td>
                        <td width="6%" align="center"><b>สถานะ</b></td>
                    </tr>

                    <?php
                    $s = 1;
                    while ($result3 = mysqli_fetch_assoc($qr3)) {
                        ?>
                        <tr>
                            <td align="center"><?= ($chk_page * $e_page) + $s ?></td>
                            <td align="center"><a href="#" onclick="return popup('car/confirm_car.php?id=<?= $result3['car_id']; ?>',popup,490,450);"><?= $result3['car_no']; ?></a>
                            </td>
                            <td align="center"><a href="#" onclick="return popup('car/confirm_car.php?id=<?= $result3['car_id']; ?>',popup,490,450);"><?= $result3['fullname']; ?></a>
                            </td>
                            <td align="center"><a href="#" onclick="return popup('car/confirm_car.php?id=<?= $result3['car_id']; ?>',popup,490,450);">
                            <?=$result3['place']."&nbsp;จ.".$result3['province']."&nbsp;อ.".$result3['amphur'];?> </td></a></td>
                            <td align="center"><?= DateThai1($result3['start_date']);?> <b>ถึง</b> <?= DateThai1($result3['end_date']);?></td>
                            <td align="center"><?= $result32['start_time']; ?> <b>ถึง</b> <?= $result3['end_time']; ?></td>
                            <td align="center"><?= $result3['amount']; ?></td>
                            <td align="center">
                            <?php if($result3['pay']=='N'){ ?>
                            <img src="images/warning.png" width="20" title="ไม่จ่ายรถ">
                            <?php } ?>
                            </td>
                        </tr>
                    <?php $s++;
                }
                ?>

                </table>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>

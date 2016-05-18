<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'>  บันทึกการอนุมัติใช้ห้องประชุม </font></h1> 
        <ol class="breadcrumb alert-warning">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> บันทึกการอนุมัติใช้ห้องประชุม</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title"><font color='brown'>ตารางบันทึกการอนุมัติใช้ห้องประชุม</font></h3>
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
    $q="select r.room_name, d.depName, ssc.start_date, ssc.end_date, ssc.start_time, ssc.end_time, ssc.amount, ssc.conf_id, ssc.conferance_no
            from ss_conferance ssc
            inner join ss_room r on r.room_id=ssc.room
            inner join emppersonal e on e.empno=ssc.empno_request
            inner join department d on d.depId=e.depid
            WHERE approve='Y' and start_date between '$this_year-10-01' and '$next_year-09-30'
            order by ssc.conf_id desc";
    $qr = mysqli_query($db,$q);

                
                ?>

                    <?php include_once ('option/funcDateThai.php'); ?>
                <table align="center" width="100%" border="1">
                    <tr align="center" bgcolor="#898888">
                        <td width="3%" align="center"><b>ลำดับ</b></td>
                        <td width="8%" align="center"><b>เลขใบคำขอ</b></td>
                        <td width="15%" align="center"><b>ห้องประชุม</b></td>
                        <td width="19%" align="center"><b>หน่วยงาน</b></td>
                        <td width="20%" align="center"><b>จากวันที่</b></td>
                        <td width="15%" align="center"><b>เวลา</b></td>
                        <td width="6%" align="center"><b>จำนวนผู้เข้าร่วม</b></td>
                        <?php if($_SESSION['ss_status']=='ADMIN' or $_SESSION['ss_status']=='SUSER'){?>
                        <td width="6%" align="center"><b>ยกเลิก</b></td>
                        <td width="6%" align="center"><b>แก้ไข</b></td>
                        <?php }?>
                    </tr>

                    <?php
                    $i = 1;
                    while ($result = mysqli_fetch_assoc($qr)) {
                        ?>
                        <tr>
                            <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                            <td align="center"><a href="#" onclick="return popup('conferance/confirm_conf.php?id=<?= $result['conf_id']; ?>',popup,490,450);"><?= $result['conferance_no']; ?></a>
                            </td>
                            <td align="center"><a href="#" onclick="return popup('conferance/confirm_conf.php?id=<?= $result['conf_id']; ?>',popup,490,450);"><?= $result['room_name']; ?></a>
                            </td>
                            <td align="center"><a href="#" onclick="return popup('conferance/confirm_conf.php?id=<?= $result['conf_id']; ?>',popup,490,450);"><?= $result['depName']; ?></a></td>
                            <td align="center"><?= DateThai1($result['start_date']);?> <b>ถึง</b> <?= DateThai1($result['end_date']);?></td>
                            <td align="center"><?= $result['start_time']; ?> <b>ถึง</b> <?= $result['end_time']; ?></td>
                            <td align="center"><?= $result['amount']; ?></td>
                            <?php if($_SESSION['ss_status']=='ADMIN' or $_SESSION['ss_status']=='SUSER'){?>
                            <td align="center"><a href="#" onclick="return popup('conferance/confirm_conf.php?id=<?= $result['conf_id']; ?>&method=cancle_conf',popup,550,450);"><img src='images/file_delete.ico' width='30'></a></td>
                            <td align="center"><a href="index.php?page=conferance/request_conf&method=edit&id=<?=$result['conf_id'];?>"><img src='images/file_edit.ico' width='30'></a></td>
                            <?php }?>
                            
                        </tr>
                    <?php $i++;
                }
                ?>

                </table>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>

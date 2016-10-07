<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'>  บันทึกการขอใช้ห้องประชุม </font></h1> 
        <ol class="breadcrumb alert-warning">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> บันทึกการขอใช้ห้องประชุม</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title"><font color='brown'>ตารางบันทึกการขอใช้ห้องประชุม</font></h3>
            </div>
            <div class="panel-body">
                <form method="post" action="" enctype="multipart/form-data" class="navbar-form navbar-right">
                        <div class="form-group"> 
                            <select name='year'  class="form-control">
                                <option value=''>กรุณาเลือกปีงบประมาณ</option>
                                <?php
                                for ($i = 2559; $i <= 2565; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">ตกลง</button>
                       <?php if (!empty($_REQUEST['year'])) {?>
                        <button type="submit" class="btn btn-danger">เคลียร์</button>   
                       <?php }?>
                    </form>
                <?php

                include 'connection/connect.php';                
                
                if (!empty($_REQUEST['year'])) {
                $year = $_POST['year'] - 543;
                include 'option/function_date.php';
                 $years = $year + 543;
                    $sql_month = mysqli_query($db,"SELECT month_name FROM month where month_id='".$_REQUEST['month_id']."'");
                    $month = mysqli_fetch_assoc( $sql_month );
                    
                    $this_year=$Y;
                    $next_year=$y;
                 }else{
                    if($date >= $bdate and $date <= $edate){
    include 'option/function_date.php';
    $this_year=$y;
    $next_year=$Yy;
}  else {
    $this_year=$Y;
    $next_year=$y;
                } }
    $q="select r.room_name, d.depName, ssc.start_date, ssc.end_date, ssc.start_time, ssc.end_time, ssc.amount, ssc.conf_id, ssc.conferance_no
            from ss_conferance ssc
            inner join ss_room r on r.room_id=ssc.room
            inner join emppersonal e on e.empno=ssc.empno_request
            inner join department d on d.depId=e.depid
            WHERE ISNULL( approve ) and ssc.start_date between '$this_year-10-01' and '$next_year-09-30'
            order by ssc.conf_id";
        $qr = mysqli_query($db,$q);
                ?>

                    <?php include_once ('option/funcDateThai.php'); ?>
                <table align="center" width="100%" border="1">
                    <?php  if (!empty($_REQUEST['year'])) {?>
                    <tr align="center">
                        <td colspan="14"><b>ปีงบประมาณ <?= $years?></b></td>
                          </tr><?php }?>
                    <tr align="center" bgcolor="#898888">
                        <td width="3%" align="center"><b>ลำดับ</b></td>
                        <td width="8%" align="center"><b>เลขใบคำขอ</b></td>
                        <td width="15%" align="center"><b>ห้องประชุม</b></td>
                        <td width="19%" align="center"><b>หน่วยงาน</b></td>
                        <td width="20%" align="center"><b>จากวันที่</b></td>
                        <td width="15%" align="center"><b>เวลา</b></td>
                        <td width="6%" align="center"><b>จำนวนผู้เข้าร่วม</b></td>
                        <?php if($_SESSION['ss_status']=='ADMIN' or $_SESSION['ss_status']=='SUSER'){?>
                        <td width="6%" align="center"><b>ยืนยัน</b></td>
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
                            <td align="center"><a href="#" onclick="return popup('conferance/confirm_conf.php?id=<?= $result['conf_id']; ?>&method=confirm_conf',popup,550,550);"><img src='images/email.ico' width='30'></a></td>
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

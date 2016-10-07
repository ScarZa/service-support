<?php  include 'connection/connect.php'; ?>
<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'>  บันทึกการขอใช้รถยนต์ </font></h1> 
        <ol class="breadcrumb alert-warning">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> บันทึกการขอใช้รถยนต์</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title"><font color='brown'>ตารางบันทึกการขอใช้รถยนต์</font></h3>
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
                
                if(!empty($_REQUEST['method'])){
                    if($_REQUEST['method']=='del'){
                        $del_id=$_REQUEST['id'];
                        $sql_del = "delete from ss_car where car_id = '$del_id';";
                        mysqli_query($db,$sql_del) or die(mysqli_error($db));
                        $sql_del_event = "delete from tbl_event where work_id = '$del_id';";
                        mysqli_query($db,$sql_del_event);
                    }
                }
                   
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
     $q="SELECT ssc . * , CONCAT( p1.pname, e1.firstname,  ' ', e1.lastname ) AS fullname, d1.depName AS dep, e1.empno AS empno,
                                 am.AMPHUR_NAME as amphur, pv.PROVINCE_NAME as province, ssc.passenger
FROM ss_car ssc
INNER JOIN emppersonal e1 ON e1.empno = ssc.empno_request
INNER JOIN pcode p1 ON e1.pcode = p1.pcode
INNER JOIN department d1 ON e1.depid = d1.depId
INNER JOIN amphur am on am.AMPHUR_ID=ssc.amphur
INNER JOIN province pv on pv.PROVINCE_ID=ssc.province
WHERE isnull(ssc.approve) and (isnull(ssc.pay) or ssc.pay='Y') and ssc.start_date between '$this_year-10-01' and '$next_year-09-30' order by ssc.car_id desc";
    $qr = mysqli_query($db,$q);
                
                 include_once ('option/funcDateThai.php'); ?>
                <table align="center" width="100%" border="1">
                    <?php  if (!empty($_REQUEST['year'])) {?>
                    <tr align="center">
                        <td colspan="14"><b>ปีงบประมาณ <?= $years?></b></td>
                          </tr><?php }?>
                    <tr align="center" bgcolor="#898888">
                        <td width="3%" align="center"><b>ลำดับ</b></td>
                        <td width="8%" align="center"><b>เลขใบคำขอ</b></td>
                        <td width="15%" align="center"><b>ผู้ขอ</b></td>
                        <td width="19%" align="center"><b>สถานที่ที่ไป</b></td>
                        <td width="20%" align="center"><b>จากวันที่</b></td>
                        <td width="15%" align="center"><b>เวลา</b></td>
                        <td width="6%" align="center"><b>จำนวนผู้ร่วมทาง</b></td>
                        <td width="6%" align="center"><b>สถานะ</b></td>
                        <?php if($_SESSION['ss_status']=='ADMIN' or $_SESSION['ss_status']=='SUSER'){?>
                        <td width="6%" align="center"><b>ยืนยัน</b></td>
                        <td width="6%" align="center"><b>แก้ไข</b></td>
                        <?php }?>
                        <?php if($_SESSION['ss_status']=='ADMIN'){ ?>
                        <td width="6%" align="center"><b>ลบ</b></td>
                        <?php }?>
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
                            <?php if($result['pay']=='Y' and $result['approve']==''){ ?>
                                <i class="fa fa-spinner fa-spin" title="รอการตรวจรับ"></i>
                            <?php } elseif ($result['pay']=='Y' and $result['approve']=='') {?>
                                    <img src="images/email.ico" width="20" title="รออนุมัติ">
                            <?php } elseif ($result['pay']=='Y' and $result['approve']=='Y') {?>
                                    <img src="images/Symbol_-_Check.ico" width="20"  title="อนุมัติ">
                                     <?php } elseif ($result['pay']=='Y' and $result['approve']=='C') {?>
                                    <img src="images/close.ico" width="20" title="ยกเลิก">
                                    <?php } elseif ($result['pay']=='Y' and $result['approve']=='N') {?>
                                    <img src="images/button_cancel.ico" width="20" title="ไม่อนุมัติ">
                                     <?php }elseif ($result['pay']=='N') {?>
                                        <img src="images/warning.png" width="20" title="ไม่จ่ายรถ"></i>
                                     <?php }elseif ($result['pay']=='') {?>
                                        <i class="fa fa-spinner" title="เจ้าหน้าที่ยังไม่ได้รับใบคำขอ"></i>
                                     <?php }?>
                            </td>
                            <?php if($_SESSION['ss_status']=='ADMIN' or $_SESSION['ss_status']=='SUSER'){
                                if($result['pay']==''){?>
                            <td align="center"><a href="#" onclick="return popup('car/confirm_car.php?id=<?= $result['car_id']; ?>&method=pay_car',popup,550,550);"><i class="fa fa-2x fa-spinner fa-spin"></i></a></td>
                                <?php }  elseif ($result['pay']=='Y') {?>
                            <td align="center"><a href="#" onclick="return popup('car/confirm_car.php?id=<?= $result['car_id']; ?>&method=confirm_car',popup,550,550);"><img src='images/email.ico' width='30'></a></td>
                                <?php }elseif ($result['pay']=='N') {?>
                            <td align="center"><img src='images/warning.png' width='30'></td>
                                <?php }?>
                            <td align="center"><a href="index.php?page=car/request_car&method=edit&id=<?=$result['car_id'];?>"><img src='images/file_edit.ico' width='30'></a></td>
                            <?php }?>
                        <?php if($_SESSION['ss_status']=='ADMIN'){ ?>
                            <td align="center"><a href="index.php?page=car/pre_request&method=del&id=<?=$result['car_id'];?>" onClick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')"><img src='images/close.ico' width='30'></a></td>
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

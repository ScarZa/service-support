<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'>  บันทึกการอนุมัติใช้รถยนต์ </font></h1> 
        <ol class="breadcrumb alert-warning">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> บันทึกการอนุมัติใช้รถยนต์</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title"><font color='brown'>ตารางบันทึกการอนุมัติใช้รถยนต์</font></h3>
            </div>
            <div class="panel-body">
                <?php

                include 'connection/connect.php'; 
                
// สร้างฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
function page_navigator($before_p,$plus_p,$total,$total_p,$chk_page){   
	global $e_page;
	global $querystr;
	$urlfile="index.php?page=car/pre_confirm"; // ส่วนของไฟล์เรียกใช้งาน ด้วย ajax (ajax_dat.php)
	$per_page=10;
	$num_per_page=floor($chk_page/$per_page);
	$total_end_p=($num_per_page+1)*$per_page;
	$total_start_p=$total_end_p-$per_page;
	$pPrev=$chk_page-1;
	$pPrev=($pPrev>=0)?$pPrev:0;
	$pNext=$chk_page+1;
	$pNext=($pNext>=$total_p)?$total_p-1:$pNext;		
	$lt_page=$total_p-4;
	if($chk_page>0){  
		echo "<a  href='$urlfile&s_page=$pPrev".$querystr."' class='naviPN'>Prev</a>";
	}
	for($i=$total_start_p;$i<$total_end_p;$i++){  
		$nClass=($chk_page==$i)?"class='selectPage'":"";
		if($e_page*$i<=$total){
		echo "<a href='$urlfile&s_page=$i".$querystr."' $nClass  >".intval($i+1)."</a> ";   
		}
	}		
	if($chk_page<$total_p-1){
		echo "<a href='$urlfile&s_page=$pNext".$querystr."'  class='naviPN'>Next</a>";
	}
}  
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
where ssc.approve='Y' and ssc.start_date between '$this_year-10-01' and '$next_year-09-30'
order by ssc.car_id desc";
    $qr=mysqli_query($db,$q);
if($qr==''){exit();}
$total=mysqli_num_rows($qr);
 
$e_page=10; // กำหนด จำนวนรายการที่แสดงในแต่ละหน้า   
if(!isset($_GET['s_page'])){   
	$_GET['s_page']=0;   
}else{   
	$chk_page=$_GET['s_page'];     
	$_GET['s_page']=$_GET['s_page']*$e_page;   
}   
$q.=" LIMIT ".$_GET['s_page'].",$e_page";
$qr=mysqli_query($db,$q);
if(mysqli_num_rows($qr)>=1){   
	$plus_p=($chk_page*$e_page)+mysqli_num_rows($qr);   
}else{   
	$plus_p=($chk_page*$e_page);       
}   
$total_p=ceil($total/$e_page);   
$before_p=($chk_page*$e_page)+1;  
echo mysqli_error($db);
                ?>
                <div class="table-responsive">
                    <?php include_once ('option/funcDateThai.php'); ?>
                    <table align="center" width="100%" class="table-responsive table-bordered table-hover">
                        <thead>
                    <tr align="center" bgcolor="#898888">
                        <td width="3%" align="center"><b>ลำดับ</b></td>
                        <td width="8%" align="center"><b>เลขใบคำขอ</b></td>
                        <td width="15%" align="center"><b>ผู้ขอ</b></td>
                        <td width="19%" align="center"><b>สถานที่ที่ไป</b></td>
                        <td width="13%" align="center"><b>จากวันที่</b></td>
                        <td width="9%" align="center"><b>เวลา</b></td>
                        <td width="6%" align="center"><b>จำนวนผู้ร่วมทาง</b></td>
                        <td width="6%" align="center"><b>ระยะทาง (ก.ม.)</b></td>
                        <td width="4%" align="center"><b>สถานะ</b></td>
                        <?php if($_SESSION['ss_status']=='ADMIN' or $_SESSION['ss_status']=='SUSER'){?>
                        <td width="6%" align="center"><b>เพิ่มระยะทาง</b></td>
                        <td width="4%" align="center"><b>ยกเลิก</b></td>
                        <td width="4%" align="center"><b>แก้ไข</b></td>
                        <?php }?>
                    </tr>
                        </thead>
                        <tbody>
                    <?php
                    $i = 1;
                    while ($result = mysqli_fetch_assoc($qr)) {
                        ?>
                        <tr>
                            <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                            <td align="center"><a href="#" onclick="return popup('car/confirm_car.php?id=<?= $result['car_id']; ?>',popup,490,550);"><?= $result['car_no']; ?></a>
                            </td>
                            <td align="center"><a href="#" onclick="return popup('car/confirm_car.php?id=<?= $result['car_id']; ?>',popup,490,550);"><?= $result['fullname']; ?></a>
                            </td>
                            <td align="center"><a href="#" onclick="return popup('car/confirm_car.php?id=<?= $result['car_id']; ?>',popup,490,550);">
                            <?=$result['place']."&nbsp;จ.".$result['province']."&nbsp;อ.".$result['amphur'];?> </td></a></td>
                            <td align="center"><?= DateThai1($result['start_date']);?> <b>ถึง</b> <?= DateThai1($result['end_date']);?></td>
                            <td align="center"><?= $result['start_time']; ?> <b>ถึง</b> <?= $result['end_time']; ?></td>
                            <td align="center"><?= $result['amount']; ?></td>
                            <td align="center"><?= $result['distance']; ?></td>
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
                            <?php if($_SESSION['ss_status']=='ADMIN' or $_SESSION['ss_status']=='SUSER'){?>
                            <td align="center"><?php if(is_null($result['befor_mile'])){?>
                                <a href="#" onclick="return popup('car/confirm_car.php?id=<?= $result['car_id'];?>&method=mile_car',popup,550,650);"><img src='images/Gauge.ico' width='30'></a>
                            <?php }else{ ?>
                                <a href="#" onclick="return popup('car/confirm_car.php?id=<?= $result['car_id'];?>&method=edit_mile_car',popup,550,650);"><img src='images/Symbol_-_Check.ico' width='30'></a>
                            <?php }?>
                            </td>
                            <td align="center"><a href="#" onclick="return popup('car/confirm_car.php?id=<?= $result['car_id'];?>&method=cancle_car',popup,550,550);"><img src='images/file_delete.ico' width='30'></a></td>
                            <td align="center"><a href="index.php?page=car/request_car&method=edit&id=<?=$result['car_id'];?>"><img src='images/file_edit.ico' width='30'></a></td>
                            <?php }?>
                            
                        </tr>
                    <?php $i++;
                }
                ?>
                        </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if($total>0){
echo mysqli_error($db);

?>
<div class="browse_page">
 
 <?php   
 // เรียกใช้งานฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
  page_navigator($before_p,$plus_p,$total,$total_p,$chk_page);    

  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size='2'>มีจำนวนทั้งหมด  <B>$total รายการ</B> จำนวนหน้าทั้งหมด ";
  echo  $count=ceil($total/10)."&nbsp;<B>หน้า</B></font>" ;
}
  ?> 
 </div> 

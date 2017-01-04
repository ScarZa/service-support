<?php  include 'connection/connect.php'; ?>
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
                <form method="post" action="" enctype="multipart/form-data" class="navbar-form navbar-right">
                    <div class="form-group">
                <select name="month_id" id="month"  class="form-control"> 
				<?php	$sql = mysqli_query($db,"SELECT month_id, month_name FROM month order by m_id");
				 echo "<option value=''>--เลือกเดือน--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
  				 echo "<option value='".$result['month_id']."' $selected>".$result['month_name']." </option>";
				 } ?>
			 </select>
            </div> 
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

               
                
               
// สร้างฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
function page_navigator($before_p,$plus_p,$total,$total_p,$chk_page){   
	global $e_page;
	global $querystr;
        $year = $_REQUEST['year'];
        $take_month=$_REQUEST['month_id'];
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
		echo "<a  href='$urlfile&year=$year&month_id=$take_month&s_page=$pPrev".$querystr."' class='naviPN'>Prev</a>";
	}
	for($i=$total_start_p;$i<$total_end_p;$i++){  
		$nClass=($chk_page==$i)?"class='selectPage'":"";
		if($e_page*$i<=$total){
		echo "<a href='$urlfile&year=$year&month_id=$take_month&s_page=$i".$querystr."' $nClass  >".intval($i+1)."</a> ";   
		}
	}		
	if($chk_page<$total_p-1){
		echo "<a href='$urlfile&year=$year&month_id=$take_month&s_page=$pNext".$querystr."'  class='naviPN'>Next</a>";
	}
}       

    if (!empty($_REQUEST['year'])) {
                $year = $_REQUEST['year'] - 543;}
                include 'option/function_date.php';
               if (!empty($_REQUEST['year']) or !empty($_GET['year'])) {
                    //$year = $_REQUEST['year'] - 543;
                    $years = $year + 543;
                    $sql_month = mysqli_query($db,"SELECT month_name FROM month where month_id='".$_REQUEST['month_id']."'");
                    $month = mysqli_fetch_assoc( $sql_month );
                    
                    if($date >= $bdate and $date <= $edate){
                $take_month=$_REQUEST['month_id'];                      
               
                             if($take_month=='1' or $take_month=='2' or $take_month=='3' or $take_month=='4' or $take_month=='5' or $take_month=='6' or $take_month=='7' or $take_month=='8' or $take_month=='9'){
                            $take_month1="$y-$take_month-01";
                             if($take_month=='4' or $take_month=='6' or $take_month=='9'){
                            $take_month2="$y-$take_month-30";  
                             }elseif ($take_month=='2') {
                            $take_month2="$y-$take_month-29"; 
                            }else{
                             $take_month2="$y-$take_month-31";
                            }
                             $take_date1="$Y-10-01";
                             $take_date2="$y-09-30"; 
                }elseif($take_month=='10' or $take_month=='11' or $take_month=='12') {
                    $take_month1="$Y-$take_month-01";
                    if($take_month=='11'){
                        $take_month2="$Y-$take_month-30"; 
                    }else{
                        $take_month2="$Y-$take_month-31";
                            }
                            $take_date1="$Y-10-01";
                            $take_date2="$y-09-30";
                }
    }  else {
                $take_month=$_REQUEST['month_id'];
                if($take_month=='1' or $take_month=='2' or $take_month=='3' or $take_month=='4' or $take_month=='5' or $take_month=='6' or $take_month=='7' or $take_month=='8' or $take_month=='9'){
                 $this_year=$y;
                 $ago_year=$Y;
                  $take_month1="$this_year-$take_month-01";
                   if($take_month=='4' or $take_month=='6' or $take_month=='9'){
                               $take_month2="$this_year-$take_month-30";  
                             }elseif ($take_month=='2') {
                               $take_month2="$this_year-$take_month-29"; 
                            }else{
                             $take_month2="$this_year-$take_month-31";
                            }
                             $take_date1="$ago_year-10-01";
                             $take_date2="$this_year-09-30";
                }  elseif($take_month=='10' or $take_month=='11' or $take_month=='12') {
                 $this_year=$y;
                 $ago_year=$Y;
                 $next_year=$Yy;
                  $take_month1="$ago_year-$take_month-01";
                   if($take_month=='11'){
                               $take_month2="$ago_year-$take_month-30";  
                             }else{
                             $take_month2="$ago_year-$take_month-31";
                            }
                             $take_date1="$ago_year-10-01";
                             $take_date2="$this_year-09-30";
                }  else {
                 $this_year=$y;
                 $ago_year=$Y;   
                }
                                }  
                $code_where="'$take_month1' and '$take_month2'";                
                }else{
                                    if($date >= $bdate and $date <= $edate){
    $this_year=$y;
    $next_year=$Yy;
}  else {
    $this_year=$Y;
    $next_year=$y;
                                }
             $code_where="'$this_year-10-01' and '$next_year-09-30'";                   
}
    $q="SELECT ssc . * , CONCAT( p1.pname, e1.firstname,  ' ', e1.lastname ) AS fullname, d1.depName AS dep, e1.empno AS empno,
                                 am.AMPHUR_NAME as amphur, pv.PROVINCE_NAME as province, ssc.passenger
FROM ss_car ssc
INNER JOIN emppersonal e1 ON e1.empno = ssc.empno_request
INNER JOIN pcode p1 ON e1.pcode = p1.pcode
INNER JOIN department d1 ON e1.depid = d1.depId
INNER JOIN amphur am on am.AMPHUR_ID=ssc.amphur
INNER JOIN province pv on pv.PROVINCE_ID=ssc.province
where ssc.approve='Y' and ssc.start_date between $code_where
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
                          <?php  if (!empty($_REQUEST['year'])) {?>
                    <tr align="center">
                        <td colspan="14"><b>ปีงบประมาณ <?= $years?>  ประจำเดือน <?= $month['month_name']?></b></td>
                          </tr><?php }?>
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

<?php include 'connection/connect.php'; 
if(!empty($_GET['method'])){
    if($_GET['method']=='del'){
        $do_id=$_GET['id'];
        $del_oil=mysqli_query($db,"delete from ss_detial_oil where do_id=$do_id");
        
    }
}
?>
<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'>  รายการเติมน้ำมัน </font></h1> 
        <ol class="breadcrumb alert-warning">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> รายการเติมน้ำมัน</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title"><font color='brown'>ตารางรายการเติมน้ำมัน</font></h3>
            </div>
            <div class="panel-body">
                <div class="col-lg-12">
                <form class="navbar-form navbar-right" role="form" action='#' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()">
                    <b>หมายเลขทะเบียน</b>
                    <div class="form-group">
                    
                <select name="license_plate" id="license_plate"  class="form-control" onkeydown="return nextbox(event, 'dep');"> 
				<?php	$sql = mysqli_query($db,"SELECT *  FROM ss_carlicense");
				 echo "<option value=''>--เลือกรถยนต์--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
				 echo "<option value='".$result['license_id']."' $selected>".$result['license_name'] ."</option>";
				 } ?>
                </select></div>
        <input class="btn btn-success" type="submit" name="submit" value="ตกลง">
                </form></div><br><br>
                <?php
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
$license_plate=$_REQUEST['license_plate'];
    $q="SELECT * FROM ss_detial_oil WHERE license_id=$license_plate and reg_date between '$this_year-10-01' and '$next_year-09-30'
order by reg_date desc";
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

            $sel_lp=  mysqli_query($db, "select license_name from ss_carlicense where license_id='$license_plate'");
            $lp=   mysqli_fetch_assoc($sel_lp);
                ?>
                <div class="col-lg-12" align='center'><b>รถยนต์หมายเลขทะเบียน <?= $lp['license_name'];?></b></div>
                <div class="table-responsive">
                    <?php include_once ('option/funcDateThai.php'); ?>
                    <table align="center" width="100%" class="table table-responsive table-bordered table-hover">
                        <thead>
                    <tr align="center" bgcolor="#898888">
                        <td width="3%" align="center"><b>ลำดับ</b></td>
                        <td width="10%" align="center"><b>วันที่เติม</b></td>
                        <td width="15%" align="center"><b>เลขไมล์ก่อนเติม</b></td>
                        <td width="15%" align="center"><b>เลขไมล์หลังเติม</b></td>
                        <td width="10%" align="center"><b>จำนวนไมล์</b></td>
                        <td width="10%" align="center"><b>จำนวนลิตร</b></td>
                        <td width="10%" align="center"><b>จำนวนเงิน</b></td>
                        <?php if($_SESSION['ss_status']=='ADMIN' or $_SESSION['ss_status']=='SUSER'){?>
                        <td width="7%" align="center"><b>แก้ไข</b></td>
                        <td width="7%" align="center"><b>ลบ</b></td>
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
                            <td align="center"><?= DateThai1($result['reg_date']);?></td>
                            <td align="center"><?= $result['pass_mile']; ?></td>
                            <td align="center"><?= $result['this_mile']; ?></td>
                            <td align="center"><?= $result['this_mile']-$result['pass_mile']; ?></td>
                            <td align="center"><?= $result['liter']; ?></td>
                            <td align="center"><?= $result['bath']; ?></td>
                            <?php if($_SESSION['ss_status']=='ADMIN' or $_SESSION['ss_status']=='SUSER'){?>
                            <td align="center"><a href="#" onclick="return popup('car/record_oil.php?id=<?= $result['do_id'];?>&edit_oil=true',popup,550,550);"><img src='images/file_edit.ico' width='30'></a></td>
                            <td align="center"><a href="?page=car/listoil&license_plate=<?= $license_plate?>&method=del&id=<?=$result['do_id'];?>"
                                                  onclick="if(confirm('ยืนยันการลบวันที่ <?= DateThai1($result['reg_date'])?>&nbsp;ออกจากรายการ ')) return true; else return false;">
                                    <img src='images/file_delete.ico' width='30'></a></td>
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

   
<!-- ค้นหา -->
  <form class="navbar-form navbar-left" role="search" action='index.php?page=car/add_car' method='post'  >
       <div class="form-group">
		<input type='text' name='Search_license' placeholder='ทะเบียน'  value='' class="form-control"  > 
		</div>
      <input type='hidden' name='method'  value='search_name'> 
		<button  class="btn btn-warning" ><i class="fa fa-search"></i>  ค้นหา</button >
  </form>
 		 
						<!--   <H1>หมายเหตุ รายการที่มีเครื่องหมายดอกจันทร์  (***) จำเป็นต้องระบุให้ครบ</H1> -->
 						

<!------------------------------------------------------------------>

<?php   
// สร้างฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
function page_navigator($before_p,$plus_p,$total,$total_p,$chk_page){   
	global $e_page;
	global $querystr;
	$urlfile="index.php?page=car/add_car"; // ส่วนของไฟล์เรียกใช้งาน ด้วย ajax (ajax_dat.php)
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
 if($_POST['method']=='search_name'){
     $_SESSION['Search_license']=$_POST['Search_license'];
 }

 $Search_license=trim($_SESSION['Search_license']);
 if($Search_license!=''){
     $code01="Where sscl.license_name like '%$Search_license%'";
     }else{
 $code01="order by sscl.license_id";
  }
  echo "แสดงคำที่ค้นหา : ".$Search_license;
//คำสั่งค้นหา
     $q="SELECT CONCAT( e1.firstname,  ' ', e1.lastname ) AS fullname, ct.cartype_name AS cartype_name, ot.oil_name AS oil_name, sscl . * 
FROM ss_carlicense sscl
LEFT OUTER JOIN emppersonal e1 ON sscl.rider = e1.empno
LEFT OUTER JOIN ss_car_type ct ON ct.cartype_id = sscl.cartype_id
LEFT OUTER JOIN ss_oil_type ot ON ot.oil_id = sscl.oil_type
$code01 "; 
 
	
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
 </head>
<body>
  

<table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" class="divider" rules="rows" frame="below">  
 <TR bgcolor='#898888'>
					<th width='5%'><CENTER>ลำดับ</CENTER></th>
                                        <th width='9%'><CENTER>ทะเบียนรถยนต์</CENTER></th>
					<th width='8%'><CENTER>ประเภท</CENTER></th>
					<th width='15%'><CENTER>ผู้รับผิดชอบ</CENTER></th>
					<th width='8%'><CENTER>ชนิดน้ำมัน</CENTER></th>
                                        <th width='10%'><CENTER>วันที่รับรถ</CENTER></th>
                                        <th width='10%'><CENTER>สถานะรถยนต์</CENTER></th>
					<th width='12%'><CENTER>แก้ไข | ลบ</CENTER></th>
 </TR>
<?php 
include 'option/funcDateThai.php'; 
$i=1;
while($result=mysqli_fetch_assoc($qr)){
/*	if($bg == "#F9F9F9") { //ส่วนของการ สลับสี 
		$bg = "#FFFFFF";
		}else{
		$bg = "#F9F9F9";
		}
*/
	if($bg == "#F4F4F4") { //ส่วนของการ สลับสี 
		$bg = "#FFFFFF";
		}else{
		$bg = "#F4F4F4";
		}

?>  
 					<tr >	    
                                        <TD height="20" align="center" ><?=($chk_page*$e_page)+$i?></TD>
					<TD><?=$result['license_name']; ?></TD>
                                        <TD align="center"><?=$result['cartype_name']; ?></TD>
					<TD><?=$result['fullname']; ?></TD>
                                        <TD align="center"><?=$result['oil_name']; ?></TD>
                                        <TD align="center"><?php if(!is_null($result['recive_date'])){ echo DateThai1($result['recive_date']);} ?></TD>
					<TD align="center"><?php if($result['car_status']=='1'){echo 'ใช้งาน'; }
                                        elseif($result['car_status']=='2'){echo 'ซ่อมบำรุง'; } elseif($result['car_status']=='3'){echo 'จำหน่าย';}
                                        //else{echo 'หัวหน้าฝ่าย';}?></TD>
 					<TD><CENTER>
				    <a href='index.php?page=car/add_car&method=update&car_id=<?=$result['license_id']?>' ><i class="fa fa-edit"></i></a> 
				    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					
					<a href='index.php?page=car/add_car&method=delete&car_id=<?=$result['license_id']?>'  title="confirm" onclick="if(confirm('ยืนยันการลบ <?= $result['license_name']?>&nbsp;ออกจากรายการ ')) return true; else return false;">   
					<i class="fa fa-trash-o"></i></a>
                                        </center>
</td>
					</tr> 
 
  			 
 		 <?php $i++; } ?>
 		 
</table>

<?php if($total>0){
echo mysqli_error($db);

?><BR>
<div class="browse_page">
 
 <?php   
 // เรียกใช้งานฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
  page_navigator($before_p,$plus_p,$total,$total_p,$chk_page);    

  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size='2'>มีจำนวนทั้งหมด  <B>$total รายการ</B> จำนวนหน้าทั้งหมด ";
  echo  $count=ceil($total/10)."&nbsp;<B>หน้า</B></font>" ;
}
  ?> 
 </div> 

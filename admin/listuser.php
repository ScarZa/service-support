   
<!-- ค้นหา -->
  <form class="navbar-form navbar-left" role="search" action='index.php?page=admin/add_User' method='post'  >
       <div class="form-group">
		<input type='text' name='Search_fname' placeholder='ชื่อ'  value='' class="form-control"  > 
		</div>
		<div class="form-group">
		<input type='text' name='Search_lname' placeholder='นามสกุล'  value='' class="form-control"  > 
		<input type='hidden' name='method'  value='search_name'> 
		 </div>
		<button  class="btn btn-warning" ><i class="fa fa-search"></i>  ค้นหา</button >
  </form>
 		 
						<!--   <H1>หมายเหตุ รายการที่มีเครื่องหมายดอกจันทร์  (***) จำเป็นต้องระบุให้ครบ</H1> -->
 						

<!------------------------------------------------------------------>

<?php   
// สร้างฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
function page_navigator($before_p,$plus_p,$total,$total_p,$chk_page){   
	global $e_page;
	global $querystr;
	$urlfile="index.php?page=admin/add_User"; // ส่วนของไฟล์เรียกใช้งาน ด้วย ajax (ajax_dat.php)
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
     $_SESSION['Search_fname']=$_POST['Search_fname'];
     $_SESSION['Search_lname']=$_POST['Search_lname'];        
 }

 $Search_fname=trim($_SESSION['Search_fname']);
 $Search_lname=($_SESSION['Search_lname']);
 if($Search_fname!='' || $Search_lname){
     $code01="Where e1.firstname like '%$Search_fname%' and  e1.lastname like '%$Search_lname%'";
     }else{
 $code01="order by fullname";
  }
  echo "แสดงคำที่ค้นหา : ".$Search_fname.' '.$Search_lname;
//คำสั่งค้นหา
     $q="SELECT CONCAT(e1.firstname,' ',e1.lastname) AS fullname,d1.dep_name AS Mdep,d2.depName AS dep,
ssm.ss_Status AS status, ssm.ss_user_name,e1.empno as empno, ssm.ss_UserID as ID , ssm.ss_process
FROM ss_member ssm
INNER JOIN emppersonal e1 ON ssm.ss_Name=e1.empno
INNER JOIN department d2 ON d2.depId=e1.depid
INNER JOIN department_group d1 ON d1.main_dep=d2.main_dep 
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
					<th width='5%'><CENTER><p>ลำดับ</p></CENTER></th>
					<th width='15%'><CENTER>ชื่อ - นามสกุล</CENTER></th>
					<th width='15%'><CENTER>ฝ่าย</CENTER></th>
					<th width='15%'><CENTER>ศูนย์/กลุ่มงาน</CENTER></th>
					<th width='15%'><CENTER>ระดับการใช้งาน</CENTER></th>
                                        <th width='15%'><CENTER>ระดับการดูแลระบบ</CENTER></th>
					<th width='8%'><CENTER>ชื่อที่ใช้งาน</CENTER></th>
					<th width='12%'><CENTER>แก้ไข | ลบ</CENTER></th>
 </TR>
<?php 
 
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
					<TD><?=$result['fullname']; ?></TD>
                                        <TD align="center"><?=$result['Mdep']; ?></TD>
					<TD align="center"><?=$result['dep']; ?></TD>
					<TD align="center"><?php if($result['status']=='ADMIN'){echo 'ผู้ดูแลระบบ'; }
                                        elseif($result['status']=='SUSER' or $result['status']=='NUSER'){echo 'ผู้ดูแลระบบย่อย';}
                                        //else{echo 'หัวหน้าฝ่าย';}?></TD>
                                        <TD align="center"><?php if($result['ss_process']=='0'){echo 'ผู้ดูแลระบบทั้งหมด'; }
                                        elseif($result['ss_process']=='2'){echo 'ผู้ดูแลระบบห้องประชุม';}
                                        elseif($result['ss_process']=='3'){echo 'ผู้ดูแลระบบรถยนต์';}
                                        elseif($result['ss_process']=='4'){echo 'ผู้ดูแลระบบข้อมูลพยาบาล';}?>
                                        </TD>
					<TD align="center"><?=$result['ss_user_name']; ?></TD>
 					<TD><CENTER>
				    <a href='index.php?page=admin/add_User&method=update&ss_id=<?=$result['empno']?>&status=<?=$result['status']?>&ID=<?= $result['ID']?>' ><i class="fa fa-edit"></i></a> 
				    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					
					<a href='index.php?page=process/prcuser&method=delete&ss_id=<?=$result['empno']?>&ID=<?= $result['ID']?>'  title="confirm" onclick="if(confirm('ยืนยันการลบ <?= $result['fullname']?>&nbsp;ออกจากรายการ ')) return true; else return false;">   
					<i class="fa fa-trash-o"></i></a>
					</tr> 
 
  			 
 		 <?php $i++; } ?>
 		 
</CENTER>
</table>

<?php if($total>0){
echo mysqli_error($db);

?><BR><BR>
<div class="browse_page">
 
 <?php   
 // เรียกใช้งานฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
  page_navigator($before_p,$plus_p,$total,$total_p,$chk_page);    

  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size='2'>มีจำนวนทั้งหมด  <B>$total รายการ</B> จำนวนหน้าทั้งหมด ";
  echo  $count=ceil($total/10)."&nbsp;<B>หน้า</B></font>" ;
}
  ?> 
 </div> 

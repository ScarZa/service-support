<?php require'../connection/connect.php'; ?>
<?php $result=$_GET['result'];
$select_id=$_GET['select_id'];
if ($result == 'process') {  		
				echo "<option value=''>เลือกระบบ</option>";
                                if($select_id=='ADMIN'){
                                  if( $resultGet['ss_process']=="0"){$Ok='selected';}
                                  echo "<option value='0'  $Ok>ผู้ดูแลระบบทั้งหมด</option>";
                                }elseif ($select_id=='SUSER') {
                                if( $resultGet['ss_process']=="2"){$Ok2='selected';}
				if($resultGet['ss_process']=="3"){$Selected='selected';}
				echo "<option value='3'  $Selected>ผู้ดูแลระบบขอรถยนต์</option>";	
				echo "<option value='2'  $Ok2>ผู้ดูแลระบบขอห้องประชุม</option>";
                                }  } ?>


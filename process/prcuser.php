<?php include 'connection/connect.php';
      $empno=$_POST['name'];	 	  	 
      $admin=$_POST['admin'];
      $process=$_POST['process'];
      $user_account=md5(trim($_POST['user_account']));
      $username=$_POST['user_account'];
      $user_pwd= md5(trim($_POST['user_pwd']));
 	 

 	  
	if($_POST['method']=='update'){
        $ID=$_POST['ID'];    
	$user_idPOST=$_POST['ss_id'];
 
		if($_POST['user_pwd']!=''){
 		$sqlUpdate=mysqli_query($db,"update ss_member set ss_Name='$empno' ,  
 		ss_Status='$admin', ss_Username='$user_account' , ss_Password='$user_pwd',ss_user_name='$username' ,ss_process='$process' 
		where ss_Name='$user_idPOST' and ss_UserID='$ID' "); 
		}else{ 
		$sqlUpdate=mysqli_query($db,"update ss_member set ss_Name='$empno' ,ss_user_name='$username',  
 		ss_Status='$admin', ss_Username='$user_account' ,ss_process='$process'   
		where ss_Name='$user_idPOST' and ss_UserID='$ID' "); 	
		}
	
 							if($sqlUpdate==false){
											 echo "<p>";
											 echo "Update not complete ".mysql_error();
											 echo "<br />";
											 echo "<br />";

											 echo "	<span class='glyphicon glyphicon-remove'></span>";
											 echo "<a href='index.php?page=admin/add_User' >กลับ</a>";
		
								}else{
								    echo	 "<p>&nbsp;</p>	";
								    echo	 "<p>&nbsp;</p>	";
									echo " <div class='bs-example'>
									              <div class='progress progress-striped active'>
									                <div class='progress-bar' style='width: 100%'></div>
									              </div>";
									echo "<div class='alert alert-info alert-dismissable'>
								              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
								               <a class='alert-link' target='_blank' href='#'><center>แก้ไขข้อมูลผู้ใช้งานเรียบร้อย</center></a> 
								            </div>";					
							 		 	 echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php?page=admin/add_User'>";
								}
   
   }//-----------------------------------------end update
   else if($_REQUEST['method']=='delete'){
       $ID=$_REQUEST['ID'];
       $user_idGet=$_REQUEST['ss_id'];	 	  
		$sqlDelete=mysqli_query($db,"delete from ss_member  
		where ss_Name='$user_idGet' and ss_UserID='$ID' "); 
				
 							if($sqlDelete==false){
											 echo "<p>";
											 echo "Delete not complete".mysqli_error($db);
											 echo "<br />";
											 echo "<br />";

											 echo "	<span class='glyphicon glyphicon-remove'></span>";
											 echo "<a href='index.php?page=admin/add_User' >กลับ</a>";
		
								}else{
								    echo	 "<p>&nbsp;</p>	";
								    echo	 "<p>&nbsp;</p>	";
									echo " <div class='bs-example'>
									              <div class='progress progress-striped active'>
									                <div class='progress-bar' style='width: 100%'></div>
									              </div>";
									echo "<div class='alert alert-info alert-dismissable'>
								              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
								               <a class='alert-link' target='_blank' href='#'><center>ลบผู้ใช้งานเรียบร้อย</center></a> 
								            </div>";								
							 		 	echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php?page=admin/add_User'>";
								}
 				 
   }//-----------------------------------------end delete
   else{
 	 	$sqlInsert=mysqli_query($db,"insert into ss_member  SET    ss_Name='$empno' ,  
 		ss_Status='$admin', ss_Username='$user_account' , ss_Password='$user_pwd',ss_user_name='$username',ss_process='$process'  "); 

	
 							if($sqlInsert==false){
											 echo "<p>";
											 echo "Insert not complete".mysqli_error($db);
											 echo "<br />";
											 echo "<br />";

											 echo "	<span class='glyphicon glyphicon-remove'></span>";
											 echo "<a href='index.php?page=admin/add_User' >กลับ</a>";
		
								}else{
								    echo	 "<p>&nbsp;</p>	";
								    echo	 "<p>&nbsp;</p>	";
									echo " <div class='bs-example'>
									              <div class='progress progress-striped active'>
									                <div class='progress-bar' style='width: 100%'></div>
									              </div>";
										echo "<div class='alert alert-info alert-dismissable'>
								              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
								               <a class='alert-link' target='_blank' href='#'><center>เพิ่มผู้ใช้งานเรียบร้อย</center></a> 
								            </div>";								
							 		 	 echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php?page=admin/add_User'>";
								}  	
   }
?>		
  <?php $db->close();?>
 
	
	
 
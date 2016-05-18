<?php session_start(); ?>
 <script type="text/javascript">
function nextbox(e, id) {
    var keycode = e.which || e.keyCode;
    if (keycode == 13) {
        document.getElementById(id).focus();
        return false;
    }
}
</script>
  <script language="javascript">
function fncSubmit()
	{
	 if(document.form1.user_pwd.value != document.form1.user_pwd2.value)
		{
			alert('การยืนยันรหัสผ่านไม่ตรงกัน กรุณาตรวจสอบ');
			document.form1.user_pwd.focus();		
			return false;
		}else{	
			return true;
			document.form1.submit();
		}
}
</script>
<section class="content-header">
 <div class="row">
          <div class="col-lg-12">
              <h1> <font color="blue">ตั้งค่าผู้ใช้งาน</font></h1>
            <ol class="breadcrumb alert-warning">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-gear"></i> ตั้งค่าผู้ใช้งาน</li>
            </ol>
          </div>
        </div><!-- /.row -->
</section>
			<?php include 'connection/connect.php';
			 if($_GET['ss_id']!=''){ 
			 $user_idGet=$_GET['ss_id'];
                          if($_REQUEST['method']=='update'){
                             $status= $_GET['status'];
                         }else{
                         $status=$_SESSION['ss_status'];}
			 $sqlGet=mysqli_query($db,"select ssm.*,concat(e.firstname,' ',e.lastname) as fullname from  ss_member ssm
                             inner join emppersonal e on e.empno=ssm.ss_Name where ssm.ss_Name='$user_idGet' and ssm.ss_Status='$status' ");
			 $resultGet=mysqli_fetch_assoc($sqlGet);
			 }
			   ?> 
<section class="content">
<div class="row">
          <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">เพิ่มผู้ใช้งานระบบ</h3>
                    </div>
                <div class="panel-body">		
                    <form name='form1' class="navbar-form navbar-left"  action='index.php?page=process/prcuser' method='post' enctype="multipart/form-data" OnSubmit="return fncSubmit();">
                        <b>ชื่อ-นามสกุล </b><br>
                        <div class="form-group">	
                        <?php if($_SESSION['ss_status']=='SUSER'){?>
                            <input type="text" name='names'   id='names' class='form-control' value='<?=$resultGet['fullname']?>'  onkeydown="return nextbox(event, 'save');" readonly >
                            <input type="hidden" name="name" id="name" value="<?=$resultGet['ss_Name']?>">
                            <?php }else{?>
                         	<select name="name" id="name" required  class="form-control"  onkeydown="return nextbox(event, 'fname');"> 
				<?php	$sql = mysqli_query($db,"SELECT empno,concat(firstname,' ',lastname) as fullname  FROM emppersonal order by empno ");
				 echo "<option value=''>เลือกบุคลากร</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['empno']==$resultGet['ss_Name']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['empno']."' $selected>".$result['fullname']." </option>";
				 } ?>
			 </select>
                            <?php }?>
			 </div> 
                        <br>
                        <div class="form-group">
                            <?php include 'admin/right.php';?>
                        </div><br>
		    <!--<div class="form-group">
                        <label>ระดับการใช้งาน</label>
			<?php /* if($_SESSION['ss_status']=='ADMIN'){?>
                                <select name='admin' id='admin'class='form-control'  onkeydown="return nextbox(event, 'user_account');"  required >
			<?php 		
				echo "<option value=''>เลือกระดับการใช้งาน</option>";			
		 		if( $resultGet['ss_Status']=="ADMIN"){$ok='selected';}
				if( $resultGet['ss_Status']=="A"){$ok2='selected';}
				if($resultGet['ss_Status']=="SUSER"){$selected='selected';}
				echo "<option value='SUSER'  $selected>ผู้ระบบย่อย</option>";	
				//echo "<option value='A'  $ok2 >หัวหน้าฝ่าย</option>";	
				echo "<option value='ADMIN'  $ok >ผู้ดูแลระบบ</option>";						
				?>
			</select>
                         <?php }else{?>
                                <input type="text" name='admin'   id='admin' class='form-control'  value='<?= 'ผู้ดูแลระบบย่อย'?>'  onkeydown="return nextbox(event, 'save');" readonly >
                         <?php }?>
                                </div>
                        <div class="form-group">
                            <label>ระดับการดูแลระบบ</label>
			<?php if($_SESSION['ss_status']=='ADMIN'){ ?>
                                <select name='process' id='process'class='form-control'  onkeydown="return nextbox(event, 'user_account');"  required >
			<?php 		
				echo "<option value=''>เลือกระบบย่อย</option>";			
		 		if( $resultGet['ss_process']=="0"){$Ok='selected';}
				if( $resultGet['ss_process']=="2"){$Ok2='selected';}
				if($resultGet['ss_process']=="3"){$Selected='selected';}
				echo "<option value='3'  $Selected>ผู้ดูแลระบบขอรถยนต์</option>";	
				echo "<option value='2'  $Ok2>ผู้ดูแลระบบขอห้องประชุม</option>";	
				echo "<option value='0'  $Ok>ผู้ดูแลระบบทั้งหมด</option>";						
				?>
			</select>
                         <?php }else{
                             if($resultGet['ss_process']=='0'){
                                 $process='ผู้ดูแลระบบทั้งหมด';
                             }elseif ($resultGet['ss_process']=='2') {
                                 $process='ผู้ดูแลระบบขอห้องประชุม';   
                                }elseif ($resultGet['ss_process']=='3'){
                                  $process='ผู้ดูแลระบบขอรถยนต์';  
                                }
?>
                                <input type="text" name='process'   id='process' class='form-control'  value='<?= $process?>'  onkeydown="return nextbox(event, 'save');" readonly >
                         <?php }*/?>
                        </div><br>-->
                        <?php if($_SESSION['ss_status']=='ADMIN'){
                            $read='';
                        }else{
                            $read='readonly';
                        }
?>
			<div class="form-group">	
			<b>ชื่อผู้ใช้งาน</b>
			<input type='text' name='user_account'  size="4"  id='user_account' placeholder='ชื่อผู้ใช้งาน' class='form-control'  onkeydown="return nextbox(event, 'user_pwd');"   value='<?php echo $resultGet['ss_user_name'];?>' required <?= $read?>>
			 </div> 
                        <br>
			<?PHP 
			if($_GET['ss_id']==''){
			 	$required='required';			
			}else{
				$required='';
			}
			?> 
			<div class="form-group">
			<b>รหัสผ่าน</b>
			<input type="password" name='user_pwd'  size="6"  id='user_pwd' placeholder='รหัสผ่าน' class='form-control'  value=''  onkeydown="return nextbox(event, 'user_pwd2');" <?= $required?>>
			 </div><br>
	 		<div class="form-group">
			<label>ยืนยันรหัสผ่าน</label>
			<input type="password" name='user_pwd2' size="1" id='user_pwd2' placeholder='ยืนยันรหัสผ่าน' class='form-control'  value=''  onkeydown="return nextbox(event, 'save');" <?= $required?>>
			 </div><br>
			 <font color="red"><?php 	if($_GET['ss_id']!=''){echo "*หากไม่เปลี่ยนรหัสผ่านไม่ต้องแก้ไข";}?></font>
 <br>
 <?PHP 
	if($_GET['ss_id']!=''){
		$get=$_GET['ss_id'];
                $Get_id=$_GET['ID'];
                echo "<input type='hidden' name='ID' value='$Get_id'>";
		echo "<input type='hidden' name='ss_id' value='$get'>";
		echo "<input type='hidden' name='method' value='update'>";
                ?>
        <p><button  class="btn btn-warning" id='save'> แก้ไข </button > <input type='reset' class="btn btn-danger"   > </p>
	<?php }  else {?>
         <p><button  class="btn btn-success" id='save'> บันทึก </button > <input type='reset' class="btn btn-danger"   > </p>
              <?php } ?>
		</form>

      </div>
    </div>
              </div>
    </div>
         <?php if($_SESSION['ss_status']=='ADMIN'){?>
        	  <div class="row">
          <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">ผู้ใช้งานระบบ</h3>
                    </div>
                  <div class="panel-body">
                    
<?php include 'listuser.php';?> 
      <!--  row of columns -->
 </div>
       </div></div></div>   
         <?php }?>
</section>

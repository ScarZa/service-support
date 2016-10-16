<?php session_start(); ?>
<?php
if($_POST['method'] == 'request_room' or $_POST['method'] == 'edit_room'){
        include'option/jquery.php'; 
        include 'connection/connect.php';
}else{
        include'../option/jquery.php'; 
        include '../connection/connect.php';?>

<?php
if (empty($_SESSION['ss_id'])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>ระบบบริการและสนับสนุนโรงพยาบาล</title>
<LINK REL="SHORTCUT ICON" HREF="images/logo.png">
<!-- Bootstrap core CSS -->
<link href="../option/css/bootstrap.css" rel="stylesheet">
<!--<link href="option/css2/templatemo_style.css" rel="stylesheet">-->
<!-- Add custom CSS here -->
<link href="../option/css/sb-admin.css" rel="stylesheet">
<link rel="stylesheet" href="option/font-awesome/css/font-awesome.min.css">
<!-- Page Specific CSS -->
<link rel="stylesheet" href="../option/css/morris-0.4.3.min.css">
<link rel="stylesheet" href="../option/css/stylelist.css">
</head>
    <body>            
<?php }
echo	 "<p>&nbsp;</p>	"; 
echo	 "<p>&nbsp;</p>	";
echo "<div class='bs-example'>
	  <div class='progress progress-striped active'>
	  <div class='progress-bar' style='width: 100%'></div>
</div>";
echo "<div class='alert alert-dismissable alert-success'>
	  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	  <a class='alert-link' target='_blank' href='#'><center>กำลังดำเนินการ</center></a> 
</div>";
    
    $obj = $_POST['obj'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    if(empty($_POST['record_date'])){
    $record_date=date('Y-m-d');
    }  else {
     $record_date=$_POST['record_date'];   
}
    $start_time = $_POST['take_hour_st'].":".$_POST['take_minute_st'];
    $end_time = $_POST['take_hour_en'].":".$_POST['take_minute_en'];
    $amount = $_POST['amount'];
    $equip = $_POST['equip'];
    $audio = $_POST['audio'];
    $mic_table = $_POST['mic_table'];
    $mic_wireless = $_POST['mic_wireless'];
    $mic_line = $_POST['mic_line'];
    $visualizer = $_POST['visualizer'];
    $projector = $_POST['projector'];
    $comp = $_POST['comp'];
    $format = $_POST['format'];
    $room = $_POST['room'];
    
    if ($_POST['method'] == 'request_room') {
        if($_SESSION['ss_status']=='USER'){
        $empno = $_SESSION['ss_id'];
        }else{
        $empno = $_POST['empno'];    
        }  
        $sql = "SELECT * FROM ss_conferance WHERE room = '".$room."'
AND start_date = '".$start_date."'
AND (

   (start_time BETWEEN '".$start_time."' AND '".$end_time."')
   OR 
   (end_time BETWEEN '".$$start_time."' AND '".$end_time."')
   OR 
    ('".$start_time."' BETWEEN start_time  AND end_time)
   OR 
    ('".$end_time."' BETWEEN  start_time  AND end_time )
)";
        $qry = mysqli_query($db,$sql) or die(mysqli_error($db));
if($row = mysqli_fetch_array($qry))
{
echo "ห้องนี้มีผู้ใช้งาน ช่วงเวลา ". $row['start_time'] ." - ". $row['end_time'] ." กรุณาตรวจสอบอีกครั้ง!";
 echo "	<br><span class='fa fa-remove'></span>";
        echo "<a href='index.php?page=conferance/request_conf' >กลับ</a>";
}else{
        
        $regis_conferance=  mysqli_query($db,"select count from count where count_name='regis_conferance'");
$Regis_conferance=  mysqli_fetch_assoc($regis_conferance);
$Ln=$Regis_conferance['count']+1;
$Y=date('y')+43;
$conferance_no="$Y/$Ln";
    $update_count=  mysqli_query($db,"update count set count='$Ln' where count_name='regis_conferance'");
    
    $request = mysqli_query($db,"insert into ss_conferance set empno_request='$empno', obj='$obj', record_date='$record_date', start_date='$start_date', end_date='$end_date',
                conferance_no='$conferance_no', start_time='$start_time', end_time='$end_time', amount='$amount', equip='$equip', audio='$audio', mic_table='$mic_table',
                   mic_wireless='$mic_wireless', mic_line='$mic_line', visualizer='$visualizer',projector='$projector', comp='$comp', format='$format',
                      room='$room' ");
    
    if ($request == false) {
        echo "<p>";
        echo "Insert not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='index.php?page=conferance/request_conf' >กลับ</a>";
    } else {
                    echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php'>";
}}
}else if ($_POST['method'] == 'edit_room') {
    $conf_id=$_REQUEST['edit_id'];
    $edit = mysqli_query($db,"update ss_conferance set obj='$obj', start_date='$start_date', end_date='$end_date',
                start_time='$start_time', end_time='$end_time', amount='$amount', equip='$equip', audio='$audio', mic_table='$mic_table',
                   mic_wireless='$mic_wireless', mic_line='$mic_line', visualizer='$visualizer',projector='$projector', comp='$comp', format='$format',
                      room='$room' where conf_id='$conf_id'");

    $edit_event=mysqli_query($db,"update tbl_event set event_start='$start_date $start_time',event_end='$end_date $end_time' where workid='$conf_id' and process='2'");

    if ($edit & $edit_event == false) {
        echo "<p>";
        echo "Update not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='index.php?page=conferance/pre_request' >กลับ</a>";
    
    } else {
            echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php?page=conferance/pre_request'>";
        }
}else if ($_POST['method'] == 'confirm_conf') {
    include '../connection/connect.php';
    
    $confirm=$_POST['confirm'];
    $conf_id=$_POST['conf_id'];
    $depName=$_POST['depName'];
    $event_start=$_POST['event_start'];
    $event_end=$_POST['event_end'];
    $empno=$_POST['empno'];
    $room=$_POST['room'];
    
    $confirm_conf=  mysqli_query($db, "update ss_conferance set approve='$confirm', approver='".$_SESSION['ss_id']."' where conf_id='$conf_id' ");
    if($confirm=='Y'){
        $event2=  mysqli_query($db,"select url from hospital");
        $Event2=  mysqli_fetch_assoc($event2);
        $Events=$Event2['url'];
    $insert_event=mysqli_query($db,"insert into tbl_event set event_title='$depName',event_start='$event_start',event_end='$event_end',event_allDay='false',
            empno='$empno',workid='$conf_id',typela='$room',process='2', event_url='$Events/service&support/conferance/confirm_conf.php?id=$conf_id&method=back'");
    }
    if ($confirm_conf == false) {
        echo "<p>";
        echo "Process not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='index.php?page=conferance/pre_request' >กลับ</a>";
    
    } else {?>
            <center><a href="#" class="btn btn-primary" onclick="javascript:window.parent.opener.document.location.href='../index.php?page=conferance/pre_request'; window.close();">ปิดหน้าต่าง</a></center>
       <?php }
}else if ($_POST['method'] == 'cancle_conf') {
    include '../connection/connect.php';
    $conf_id=$_POST['conf_id'];
    $cancle_conf=  mysqli_query($db, "update ss_conferance set approve='C', approver='".$_SESSION['ss_id']."' where conf_id='$conf_id' ");
    $delete_conf=  mysqli_query($db,"delete from tbl_event where workid='$conf_id' and process='2'");
    
                    if ($cancle_conf == false) {
        echo "<p>";
        echo "Cancle not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='index.php?page=conferance/pre_request' >กลับ</a>";
    
    } else {?>
            <center><a href="#" class="btn btn-primary" onclick="javascript:window.parent.opener.document.location.href='../index.php?page=conferance/pre_confirm'; window.close();">ปิดหน้าต่าง</a></center>
    <?php }
}else if ($_POST['method'] == 'add_conf') {
    include 'connection/connect.php';
    $room=$_POST['conf'];
    $sql_conf=  mysqli_query($db, "insert into ss_room set room_name='$room'");
    
                    if ($sql_conf == false) {
        echo "<p>";
        echo "Insert not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='index.php?page=conferance/add_conf' >กลับ</a>";
    
    } else {
            echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php?page=conferance/add_conf'>";
     }
}else if ($_POST['method'] == 'edit_conf') {
    include 'connection/connect.php';
    $room_id=$_POST['room_id'];
    $room=$_POST['conf'];
    $edit_conf=  mysqli_query($db, "update ss_room set room_name='$room' where room_id='$room_id'");
    
                    if ($edit_conf == false) {
        echo "<p>";
        echo "Insert not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='index.php?page=conferance/add_conf' >กลับ</a>";
    
    } else {
            echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php?page=conferance/add_conf'>";
     }
}
?>
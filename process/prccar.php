<?php session_start(); ?>
<?php
if($_POST['method'] == 'request_car' or $_POST['method'] == 'edit_car' or $_POST['method'] == 'add_license' or $_POST['method'] == 'edit_license'){
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
<?php }?>
<p>&nbsp;</p> <p>&nbsp;</p>
<div class='bs-example'>
	  <div class='progress progress-striped active'>
	  <div class='progress-bar' style='width: 100%'></div>
</div>
<div class='alert alert-dismissable alert-success'>
	  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	  <a class='alert-link' target='_blank' href='#'><center>กำลังดำเนินการ</center></a> 
</div>
    <?php
    date_default_timezone_set('Asia/Bangkok');
    $place=$_POST['place'];
    $province=$_POST['province'];
    $amphur=$_POST['amphur'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $request_date=date('Y-m-d H:m:s');
    $start_time = $_POST['take_hour_st'].":".$_POST['take_minute_st'];
    $end_time = $_POST['take_hour_en'].":".$_POST['take_minute_en'];
    $amount_date = $_POST['amount_date'];
    $obj = $_POST['obj'];
    $amount = $_POST['amount'];
    $passenger = $_POST['passenger'];
    $wait = $_POST['wait'];
    
    if ($_POST['method'] == 'request_car') {
        if($_SESSION['ss_status']=='USER'){
        $empno_request = $_SESSION['ss_id'];
        }else{
        $empno_request = $_POST['empno'];    
        }
        
$regis_car=  mysqli_query($db,"select count from count where count_name='regis_car'");
$Regis_car=  mysqli_fetch_assoc($regis_car);
$Ln=$Regis_car['count']+1;
$Y=date('y')+43;
$car_no="$Y/$Ln";
    $update_count=  mysqli_query($db,"update count set count='$Ln' where count_name='regis_car'");
    
    $request = mysqli_query($db,"insert into ss_car set 
            car_no='$car_no', empno_request='$empno_request', obj='$obj', request_date='$request_date', start_date='$start_date', end_date='$end_date',
                start_time='$start_time', end_time='$end_time', amount='$amount', place='$place', province='$province', amphur='$amphur',
                   passenger='$passenger', wait='$wait', amount_date='$amount_date'");
    
    if ($request == false) {
        echo "<p>";
        echo "Insert not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='index.php?page=car/request_car' >กลับ</a>";
    } else {
                    echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php'>";
    }
}else if ($_POST['method'] == 'edit_car') {
    if($_SESSION['ss_status']=='USER'){
        $empno_request = $_SESSION['ss_id'];
        }else{
        $empno_request = $_POST['empno'];    
        }
    $car_id=$_REQUEST['edit_id'];
    $edit = mysqli_query($db,"update ss_car set empno_request='$empno_request', obj='$obj', request_date='$request_date', start_date='$start_date', end_date='$end_date',
                start_time='$start_time', end_time='$end_time', amount='$amount', place='$place', province='$province', amphur='$amphur',
                   passenger='$passenger', wait='$wait', amount_date='$amount_date' where car_id='$car_id'");
    $sel_car=  mysqli_query($db, "select pay from ss_car where car_id='$car_id'");
    $car=  mysqli_fetch_assoc($sel_car);
    if($car['pay']=='Y'){
        $event2=  mysqli_query($db,"select url from hospital");
        $Event2=  mysqli_fetch_assoc($event2);
        $Events=$Event2['url'];
          $update_event=mysqli_query($db,"update tbl_event set event_start='$start_date $start_time',event_end='$end_date $end_time', event_url='$Events/service&support/car/confirm_car.php?id=$car_id&method=back',event_allDay='false',
            workid='$car_id',process='3' where workid='$car_id'");  
    }

    if ($edit == false) {
        echo "<p>";
        echo "Update not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='index.php?page=car/pre_request&id=$car_id' >กลับ</a>";
    
    } else {
            echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php?page=car/pre_request'>";
        }
}else if ($_POST['method'] == 'pay_car') {
    include '../connection/connect.php';
    
    $car_type=$_POST['car_type'];
    $license_plate=$_POST['license_plate'];
    $rider=$_POST['rider'];
    $car_id=$_POST['car_id'];
    $paye_date=  date("Y-m-d");
    $other=$_POST['other'];
    $pay=$_POST['pay'];
    $select_rider=  mysqli_query($db,"SELECT ssc . * , CONCAT( e1.firstname,  ' ', e1.lastname ) AS fullname from ss_car ssc 
        INNER JOIN emppersonal e1 ON e1.empno = ssc.rider where ssc.rider='$rider'");
    $rider_name= mysqli_fetch_assoc($select_rider);
    
    $passenger=$_POST['passenger']." ขับโดย ".$rider_name['fullname'];
    $event_start=$_POST['event_start'];
    $event_end=$_POST['event_end'];
    $empno=$_POST['empno'];
    
    $pay_car=  mysqli_query($db, "update ss_car set car_type='$car_type', license_plate='$license_plate', rider='$rider', other='$other', pay='$pay', payer='".$_SESSION['ss_id']."', paye_date='$paye_date'
             where car_id='$car_id' ");
    if($pay=='Y'){
        $event2=  mysqli_query($db,"select url from hospital");
        $Event2=  mysqli_fetch_assoc($event2);
        $Events=$Event2['url'];
    $insert_event=mysqli_query($db,"insert into tbl_event set event_title='$passenger',event_start='$event_start',event_end='$event_end', event_url='$Events/service&support/car/confirm_car.php?id=$car_id&method=back',event_allDay='false',
            empno='$empno',workid='$car_id',typela='$license_plate',process='3'");
    }
    if ($pay_car == false) {
        echo "<p>";
        echo "Process not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='index.php?page=car/pre_request' >กลับ</a>";
    
    } else {?>
            <center><a href="#" class="btn btn-primary" onclick="javascript:window.parent.opener.document.location.href='../index.php?page=car/pre_request'; window.close();">ปิดหน้าต่าง</a></center>
       <?php }
}else if ($_POST['method'] == 'cancle_car') {
    include '../connection/connect.php';
    $car_id=$_POST['car_id'];
    $cancle_car=  mysqli_query($db,"update ss_car set approve='C', approver='".$_SESSION['ss_id']."' where car_id='$car_id' ");
    $delete_car=  mysqli_query($db,"delete from tbl_event where workid='$car_id' and process='3'");
    
                    if ($cancle_car == false) {
        echo "<p>";
        echo "Cancle not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='index.php?page=car/pre_request' >กลับ</a>";
    
    } else {?>
            <center><a href="#" class="btn btn-primary" onclick="javascript:window.parent.opener.document.location.href='../index.php?page=car/pre_confirm'; window.close();">ปิดหน้าต่าง</a></center>
    <?php }
}else if ($_POST['method'] == 'confirm_car') {
    include '../connection/connect.php';
    
    $car_id=$_POST['car_id'];
    $confirm_date=  date("Y-m-d");
    $reason=$_POST['reason'];
    $approve=$_POST['confirm'];
    $car_type=$_POST['car_type'];
    $license_plate=$_POST['license_plate'];
    $rider=$_POST['rider'];
    
    
    $confirm_car=  mysqli_query($db, "update ss_car set license_plate='$license_plate', car_type='$car_type', rider='$rider' , approve='$approve', approver='".$_SESSION['ss_id']."', approve_date='$confirm_date', reason='$reason' where car_id='$car_id' ");
    $select_rider=  mysqli_query($db,"SELECT ssc . * , CONCAT( e1.firstname,  ' ', e1.lastname ) AS fullname from ss_car ssc 
        INNER JOIN emppersonal e1 ON e1.empno = ssc.rider where ssc.rider='$rider'");
    $rider_name= mysqli_fetch_assoc($select_rider);
    
    $passenger=$_POST['passenger']." ขับโดย ".$rider_name['fullname'];
    $update_event=mysqli_query($db,"update tbl_event set event_title='$passenger'
            where workid='$car_id' and process='3'");
    
    if($approve=='N'){
    $delete_car=  mysqli_query($db,"delete from tbl_event where workid='$car_id' and process='3'");
}
    if ($confirm_car and $update_event == false) {
        echo "<p>";
        echo "Process not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='index.php?page=car/pre_request' >กลับ</a>";
    
    } else {?>
            <center><a href="#" class="btn btn-primary" onclick="javascript:window.parent.opener.document.location.href='../index.php?page=car/pre_request'; window.close();">ปิดหน้าต่าง</a></center>
       <?php }
}else if ($_POST['method'] == 'mile_car') {
    include '../connection/connect.php';
    
    $car_id=$_POST['car_id'];
    $befor_mile=$_POST['befor_mile'];
    $after_mile=$_POST['after_mile'];
    $distance=$after_mile-$befor_mile;
    
    $mile_car=  mysqli_query($db, "update ss_car set befor_mile='$befor_mile', after_mile='$after_mile', distance='$distance' where car_id='$car_id' ");

    if ($mile_car == false) {
        echo "<p>";
        echo "Process not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='index.php?page=car/pre_confirm' >กลับ</a>";
    
    } else {?>
            <center><a href="#" class="btn btn-primary" onclick="javascript:window.parent.opener.document.location.href='../index.php?page=car/pre_confirm'; window.close();">ปิดหน้าต่าง</a></center>
       <?php }
}else if ($_POST['method'] == 'detial_oil') {
    include '../connection/connect.php';
    
    $license_id=$_POST['license_id'];
    $reg_date=$_POST['reg_date'];
    $empno_record=$_SESSION['ss_id'];
    $pass_mile=$_POST['pass_mile'];
    $this_mile=$_POST['this_mile'];
    $oil_type=$_POST['oil_type'];
    $liter=$_POST['liter'];
    $bath=$_POST['bath'];
    $maintenance=$_POST['maintenance'];
    $other=$_POST['other'];
    
    $detial_oil=  mysqli_query($db, "insert into ss_detial_oil set license_id='$license_id', reg_date='$reg_date', empno_report='$empno_record', pass_mile='$pass_mile',
            this_mile='$this_mile', oil_type='$oil_type', liter='$liter', bath='$bath', maintenance='$maintenance', other='$other'");

    if ($detial_oil == false) {
        echo "<p>";
        echo "Process not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='../car/record_oil.php' >กลับ</a>";
    
    } else {?>
            <center><a href="#" class="btn btn-primary" onclick="javascript:window.parent.opener.document.location.href='../index.php?page=car/pre_confirm'; window.close();">ปิดหน้าต่าง</a></center>
       <?php }
}else if ($_POST['method'] == 'edit_oil') {
    include '../connection/connect.php';
    $do_id=$_POST['do_id'];
    $license_id=$_POST['license_id'];
    $reg_date=$_POST['reg_date'];
    $empno_record=$_SESSION['ss_id'];
    $pass_mile=$_POST['pass_mile'];
    $this_mile=$_POST['this_mile'];
    $oil_type=$_POST['oil_type'];
    $liter=$_POST['liter'];
    $bath=$_POST['bath'];
    $maintenance=$_POST['maintenance'];
    $other=$_POST['other'];
    
    $detial_oil=  mysqli_query($db, "update ss_detial_oil set license_id='$license_id', reg_date='$reg_date', empno_report='$empno_record', pass_mile='$pass_mile',
            this_mile='$this_mile', oil_type='$oil_type', liter='$liter', bath='$bath', maintenance='$maintenance', other='$other'
            where do_id=$do_id");

    if ($detial_oil == false) {
        echo "<p>";
        echo "Process not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='../car/record_oil.php' >กลับ</a>";
    
    } else {?>
            <center><a href="#" class="btn btn-primary" onclick="javascript:window.parent.opener.document.location.href='../index.php?page=car/listoil&license_plate=<?= $license_id?>'; window.close();">ปิดหน้าต่าง</a></center>
       <?php }
}else if ($_POST['method'] == 'edit_mile_car') {
    include '../connection/connect.php';
    
    $car_id=$_POST['car_id'];
    $befor_mile=$_POST['befor_mile'];
    $after_mile=$_POST['after_mile'];
    $distance=$after_mile-$befor_mile;
    
    $mile_car=  mysqli_query($db, "update ss_car set befor_mile='$befor_mile', after_mile='$after_mile', distance='$distance' where car_id='$car_id' ");

    if ($mile_car == false) {
        echo "<p>";
        echo "Process not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='index.php?page=car/pre_confirm' >กลับ</a>";
    
    } else {?>
            <center><a href="#" class="btn btn-primary" onclick="javascript:window.parent.opener.document.location.href='../index.php?page=car/pre_confirm'; window.close();">ปิดหน้าต่าง</a></center>
       <?php }
}else if ($_POST['method'] == 'add_license') {
    include 'connection/connect.php';
    
    $license_name=$_POST['license'];
    $cartype_id=$_POST['cartype'];
    $rider=$_POST['rider'];
    $oil_type=$_POST['oil_type'];
    $recive_date=$_POST['recive_date'];
    $car_status=$_POST['car_status'];
    
    $insert_license=  mysqli_query($db, "insert into ss_carlicense set license_name='$license_name', cartype_id='$cartype_id', rider='$rider', oil_type='$oil_type' , recive_date='$recive_date', car_status='$car_status'");

    if ($insert_license == false) {
        echo "<p>";
        echo "Insert not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='index.php?page=car/add_car' >กลับ</a>";
    
    } else {
echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php?page=car/add_car'>";        }

}else if ($_POST['method'] == 'edit_license') {
    include 'connection/connect.php';
    $license_id=$_POST['license_id'];
    $license_name=$_POST['license'];
    $cartype_id=$_POST['cartype'];
    $rider=$_POST['rider'];
    $oil_type=$_POST['oil_type'];
    if(!empty($_POST['recive_date'])){
    $recive_date=$_POST['recive_date'];
    $code=" , recive_date='$recive_date' ";
    }  else {
    $code='';    
    }
    $car_status=$_POST['car_status'];
    
    $edit_license=  mysqli_query($db, "update ss_carlicense set license_name='$license_name', cartype_id='$cartype_id', rider='$rider' $code, oil_type='$oil_type', car_status='$car_status' where license_id='$license_id'");

    if ($edit_license == false) {
        echo "<p>";
        echo "Insert not complete" . mysqli_error($db);
        echo "<br />";
        echo "<br />";

        echo "	<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='index.php?page=car/add_car' >กลับ</a>";
    
    } else {echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php?page=car/add_car'>";  }
}
?>
</body>
</html>
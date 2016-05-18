<?php @session_start(); ?>
<?php include '../connection/connect.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>ระบบบริการและสนับสนุน</title>
<LINK REL="SHORTCUT ICON" HREF="../images/logo.png">
<!-- Bootstrap core CSS -->
<link href="../option/css/bootstrap.css" rel="stylesheet">
<!--<link href="option/css2/templatemo_style.css" rel="stylesheet">-->
<!-- Add custom CSS here -->
<link href="../option/css/sb-admin.css" rel="stylesheet">
<link rel="stylesheet" href="../option/font-awesome/css/font-awesome.min.css">
<!-- Page Specific CSS -->
<link rel="stylesheet" href="../option/css/morris-0.4.3.min.css">
<link rel="stylesheet" href="../option/css/stylelist.css">
<script src="../option/js/excellentexport.js"></script>
</head>
<?php
include_once ('../option/funcDateThai.php');

    $car_id=$_REQUEST['car_id'];
    $sql_hos=  mysqli_query($db,"SELECT name FROM hospital ");
    $hospital=mysqli_fetch_assoc($sql_hos);
    $sql=  mysqli_query($db,"SELECT ssc . * , CONCAT( p1.pname, e1.firstname,  ' ', e1.lastname ) AS fullname, d1.depName AS dep, d2.dep_name AS depname, p2.posname AS posi,
        am.AMPHUR_NAME as amphur, pv.PROVINCE_NAME as province,c.cartype_name,l.license_name,
        (SELECT CONCAT( p1.pname, e1.firstname,  ' ', e1.lastname ) from ss_car ssc INNER JOIN emppersonal e1 ON ssc.passenger = e1.empno
        INNER JOIN pcode p1 ON e1.pcode = p1.pcode where ssc.passenger = e1.empno and ssc.car_id ='$car_id') pass_name,
        (SELECT CONCAT( p1.pname, e1.firstname,  ' ', e1.lastname ) from ss_car ssc INNER JOIN emppersonal e1 ON ssc.rider = e1.empno
        INNER JOIN pcode p1 ON e1.pcode = p1.pcode where ssc.rider = e1.empno and ssc.car_id ='$car_id') rider_name
FROM ss_car ssc
INNER JOIN emppersonal e1 ON ssc.empno_request = e1.empno
INNER JOIN pcode p1 ON e1.pcode = p1.pcode
INNER JOIN department d1 ON e1.depid = d1.depId
INNER JOIN department_group d2 ON d2.main_dep = d1.main_dep
INNER JOIN posid p2 ON e1.posid = p2.posId
INNER JOIN amphur am on am.AMPHUR_ID=ssc.amphur
INNER JOIN province pv on pv.PROVINCE_ID=ssc.province
INNER JOIN ss_car_type c on c.cartype_id=ssc.car_type
INNER JOIN ss_carlicense l on l.license_id=ssc.license_plate
WHERE ssc.car_id ='$car_id'");
    $car=  mysqli_fetch_assoc($sql);
    

?>
<body>
    <?php
require_once('../option/library/MPDF54/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
ob_start(); // ทำการเก็บค่า html นะครับ*/
?>
    
<div class="col-lg-12">
    <h4 align="right">เลขที่ <u> &nbsp;<?= $car['car_no']?>&nbsp; </u></h4>
    <h2 align="center"><b><u>แบบขออนุญาตใช้รถส่วนกลาง</u></b></h2>
</div><br>
<div class="col-lg-12" align="right">
วันที่ <?= DateThai2($car['request_date'])?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

</div>
<br>
<div class="col-lg-12" align="let">
    <b>เรียน &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้อำนวยการ<?=$hospital['name']?></b><br><br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            ข้าพเจ้า <b><?= $car['fullname']?></b> ตำแหน่ง <b><?= $car['posi']?></b><br> งาน <b><?= $car['dep']?></b> ฝ่าย/กลุ่มงาน <b><?= $car['depname']?></b><br> 
            ขออนุญาตใช้รถราชการที่ <b><?= $car['place']?></b>
            <?= "อำเภอ&nbsp;<b>".$car['amphur']."</b>&nbsp;จังหวัด&nbsp;<b>".$car['province']?></b><br> 
            เพื่อ <b><?= $car['obj']?></b> มีคนนั่ง <b><?= $car['amount']?></b> คน<br>
                        ในวันที่&nbsp; <b><?= DateThai2($car['start_date'])?></b>&nbsp;  เวลา &nbsp; <b><?= $car['start_time']?></b>&nbsp; น. &nbsp;ถึงวันที่&nbsp; <b><?= DateThai2($car['end_date'])?></b>&nbsp; เวลา&nbsp; <b><?= $car['end_time']?></b> &nbsp;น.
                            <br>หรือตามหนังสือที่แนบท้ายนี้ โดยให้ <b><?= $car['pass_name']?></b> เป็นผู้ควบคุม หากมีการเปลี่ยนแปลงหรืองดการใช้ จะแจ้งให้ผู้สั่งจ่ายรถทราบล่วงหน้า หากเลยกำหนดเวลาการขอใช้ 15 นาที ให้ถือว่าไม่ประสงค์ใช้รถคันดังกล่าว และการใช้รถในครั้งนี้ขอให้พนักงานขับรถ
                            <?php 
                            if($car['wait']=='Y'){
                                echo '<b>รอรับ</b>';
                            }elseif ($car['wait']=='N') {
                                echo '<b>ไม่รอรับ</b>';
                            }
                            ?>
                                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    
</div> 
                                 <br><br>
<div class="row">
    <div class="col-lg-12">
        <div class="col-lg-6 col-xs-6" align="center"></div>
        <div class="col-lg-6 col-xs-6" align="center">
                                                     ลงชื่อ .......................................................... ผู้ขอใช้รถ<br>
                                                     ( <?= $car['fullname']?> )<br>
                                                      <?= DateThai2($car['request_date'])?><br><br>
                                                      ลงชื่อ .......................................................... หัวหน้าหน่วยงาน<br><br>
                                                      ( .......................................................... )<br><br>
                                         ........../............/............
        </div></div></div><br><br>
<left> <b><u>ความเห็นของหัวหน้างานสนับสนุนบริการ</u></b><br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เห็นควรให้ใช้รถส่วนกลางประเภท <b><?= $car['cartype_name']?></b>&nbsp;หมายเลขทะเบียน <b><?= $car['license_name']?></b>&nbsp;&nbsp; โดยให้ <b><?= $car['rider_name']?></b>&nbsp;
    เป็นพนักงานขับรถ <?php if($car['other']!=''){ echo "และมีความเห็นเพิ่มเติม ดังนี้&nbsp;&nbsp;<b>".$car['other'];} ?></b></left><br><br>
    <div class="row">
    <div class="col-lg-12">
    <table width="100%" border="0" cellspacing="0" >
                                         <tr><td align="center"> 
                                         <b><u>ทราบ</u></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br>
                                         (ลงชื่อ).............................................พนักงานขับรถ<br><br>
                                             ( <?= $car['rider_name']?> )<br><br>
                                         ........../............/............<br><br>
                                         </td>
                                         <td align="center"><br><br>
    <left>(ลงชื่อ).............................................ผู้สั่งจ่ายรถ<br><br>
                                             ( ............................................. )<br><br>
                                         ........../............/............<br><br></left>
    </td></tr></table></div></div><br><br>
    <b><u>คำสั่งผู้อำนวยการ<?= $hospital['name']?> หรือผู้รับมอบอำนาจ</u></b><br>
    
        ( &nbsp; ) อนุญาต &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ) ไม่อนุญาต
   
    <br><br>เนื่องจาก..........................................................................................................................................................................
    <br><br>
     <div class="col-lg-12" align="center">
                                         (ลงชื่อ).............................................ผู้อำนวยการหรือผู้รับมอบอำนาจ<br><br>
                                         (..........................................................)
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         <br><br>
                                         ........../............/............
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         <br><br>                                         
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         F-AD-023
                                         
     </div>
                                         
<?php
$time_re=  date('Y_m_d');
$reg_date=$work[reg_date];
$html = ob_get_contents();
ob_clean();
$pdf = new mPDF('th', 'A4', '10', 'THSaraban');
$pdf->SetAutoFont();
$pdf->SetDisplayMode('fullpage');
$pdf->WriteHTML($html, 2);
$pdf->Output("../MyPDF/car$car_id.pdf");
echo "<meta http-equiv='refresh' content='0;url=../MyPDF/car$car_id.pdf' />";
?>
</body>
</html>
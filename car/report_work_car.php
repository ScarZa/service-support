<?php include 'connection/connect.php';  ?>
<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'>  ข้อมูลรายละเอียดผลการปฏิบัติงานของงานยานพาหนะ </font></h1> 
        <ol class="breadcrumb alert-warning">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> ข้อมูลรายละเอียดผลการปฏิบัติงาน</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title"><font color='brown'>ตารางข้อมูลรายละเอียดผลการปฏิบัติงาน</font></h3>
            </div>
            <div class="panel-body">
                <form method="post" action="" enctype="multipart/form-data" class="navbar-form navbar-right">
                    <div class="form-group">
                <select name="month_id" id="month"  class="form-control" required=""> 
				<?php	$sql = mysqli_query($db,"SELECT month_id, month_name FROM month order by m_id");
				 echo "<option value=''>--เลือกเดือน--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
  				 echo "<option value='".$result['month_id']."' $selected>".$result['month_name']." </option>";
				 } ?>
			 </select>
            </div> 
                        <div class="form-group"> 
                            <select name='year'  class="form-control" required="">
                                <option value=''>กรุณาเลือกปีงบประมาณ</option>
                                <?php
                                for ($i = 2559; $i <= 2565; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">ตกลง</button> 						
                    </form>
                <?php
               
                
                if (!empty($_POST['year'])) {
                    $year = $_POST['year'] - 543;
                    include 'option/function_date.php';
                    $years = $year + 543;
                    $sql_month = mysqli_query($db,"SELECT month_name FROM month where month_id='".$_POST['month_id']."'");
                    $month = mysqli_fetch_assoc( $sql_month );
                    
                    if($date >= $bdate and $date <= $edate){
                $take_month=$_POST['month_id'];                      
               
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
                $take_month=$_POST['month_id'];
                
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

    $q="SELECT cl.license_name, ot.oil_name, 
(select count(ssc.car_id) from ss_car ssc where ssc.province='30' and pay='Y' and approve='Y' and cl.license_id=ssc.license_plate and ssc.start_date between '$take_month1' and '$take_month2' )count_in_province,
(select sum(ssc.distance) from ss_car ssc where ssc.province='30' and pay='Y' and approve='Y' and cl.license_id=ssc.license_plate and ssc.start_date between '$take_month1' and '$take_month2' )sum_in_province,
(select count(ssc.car_id) from ss_car ssc where ssc.province!='30' and pay='Y' and approve='Y' and cl.license_id=ssc.license_plate and ssc.start_date between '$take_month1' and '$take_month2' )count_out_province,
(select sum(ssc.distance) from ss_car ssc where ssc.province!='30' and pay='Y' and approve='Y' and cl.license_id=ssc.license_plate and ssc.start_date between '$take_month1' and '$take_month2')sum_out_province,
(select sum(ssc.distance) from ss_car ssc where pay='Y' and approve='Y' and cl.license_id=ssc.license_plate and ssc.start_date between '$take_month1' and '$take_month2')sum_distance,
(select sum(do.liter) from ss_detial_oil do where do.license_id=cl.license_id and do.reg_date between '$take_month1' and '$take_month2' and do.other='2')oil_bill,
(select sum(do.bath) from ss_detial_oil do where do.license_id=cl.license_id and do.reg_date between '$take_month1' and '$take_month2' and do.other='2')bath_bill,
(select sum(do.liter) from ss_detial_oil do where do.license_id=cl.license_id and do.reg_date between '$take_month1' and '$take_month2' and do.other='1')oil,
(select sum(do.bath) from ss_detial_oil do where do.license_id=cl.license_id and do.reg_date between '$take_month1' and '$take_month2' and do.other='1')bath,
(select round((select sum(ssc.distance) from ss_car ssc where pay='Y' and approve='Y' and cl.license_id=ssc.license_plate and ssc.start_date between '$take_month1' and '$take_month2')/
(select sum(do.liter) from ss_detial_oil do where do.license_id=cl.license_id and do.reg_date between '$take_month1' and '$take_month2'),2))av,
(select sum(do.maintenance) from ss_detial_oil do where do.license_id=cl.license_id and do.reg_date between '$take_month1' and '$take_month2') maintenance   
from  ss_carlicense cl
left outer join ss_detial_oil do on do.license_id=cl.license_id
left outer join ss_car ssc on cl.license_id=ssc.license_plate
left outer join ss_oil_type ot on ot.oil_id=do.oil_type
group by cl.license_id";
    $qr = mysqli_query($db,$q);
       }         ?>
<div class="table-responsive">
                    <?php include_once ('option/funcDateThai.php'); ?>
                <a class="btn btn-success" download="report_work_<?= $month['month_name']?>.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable', 'Sheet Name Here');">Export to Excel</a><br><br>
                <table  id="datatable"  align="center" width="100%" class="table table-responsive table-bordered table-hover">
                    <thead>
                    <tr align="center">
                        <td colspan="13"><h4>ข้อมูลรายละเอียดผลการปฏิบัติงานของงานยานพาหนะ</h4></td>
                    </tr>
                    <tr align="center">
                        <td colspan="13"><b>ปีงบประมาณ <?= $years?>  ประจำเดือน <?= $month['month_name']?></b></td>
                    </tr>
                    <tr align="center" >
                        <td width="10%" rowspan="3" align="center" bgcolor="#898888"><b>ทะเบียนรถ</b></td>
                        <td rowspan="2" colspan="2" align="center" bgcolor="#898888"><b>ใช้บริการภายในจังหวัด</b></td>
                        <td rowspan="2" colspan="2" align="center" bgcolor="#898888"><b>ใช้บริการนอกเขตจังหวัด</b></td>
                        <td width="8%" rowspan="3" align="center" bgcolor="#898888"><b>รวมระยะทาง</b></td>
                         <td colspan="5" align="center" bgcolor="#898888"><b>ข้อมูลน้ำมันเชื้อเพลิง</b></td>
                        <td width="8%" rowspan="3" align="center" bgcolor="#898888"><b>ค่าเฉลี่ย (กม./ลิตร)</b></td>
                        <td width="10%" rowspan="3" align="center" bgcolor="#898888"><b>ค่าซ่อมบำรุง</b></td>
                     </tr>
                     <tr align="center">
                         <td rowspan="2" width="8%" align="center" bgcolor="#898888"><b>ชนิด</b></td>
                         <td colspan="2" align="center" bgcolor="#898888"><b>บิล</b></td>
                         <td colspan="2" align="center" bgcolor="#898888"><b>เงินสด</b></td>
                     </tr>
                    <tr align="center">
                      <td width="8%" align="center" bgcolor="#898888"><strong>ครั้ง</strong></td>
                      <td width="8%" align="center" bgcolor="#898888"><strong>ระยะทาง</strong></td>
                      <td width="8%" align="center" bgcolor="#898888"><strong>ครั้ง</strong></td>
                      <td width="8%" align="center" bgcolor="#898888"><strong>ระยะทาง</strong></td>
                        <td width="8%" align="center" bgcolor="#898888"><strong>ลิตร</strong></td>
                        <td width="8%" align="center" bgcolor="#898888"><b>บาท</b></td>
                        <td width="8%" align="center" bgcolor="#898888"><strong>ลิตร</strong></td>
                        <td width="8%" align="center" bgcolor="#898888"><b>บาท</b></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($_POST['year'])) {
                    $i = 1;
                    while ($result = mysqli_fetch_assoc($qr)) {
                        ?>
                        <tr>
                            <td align="center"><?= $result['license_name'] ?></td>
                            <td align="center"><?= $result['count_in_province'] ?></td>
                            <td align="center"><?= $result['sum_in_province'] ?></td>
                            <td align="center"><?= $result['count_out_province'] ?></td>
                            <td align="center"><?= $result['sum_out_province'] ?></td>
                            <td align="center"><?= $result['sum_distance'] ?></td>
                            <td align="center"><?= $result['oil_name']?></td>
                            <td align="center"><?= $result['oil_bill'] ?></td>
                            <td align="center"><?= $result['bath_bill'] ?></td>
                            <td align="center"><?= $result['oil'] ?></td>
                            <td align="center"><?= $result['bath'] ?></td>
                            <td align="center"><?= $result['av'] ?></td>
                            <td align="center"><?= $result['maintenance']; ?></td>
                           
                        </tr>
                    <?php 
                    $info[0]=$info[0]+$result['count_in_province'];
                    $info[1]=$info[1]+$result['sum_in_province'];
                    $info[2]=$info[2]+$result['count_out_province'];
                    $info[3]=$info[3]+$result['sum_out_province'];
                    $info[4]=$info[4]+$result['sum_distance'];
                    $info[5]=$info[5]+$result['oil_bill'];
                    $info[6]=$info[6]+$result['bath_bill'];
                    $info[7]=$info[7]+$result['oil'];
                    $info[8]=$info[8]+$result['bath'];
                    $info[9]=$info[9]+$result['av'];
                    $info[10]=$info[10]+$result['maintenance'];
                    $i++;
                    
                    }}
                ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th style="background-color: #898888" align="center">รวม</th>
                            <th style="background-color: #dad55e" align="center"><?=$info[0]?></th>
                            <th style="background-color: #dad55e" align="center"><?=$info[1]?></th>
                            <th style="background-color: #dad55e" align="center"><?=$info[2]?></th>
                            <th style="background-color: #dad55e" align="center"><?=$info[3]?></th>
                            <th style="background-color: #dad55e" align="center"><?=$info[4]?></th>
                            <td style="background-color: #dad55e" align="center"></td>
                            <th style="background-color: #dad55e" align="center"><?=$info[5]?></th>
                            <th style="background-color: #dad55e" align="center"><?=$info[6]?></th>
                            <th style="background-color: #dad55e" align="center"><?=$info[7]?></th>
                            <th style="background-color: #dad55e" align="center"><?=$info[8]?></th>
                            <th style="background-color: #dad55e" align="center"><?=$info[9]?></th>
                            <th style="background-color: #dad55e" align="center"><?=$info[10]?></th>
                            
                        </tr>
                    </tfoot>
                </table>
</div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>

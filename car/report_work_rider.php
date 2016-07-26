<?php include 'connection/connect.php';  ?>
<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'>  ข้อมูลรายละเอียดผลการปฏิบัติงานของพนักงานขับรถ </font></h1> 
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
                <h3 class="panel-title"><font color='brown'>ตารางข้อมูลรายละเอียดผลการปฏิบัติงานของพนักงานขับรถ</font></h3>
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
               include 'option/function_date.php';
                
                if (!empty($_POST['year'])) {
                    $year = $_POST['year'] - 543;
                    $years = $year + 543;
                    $sql_month = mysqli_query($db,"SELECT month_name FROM month where month_id='".$_POST['month_id']."'");
                    $month = mysqli_fetch_assoc( $sql_month );
                    
                    if($date >= $bdate and $date <= $edate){
                $take_month=$_POST['month'];                      
               
                             $y= $Yy;
                             $Y= date("Y");
                             $take_month1="$Y-$take_month-01";
                             if($take_month=='4' or $take_month=='6' or $take_month=='9' or $take_month=='11'){
                               $take_month2="$Y-$take_month-30";  
                             }elseif ($take_month=='2') {
                               $take_month2="$Y-$take_month-29"; 
                            }else{
                             $take_month2="$Y-$take_month-31";
                            }
                             $take_date1="$Y-10-01";
                             $take_date2="$y-09-30";
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

    $q="SELECT CONCAT(emp.firstname,' ',emp.lastname) AS rider, 
(select count(ssc.car_id) from ss_car ssc where ssc.province='30' and pay='Y' and approve='Y' and emp.empno=ssc.rider and (ssc.start_date between '$take_month1' and '$take_month2'))count_in_province,
(select sum(ssc.distance) from ss_car ssc where ssc.province='30' and pay='Y' and approve='Y' and emp.empno=ssc.rider and (ssc.start_date between '$take_month1' and '$take_month2'))sum_in_province,
(select count(ssc.car_id) from ss_car ssc where ssc.province!='30' and pay='Y' and approve='Y' and emp.empno=ssc.rider and (ssc.start_date between '$take_month1' and '$take_month2'))count_out_province,
(select sum(ssc.distance) from ss_car ssc where ssc.province!='30' and pay='Y' and approve='Y' and emp.empno=ssc.rider and (ssc.start_date between '$take_month1' and '$take_month2'))sum_out_province,
(select sum(ssc.distance) from ss_car ssc where pay='Y' and approve='Y' and emp.empno=ssc.rider and (ssc.start_date between '$take_month1' and '$take_month2'))sum_distance
from ss_car ssc
INNER JOIN emppersonal emp ON emp.empno=ssc.rider
group by ssc.rider order by sum_distance desc";
    $qr = mysqli_query($db,$q);
       }         ?>

                    <?php include_once ('option/funcDateThai.php'); ?>
                <div class="table-responsive">
                <a class="btn btn-success" download="report_rider_<?= $month['month_name']?>.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable', 'Sheet Name Here');">Export to Excel</a><br><br>
                <table  id="datatable"  align="center" width="100%" class="table table-responsive table-hover table-bordered">
                    <thead>
                    <tr align="center">
                        <td colspan="14"><h4>ข้อมูลรายละเอียดผลการปฏิบัติงานของพนักงานขับรถ</h4></td>
                    </tr>
                    <tr align="center">
                        <td colspan="14"><b>ปีงบประมาณ <?= $years?>  ประจำเดือน <?= $month['month_name']?></b></td>
                    </tr>
                    <tr align="center" >
                        <td width="10%" rowspan="2" align="center" bgcolor="#898888"><b>พนักงานขับรถ</b></td>
                        <td colspan="2" align="center" bgcolor="#898888"><b>ใช้บริการภายในจังหวัด</b></td>
                        <td colspan="2" align="center" bgcolor="#898888"><b>ใช้บริการนอกเขตจังหวัด</b></td>
                        <td width="8%" rowspan="2" align="center" bgcolor="#898888"><b>รวมระยะทาง</b></td>
                     </tr>
                    <tr align="center">
                      <td width="8%" align="center" bgcolor="#898888"><strong>จำนวนครั้ง</strong></td>
                      <td width="8%" align="center" bgcolor="#898888"><strong>ระยะทาง</strong></td>
                      <td width="8%" align="center" bgcolor="#898888"><strong>จำนวนครั้ง</strong></td>
                      <td width="8%" align="center" bgcolor="#898888"><strong>ระยะทาง</strong></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($_POST['year'])) {
                    $i = 1;
                    while ($result = mysqli_fetch_assoc($qr)) {
                        ?>
                        <tr>
                            <td align="center"><?= $result['rider'] ?></td>
                            <td align="center"><?= $result['count_in_province'] ?></td>
                            <td align="center"><?= $result['sum_in_province'] ?></td>
                            <td align="center"><?= $result['count_out_province'] ?></td>
                            <td align="center"><?= $result['sum_out_province'] ?></td>
                            <td align="center"><?= $result['sum_distance'] ?></td>
                        </tr>
                    <?php $i++;
                    }}
                ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>

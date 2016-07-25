<?php include 'connection/connect.php';  ?>
<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'>  รายงานการใช้งานรถยนต์ </font></h1> 
        <ol class="breadcrumb alert-warning">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> รายงานการใช้งานรถยนต์</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title"><font color='brown'>ตารางรายงานการใช้งานรถยนต์</font></h3>
            </div>
            <div class="panel-body">
                <form method="post" action="" enctype="multipart/form-data" class="navbar-form navbar-right">
                    <div class="form-group">
                        <select name="license_plate" id="license_plate"  class="form-control" required=""> 
				<?php	$sql = mysqli_query($db,"SELECT *  FROM ss_carlicense");
				 echo "<option value=''>--เลือกรถยนต์--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['license_id']==$edit_person['license_plate']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['license_id']."' $selected>".$result['license_name'] ."</option>";
				 } ?>
                </select>
            </div>
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
    $license_id=$_POST['license_plate'];            
    $sel_license_plate=  mysqli_query($db, "select license_name from ss_carlicense where license_id='$license_id'");
    $license_plate= mysqli_fetch_assoc($sel_license_plate);
    $q="SELECT d.depName,COUNT(ssc.car_id) AS time,SUM(ssc.distance)AS dist
FROM ss_car ssc
INNER JOIN emppersonal emp ON emp.empno=ssc.empno_request
INNER JOIN department d ON d.depId=emp.depid
WHERE ssc.license_plate=$license_id and (ssc.start_date between '$take_month1' and '$take_month2')
GROUP BY d.depId ORDER BY dist DESC";
    $qr = mysqli_query($db,$q);
       }         ?>

                    <?php include_once ('option/funcDateThai.php'); ?>
                <a class="btn btn-success" download="report_drive_out_<?= $license_plate['license_name']?>.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable', 'Sheet Name Here');">Export to Excel</a><br><br>
                <table  id="datatable"  align="center" width="100%" border="1">
                    <tr align="center">
                        <td colspan="4"><h4>รายงานการใช้งานรถยนต์</h4></td>
                    </tr>
                    <tr align="center">
                        <td colspan="4"><b>ประจำปีงบประมาณ <?= $years?> เดือน  <?= $month['month_name']?></b></td>
                    </tr>
                    <tr align="center">
                        <td colspan="4"><b>รถยนต์หมายเลขทะเบียน <?= $license_plate['license_name']?> </b></td>
                    </tr>
                    <tr align="center" >
                        <td width="3%" align="center" bgcolor="#898888"><b>ลำดับ</b></td>
                        <td width="9%" align="center" bgcolor="#898888"><b>หน่วยงาน</b></td>
                        <td width="9%" align="center" bgcolor="#898888"><b>จำนวนครั้งที่ออก</b></td>
                        <td width="9%" align="center" bgcolor="#898888"><b>ระยะทาง( ก.ม. )</b></td>
                     </tr>
                    <?php if (!empty($_POST['year'])) {
                    $i = 1; $I=0;
                    while ($result = mysqli_fetch_assoc($qr)) {
                        ?>
                        <tr>
                            <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                            <td align="center"><?= $result['depName']?></td>
                            <td align="center"><?= $time[$I]=$result['time']; ?></td>
                            <td align="center"><?= $dist[$I]=$result['dist']; ?></td>
                        </tr>
                    <?php $i++;$I++; 
                    }if(!empty($time)){
                     $sumtime=array_sum ($time);
                     $sumdist=array_sum ($dist);
                    }
                            }
                ?>
                        <tr>
                            <td align="center" colspan="2" bgcolor="#898888"><b>รวม</b></td>
                            <td align="center"><?= $sumtime?></td>
                            <td align="center"><?= $sumdist?></td>
                        </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>

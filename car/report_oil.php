<?php include 'connection/connect.php';  ?>
<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'>  รายงานการใช้น้ำมันเชื้อเเพลิง </font></h1> 
        <ol class="breadcrumb alert-warning">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li class="active"><i class="fa fa-edit"></i> รายงานการใช้น้ำมันเชื้อเเพลิง</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title"><font color='brown'>ตารางรายงานการใช้น้ำมันเชื้อเเพลิง</font></h3>
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

    $q="SELECT * from ss_detial_oil        where reg_date between '$take_month1' and '$take_month2' and license_id='$license_id'
        order by do_id";
    $qr = mysqli_query($db,$q);
    
    $sql_bath=  mysqli_query($db, "SELECT sum(liter) as sumliter, sum(bath) as sumbath from ss_detial_oil where other='1' and reg_date between '$take_month1' and '$take_month2' and license_id='$license_id'");
    $sumcash=  mysqli_fetch_assoc($sql_bath);
    $sql_bill=  mysqli_query($db, "SELECT sum(liter) as sumliter, sum(bath) as sumbath from ss_detial_oil where other='2' and reg_date between '$take_month1' and '$take_month2' and license_id='$license_id'");
    $sumbill=  mysqli_fetch_assoc($sql_bill);

       }         ?>

                    <?php include_once ('option/funcDateThai.php'); ?>
                <a class="btn btn-success" download="report_oil<?= $license_plate['license_name']?>.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable', 'Sheet Name Here');">Export to Excel</a><br><br>
                <table  id="datatable"  align="center" width="100%" border="1">
                    <tr align="center">
                        <td colspan="11"><h4>รายงานการใช้น้ำมันเชื้อเเพลิง</h4></td>
                    </tr>
                    <tr align="center">
                        <td colspan="11"><b>ประจำปีงบประมาณ <?= $years?> เดือน  <?= $month['month_name']?></b></td>
                    </tr>
                    <tr align="center">
                        <td colspan="11"><b>รถยนต์หมายเลขทะเบียน <?= $license_plate['license_name']?> เกณฑ์การใช้น้ำมัน............................... กม./ลิตร</b></td>
                    </tr>
                    <tr align="center" >
                        <td width="3%" rowspan="2" align="center" bgcolor="#898888"><b>ลำดับ</b></td>
                        <td width="9%" rowspan="2" align="center" bgcolor="#898888"><b>วัน/เดือน/ปี</b></td>
                        <td width="9%" rowspan="2" align="center" bgcolor="#898888"><b>เลขไมล์ครั้งก่อน</b></td>
                        <td width="9%" rowspan="2" align="center" bgcolor="#898888"><b>เลขไมล์ครั้งนี้</b></td>
                        <td width="9%" rowspan="2" align="center" bgcolor="#898888"><b>รวมระยะทาง</b></td>
                        <td width="18%" colspan="2" align="center" bgcolor="#898888"><b>จำนวนเติมครั้งสุดท้าย</b></td>
                        <td width="9%" rowspan="2" align="center" bgcolor="#898888"><b>ลิตรละ</b></td>
                        <td width="9%" rowspan="2" align="center" bgcolor="#898888"><b>ค่าเฉลี่ย (กม./ลิตร)</b></td>
                        <td width="9%" rowspan="2" align="center" bgcolor="#898888"><b>ค่าซ่อมบำรุง</b></td>
                        <td width="9%" rowspan="2" align="center" bgcolor="#898888"><b>หมายเหตุ</b></td>
                     </tr>
                    <tr align="center">
                        <td align="center" bgcolor="#898888"><b>จำนวนลิตร</b></td>
                        <td align="center" bgcolor="#898888"><b>จำนวนเงิน</b></td>
                    </tr>

                    <?php if (!empty($_POST['year'])) {
                    $i = 1; $I=0;
                    while ($result = mysqli_fetch_assoc($qr)) {
                        ?>
                        <tr>
                            <td align="center"><?= ($chk_page * $e_page) + $i ?></td>
                            <td align="center"><?= DateThai1($result['reg_date']); ?></td>
                            <td align="center"><?= $result['pass_mile']; ?></td>
                            <td align="center"><?= $result['this_mile']; ?></td>
                            <td align="center"><?= $distance[$I]=$result['this_mile']-$result['pass_mile']; ?></td>
                            <td align="center"><?= $oil[$I]=$result['liter']; ?></td>
                            <td align="center"><?= $bath[$I]=$result['bath']; ?></td>
                            <td align="center"><?= $liter[$I]= round($result['bath']/$result['liter'],2); ?></td>
                            <td align="center"><?= $average[$I]= round($distance[$I]/$result['liter'],2); ?></td>
                            <td align="center"><?= $maintenance[$I]= $result['maintenance']; ?></td>
                            <td align="center"><?php if($result['other']=='1'){ echo 'เงินสด';}elseif ($result['other']=='2') { echo 'บิลน้ำมัน';} ?></td>
                            
                        </tr>
                    <?php $i++;$I++; 
                    }if(!empty($distance)){
                     $sumdistance=array_sum ($distance);
                     $sumoil=array_sum ($oil);
                     $sumbath=array_sum ($bath);
                     $summaintenance=array_sum ($maintenance);
                    }
                            }
                ?>
                        <tr>
                            <td colspan="11"></td>
                        </tr>
                        <tr>
                            <td align="center" colspan="4" bgcolor="#898888"><b>รวม</b></td>
                            <td align="center"><?= $sumdistance?></td>
                            <td align="center"><?= $sumoil?></td>
                            <td align="center"><?= $sumbath?></td>
                            <td align="center"></td>
                            <td align="center"><?php if(!empty($distance)){ echo round($sumdistance/$sumoil,2);}?></td>
                            <td align="center"><?= $summaintenance?></td>
                            <td align="center"></td>
                        </tr>
                        <tr>
                            <td align="center" colspan="4" bgcolor="#898888"><b>เงินสด</b></td>
                            <td align="center"></td>
                            <td align="center"><?= $sumcash['sumliter']?></td>
                            <td align="center"><?= $sumcash['sumbath']?></td>
                            <td align="center" colspan="4"></td>
                        </tr>
                        <tr>
                            <td align="center" colspan="4" bgcolor="#898888"><b>บิลน้ำมัน</b></td>
                            <td align="center"></td>
                            <td align="center"><?= $sumbill['sumliter']?></td>
                            <td align="center"><?= $sumbill['sumbath']?></td>
                            <td align="center" colspan="4"></td>
                        </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>

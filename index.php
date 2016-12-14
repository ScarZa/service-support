<?php require 'header.php'; ?>
<!-- Content Header (Page header) -->
<?php

function getRenderedHTML($path) {
    ob_start();
    include("$path.php");
    $var = ob_get_contents();
    ob_end_clean();
    return $var;
}

if (isset($_SESSION['ss_id'])) {
    if (isset($_REQUEST['page'])) {
        $page = $_REQUEST['page'];
        echo getRenderedHTML($page);
        /*    require 'class/renderPHP.php';
          $render_php=new renderPHP("$page");
          $render_php->display();
          echo $render_php; */
    } else {
        $sql = mysqli_query($db, "select * from  hospital");
        $resultHos = mysqli_fetch_assoc($sql);


        if ($resultHos['logo'] != '') {
            $pic = $resultHos['logo'];
            $fol = "logo/";
        } else {
            $pic = 'agency.ico';
            $fol = "images/";
        }
        ?>

        <section class="content-header">
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-warning">
                        <div class="col-lg-1 col-md-2 col-xs-3" align="center"><img src='<?= $resultHos['url']?>/hrd/<?= $fol . $pic; ?>' width="80"></div>
                        <div class="col-lg-11 col-md-10 col-xs-9" valign="top">
                            <h2><b>ระบบบริการและสนับสนุน </b><small><br><b><font color="green">
        <?php echo $resultHos['name']; ?></font></b></small></h2>
                            ยินดีต้อนรับสู่ <a class="alert-link" href="http://startbootstrap.com" target="_blank"> ระบบบริการและสนับสนุน</a>
                        </div>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                </div>
            </div>
            <div>
                <ol class="breadcrumb alert-warning">
              <!--<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>-->
                    <li class="active"><i class="fa fa-hospital"></i> หน้าหลัก</li>
                </ol>  
            </div>
        </section>
        <section class="content">

<div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Use of cars Statistics :                 
                        <?php
                        include_once ('option/funcDateThai.php');
                        include 'option/function_date.php';
                        $d_start = 01;
                        $m_start = 01;
                        $d = date("d");
                        if ($_POST[year] == '') {
                            
                            if($date >= $bdate and $date <= $edate){
                             $y= $Yy;
                             $Y= date("Y");
                            }else{
                            $y = date("Y");
                            $Y = date("Y") - 1;
                            }
                        } else {
                            $y = $_POST[year] - 543;
                            $Y = $y - 1;
                        }
                        $date_start = "$Y-10-01";
                        $date_end = "$y-09-30";
                        echo $date_start = DateThai2($date_start); //-----แปลงวันที่เป็นภาษาไทย
                        echo " ถึง ";
                        echo $date_end = DateThai2($date_end); //-----แปลงวันที่เป็นภาษาไทย
                        ?>	</h3>
                </div>
                <div class="panel-body">
                    <div class="col-lg-12 col-xs-12">
                    <form method="post" action="" enctype="multipart/form-data" class="navbar-form navbar-right">
                        <div class="form-group col-lg-9 col-md-9 col-xs-8"> 
                            <select name='year'  class="form-control">
                                <option value=''>กรุณาเลือกปีงบประมาณ</option>
                                <?php
                                for ($i = 2559; $i <= 2565; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-xs-4"><button type="submit" class="btn btn-success">ตกลง</button></div> 						
                    </form>
                    </div><br><br><br>
                    <?php
                    if ($_POST[year] == '') {
                        
                            if($date >= $bdate and $date <= $edate){
                          $year = $Yy;
                        $years = $year + 543;      
                            }else{
                        $year = date('Y');
                        $years = $year + 543;
                        
                            }
                    } else {
                        $year = $_POST[year] - 543;
                        $years = $year + 543;
                    }
                    
              echo "<center>";



                    echo "รายงานการใช้น้ำมัน";
                    echo "&nbsp;&nbsp;";
                    echo "ปีงบประมาณ : $years";
                    echo "</center>";

                    $month_start = "$Y-10-01";
                    $month_end = "$y-09-30";
                    
                    $num_license = mysqli_query($db,"select count(license_id) as count_cl from ss_carlicense");
                        $count_license = mysqli_fetch_assoc($num_license);
                        $count_cl = $count_license['count_cl'];
                    
                    for ($c = 1; $c <= $count_cl; $c++) {
                    $sql2 = mysqli_query($db, "select license_name from ss_carlicense where license_id='$c'");
                    $rs2 = mysqli_fetch_assoc($sql2);
                    $name_license[$c].=$rs2['license_name'] . ',';
                    }
                    $I = 10;
                    for ($i = -2; $i <= 9; $i++) {

                        $sqlMonth = mysqli_query($db,"select * from month where m_id='$i'");
                        $month = mysqli_fetch_assoc($sqlMonth);

                        if ($i <= 0) {
                            $month_start = "$Y-$I-01";
                            $month_end = "$Y-$I-31";
                            /* if(date("Y-m-d")=="$y-$I-$d"){
                              $month_start = "$y-$I-01";
                              $month_end = "$y-$I-31";
                              } */
                        } elseif ($i >= 1 and $i <= 9) {
                            $month_start = "$year-0$i-01";
                            $month_end = "$year-0$i-31";
                        } else {
                            $month_start = "$year-$i-01";
                            $month_end = "$year-$i-31";
                        }

                        $month_start;
                        echo "&nbsp;&nbsp;";
                        $month_end;
                        
                        for ($c = 1; $c <= $count_cl; $c++) {
                        $sql  = mysqli_query($db,"select if(ISNULL(sum(bath)),0,sum(bath)) as sum_oil from ss_detial_oil   
						 where  license_id='$c' and reg_date between '$month_start' and '$month_end' order by license_id");
                        
                        $rs = mysqli_fetch_assoc($sql);
                       
                        $countnum[$c].= $rs['sum_oil'] . ',';
                        }
                        $name.="'".$month['month_short']."'" . ',';
                        $I++;
                    }
                    echo mysql_error();?>
                    <script src="option/Highcharts/js/highcharts.js"></script>
                    <script src="option/Highcharts/js/modules/exporting.js"></script>
                    <script type="text/javascript">
                        $(function () {
                            var chart;
                            $(document).ready(function () {
                                chart = new Highcharts.Chart({
                                    chart: {
                                        renderTo: 'container',
                                        type: 'line'
                                    },
                                    title: {
                                        text: 'จำนวนการใช้น้ำมันในแต่ละเดือน'
                                    },
                                    subtitle: {
                                        text: ''
                                    },
                                    xAxis: {
                                        categories: [<?= $name; ?>
                                        ]
                                    },
                                    yAxis: {
                                        title: {
                                            text: 'จำนวนเงิน (บาท)'
                                        }
                                    },
                                    tooltip: {
                                        enabled: true,
                                        formatter: function () {
                                            return '<b>' + this.series.name + '</b><br/>' +
                                                    this.x + ': ' + this.y + ' บาท';
                                        }
                                    },
                                    plotOptions: {
                                        line: {
                                            dataLabels: {
                                                enabled: true
                                            },
                                            enableMouseTracking: true
                                        }
                                    },
                                    series: [
                                    <?php for ($c = 1; $c <= $count_cl; $c++) {?>
                                    {
                                        
                                            name: '<?= $name_license[$c]?>',
                                            data: [<?= $countnum[$c]?>]
                                        
                                        },
                                                <?php }   ?>
                                    ]
                                });
                            });

                        });


                    </script>
                <div class="row">    
                    <div class="col-lg-12 col-xs-12">
                    <div class="col-lg-12" id="container" style="margin: 0 auto"></div>
                    </div>
                    </div>
                    <br><br>
                    <?php
            /*        echo "<center>";
                    echo "รายงานระยะทางการใช้รถยนต์ : ทั้งหมด";
                    echo "&nbsp;&nbsp;";
                    echo "ปีงบประมาณ : $years";
                    echo "</center>";

                    $month_start = "$Y-10-01";
                    $month_end = "$y-09-30";
                    for ($c = 1; $c <= $count_cl; $c++) {
                    $sql4 = mysqli_query($db, "select license_name from ss_carlicense where license_id='$c'");
                    $rs4 = mysqli_fetch_assoc($sql4);
                    $name_license4[$c].=$rs4['license_name'] . ',';
                    }
                   $I = 10;
                    for ($i = -2; $i <= 9; $i++) {

                        $sqlMonth = mysqli_query($db,"select * from month where m_id='$i'");
                        $month = mysqli_fetch_assoc($sqlMonth);

                        if ($i <= 0) {
                            $month_start = "$Y-$I-01";
                            $month_end = "$Y-$I-31";
                            /* if(date("Y-m-d")=="$y-$I-$d"){
                              $month_start = "$y-$I-01";
                              $month_end = "$y-$I-31";
                              } */
              /*          } elseif ($i >= 1 and $i <= 9) {
                            $month_start = "$year-0$i-01";
                            $month_end = "$year-0$i-31";
                        } else {
                            $month_start = "$year-$i-01";
                            $month_end = "$year-$i-31";
                        }

                        $month_start;
                        echo "&nbsp;&nbsp;";
                        $month_end;
                        for ($c = 1; $c <= $count_cl; $c++) {
                        $sql  = mysqli_query($db,"select sum(distance) as distance from ss_car  
						 where  license_plate='$c' and start_date between '$month_start' and '$month_end' order by license_plate");
                        
                        $rs3 = mysqli_fetch_assoc($sql);
                       
                        $distance[$c].= $rs3['distance'] . ',';
                        }
                        $name2.="'".$month['month_short']."'" . ',';
                        $I++;
                    }
                    echo mysql_error(); */?>
                    <!--<script type="text/javascript">
                        $(function () {
                            var chart;
                            $(document).ready(function () {
                                chart = new Highcharts.Chart({
                                    chart: {
                                        renderTo: 'container01',
                                        type: 'line'
                                    },
                                    title: {
                                        text: 'ระยะทางการใช้รถยนต์ในแต่ละเดือน'
                                    },
                                    subtitle: {
                                        text: ''
                                    },
                                    xAxis: {
                                        categories: [<?= $name2; ?>
                                        ]
                                    },
                                    yAxis: {
                                        title: {
                                            text: 'ระยะทาง (ก.ม.)'
                                        }
                                    },
                                    tooltip: {
                                        enabled: true,
                                        formatter: function () {
                                            return '<b>' + this.series.name + '</b><br/>' +
                                                    this.x + ': ' + this.y + ' ก.ม.';
                                        }
                                    },
                                    plotOptions: {
                                        line: {
                                            dataLabels: {
                                                enabled: true
                                            },
                                            enableMouseTracking: true
                                        }
                                    },
                                    series: [
                                    <?php for ($c = 1; $c <= $count_cl; $c++) {?>
                                    {
                                            name: '<?= $name_license4[$c]?>',
                                            data: [<?= $distance[$c]?>]
                                        },
                                                <?php }   ?>
                                    ]
                                });
                            });

                        });


                    </script>
                <div class="row">    
                    <div class="col-lg-12 col-xs-12">
                    <div class="col-lg-12" id="container01" style="margin: 0 auto"></div>
                    </div>
                    </div>-->
                    
                 <?php   
                    $m_start = "$Y-10-01";
                    $m_end = "$y-09-30";
                    $sql=  mysqli_query($db, "SELECT sscl.license_name as cl_name,
(SELECT COUNT(ssc.car_id) from ss_car ssc where sscl.license_id=ssc.license_plate and ((ssc.start_date between '$m_start' and '$m_end') AND
(ssc.end_date between '$m_start' and '$m_end')) and ssc.pay='Y' and approve='Y')use_car
FROM ss_car ssc
LEFT OUTER JOIN ss_carlicense sscl on sscl.license_id=ssc.license_plate
WHERE sscl.license_id=ssc.license_plate and ((ssc.start_date between '$m_start' and '$m_end') AND
(ssc.end_date between '$m_start' and '$m_end')) and ssc.pay='Y' and approve='Y'
GROUP BY sscl.license_id  
order by sscl.license_id");
?>
                    
                    
                    
                    <script type="text/javascript">
                        $(function () {
                            var chart;
                            $(document).ready(function () {
                                chart = new Highcharts.Chart({
                                    chart: {
                                        renderTo: 'contain',
                                        plotBackgroundColor: null,
                                        plotBorderWidth: null,
                                        plotShadow: false,
                                    },
                                    title: {
                                        text: 'จำนวนการใช้รถในปีงบประมาณ <?= $years ?>'
                                    },
                                    tooltip: {
                                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>',
                                        percentageDecimals: 1
                                    },
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            dataLabels: {
                                                enabled: true,
                                                color: '#000000',
                                                connectorColor: '#000000',
                                                formatter: function () {
                                                    return '<b>' + this.point.name + '</b>: <br>' + this.y + ' ครั้ง';
                                                }
                                            }
                                        }
                                    },
                                    series: [{
                                            type: 'pie',
                                            name: 'ใช้ไป',
                                            data: [<?php
                while ($row = mysqli_fetch_assoc($sql)) {
                    $depnamex = $row['cl_name'];
                    $countx = $row['use_car'];
                    $sss = "['" . $depnamex . "'," . $countx . "],";
                    echo $sss;
                }
                ?>
                                            ]
                                        }]
                                });
                            });

                        });
                    </script>
                    <div class="col-lg-6 col-xs-12" id="contain" style="margin: 0 auto"></div>
      <?php
      $sql=  mysqli_query($db, "SELECT count(car_id) as in_province,
(select count(car_id) from ss_car where province!='30' and((start_date between '$m_start' and '$m_end') AND
(end_date between '$m_start' and '$m_end')) and pay='Y' and approve='Y') out_province
FROM `ss_car` 
where province='30' and((start_date between '$m_start' and '$m_end') AND
(end_date between '$m_start' and '$m_end')) and pay='Y' and approve='Y'");
              $row = mysqli_fetch_assoc($sql);
      ?>
                    <script type="text/javascript">
                        $(function () {
                            var chart;
                            $(document).ready(function () {
                                chart = new Highcharts.Chart({
                                    chart: {
                                        renderTo: 'contain2',
                                        plotBackgroundColor: null,
                                        plotBorderWidth: null,
                                        plotShadow: false,
                                    },
                                    title: {
                                        text: 'จำนวนการใช้รถภายใน/ภายนอกจังหวัด <br> ในปีงบประมาณ <?= $years ?>'
                                    },
                                    tooltip: {
                                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>',
                                        percentageDecimals: 1
                                    },
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            dataLabels: {
                                                enabled: true,
                                                color: '#000000',
                                                connectorColor: '#000000',
                                                formatter: function () {
                                                    return '<b>' + this.point.name + '</b>: <br>' + this.y + ' ครั้ง';
                                                }
                                            }
                                        }
                                    },
                                    series: [{
                                            type: 'pie',
                                            name: 'ใช้ไป',
                                            data: [
                                                ['ภายในจังหวัด', <?= $row['in_province'] ?>],
                                                ['ภายนอกจังหวัด', <?= $row['out_province'] ?>]
                                        ]
                                        }]
                                });
                            });

                        });
                    </script>
                    <div class="col-lg-6 col-xs-12" id="contain2" style="margin: 0 auto"></div>
                    
                    
                    </div>
                </div>
            </div>
        </div>
        </section>
    <?php }
} else { ?>


    <!-- Main content -->
    <section class="content">
        <meta http-equiv='refresh' content='0;url=fullcalendar1_2.php' />
    </section>
<?php } ?>


<?php require 'footer.php'; ?>
<?php session_start(); ?>
<?php include 'connection/connect.php'; ?>
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
        <link href="option/css/bootstrap.css" rel="stylesheet">
        <!-- Add custom CSS here -->
        <link href="option/css/sb-admin.css" rel="stylesheet">
        <link rel="stylesheet" href="option/font-awesome/css/font-awesome.min.css">
        <!-- Page Specific CSS -->
        <link rel="stylesheet" href="option/css/morris-0.4.3.min.css">
        <link rel="stylesheet" href="option/css/stylelist.css">
        <script src="option/js/jquery-2.1.4.min.js"></script>
        <script src="option/js/excellentexport.js"></script>

        <!-- InstanceBeginEditable name="head" -->
        <script type="text/javascript">
                        function popup(url,name,windowWidth,windowHeight){    
                                        myleft=(screen.width)?(screen.width-windowWidth)/2:100;	
                                        mytop=(screen.height)?(screen.height-windowHeight)/2:100;	
                                        properties = "width="+windowWidth+",height="+windowHeight;
                                        properties +=",scrollbars=yes,resizable=no,toolbar=no, top="+mytop+",left="+myleft;   
                                        window.open(url,name,properties);
                }
        </script>
        <script type="text/javascript">
            function resizeIframe(obj)// auto height iframe
            {
                {
                    obj.style.height = 0;
                }
                ;
                {
                    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
                }
            }
        </script>
        <script type="text/javascript">
            $(document).ready(function () {

                $('a[id^="chart"]').fancybox({
                    'width': 1000,
                    'height': 1300,
                    'autoScale': false,
                    'transitionIn': 'fade',
                    'transitionOut': 'fade',
                    'type': 'iframe',
                    /*afterClose	:	function() {
                     parent.location.reload(true); 
                     }*/
                });
                $('a[id^="chart3"]').fancybox({
                    'width': 1000,
                    'height': 1300,
                    'autoScale': false,
                    'transitionIn': 'fade',
                    'transitionOut': 'fade',
                    'type': 'iframe',
                    /*afterClose	:	function() {
                     parent.location.reload(true); 
                     }*/
                });
            });
        </script>
        <script type="text/javascript">
            function getRefresh() {
                $("#auto").show("slow");
                $("#autoRefresh").load("count_conf.php", '', callback);
            }

            function callback() {
                $("#autoRefresh").fadeIn("slow");
                setTimeout("getRefresh();", 1000);
            }

            $(document).ready(getRefresh);
        </script>
        <script language="JavaScript">
            var HttPRequest = false;
            function doCallAjax(Sort) {
                HttPRequest = false;
                if (window.XMLHttpRequest) { // Mozilla, Safari,...
                    HttPRequest = new XMLHttpRequest();
                    if (HttPRequest.overrideMimeType) {
                        HttPRequest.overrideMimeType('text/html');
                    }
                } else if (window.ActiveXObject) { // IE
                    try {
                        HttPRequest = new ActiveXObject("Msxml2.XMLHTTP");
                    } catch (e) {
                        try {
                            HttPRequest = new ActiveXObject("Microsoft.XMLHTTP");
                        } catch (e) {
                        }
                    }
                }
                if (!HttPRequest) {
                    alert('Cannot create XMLHTTP instance');
                    return false;
                }
                var url = 'count_conf.php';
                var pmeters = 'mySort=' + Sort;
                HttPRequest.open('POST', url, true);
                HttPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                HttPRequest.setRequestHeader("Content-length", pmeters.length);
                HttPRequest.setRequestHeader("Connection", "close");
                HttPRequest.send(pmeters);
                HttPRequest.onreadystatechange = function ()
                {
                    if (HttPRequest.readyState == 3)  // Loading Request
                    {
                        document.getElementById("mySpan").innerHTML = "Now is Loading...";
                    }
                    if (HttPRequest.readyState == 4) // Return Request
                    {
                        document.getElementById("mySpan").innerHTML = HttPRequest.responseText;
                    }
                }
            }
        </script>
        
    
    </head>

    <body Onload="bodyOnload();">

        <div id="wrapper">
            <!-- Sidebar -->
            <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">

                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <?php
//===ชื่อโรงพยาบาล
                    $sql = mysqli_query($db,"select * from  hospital");
                    $resultHos = mysqli_fetch_assoc($sql);
                    ?>
                    <a class="navbar-brand" href="./"><font color='#fedd00'><b>Service & Support System v.1 </b></font><!--ระบบบริหารความเสี่ยง <? echo $resultHos['name']; ?>--></a>
                </div>
                <?php
                if ($_SESSION['ssuser_id'] != '') {
                    $sqlUser = mysqli_query($db,"select admin from user where user_id='$user_id' ");
                    $resultUser = mysqli_fetch_assoc($sqlUser);
                    $admin = $_SESSION['admin'];
                }
                ?>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">

                    <ul class="nav  navbar-custom navbar-nav side-nav">
                        <li><a href="./"><img src='images/gohome.ico' width='25'> หน้าหลัก</a></li> 		
                        <li><a href="#" onClick="return popup('fullcalendar/fullcalendar1.php', popup, 820, 670);" title="ดูการใช้ห้องประชุม"><img src='images/calendar-clock.ico' width='25'> ปฏิทินการใช้ห้องประชุม</a></li>
                        <li><a href="#" onClick="return popup('fullcalendar/fullcalendar2.php', popup, 820, 670);" title="ดูการใช้ห้องประชุม"><img src='images/calendar-clock.ico' width='25'> ปฏิทินการใช้รถยนต์</a></li>
                        <?php if($_SESSION['ss_status'] != ''){?>
                        <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src='images/kwrite.ico' width='25'> ขอใช้บริการ/สนับสนุน <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                        <li><a href="index.php?page=conferance/request_conf"><img src='images/kwrite.ico' width='25'> เขียนขอห้องประชุม</a></li>
                        <li><a href="index.php?page=car/request_car"><img src='images/kwrite.ico' width='25'> เขียนขอรถยนต์</a></li>
                        <li><a href="index.php?page=user/pre_order"><img src='images/kwrite.ico' width='25'> ตรวจสอบสถานะ</a></li>
                                    </ul>
                        </li>
                        <?php }?>
                            <?php if($_SESSION['ss_status']=='ADMIN' or $_SESSION['ss_status']=='SUSER'){ 
                                    if($_SESSION['ss_process']=='2' or $_SESSION['ss_process']=='0'){?>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src='images/Meeting_Dark.ico' width='25'> ระบบขอใช้ห้องประชุม <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        
                                        <li><a href="index.php?page=conferance/pre_request"><img src='images/Lfolder.ico' width='25'> บันทึกขอใช้ห้องประชุม</a></li>
                                        <li><a href="index.php?page=conferance/pre_confirm"><img src='images/Lfolder.ico' width='25'> บันทึกอนุมัติใช้ห้องประชุม</a></li>
                                        <li><a href="index.php?page=conferance/pre_cancle"><img src='images/Lfolder.ico' width='25'> บันทึกไม่อนุมัติ/ยกเลิกห้องประชุม</a></li>
                                    </ul>            
                                </li>
                            <?php } if($_SESSION['ss_process']=='3' or $_SESSION['ss_process']=='0'){?>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src='images/Ambulance.ico' width='25'> ระบบขอใช้รถยนต์ <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="index.php?page=car/pre_request"><img src='images/Lfolder.ico' width='25'> บันทึกขอใช้รถยนต์</a></li>
                                        <li><a href="index.php?page=car/pre_confirm"><img src='images/Lfolder.ico' width='25'> บันทึกอนุมัติใช้รถยนต์</a></li>
                                        <li><a href="index.php?page=car/pre_cancle"><img src='images/Lfolder.ico' width='25'> บันทึกไม่อนุมัติ/ยกเลิกรถยนต์</a></li>
                                    </ul>            
                            </li><?php }}?>
                            <li><a href="#">&nbsp;</a></li>
                        </ul>

                        <ul class="nav navbar-nav navbar-right navbar-user">
                            <?php if($_SESSION['ss_status'] == 'ADMIN'){?>
                            <li class="dropdown alerts-dropdown">
                             <?php $sql = mysqli_query($db,"select count(conf_id) AS countconf from ss_conferance WHERE isnull(approve) group by approve");
                                    $result = mysqli_fetch_assoc($sql);
                                    echo mysqli_error($db);
                                ?>
<a href="JavaScript:doCallAjax('countconf')" class="dropdown-toggle" data-toggle="dropdown"><img src='images/Bell.ico' width='18'> แจ้งขอห้องประชุม 
<span class="badge_alert" ><?php echo $result['countconf']; ?></span><b class="caret"></b></a>

<ul class="dropdown-menu">
                                            <?php 
                                            $sql2 = mysqli_query($db,"SELECT d.depName, ssc.conf_id, LEFT( ssc.obj, 20 ) AS detail, r.room_name, ssc.start_date, ssc.start_time
                                                                        FROM ss_conferance ssc
                                                                        INNER JOIN emppersonal e ON e.empno = ssc.empno_request
                                                                        INNER JOIN department d ON d.depId = e.depid
                                                                        INNER JOIN ss_room r ON r.room_id = ssc.room
                                                                        WHERE ISNULL( approve ) 
                                                                        ORDER BY ssc.conf_id");
                                            while ($result2 = mysqli_fetch_assoc($sql2)) {
                                                ?>
                                                <li><a href="#" onclick="return popup('conferance/confirm_conf.php?id=<?= $result2['conf_id']; ?>&method=confirm_conf',popup,550,550);">
                                                        <span class="name"><b><?php echo $result2['depName']; ?>:</b></span>
                                                    <span class="message"><?php echo $result2['detail']; ?>...</span><br>
                                                    <span class="message"><?php echo $result2['room_name']; ?></span><br>
                                                    <span class="time"><i class="fa fa-clock-o"></i> <?php
                                                        include_once ('option/funcDateThai.php');
                                                        echo DateThai1($result2['start_date'])." เวลา ".$result2['start_time'] ; //-----แปลงวันที่เป็นภาษาไทย  
                                                        ?>
                                                    </a></li><li class="divider"></li>
                                            <?php } ?>
                                            
                                            <li><a href="index.php?page=conferance/pre_request">ดูทั้งหมด</a></li>
                                        </ul>

                            </li>
                            <li class="dropdown alerts-dropdown">
                            <?php $sql = mysqli_query($db,"select count(car_id) AS countcar from ss_car WHERE isnull(payer) group by payer");
                                    $result = mysqli_fetch_assoc($sql);
                                    echo mysqli_error($db);
                                ?>
<a href="JavaScript:doCallAjax('countcar')" class="dropdown-toggle" data-toggle="dropdown"><img src='images/Bell.ico' width='18'> แจ้งขอรถยนต์ 
<span class="badge_alert" ><?php echo $result['countcar']; ?></span><b class="caret"></b></a>

<ul class="dropdown-menu">
                                            <?php 
                                            $sql2 = mysqli_query($db,"SELECT ssc.place, ssc.car_id, LEFT( ssc.obj, 20 ) AS detail, concat(e.firstname,' ',e.lastname) as fullname, ssc.start_date, ssc.start_time
                                                                        FROM ss_car ssc
                                                                        INNER JOIN emppersonal e ON e.empno = ssc.empno_request
                                                                        INNER JOIN department d ON d.depId = e.depid
                                                                        WHERE ISNULL( payer ) 
                                                                        ORDER BY ssc.car_id");
                                            while ($result2 = mysqli_fetch_assoc($sql2)) {
                                                ?>
                                                <li><a href="#" onclick="return popup('car/confirm_car.php?id=<?= $result2['car_id']; ?>&method=pay_car',popup,550,550);">
                                                        <span class="name"><b><?php echo $result2['fullname']; ?>:</b></span>
                                                    <span class="message"><?php echo $result2['detail']; ?>...</span><br>
                                                    <span class="message"><?php echo $result2['place']; ?></span><br>
                                                    <span class="time"><i class="fa fa-clock-o"></i> <?php
                                                        include_once ('option/funcDateThai.php');
                                                        echo DateThai1($result2['start_date'])." เวลา ".$result2['start_time'] ; //-----แปลงวันที่เป็นภาษาไทย  
                                                        ?>
                                                    </a></li><li class="divider"></li>
                                            <?php } ?>
                                            
                                            <li><a href="index.php?page=car/pre_request">ดูทั้งหมด</a></li>
                                        </ul>    
                            </li>
                            <?php }?>
                            <?php
                                if ($_SESSION['ss_status']=='SUSER') { ?>
                                    
                                        <script language="JavaScript">
                                            function bodyOnload()
                                            {
                                                doCallAjax('CustomerID')
                                                setTimeout("doLoop();", 2000);
                                            }
                                            function doLoop()
                                            {
                                                bodyOnload();
                                            }
                                        </script>
                                        <li class="dropdown alerts-dropdown" id="mySpan"></li>
                                    <?php
                                }
                            ?>
                            <?PHP if (empty($_SESSION['ss_id'])) { ?>            	
                                <li> 	
                                    <form class="navbar-form navbar-right" action='process/checkLogin.php' method='post'>
                                        <div class="form-group">
                                            <input type="text" placeholder="User Name" name='user_account' class="form-control" value='' required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" placeholder="Password" name='user_pwd' class="form-control"  value='' required>
                                        </div>
                                        <button type="submit" class="btn btn-success"><i class="fa fa-lock"></i> Sign in</button> 
                                        <div class="form-group">
                                        </div>
                                    </form>
                                </li>
                            <?PHP } else { ?>



                                <li class="dropdown user-dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src='images/personal.ico' width='20'> 
                                        <?php
                                        $user_id = $_SESSION['ss_id'];
                                        if (isset($user_id)) {
                                            echo $_SESSION['ssfullname'];
                                        }
                                        ?><b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                    <!--  <li><a href="#"><i class="fa fa-user"></i> Profile</a></li>
                                      <li><a href="#"><i class="fa fa-envelope"></i> Inbox <span class="badge">
                                      </span></a></li>
                                      <li><a href="#"><i class="fa fa-gear"></i> Settings</a></li>         
                                        --> 
                                        <li><a href="#" onClick="return popup('about.php', popup, 500, 500);" title="เกี่ยวกับเรา"><img src='images/Paper Mario.ico' width='25'> เกี่ยวกับเรา</a></li>    
                                        <li class="divider"></li>
                                        <li><a href="frmEditUser.php?user_id=<?= $_SESSION[user_id] ?>"><img src='images/personal.ico' width='25'> แก้ไขข้อมูลส่วนตัว</a></li>
                                        <li class="divider"></li>
                                        <li><a href="index.php?page=process/logout"><img src='images/exit.ico' width='25'> Log Out</a></li>
                                </ul>
                                </form>
                            <?PHP } ?>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>
            <script src="option/js/jquery.min.js"></script>
            <script src="option/js/bootstrap.js"></script>
            <!--<script langauge="javascript">
                window.location.reload();
            </script>-->
            <script type="text/javascript">
                    function inputDigits(sensor) {
                        var regExp = /[0-9.-]$/;
                        if (!regExp.test(sensor.value)) {
                            alert("กรอกตัวเลขเท่านั้นครับ");
                            sensor.value = sensor.value.substring(0, sensor.value.length - 1);
                        }
                    }
                </script>
            <div id="page-wrapper">

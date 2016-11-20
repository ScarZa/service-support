<?php include 'header.php';?>
<section class="content">
        <div class="col-lg-6">
    <link rel="stylesheet" href="fullcalendar/js/fullcalendar-2.1.1/fullcalendar.min.css">
<script type="text/javascript">
            $(function() {
                $('#calendar').fullCalendar({
                    header: {
                        left: 'month,agendaWeek,agendaDay',
                        center: 'title',
                        right: 'prev,next today'
                    },
                    editable: true,
                    theme: true,
                    events: "fullcalendar/data_events.php?gData=1",
                    loading: function(bool) {
                        if (bool)
                            $('#loading').show();
                        else
                            $('#loading').hide();
                    },
                    eventLimit:true,  
                    lang:'th'// put your options and callbacks here  
                });

            });
        </script>
    <style type="text/css">
    	#calendar{
		max-width: 60%;
		margin: 0 left;
        font-size:10px;
	}        
    </style>
<center><h3>ปฏิทินการใช้ห้องประชุม</h3></center>
<div style="margin:auto;width:800px;">
 <div id='calendar'></div>
 </div>
<br>
<div align="center">
<?php
include 'connection/connect.php';
$li_conf=  mysqli_query($db, "SELECT room_name FROM ss_room ORDER BY room_id ASC") or die(mysqli_error($db));
$code_color=array("1"=>"#1e6c06","2"=>"#930606","3"=>"#416cbb","4"=>"purple","5"=>"#d92727","6"=>"orange","7"=>"yellow");
$i=1;
while ($row = mysqli_fetch_array($li_conf)) {  ?>
<a style="background-color:<?= $code_color[$i]?>; color: white"><?= $row['room_name']?></a> 
<?php $i++; }
 echo "<br>";
if(!empty($_GET['check'])=='1'){?>
   <a href="#" class="btn btn-success btn-sm" onclick="javascript:window.parent.opener.document.location.href='../index.php?page=conferance/request_conf'; window.close();">ขอใช้ห้องประชุม</a> 
<?php }
?></div></div>
    <div class="col-lg-6">
        <script type="text/javascript">
            $(function() {
                $('#calendar2').fullCalendar({
                    header: {
                        left: 'month,agendaWeek,agendaDay',
                        center: 'title',
                        right: 'prev,next today'
                    },
                    editable: true,
                    theme: true,
                    events: "fullcalendar/data_events2.php?gData=1",
                    loading: function(bool) {
                        if (bool)
                            $('#loading').show();
                        else
                            $('#loading').hide();
                    },
                    eventLimit:true,  
                    lang:'th'// put your options and callbacks here  
                });

            });
        </script>
    <style type="text/css">
	#calendar2{
		max-width: 60%;
		margin: 0 left;
        font-size:10px;
	}        
    </style>
</head>
<body>
<center><h3>ปฏิทินการใช้รถยนต์</h3></center>
<div style="margin:auto;width:800px;">
 <div id='calendar2'></div>
 </div>
<br>
<div align="center">
<?php
include 'connection/connect.php';
$li_car=  mysqli_query($db, "SELECT license_name FROM ss_carlicense ORDER BY license_id ASC") or die(mysqli_error($db));
$code_color=array("1"=>"#416cbb","2"=>"#6a6a6a","3"=>"#68bd60","4"=>"#977dd1","5"=>"#ec8b00","6"=>"#ec73c8","7"=>"yellow");
//$code_color=array("1"=>"#1e6c06","2"=>"#930606","3"=>"#416cbb","4"=>"purple","5"=>"#d92727","6"=>"orange","7"=>"yellow");
$i=1;
while ($row = mysqli_fetch_array($li_car)) {  ?>
<a style="background-color:<?= $code_color[$i]?>; color: white"><?= $row['license_name']?></a> 
<?php $i++; }
 echo "<br>";
if(!empty($_GET['check'])=='1'){?>
   <a href="#" class="btn btn-primary btn-sm" onclick="javascript:window.parent.opener.document.location.href='../index.php?page=car/request_car'; window.close();">ขอใช้รถยนต์</a> 
<?php }
?>
</div>
    </div></section>
<script type="text/javascript" src="fullcalendar/js/fullcalendar-2.1.1/lib/jquery.min.js"></script>    
<script type="text/javascript" src="fullcalendar/js/fullcalendar-2.1.1/lib/moment.min.js"></script>
<script type="text/javascript" src="fullcalendar/js/fullcalendar-2.1.1/fullcalendar.min.js"></script>
<script type="text/javascript" src="fullcalendar/js/fullcalendar-2.1.1/lang/th.js"></script>
<script type="text/javascript" src="fullcalendar/script.js"></script>   
<script type="text/javascript" src="fullcalendar/script2.js"></script> 
</body>
</html>    
<?php @session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ระบบข้อมูลบุคคลากรโรงพยาบาล</title>
<LINK REL="SHORTCUT ICON" HREF="../images/logo.png">
    <link rel="stylesheet" href="js/fullcalendar-2.1.1/fullcalendar.min.css">
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
                    events: "data_events3.php?gData=1",
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
    html,body{
        maring:0;padding:0;
        font-family:tahoma, "Microsoft Sans Serif", sans-serif, Verdana;   
        font-size:12px;
    }
	#calendar{
		max-width: 700px;
		margin: 0 auto;
        font-size:13px;
	}        
    </style>
</head>
<body>

<br><br>
<div style="margin:auto;width:800px;">
 <div id='calendar'></div>
 </div>
<br>
<div align="center">
<a style="background-color:orange; color: white">ประชุม</a> 
<a style="background-color:violet; color: white">ประชุมเชิงปฏิบัติการ</a>
<a style="background-color:green; color: white">วิทยากร</a>
<a style="background-color:red; color: white">ศึกษาดูงาน</a>
<a style="background-color:yellow">สัมมนา</a>
<a style="background-color:blue; color: white">อบรม</a>
<a style="background-color:brown; color: white">อบรมเชิงปฏิบัติการ</a>
<a style="background-color:purple; color: white">อื่นๆ</a>
</div>
    
<script src="js/fullcalendar-2.1.1/lib/jquery.min.js"></script>    
<script type="text/javascript" src="js/fullcalendar-2.1.1/lib/moment.min.js"></script>
<script type="text/javascript" src="js/fullcalendar-2.1.1/fullcalendar.min.js"></script>
<script type="text/javascript" src="js/fullcalendar-2.1.1/lang/th.js"></script>
<script type="text/javascript" src="script3.js"></script>            
</body>
</html>
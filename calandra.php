<?php
//-- กำหนดช่องเวลา แบบตายตัว
$timeArr = array("07:00", "08:00", "09:00", "10:00", "11:00", "12:00", "13:00", "14:00",
"15:00", "16:00", "17:00", "18:00", "19:00", "20:00", "21:00", "22:00"
);
//-- ตารางห้องประชุม
//-- ส่วนที่ดึงมาจากฐานข้อมูล ในลูป while ซึ่งมีจำนวนห้องประชุมทั้งหมด 5 ห้อง
$room = array();
$room[] = array('id' => 1, 'name' => 'ห้องประชุม 1');
$room[] = array('id' => 2, 'name' => 'ห้องประชุม 2');
$room[] = array('id' => 3, 'name' => 'ห้องประชุม 3');
$room[] = array('id' => 4, 'name' => 'ห้องประชุม 4');
$room[] = array('id' => 5, 'name' => 'ห้องประชุม 5');
//-- สิ้นสุดการจัดรูปแบบข้อมูลในลูป while
//-- ตารางการจอง
//-- ส่วนที่ดึงมาจากฐานข้อมูล ในลูป while
//$array[{ไอดีห้องประชุม}][] = array('start_time' => '', 'end_time' => '', 'title' => '');
$booking = array();
$booking[1][] = array('start_time' => '08:10', 'end_time' => '11:15', 'title' => 'อบรม เทคโนโลยีสารสนเทศ และการสื่อสาร');
$booking[1][] = array('start_time' => '13:35', 'end_time' => '15:20', 'title' => 'วาระที่ 1');
$booking[2][] = array('start_time' => '11:45', 'end_time' => '16:10', 'title' => 'หัวข้อพิเศษเกี่ยวกับวิทยาการคอมพิวเตอร์');
$booking[3][] = array('start_time' => '12:15', 'end_time' => '14:30', 'title' => 'สรุปโครงการ');
$booking[4][] = array('start_time' => '15:00', 'end_time' => '17:00', 'title' => 'อบรม ระบบฐานข้อมูล');
$booking[5][] = array('start_time' => '08:30', 'end_time' => '12:00', 'title' => 'จัดกิจกรรมสัมมนาวิชาการ');
//-- สิ้นสุดการจัดรูปแบบข้อมูลในลูป while
 
/*
** คำนวณหาตำแหน่งซ้ายสุด และความกว้างที่จะแสดงในช่องเวลา
** ข้อกำหนดของการสร้างจำนวนคอลัมน์ เพื่อแสดงแถบเวลา
** 1 คอลัมน์ = ชั่วโมง, จะมีขนาดกว้าง 60px
** ต้องหาจุดเริ่มต้น css left
** ต้องหาความกว้าง css width
** เวลาเริ่มต้นคือ 7.00 ดังนั้นต้องลบ 7x60(420 ออกทุกครั้งที่หา left) * แต่เมื่อมีช่องก่อนหน้า ให้เพิ่มจำนวนที่ต้องลบออกมากขึ้น
** ความกว้าง ให้ใช้ค่า end_time - start_time
*/
Class SetTimeObject
{
public $startPx;
public $diff;
public $leftMin = 0;
 
public function getWidthPos($startTime, $endTime){
$s = explode(":", $startTime);
$this->startPx = ((int)$s[0] * 60) + (int)$s[1];
 
list($sTime1, $sTime2) = explode(":", $startTime);
list($eTime1, $eTime2) = explode(":", $endTime);
$sTime = (float)$sTime1.".". ($sTime2*100)/60;
$eTime = (float)$eTime1.".". ($eTime2*100)/60;
$this->diff = ($eTime - $sTime);
$l = ($this->startPx - 420) - $this->leftMin;
$w = ($this->diff * 60);
return array('left' => $l, 'width' => $w);
}
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>ตารางแสดงช่วงเวลาการใช้ห้องประชุม - www.sunzan-design.com</title>
<style type="text/css">
#snaptarget {
height: 50px;
background: url("http://code.jquery.com/ui/1.10.3/themes/smoothness/images/ui-bg_highlight-soft_75_cccccc_1x100.png") repeat-x scroll 50% 50% #CCCCCC;
}
td.room{
width : 100px;
text-align : right;
font-weight : bold;
background: url("http://code.jquery.com/ui/1.10.3/themes/smoothness/images/ui-bg_highlight-soft_75_cccccc_1x100.png") repeat-x scroll 50% 50% #CCCCCC;
}
.td_time{ height : 20px; }
.td_time div{
float : left;
width : 60px;
border-right : 1px solid #1AEB00;
}
.draggable2{
background: #C3FF7D;
border: 1px solid #AAAAAA;
color: #222222;
float : left;
height : 44px;
line-height : 14px;
padding : 2px; 
cursor : pointer;
overflow : hidden;
text-align : center;
font-weight : 100;
position : relative;
}
</style>
</head>
<body>
<?php
 
$objTime = new SetTimeObject;
echo '<table border="1" width="1095">';
foreach($room as $row){
echo '<tr>';
echo '<td class="room">'.$row['name'].'</td>';
echo '<td>
<div class="td_time"><div>'. implode("</div><div>", $timeArr) .'</div><div style="clear:both"></div></div>
<div id="snaptarget" class="ui-widget-header">';
if(isset($booking[$row['id']])){
$objTime->leftMin = 0;
foreach($booking[$row['id']] as $bookData){
$arr = $objTime->getWidthPos($bookData['start_time'], $bookData['end_time']);
$left = $arr['left'];
$width = $arr['width'];
$objTime->leftMin += $arr['width'];
$title = $bookData['title']. ' <br/>( '. $bookData['start_time'] .'-'.$bookData['end_time'] .')';
echo '<div class="draggable2" style="left: '.$left.'px;width: '.$width.'px" title="'.$title.'">'
. $title
. '</div>';
}
}
echo '  </div>
</td>';
echo '</tr>';
}
echo ' </table>';
//ใช้ทดสอบการคำนวณค่าว่าได้ตรงตามต้องการหรือไม่
Class Test_SetTimeObject extends SetTimeObject
{  
public static function TestGetWidthPos(){
$startTime = "08:10";
$endTime = "11:15";
$obj = new SetTimeObject;
$arr = $obj->getWidthPos($startTime, $endTime);
echo "<hr><br><b>ทดสอบการคำนวณตำแหน่ง และความกว้าง</b>";
echo "<br>เวลาที่ส่งไป  $startTime, $endTime";
echo "<br>ค่าที่จะต้องได้ออกมา left : 90, width : 120";
echo "<br><font color='green'><b>ผลลัพธ์ที่ได้ left : $arr[left], width : $arr[width]</b></font>";
echo "<br><br><b>ตรวจสอบค่าต่างๆ </b>";
echo "<br>ตำแหน่งด้านซ้าย : (8x60) + 10 = 490 คำนวณจากสูตรได้   $obj->startPx ";
echo "<br>ความกว้าง จำนวนช่อง x 60 : 2x60 = 120 คำนวณจากสูตรได้  <font color='green'><b>($obj->diff x 60) = $arr[width]</b></font>";
echo "<br><br><hr>";
}
}
Test_SetTimeObject::TestGetWidthPos();
?>
 
<br style="clear: both;" />
</body>
</html>


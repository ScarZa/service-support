<?php session_start(); 
include 'connection/connect.php';
 if($_SESSION['ss_process']=='2' or $_SESSION['ss_process']=='0'){
$sql = mysqli_query($db,"select count(conf_id) AS countconf from ss_conferance WHERE isnull(approve) group by approve");
                                    $result = mysqli_fetch_assoc($sql);
                                    echo mysqli_error($db);
                                ?>
<li class="dropdown alerts-dropdown">
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
                                                                        ORDER BY ssc.conf_id desc");
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

<?php } 
if($_SESSION['ss_process']=='3' or $_SESSION['ss_process']=='0'){
$sql = mysqli_query($db,"select count(car_id) AS countcar from ss_car WHERE isnull(payer) group by payer");
                                    $result = mysqli_fetch_assoc($sql);
                                    echo mysqli_error($db);
                                ?>
<li class="dropdown alerts-dropdown">
<a href="JavaScript:doCallAjax('countcar')" class="dropdown-toggle" data-toggle="dropdown"><img src='images/Bell.ico' width='18'> แจ้งขอรถยนต์   
<span class="badge_alert" ><?php echo $result['countcar']; ?></span><b class="caret"></b></a>

<ul class="dropdown-menu">
                                            <?php 
                                            $sql2 = mysqli_query($db,"SELECT ssc.place, ssc.car_id, LEFT( ssc.obj, 20 ) AS detail, concat(e.firstname,' ',e.lastname) as fullname, ssc.start_date, ssc.start_time
                                                                        FROM ss_car ssc
                                                                        INNER JOIN emppersonal e ON e.empno = ssc.empno_request
                                                                        INNER JOIN department d ON d.depId = e.depid
                                                                        WHERE ISNULL( payer ) 
                                                                        ORDER BY ssc.car_id desc");
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

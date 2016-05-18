<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
        <title>ระบบบริการและสนับสนุนโรงพยาบาล</title>
        <LINK REL="SHORTCUT ICON" HREF="../images/Paper Mario.ico">
        <!-- Bootstrap core CSS -->
        <link href="../option/css/bootstrap.css" rel="stylesheet">
        <!-- Add custom CSS here -->
        <link href="../option/css/sb-admin.css" rel="stylesheet">
        <link rel="stylesheet" href="../option/font-awesome/css/font-awesome.min.css">
        <!-- Page Specific CSS -->
        <link rel="stylesheet" href="../option/css/morris-0.4.3.min.css">
        <link rel="stylesheet" href="../option/css/stylelist.css">
        <script src="../option/js/jquery-2.1.4.min.js"></script>
        <script src="../option/js/excellentexport.js"></script>
        </head>

    <body>
<?php 
require '../connection/connect.php';
$user_account = md5(trim($_POST['user_account']));
$user_pwd = md5(trim($_POST['user_pwd']));

echo	 "<p>&nbsp;</p>	"; 
echo	 "<p>&nbsp;</p>	";
echo "<div class='bs-example'>
	  <div class='progress progress-striped active'>
	  <div class='progress-bar' style='width: 100%'></div>
</div>";
echo "<div class='alert alert-dismissable alert-success'>
	  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	  <a class='alert-link' target='_blank' href='#'><center>กำลังดำเนินการ</center></a> 
</div>";
$sql = $db->prepare("select CONCAT(e1.firstname,' ',e1.lastname) as fullname, ss.ss_Name as id, ss.ss_Status as status, ss.ss_process as process, e1.depid as dep
from ss_member ss 
INNER JOIN emppersonal e1 on e1.empno=ss.ss_Name
where   ss.ss_Username= ? && ss.ss_Password= ?");
$sql->bind_param("ss", $user_account,$user_pwd);
$sql->execute();  
$sql->bind_result($fullname,$id,$status_usere,$process,$dep);
$sql->fetch();
if (empty($id)) {
$sql = $db->prepare("select CONCAT(e1.firstname,' ',e1.lastname) as fullname, e1.empno as id, e1.depid as dep 
from emppersonal e1
inner join member m on m.Name=e1.empno
where m.Username= ? && m.Password= ?");
$sql->bind_param("ss", $user_account,$user_pwd);
$sql->execute();  
$sql->bind_result($fullname,$id,$dep);
$sql->fetch();
$status_usere='USER';
$process='0';
}

if (empty($id)) {
    echo "<script>alert('ชื่อหรือรหัสผ่านผิด กรุณาตรวจสอบอีกครั้ง!')</script>";
    echo "<meta http-equiv='refresh' content='0;url=../index.php'/>";
    exit();
} else {
    /*include '../connection/connect.php';
    $date_login = date("Y-m-d");
    $time_login = date('H:i:s');
    $sql = mysqli_query($db,"update jvlmatrix_user  set date_login='$date_login' , time_login='$time_login' 
                            where username='$user_account' and password='$user_pwd'");
    if ($sql == false) {
            echo "<p>";
            echo "Update not complete" . mysqli_error();
    }*/
    $_SESSION['ssfullname'] = $fullname;
    $_SESSION['ss_id'] = $id;
    //$_SESSION['lname'] = $result[lname];
    $_SESSION['ss_dep'] = $dep;
    $_SESSION['ss_process'] = $process;
    $_SESSION['ss_status'] = $status_usere;

    // require'myfunction/savelog.php';
    //	  echo "<input type='hidden' name='acc_id' value='$acc_username'> ";
    echo "<meta http-equiv='refresh' content='0;url=../index.php' />";
$db->close();
}
?>
 </section>
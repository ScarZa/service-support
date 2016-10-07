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
    $_SESSION['ssfullname'] = $_GET['fullname'];
    $_SESSION['ss_id'] = $_GET['id'];
    //$_SESSION['lname'] = $result[lname];
    $_SESSION['ss_dep'] = $_GET['dep'];
    $_SESSION['ss_process'] = '0';
    $_SESSION['ss_status'] = 'USER';

    // require'myfunction/savelog.php';
    //	  echo "<input type='hidden' name='acc_id' value='$acc_username'> ";
    echo "<meta http-equiv='refresh' content='0;url=../index.php' />";
$db->close();
?>
 </section>
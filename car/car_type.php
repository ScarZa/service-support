<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

</head>
<body>
 
  
<?php include'../connection/connect.php';?>
	<script language="JavaScript">

function Check_txt(){
	if(document.getElementById('car_type').value=="1"){
		alert("กรุณาระบุ ชนิดของรถยนต์ด้วย ด้วย");
		document.getElementById('car_type').focus();
		return false;
	}
	if(document.getElementById('license_plate').value=="1"){
		alert("กรุณาระบุ ทะเบียนรถด้วย ด้วย");
		document.getElementById('license_plate').focus();
		return false;
	}
}
</script>
    <td width='50%' align="right" valign="top"><B>ใช้รถประเภท : </b></td>
                    <?php //if($_SESSION['ss_status']=='ADMIN'){?>
    <td colspan="3"> <?php $readonly=$detial_l['approve']=='Y' ? 'readonly':'';?>
        <select name="car_type" id="car_type" class='form-control' onchange="data_show(this.value,'license_plate');" <?=$readonly?> disabled required>
			<?php 
                        $sql = mysqli_query($db,"SELECT *  FROM ss_car_type");
				 echo "<option value=''>--เลือกประเภทรถยนต์--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['cartype_id']==$detial_l['car_type']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['cartype_id']."' $selected>".$result['cartype_name'] ."</option>";
				 } ?>
			</select>
                                </td>
    <tr>
        <td align="right" valign="top"><B>หมายเลขทะเบียน : </b></td>
        <td colspan="3"><select name="license_plate" id="license_plate"  class="form-control" <?=$readonly?> disabled required> 
                        <?php if($detial_l['pay']=='Y'){ ?>
				<?php	$sql = mysqli_query($db,"SELECT *  FROM ss_carlicense where cartype_id='".$detial_l['car_type']."'");
				 echo "<option value=''>--เลือกรถยนต์--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['license_id']==$detial_l['license_plate']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['license_id']."' $selected>".$result['license_name'] ."</option>";
				 }}  else {?>
            <option value="">--เลือกรถยนต์--</option>
            <?php }?>
			 </select>
                </td>
    </tr>
        <!--<div class="form-group">
        <label>ตำบล &nbsp;</label>  
	<select class="form-control" name='district' id='district'>
            <?php/* if($_REQUEST[method]=='edit'){
                $rstTemp = mysql_query("select * from district where DISTRICT_ID='$edit_person[tambol]'");
                while ($arr_2 = mysql_fetch_array($rstTemp)){
                if($arr_2[DISTRICT_ID]==$edit_person[tambol]){$selected='selected';}else{$selected='';}
                echo "<option value='$arr_2[DISTRICT_ID]' $selected>$arr_2[DISTRICT_NAME]</option>";
                
                } }  else {*/?>
		<option value="">---โปรดเลือกตำบล---</option>
                <?php// }?>
	</select>
        </div>-->

<script language="javascript">
// Start XmlHttp Object
function uzXmlHttp(){
    var xmlhttp = false;
    try{
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    }catch(e){
        try{
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }catch(e){
            xmlhttp = false;
        }
    }
 
    if(!xmlhttp && document.createElement){
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}
// End XmlHttp Object

function data_show(select_id,result){
	var url = 'car_lic.php?select_id='+select_id+'&result='+result;
	//alert(url);
	
    xmlhttp = uzXmlHttp();
    xmlhttp.open("GET", url, false);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8"); // set Header
    xmlhttp.send(null);
	document.getElementById(result).innerHTML =  xmlhttp.responseText;
}
//window.onLoad=data_show(5,'amphur'); 
</script>


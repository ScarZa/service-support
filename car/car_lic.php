<?php require'../connection/connect.php'; ?>
<?php $result=$_GET['result'];
$select_id=$_GET['select_id'];
if ($result == 'license_plate') {  		
				$sql = mysqli_query($db,"SELECT *  FROM ss_carlicense where cartype_id='$select_id'");
				 echo "<option value=''>--เลือกรถยนต์--</option>";
				 while( $result = mysqli_fetch_assoc( $sql ) ){
          if($result['license_id']==$detial_l['license_plate']){$selected='selected';}else{$selected='';}
				 echo "<option value='".$result['license_id']."' $selected>".$result['license_name'] ."</option>";
				 }  } ?>


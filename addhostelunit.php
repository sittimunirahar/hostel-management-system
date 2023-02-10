<?php
require 'upperbody3.php';
$hn="";
if(!empty($_SESSION['password'])&&!empty($_SESSION['username'])){
if(!empty($_GET['hn'])){
	$hn=$_GET['hn'];
}

$hosstat='';
$query="SELECT hos_managed_by from hostel_details WHERE hos_name='$hn'";
$record=mysqli_query($link, $query);

while($row=mysqli_fetch_assoc($record)){
	$hosstat=$row['hos_managed_by'];	
}

?>

		<div class="list-group">
			<a href="hostel.php" class="list-group-item active">
			<i class="fa fa-building"  ></i>HOSTEL</a>
			<a href="allocation.php" class="list-group-item">
			<i class="fa fa-key" ></i>ALLOCATION</a>
			<a href="payment.php" class="list-group-item">
			<i class="fa fa-credit-card" ></i>FINANCIAL</a>
			<a href="services.php" class="list-group-item">
			<i class="fa fa-bar-chart" ></i>REPORT</a>
			<a href="dashboardhostel.php" class="list-group-item">
			<i class="fa fa-dashboard" ></i>DASHBOARD</a>
			<a href="home.php" class="list-group-item">
			<i class="fa fa-home" ></i>HOME</a>
		</div>
		</div>
		
   <div class="content">
   
	<form method="post">

	<h3>Add Unit to <?php echo $hn;?></h3><hr>
	
	<div class="panel panel-default">
	<div class="panel-body">
	<table id="typical">
	
	<tr ><th colspan=2 style="padding:10px;margin-top:4px;background-color:#267871;color:white;">Unit Details</th></tr>
		
		<tr>
			<th><label>Unit No:</label></th>
			<td><input name="unitno" type="text" id="unitno" class="form-control" required value="<?php echo $row['unit_no'] ?>"></td>
		</tr>
		
		<tr>
			<th><label>Rental:</label></th>
			<?php if($hosstat=='IIC'){?>
				<td><input name="rent" type="number" id="rent" class="form-control" placeholder="0.00" required></td>
			<?php } else {?>
				<td><input name="rent" type="number" id="rent" class="form-control" placeholder="0.00" disabled></td>
			<?php } ?>
		</tr>
		
		<tr><th>Expired Date: </th>
		<td> <input name="exp" type="date" id="exp" class="form-control" required></td></tr>
		
		<tr><th>Remarks: </th>
		<td> <input name="rmk" type="text" id="rmk" class="form-control" ></td></tr>
		
	<tr ><th colspan=2 style="padding:10px;margin-top:4px;background-color:#267871;color:white;">Owner Details</th></tr>
	
	<tr><th>Name:</th>
    <td> <input name="name" type="text" id="name" class="form-control" required></td></tr>
	
	<tr><th>H/P: </th>
    <td> <input name="hpno" type="text" id="hpno" class="form-control" required></td></tr>
	
	<tr><th>Email: </th>
    <td> <input name="email" type="email" id="email" class="form-control" required></td></tr>

	</table>
	</div>
	</div>
     <input name="add" type="submit" value="Add" class="btn btn-primary" />
	  <input name="reset" type="reset" value="Clear" class="btn btn-primary" />
     <input name="cancel" type="button" value="Cancel" class="btn btn-primary"  onClick="window.history.back();" style="float:right;"/>
    </form>
    </div>

<?php 

	if(isset($_POST['add']))
	{    
		 extract($_REQUEST);
			$ownid="";
			$unitno=$_POST['unitno'];
			$rent=0;
			if($hosstat=='IIC'){
				$rent=$_POST['rent'];
				 }
			
			$exp=$_POST['exp'];
			$rmk=$_POST['rmk'];
			$name=$_POST['name'];
			$email=$_POST['email'];
			$hp=$_POST['hpno'];
		 
		 $query="SELECT * FROM unit_list WHERE unit_no='$unitno' AND hos_name='$hn'";
		 $record=mysqli_query($link, $query);
		
		 if(mysqli_num_rows($record)>0){
			?>
			<script>
			alert('Unit number already exists!');
			</script>
			<?php
		}
		else{
			
			$query2="SELECT owner_id FROM owner_list WHERE owner_name='$name' AND owner_email='$email'";
			$record2=mysqli_query($link, $query2);	
			if (mysqli_num_rows($record2)==1){
				 while($row2=mysqli_fetch_assoc($record2)){
				 $ownid=$row2['owner_id'];
				}
			}
			else{
				$query="INSERT INTO owner_list (owner_name, owner_hp, owner_email, expiry_date, remarks) 
				VALUES ('$name', '$hp', '$email', '$exp', '$rmk')";
				$record=mysqli_query($link, $query);
				
				if($record){
					$query2="SELECT owner_id FROM owner_list WHERE owner_name='$name' AND owner_email='$email'";
					$record2=mysqli_query($link, $query2);	
					if (mysqli_num_rows($record2)==1){
						 while($row2=mysqli_fetch_assoc($record2)){
						 $ownid=$row2['owner_id'];
						 
						}
					}
				}
			}
			
					$q="INSERT INTO unit_list (unit_no, owner_id, hos_name, rental) VALUES ('$unitno', '$ownid', '$hn', '$rent')";
					$r=mysqli_query($link, $q);
					if($r){
					?>
					<script>
					alert('Unit added');
					window.location.href = "hostel.php";

					</script>
					<?php
				}
			}
	
		}
		 

require 'lowerbody.php';}
else{
	require 'warninglogin.php';
}?>
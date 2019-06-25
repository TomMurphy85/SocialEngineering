<!DOCTYPE HTML>  
<?php
include ('functions.php');
$voterEmail = "";
$voteDisp = "display:none";
$emaildisp = "display:block";
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>


<!--Sign in with Email address.  This will be replaced by Google oAuth in next release -->
  <form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
Email Address: <input type="text" name="voterEmail" value="<?php echo $voterEmail;?>">
  <br>     
   	<input type="submit" name="signIn" value="Sign In"> 
	</form>

<?php 
if (isset($_POST['signIn'])){
//check that user has access to vote
$voterEmail = (trim($_POST['voterEmail']));
$emailQuery = readFromDatabase("eventID", "voterInfo", "voterEmail ='$voterEmail'");
$row = mysqli_fetch_array($emailQuery);
$eventID = $row['eventID'];
$emailNumRows = mysqli_num_rows($emailQuery);
	if($emailNumRows == 0){
		//if there are no rows, show error
                echo "Your email is not assigned to any Events.";
      } 
//IF the user is only in one Event
elseif($emailNumRows == 1){
$emaildisp  = "display:none";
$voteDisp = "display:block";
$query = readFromDatabase("*", "voterInfo", "userSubmission <> '' && eventID = '$eventID'");
}
//If the user is in multiple Events
elseif($emailNumRows > 1){

//Create Dropdown to let user select which event they are voting for
//$DDquery = readFromDatabase("eventID", "voterInfo", "userSubmission <> '' && eventID = '$eventID'");
		while ($row = mysqli_fetch_array($emailQuery))
		{
			$amount = $row['amount'] == 0 ? '' : number_format($row['amount']);
			$eventID2 = $row['eventID'];
//DO SOMETHING TO ID What EVENT is available

			$total += $row['amount'];
			$no++;
		}
}
//something went wrong
else
echo "Something went wrong, please reload and try again";
}
?>
<!-- Table to cast vote -->
	<table style="<?=$votedisp?>" width="40%" class="data-table" >
		<thead>
			<tr>

				<th>No</th>
				<th style="display:none">ID</th>
				<th>Location</th>
				<th>Comment</th>
				<th>Vote</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$no 	= 1;
		$total 	= 0;
		while ($row = mysqli_fetch_array($query))
		{
			$amount  = $row['amount'] == 0 ? '' : number_format($row['amount']);
			echo '<tr>
					<td width="10%"><center>'.$no.'</center></td>
					<td style="display:none;">'.$row['voteID'].'</td>
					<td><center>'.$row['userSubmission'].'</center></td>
					<td><center>'.$row['userComment'].'</center></td>
					<td width="10%"><form method="post" action="">
					<input type="submit" name="action" value="Vote"/>
					<input type="hidden" name="id" value="'.$row['voteID'].'"/>
					</form></td>
				</tr>';
			$total += $row['amount'];
			$no++;
		}?>
		</tbody>
	</table>

<?php 
//Register Vote and write to Database.  Currently not working, isn't catching isset() for submit button.
//******Delete Table Row******
if ($_POST['action'] && $_POST['id']) {
  if ($_POST['action'] = 'vote') {
writeToDatabase('voterInfo', 'voteID', $_POST['id']);
  }
}

?>
</body>
</html>

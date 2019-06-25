<?php
include ('functions.php');

session_start();
if(empty($_SESSION["sessionEmail"]))
{
$_SESSION['redirectLink'] = "manageEvents.php";
header('location: home.php');
}

$userEmail = $_SESSION["sessionEmail"];
$query = readFromDatabase("*", "createEvent", "eventCreator = '$userEmail'");

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

	<table class="data-table">
		<caption class="title"><h1><?php echo $userEmail; ?>'s Events</h1></caption>
		<thead>
			<tr>

				<th>No</th>
				<th style="display:none"> eventID </th>
				<th>Event Name</th>
				<th>Date</th>
				<th>Time</th>
				<th>Comments</th>
				<th>edit</th>
				<th>Remove</th>
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
					<td>'.$no.'</td>
					<td style="display:none;">'.$row['eventID'].'</td>
					<td>'.$row['eventName'].'</td>
					<td>'.$row['eventDate'].'</td>
					<td>'.$row['eventTime'] . '</td>
					<td>'.$row['Comments'].'</td>
					<td><form method="post" action="">
					<input type="submit" name="edit" value="Edit"/>
					<input type="hidden" name="id" value="'.$row['eventID'].'"/>
					</form></td>
					<td><form method="post" action="">
					<input type="submit" name="delete" value="Delete"/>
					<input type="hidden" name="id" value="'.$row['eventID'].'"/>
					</form></td>
				</tr>';
			$total += $row['amount'];
			$no++;
		}?>
		</tbody>


	</table>
<br>
					<form method="post" action="" align="bottom">
					<center><input type="submit" name="Create" value="Create New Event"/></c>
					</form>
<?php 
//******ALter Event Info Row******
if (($_POST['edit'] || $_POST['delete']) && $_POST['id']) {
  if ($_POST['delete']) {
	deleteTableRow("createEvent", $_POST['id']);
header("Refresh:0");
}
 elseif ($_POST['edit']) {
$_SESSION["sessionEventID"] = $_POST['id'];
header('location: eventDetails.php'); 
  }
}
//****************************
 
if($_POST['Create']) {
$_SESSION['sessionEventID'] = "";
header('location: createEvent.php'); 
}


?>

</body>
</html>

<?php
include ('functions.php');
session_start();
if(empty($_SESSION["sessionEmail"]))
{
$_SESSION['redirectLink'] = "eventDetails.php";
header('location: home.php');
}elseif (empty($_SESSION["sessionEventID"])){
header('location: manageEvents.php');
}else{
$sessionID = $_SESSION['sessionEventID'];
$sessionEmail = $_SESSION["sessionEmail"];
}
$query = readFromDatabase("*", "voterInfo", "eventID = '$sessionID'");
$eventquery = readFromDatabase("*", "createEvent", "eventID = '$sessionID'");
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<?php

// define variables and set to empty values
$editQuery = readFromDatabase("*", "createEvent", "eventID = '$sessionID'");
$editNumRows = mysqli_num_rows($editQuery);

if($sessionID <> '' && $editNumRows == 1) {
$row = mysqli_fetch_array($editQuery);
$eventName = $row['eventName'];
$eventDate = $row['eventDate'];
$eventTime = $row['eventTime'];
$eventPassword = $row['eventPassword'];
$comment = $row['Comments'];
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>Update Event</h2>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
Event Name: <input type="text" name="eventName" value="<?php echo $eventName;?>">
  <span class="error">* <?php echo $eventNameErr;?></span>
  <br><br>
Event Date: <input type="Date" name="eventDate" value="<?php echo $eventDate;?>">
  <span class="error">* <?php echo $eventDateErr;?></span>
  <br><br> 
Event Time: <input type="Time" name="eventTime" value="<?php echo $eventTime;?>">
  <span class="error">* <?php echo $eventTimeErr;?></span>
  <br><br> 
Event Password: <input type="text" name="eventPassword" value="<?php echo $eventPassword;?>">
  <span class="error">* <?php echo $eventPasswordErr;?></span>
  <br><br>
Comment: <textarea name="Comments" rows="5" cols="40"><?php echo $comment;?></textarea>
  <br><br>
   <input type="submit" name="update" value="Update Event">  
</form>

<?php
if (isset($_POST['update']))
{
$eventName = $_POST['eventName'];
$eventDate = $_POST['eventDate'];
$eventTime = $_POST['eventTime'];
$eventPassword = $_POST['eventPassword'];
$comment = $_POST['Comments'];
if ((!empty($eventName)) && (!empty($eventDate)) && (!empty($eventTime)) && (!empty($eventPassword)))
{


UpdateDatabase("createEvent", "eventName = '$eventName', eventDate = '$eventDate', eventTime = '$eventTime', eventPassword = '$eventPassword', Comments = '$comment'", "eventID = $sessionID"); 

header("Refresh:0");
} 
else
{ 
echo "Required fields must not be blank";
}
}

?>
<table class="data-table">
		<caption class="title"><h2>Event Members</h2></caption>
		<thead>
			<tr>

				<th>Row</th>
				<th style="display:none"> RowID </th>
				<th>Email</th>
				<th>User Suggestion</th>
				<th>User Vote</th>
				<th>Attending?</th>
				<th>Comment</th>
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
					<td style="display:none;">'.$row['voteID'].'</td>
					<td>'.$row['voterEmail'].'</td>
					<td>'.$row['userSubmission'].'</td>
					<td>'.$row['userVote'].'</td>
					<td>'.$row['userAttending'] . '</td>
					<td>'.$row['userComment'].'</td>
					<td><form method="post" action="">
					<input id="delete" type="submit" name="action" value="Delete"/>
					<input type="hidden" name="id" value="'.$row['voteID'].'"/>
					</form></td>
				</tr>';
			$total += $row['amount'];
			$no++;
		}?>
		</tbody>
	</table>

<form method="post" onsubmit="return confirm('This will delete all members and votes for this event.  Do you wish to continue?');" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<center><br>
<input type="submit" onclick="confirmPress()" class= "delete"  name="clearTable" value="Clear Table" >
</center>
</form>
<?php 
//******Delete voterINFO*******
if ($_POST['action'] && $_POST['id']) {
  if ($_POST['action'] = 'delete') {
    deleteTableRow("voterInfo", $_POST['id']);
	header("Refresh:0");
  }
}

if (isset($_POST['clearTable']))
{
clearTable("voterInfo", "eventID = $sessionID");
header("Refresh:0");
}
//****************************
?>

<?php
$eMailErr = "";
$eMail = "";
if (isset($_POST['addEmail'])){
  if (empty($_POST["eMail"]))
    $eMailErr = "Email is required";
else if (!filter_var($_POST["eMail"], FILTER_VALIDATE_EMAIL)) 
    $eMailErr = "Invalid email format";  
else
{
      writeToDatabase("voterInfo", "eventID, voterEmail", "'$sessionID', '".$_POST["eMail"]."'"); 
	header("Refresh:0");
}}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  

<center>Email Address: <input type="text" name="eMail" value="<?php echo $eMail;?>">
   <input type="submit" name="addEmail" value="Add Email">  
<br> <span class="error"> <?php echo $eMailErr;?></span></center>
</form>

</body>
</html>

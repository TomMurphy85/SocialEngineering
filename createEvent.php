
<!DOCTYPE HTML>  
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
session_start();
//***********Handle Session Variables***********
if(empty($_SESSION["sessionEmail"]))
{
$_SESSION['redirectLink'] = "createEvent.php";
header('location: home.php');
}
$sessionEmail = $_SESSION["sessionEmail"];
//***********************************
include ('functions.php');
echo displayNav("create");
$eventName = $eventDate = $eventTime = $comment = "";
$reqMet = "True";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["eventName"])) {
    $eventNameErr = "Event Name is required";
    $reqMet = "False";
  } else {
    $eventName = test_input($_POST["eventName"]);
    // check if Event Name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z0-9 ']*$/",$eventName)) {
      $eventNameErr = "Only letters, numbers, apostrophe, and white space allowed"; 
    }
  }
  if (empty($_POST["eventDate"])) {
    $eventDateErr = "Event Date is required";
    $reqMet = "False";
  } else {
    $eventDate = test_input($_POST["eventDate"]);
	}
  
  if (empty($_POST["eventTime"])) {
    $eventTimeErr = "Event Time is required";
    $reqMet = "False";
  } else {
    $eventTime = test_input($_POST["eventTime"]);
	}

  if (empty($_POST["comment"])) {
    $comment = "";
  } else {
    $comment = test_input($_POST["comment"]);
  }

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>Create Event</h2>
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
Comment: <textarea name="comment" rows="5" cols="40"><?php echo $comment;?></textarea>
  <br><br>
   <input type="submit" name="submit" value="Create Event">  
</form>

<?php 
if (isset($_POST['submit']))
{
//Check if event name contains apostrophe add second apostrophe to write to SQL
$eventName = str_replace("'", "''", $eventName);
$sessionEmail = str_replace("'", "''", $sessionEmail);
$comment = str_replace("'", "''", $comment);

$myValues = "'" . $sessionEmail . "', '" . $eventName . "', '" . $eventDate . "', '" . $eventTime . "', '" . $comment . "', '". "Submission" . "'";
if ($reqMet == "True")
{
writeToDatabase("createEvent", "eventCreator, eventName, eventDate, eventTime, Comments, eventPhase", $myValues);

//Query to find newly created eventID
$queryEventID = readFromDatabase("eventID", "createEvent", " eventCreator = '$sessionEmail' && eventName = '$eventName'");

//add event creator to the newly created event
$getID = mysqli_fetch_array($queryEventID);
$eventID = $getID['eventID'];
writeToDatabase("voterInfo", "eventID, voterEmail", "'$eventID', '$sessionEmail'"); 
echo "Event Titled ".$eventName." was created successfully.";

header('location: manageEvents.php');    
} else
{ 
echo "Required fields must not be blank";
}
}

?>

<p>Want to Manage your Events? <a href="manageEvents.php">Manage Events here</a>.</p>

</body>
</html>

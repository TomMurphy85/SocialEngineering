
<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
include ('functions.php');

// define variables and set to empty values
$eventNameErr = $eventDateErr = $eventTimeErr = $eventPasswordErr = $reqPasswordErr = "";
$eventName = $eventDate = $eventTime = $eventPassword = $comment = $reqPassword = "";
$reqMet = "True";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["eventName"])) {
    $eventNameErr = "Event Name is required";
    $reqMet = "False";
  } else {
    $eventName = test_input($_POST["eventName"]);
    // check if Event Name only contains letters and whitespace
//TODO - add numbers to acceptable input
    if (!preg_match("/^[a-zA-Z ]*$/",$eventName)) {
      $eventNameErr = "Only letters and white space allowed"; 
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

 if (empty($_POST["reqPassword"])) {
    $reqPasswordErr = "Password is required";
    $reqMet = "False";
  } else {
    $reqPassword = test_input($_POST["reqPassword"]);
   }
  if (empty($_POST["comment"])) {
    $comment = "";
  } else {
    $comment = test_input($_POST["comment"]);
  }

  if (empty($_POST["eventPassword"]) && (isset($reqPassword) && $reqPassword=="Yes")) {
    $eventPasswordErr = "Event Password is required";
    $reqMet = "False";
    	
  } else {
    $eventPassword = test_input($_POST["eventPassword"]);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>Voting Submission</h2>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
Event Name: <input type="text" name="eventName" value="<?php echo $eventName;?>">
  <span class="error">* <?php echo $eventNameErr;?></span>
  <br><br>
Requires Password:
  <input type="radio" name="reqPassword" <?php if (isset($reqPassword) && $reqPassword=="Yes") echo "checked";?> value="Yes">Yes
  <input type="radio" name="reqPassword" <?php if (isset($reqPassword) && $reqPassword=="No") echo "checked";?> value="No">No  
  <span class="error">* <?php echo $availableErr;?></span>
  <br><br>
Event Password: <input type="password" name="eventPassword" readonly="false" value="<?php echo $eventPassword;?>">
  <span class="error">* <?php echo $eventPasswordErr;?></span>
  <br><br>
Event Date: <input type="Date" name="eventDate" value="<?php echo $eventDate;?>">
  <span class="error">* <?php echo $eventDateErr;?></span>
  <br><br> 
Event Time: <input type="Time" name="eventTime" value="<?php echo $eventTime;?>">
  <span class="error">* <?php echo $eventTimeErr;?></span>
  <br><br> 
Comment: <textarea name="comment" rows="5" cols="40"><?php echo $comment;?></textarea>
  <br><br>
   <input type="submit" name="submit" value="Submit">  
</form>

<?php

echo "<h2>Your Input:</h2>";
echo "Event Name: ".$eventName;
echo "<br>";
echo "Requires Password: ".$reqPassword;
echo "<br>";
echo "Event Password: ".$eventPassword;
echo "<br>";
echo "Event Date: ".$eventDate;
echo "<br>";
echo "Event Time: ".$eventTime;
echo "<br>";
echo "Comment: ".$comment;
echo "<br>";
echo "<h2>MySQL Results:</h2>";


?>

<?php 
if (isset($_POST['submit']))
{
$myValues = "'" . $eventDate . "'," . " '" . $eventTime . "'," ." '" . $eventName . "'," . " '" . $eventPassword . "'," . " '" . 
$comment . "'"  ;
if ($reqMet == "True")
{
//writeToDatabase("votingOptions", "Location, enteredBy, userAttending, userComment", $myValues); 
echo "SQL written";
}
else echo "Required fields must not be blank";

}

?>







</body>
</html>

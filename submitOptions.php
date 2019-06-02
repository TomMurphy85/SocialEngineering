
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
$nameErr = $submissionErr = $availableErr = $passwordErr = "";
$name = $submission = $available = $comment = $password = "";
$reqMet = "True";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
    $reqMet = "False";
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed"; 
    }
  }
  
  if (empty($_POST["submission"])) {
    $submissionErr = "Submission is required";
    $reqMet = "False";
  } else {
    $submission = test_input($_POST["submission"]);
	}
  
 if (empty($_POST["password"])) {
    $passwordErr = "Password is required";
  } else {
    $password = test_input($_POST["password"]);
   }
  if (empty($_POST["comment"])) {
    $comment = "";
  } else {
    $comment = test_input($_POST["comment"]);
  }

  if (empty($_POST["available"])) {
    $availableErr = "Availability is required";
    $reqMet = "False";
    	
  } else {
    $available = test_input($_POST["available"]);
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
Name: <input type="text" name="name" value="<?php echo $name;?>">
  <span class="error">* <?php echo $nameErr;?></span>
  <br><br>
Password: <input type="text" name="password" value="<?php echo $password;?>">
<!--  <span class="error"><?php echo $passwordErr;?></span> -->
  <br><br>
Availability:
  <input type="radio" name="available" <?php if (isset($available) && $available=="Yes") echo "checked";?> value="Yes">Yes
  <input type="radio" name="available" <?php if (isset($available) && $available=="Maybe") echo "checked";?> value="Maybe">Maybe
  <input type="radio" name="available" <?php if (isset($available) && $available=="No") echo "checked";?> value="No">No  
  <span class="error">* <?php echo $availableErr;?></span>
  <br><br>
 Submission: <input type="text" name="submission" value="<?php echo $submission;?>">
  <span class="error">* <?php echo $submissionErr;?></span>
  <br><br> 
Comment: <textarea name="comment" rows="5" cols="40"><?php echo $comment;?></textarea>
  <br><br>
   <input type="submit" name="submit" value="Submit">  
</form>

<?php

echo "<h2>Your Input:</h2>";
echo "Name: ".$name;
echo "<br>";
echo "Password: ".$password;
echo "<br>";
echo "Availability: ".$available;
echo "<br>";
echo "Submission: ".$submission;
echo "<br>";
echo "Comment: ".$comment;
echo "<br>";
echo "<h2>MySQL Results:</h2>";


?>

<?php 
if (isset($_POST['submit']))
{

$myValues = "'" . $submission . "'," . " '" . $name . "'," . " '" . $available . "'," . " '" . $comment . "'"  ;
if ($reqMet == "True")
{
writeToDatabase("votingOptions", "Location, enteredBy, userAttending, userComment", $myValues); 
}
else echo "Required fields must not be blank";

}

?>







</body>
</html>
